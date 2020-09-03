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
                'only' => ['index', 'view', 'process', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'view', 'process','delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionView($id)
    {

        $student_groupe = StudentGroupe::find()->where(['id' => $id])->with("student", "sgct")->asArray()->one();
        if (!$student_groupe) return $this->goHome();

        Yii::$app->user->setReturnUrl(Yii::$app->request->url);

        return $this->render('view', [
            'student_groupe' => $student_groupe,
        ]);
    }    

    public function actionDelete($id)
    {
        $course = StudentGroupe::findOne(['id' => $id]);
        if (!$course) return $this->goHome();

        $course->delete(); 
        
        Yii::$app->session->setFlash('success', 'Группа успешно удалена');
        return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null));
    }

    public function actionIndex()
    {

        $student_groupe = StudentGroupe::find()->with('studentCount', 'courseCount')->asArray();

        Yii::$app->user->setReturnUrl(Yii::$app->request->url);

        return $this->render('index', ['student_groupe' => $student_groupe]);
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
