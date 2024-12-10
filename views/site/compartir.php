<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Compartir Contenido';
?>
<div class="container mt-5">
    <div class="shadow p-4 rounded bg-white compartir-card">
        <h1 class="text-center text-primary mb-4"><?= Html::encode($this->title) ?></h1>
        <p class="text-muted text-center">Comparte tu contenido ingresando el correo electrónico del destinatario y seleccionando uno de tus archivos.</p>

        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success">
                <?= Yii::$app->session->getFlash('success') ?>
            </div>
        <?php endif; ?>

        <?php $form = ActiveForm::begin([
            'id' => 'compartir-form',
            'method' => 'post',
        ]); ?>

        <div class="form-group">
            <?= $form->field($model, 'email')->textInput(['placeholder' => 'Correo electrónico del destinatario', 'class' => 'form-control'])->label('<strong>Correo Electrónico</strong>') ?>
        </div>

        <div class="form-group">
            <?= $form->field($model, 'message')->textarea(['placeholder' => 'Mensaje opcional...', 'rows' => 4, 'class' => 'form-control'])->label('<strong>Mensaje (Opcional)</strong>') ?>
        </div>

        <div class="form-group">
            <label for="archivoSeleccionado" class="form-label"><strong>Seleccionar Archivo</strong></label>
            <select name="archivoSeleccionado" id="archivoSeleccionado" class="form-select">
                <?php foreach ($archivos as $archivo): ?>
                    <option value="<?= $archivo['archivoID'] ?>"><?= Html::encode($archivo['nombreA']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="text-center">
            <?= Html::submitButton('Compartir', ['class' => 'btn btn-primary btn-lg mt-3']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<style>
    body {
        background-color: #f4f4f9;
        font-family: Arial, sans-serif;
        color: #333;
        font-size: 16px;
        padding-right: 640px;
    }

    .compartir-card {
    max-width: 600px;
    margin: 20px auto; 
    background: #fff;
}
.container {
    padding-top: 0 !important; 
}
.container.mt-5 {
    margin-top: 150 !important; 
}



    h1 {
        font-size: 24px;
        color: #1e40af;
        margin-top: 10px; 
    }

    .form-group label {
        font-size: 14px;
        color: #555;
    }

    .btn-primary {
        background-color: #1e40af;
        border-color: #1e40af;
        padding: 10px 20px;
        font-size: 16px;
    }

    .btn-primary:hover {
        background-color: #163370;
        border-color: #163370;
    }
</style>




