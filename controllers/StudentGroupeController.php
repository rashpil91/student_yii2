<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Student;
use app\models\StudentGroupe;
use app\models\StudentGroupeForm;

class StudentGroupeController extends Controller
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

        $student_groupe = StudentGroupe::find()->where(['id' => $id])->asArray()->one();
        if (!$student_groupe) return $this->goHome();

        $student = Student::find()->where(['student_groupe' => $id]);

        return $this->render('view', [
            'student_groupe' => $student_groupe,
            'student' => $student
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
