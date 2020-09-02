<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Student;
use app\models\Photo;
use app\models\PhotoUpload;
use app\models\StudentForm;
use app\models\StudentGroupe;
use app\models\StudentGroupeForm;

class StudentController extends Controller
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
        $student = Student::find()->where(['id' => $id])->with("studentGroupe")->asArray()->one();

        if (!$student OR $student['falled']) return $this->goHome();
    
        return $this->render('view', ['model' => $student]);
    }

    /*
     * В екшне Process создается пустая запись в таблице студентов со специальным флагом falled
     * Это нужно для связи с аватаром, который загружается в другом методе с помощью ajax.
     * После заполнения формы флажок falled снимается. 
     * Планируется по крону удалять записи студентов с флагом falled, дата создания которых (created_at) более 1 часа
     */

    public function actionProcess($id = null)
    {

        if (!$id)
        {
            $student = new Student();
            $student->created_at = time();
            $student->user_id = Yii::$app->user->id;
            $student->falled = 1;
            $student->save();
            
            return $this->redirect(['process', 'id' => $student->id]);

        } else 
            $student = Student::findOne(['id' => $id]);

        if (!$student OR $student->user_id != Yii::$app->user->id) return $this->goHome();

        $falled = $student->falled;

        $student_groupe = StudentGroupe::find()->asArray()->all();

        $model = new StudentForm($student, $student_groupe);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if ($falled)
            {
                Yii::$app->session->setFlash('success', 'Студент успешно добавлен');
                return $this->redirect(['view', 'id' => $student->id]);

            } else {
                Yii::$app->session->setFlash('success', 'Изменения успешно сохранены.');
                return $this->refresh();
            }

        }

        return $this->render('process', ['model' => $model, 'student_groupe' => $student_groupe]);
    }

    public function actionPhotoUpload()
    {

        $result = ['status' => "error"];
        $model = new PhotoUpload();
 
        if ($model->load(Yii::$app->request->post()) && $model->save())
            $result['status'] = "ok";
        else
            $result['errors'] = $model->errors;

        die(json_encode($result));
    }

    public function actionPhotoDelete($id)
    {

        $result['status'] = "error";

        $student = Student::findOne(['id' => $id]);

        if ($student AND $student->photo)
        {

            $image_path = Photo::getPath($student->photo);
            $image_path_thumb = Photo::getPath($student->photo, "thumb");

            if (file_exists($image_path)) @unlink($image_path);
            if (file_exists($image_path_thumb)) @unlink($image_path_thumb);

            $student->photo = "";
            $student->save();

            $result['status'] = "ok";

        } else
            $result['message'] = "Ошибка при передаче данных";
        
        die(json_encode($result));
    }


    public function actionGroupeView($id)
    {

        $student_groupe = StudentGroupe::find()->where(['id' => $id])->asArray()->one();
        if (!$student_groupe) return $this->goHome();

        $student = Student::find()->where(['student_groupe' => $id]);

        return $this->render('groupe_view', [
            'student_groupe' => $student_groupe,
            'student' => $student
        ]);
    }    

    public function actionGroupeProcess($id = false)
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
                return $this->redirect(['groupe-view', 'id' => $model->id]);

            }

        }        

        return $this->render('groupe_process', ['model' => $model, 'id' => $id]);
    }

    public function actionIndex()
    {
        $student = Student::find()->with('studentGroupe');

        return $this->render('student', [
            'student' => $student,
        ]);
    }

}
