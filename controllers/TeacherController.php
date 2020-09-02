<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Teacher;
use app\models\TeacherForm;

class TeacherController extends Controller
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
        $teacher = Teacher::find()->where(['id' => $id])->asArray()->one();
        if (!$teacher) return $this->goHome();
    
        return $this->render('view', ['model' => $teacher]);
    }    

    public function actionAdd()
    {

        $model = new TeacherForm();
 
        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            Yii::$app->session->setFlash('success', 'Преподаватель успешно добавлен');
            return $this->redirect(['view', 'id' => $model->id]);
        }        
    
        return $this->render('process', ['model' => $model, 'new' => 1]);        
    }


    public function actionEdit($id)
    {

        $teacher = teacher::findOne(['id' => $id]);
        if (!$teacher) return $this->goHome();

        $model = new TeacherForm($teacher);

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            Yii::$app->session->setFlash('success', 'Изменения успешно сохранены.');
            return $this->refresh();
        }
        
        return $this->render('process', ['model' => $model, 'new' => 0]);   

    }

    public function actionIndex()
    {
        $teacher = Teacher::find();

        return $this->render('teacher', [
            'teacher' => $teacher,
        ]);
    }

}
