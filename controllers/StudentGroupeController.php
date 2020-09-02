<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Student;
use app\models\Course;
use app\models\Teacher;
use app\models\StudentGroupe;
use app\models\StudentGroupeForm;
use app\models\StudentGroupeCourseWithTeacher;
use app\models\StudentGroupeCourseWithTeacherForm;

class StudentGroupeController extends Controller
{

    const STATUS = [
        0 => 'На согласовании',
        1 => 'Согласовано',
        2 => 'Отклонено'
    ];

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

        $student_groupe = StudentGroupe::find()->where(['id' => $id])->asArray()->one();
        if (!$student_groupe) return $this->goHome();

        $student = Student::find()->where(['student_groupe' => $id]);

        return $this->render('view', [
            'student_groupe' => $student_groupe,
            'student' => $student
        ]);
    }    


    public function actionCourseProcess($id = false)
    {

        $course = Course::find()->asArray()->all();
        $student_groupe = StudentGroupe::find()->asArray()->all();
        $teacher = Teacher::find()->asArray()->all();

        if ($id)
        {
            $course_teacher = StudentGroupeCourseWithTeacher::findOne(['id' => $id]);
            if (!$course_teacher) return $this->goHome();

            $model = new StudentGroupeCourseWithTeacherForm($course_teacher, $course, $student_groupe, $teacher, self::STATUS);
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

        return $this->render('course_process', [
            'model' => $model,
            'course' => $course,
            'student_groupe' => $student_groupe,
            'teacher' => $teacher,
            'status' => self::STATUS
        ]);

    } 

    public function actionCourse()
    {
        $model = StudentGroupeCourseWithTeacher::find()->with("courses", "teachers", "studentGroupe"); //->asArray()->all();
        
        return $this->render('course', [
            'model' => $model,
            'status' => self::STATUS
        ]);
    }

    public function actionProcess($id = false)
    {

        if ($id)
        {
            $student_groupe = StudentGroupe::findOne(['id' => $id]);
            if (!$student_groupe) return $this->goHome();

            $model = new StudentGroupeForm($student_groupe);
            $model->scenario  = StudentGroupeForm::SCENARIO_EDIT;

        } else {
         
            $model = new StudentGroupeForm();
            $model->scenario  = StudentGroupeForm::SCENARIO_ADD;
       
        }

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {

            if ($id)
            {

                Yii::$app->session->setFlash('success', 'Изменения успешно сохранены.');
                return $this->refresh();

            } else {

                Yii::$app->session->setFlash('success', 'Группа успешно добавлена');
                return $this->redirect(['view', 'id' => $model->id]);

            }

        }        

        return $this->render('process', ['model' => $model, 'id' => $id]);
    }


}
