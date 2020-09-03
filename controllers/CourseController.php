<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Course;
use app\models\CourseForm;

class CourseController extends Controller
{

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


    public function actionView($id)
    {
        $course = Course::find()->where(['id' => $id])->with('studentGroupe', 'teacher')->asArray()->one();

        if (!$course) return $this->goHome();

        Yii::$app->user->setReturnUrl(Yii::$app->request->url);

        return $this->render('view', ['model' => $course]);
    }    

    public function actionAdd()
    {

        $model = new CourseForm();
        $model->scenario  = CourseForm::SCENARIO_ADD;

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            Yii::$app->session->setFlash('success', 'Курс успешно добавлен');
            return $this->redirect(['view', 'id' => $model->id]);
        }        
    
        return $this->render('process', ['model' => $model, 'new' => 1]);        
    }


    public function actionEdit($id)
    {

        $course = Course::findOne(['id' => $id]);
        if (!$course) return $this->goHome();

        $model = new CourseForm($course);
        $model->scenario  = CourseForm::SCENARIO_EDIT;
        
        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            Yii::$app->session->setFlash('success', 'Изменения успешно сохранены.');
            return $this->refresh();
        }
        
        return $this->render('process', ['model' => $model, 'new' => 0]);   

    }

    public function actionDelete($id)
    {
        $course = Course::findOne(['id' => $id]);
        if (!$course) return $this->goHome();

        $course->delete(); 
        
        Yii::$app->session->setFlash('success', 'Курс успешно удален');
        return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null));
    }

    public function actionIndex()
    {
        $course = Course::find();
        
        Yii::$app->user->setReturnUrl(Yii::$app->request->url);

        return $this->render('course', [
            'course' => $course,
        ]);
    }

}
