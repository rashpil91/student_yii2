<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Course;
use app\models\Teacher;
use app\models\StudentGroupe;
use app\models\StudentGroupeCourseWithTeacher;
use app\models\StudentGroupeCourseWithTeacherForm;

class SiteController extends Controller
{

    const STATUS = [
        0 => 'На согласовании',
        1 => 'Согласовано',
        2 => 'Отклонено'
    ];

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */

    public function actionProcess($id = false)
    {

        $course = Course::find()->asArray()->all();
        $student_groupe = StudentGroupe::find()->asArray()->all();
        $teacher = Teacher::find()->asArray()->all();

        if ($id)
        {
            $sgct = StudentGroupeCourseWithTeacher::findOne(['id' => $id]);
            if (!$sgct) return $this->goHome();

            $model = new StudentGroupeCourseWithTeacherForm($sgct, $course, $student_groupe, $teacher, self::STATUS);
            $model->scenario  = StudentGroupeCourseWithTeacherForm::SCENARIO_EDIT;

        } else {
         
            $model = new StudentGroupeCourseWithTeacherForm(false, $course, $student_groupe, $teacher, self::STATUS);
            $model->scenario  = StudentGroupeCourseWithTeacherForm::SCENARIO_ADD;

        }

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {

            if ($id)
            {
                Yii::$app->session->setFlash('success', 'Изменения успешно сохранены.');
                return $this->refresh();

            } else {

                Yii::$app->session->setFlash('success', 'Группа успешно записана на курс');
                return $this->redirect(['view', 'id' => $model->id]);

            }

        }        

        return $this->render('process', [
            'id' => $id,
            'model' => $model,
            'course' => $course,
            'student_groupe' => $student_groupe,
            'teacher' => $teacher,
            'status' => self::STATUS
        ]);

    } 

    public function actionIndex()
    {
        $model = StudentGroupeCourseWithTeacher::find()->with("courses", "teachers", "studentGroupe")->asArray();
        
        Yii::$app->user->setReturnUrl(Yii::$app->request->url);

        return $this->render('index', [
            'model' => $model,
            'status' => self::STATUS
        ]);
    }


    public function actionDelete($id)
    {
        $sgct = StudentGroupeCourseWithTeacher::findOne(['id' => $id]);
        if (!$sgct) return $this->goHome();
        
        $sgct->delete();

        Yii::$app->session->setFlash('success', 'Запись успешно удалена');
        return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null));
    }    

    public function actionView($id)
    {
        $sgct = StudentGroupeCourseWithTeacher::find()->where(['id' => $id])->with("courses", "teachers", "student")->asArray()->one();

        if (!$sgct) return $this->goHome();
        Yii::$app->user->setReturnUrl(Yii::$app->request->url);

        return $this->render('view', [
            'model' => $sgct,
            'status' => self::STATUS
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
