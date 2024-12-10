<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Subir Carpeta';
?>

<h1><?= Html::encode($this->title) ?></h1>

<!-- Mostrar mensajes flash -->
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php elseif (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>

<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'], // Esto es necesario para la carga de archivos
]); ?>

<div class="form-group">
    <?= Html::fileInput('carpeta[]', null, [
        'multiple' => true,  // Permite seleccionar múltiples archivos
        'webkitdirectory' => true, // Permite seleccionar carpetas
        'class' => 'form-control',
        'id' => 'carpeta',
    ]) ?>
</div>

<div class="form-group">
    <?= Html::submitButton('Subir Carpeta', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>














