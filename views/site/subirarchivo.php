<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Archivos */

$this->title = 'Subir Archivo';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'], // Necesario para cargar archivos
]); ?>

    <?= $form->field($model, 'archivo')->fileInput() ?>  <!-- Campo para seleccionar archivo -->
    
    <div class="form-group">
        <?= Html::submitButton('Subir', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

<!-- Mostrar los mensajes de éxito o error -->
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php elseif (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>

<!-- Mostrar el nombre del archivo después de haberlo subido -->
<?php if ($model->nombreA): ?>
    <p>Archivo subido: <?= Html::encode($model->nombreA) ?></p> <!-- Muestra el nombre del archivo subido -->
<?php endif; ?>


