<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use frontend\models\Patient;
use kartik\mpdf\Pdf;

class PatientController extends Controller
{
    /**
     * Lists all Patient models.
     * @return mixed
     */
    public function actionIndex()
    {
        $patients = Patient::find()
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'patients' => $patients,
        ]);
    }

    /**
     * Displays a single Patient model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Patient model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Patient the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Patient::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested patient does not exist.');
    }

    // frontend/controllers/PatientController.php

/**
 * Updates an existing Patient model.
 * @param integer $id
 * @return mixed
 */
public function actionUpdate($id)
{
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        Yii::$app->session->setFlash('success', '✅ Patient updated successfully!');
        return $this->redirect(['view', 'id' => $model->id]);
    }

    return $this->render('update', [
        'model' => $model,
    ]);
}

/**
 * Deletes an existing Patient model.
 * @param integer $id
 * @return \yii\web\Response
 */
public function actionDelete($id)
{
    $model = $this->findModel($id);
    $name = $model->first_name . ' ' . $model->last_name;
    
    $model->delete();

    Yii::$app->session->setFlash('success', "✅ Patient '$name' deleted successfully.");
    return $this->redirect(['index']);
}



/**
 * Generates PDF for a single patient.
 * @param integer $id
 * @return mixed
 */
public function actionPdf($id)
{
    $model = $this->findModel($id);

    $content = $this->renderPartial('_pdf-single', [
        'model' => $model
    ]);

    $pdf = new Pdf([
        'mode' => Pdf::MODE_CORE,
        'format' => Pdf::FORMAT_A4,
        'orientation' => Pdf::ORIENT_PORTRAIT,
        'destination' => Pdf::DEST_BROWSER,
        'content' => $content,
        'cssFile' => '@vendor/fortawesome/font-awesome/css/all.min.css',
        'options' => ['title' => 'Patient Profile'],
        'methods' => [
            'SetHeader' => ['Patient Record | Generated: ' . date('Y-m-d')],
            'SetFooter' => ['Page {PAGENO}'],
        ]
    ]);

    return $pdf->render();
}

public function actionPdfAll()
{
    $patients = Patient::find()->orderBy(['id' => SORT_DESC])->all();

    $content = $this->renderPartial('_pdf-all', [
        'patients' => $patients
    ]);

    $pdf = new Pdf([
        'mode' => Pdf::MODE_CORE,
        'format' => Pdf::FORMAT_A4,
        'orientation' => Pdf::ORIENT_PORTRAIT,
        'destination' => Pdf::DEST_BROWSER,
        'content' => $content,
        'cssFile' => '@vendor/fortawesome/font-awesome/css/all.min.css',
        'options' => ['title' => 'All Patients'],
        'methods' => [
            'SetHeader' => ['All Patients | Generated: ' . date('Y-m-d')],
            'SetFooter' => ['Page {PAGENO}'],
        ]
    ]);

    return $pdf->render();
}
}