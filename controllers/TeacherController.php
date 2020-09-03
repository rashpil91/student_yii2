<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Teacher;
use app\models\TeacherForm;
use app\models\StudentGroupeCourseWithTeacher;

class TeacherController extends Controller
{

    public function actionView($id)
    {
        $teacher = Teacher::find()->where(['id' => $id])->asArray()->one();
        if (!$teacher) return $this->goHome();
    
        Yii::$app->user->setReturnUrl(Yii::$app->request->url);

        $student_groupe_course = StudentGroupeCourseWithTeacher::find()->where(['teacher' => $id])->with("courses", "studentGroupe");

        return $this->render('view', ['model' => $teacher, 'student_groupe_course' => $student_groupe_course]);
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

    public function actionDelete($id)
    {
        $teacher = Teacher::findOne(['id' => $id]);
        if (!$teacher) return $this->goHome();

        $teacher->delete(); 
        
        Yii::$app->session->setFlash('success', 'Преподватель успешно удален.');
        return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null));
    }

    public function actionIndex()
    {
        $teacher = Teacher::find()->with('courseCount')->asArray();

        Yii::$app->user->setReturnUrl(Yii::$app->request->url);

        return $this->render('teacher', [
            'teacher' => $teacher,
        ]);
    }

}
