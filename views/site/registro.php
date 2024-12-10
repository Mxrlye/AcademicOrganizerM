<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'registro';
?>

<style>
    /* Estilo general */
    body {
        background: #f4f4f9;
        font-family: Arial, sans-serif;
        color: #333;
        margin: 0;
        padding: 0;
        padding-right;: 250px
    }

    /* Contenedor principal */
    .register-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        padding: 20px;
    }

    /* Caja del formulario */
    .register-box {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        padding: 30px;
        max-width: 500px;
        width: 100%;
        text-align: center;
    }

    /* Título del formulario */
    .register-box h1 {
        font-size: 28px;
        color: #333;
        margin-bottom: 20px;
        font-weight: bold;
    }

    /* Campos del formulario */
    .register-box input[type="text"],
    .register-box input[type="password"],
    .register-box input[type="email"],
    .register-box input[type="tel"],
    .register-box select {
        width: 100%;
        padding: 10px;
        margin: 15px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

    /* Efecto al enfocar los campos */
    .register-box input:focus,
    .register-box select:focus {
        border-color: #1a92cf;
        outline: none;
        box-shadow: 0 0 5px rgba(26, 146, 207, 0.3);
    }

    /* Botón de registro */
    .btn-registrarse {
        background-color: #1a92cf;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
        width: 100%;
    }

    /* Hover del botón */
    .btn-registrarse:hover {
        background-color: #1477a8;
    }

    /* Enlaces */
    .register-box a {
        color: #1a92cf;
        text-decoration: none;
        font-size: 14px;
    }

    .register-box a:hover {
        text-decoration: underline;
    }

    /* Alertas */
    .alert {
        margin-bottom: 20px;
        text-align: left;
    }
</style>

<div class="register-container">
    <div class="register-box">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success">
                <?= Yii::$app->session->getFlash('success') ?>
            </div>
        <?php elseif (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger">
                <?= Yii::$app->session->getFlash('error') ?>
            </div>
        <?php endif; ?>

        <?php $form = ActiveForm::begin(['id' => 'register-form']); ?>

        <!-- Campo Nombre de Usuario -->
        <?= $form->field($model, 'nombreU')
            ->textInput(['placeholder' => 'Nombre de Usuario', 'required' => true])
            ->label(false) ?>

        <!-- Campo Contraseña -->
        <?= $form->field($model, 'contraseña')
            ->passwordInput(['placeholder' => 'Contraseña', 'required' => true])
            ->label(false) ?>

        <!-- Campo Correo Electrónico -->
        <?= $form->field($model, 'correo')
            ->textInput(['placeholder' => 'Correo Electrónico', 'required' => true])
            ->label(false) ?>

        <!-- Campo Nombres -->
        <?= $form->field($model, 'nombres')
            ->textInput(['placeholder' => 'Tus Nombres', 'required' => true])
            ->label(false) ?>

        <!-- Campo Apellidos -->
        <?= $form->field($model, 'apellidos')
            ->textInput(['placeholder' => 'Tus Apellidos', 'required' => true])
            ->label(false) ?>

        <!-- Campo Género -->
        <?= $form->field($model, 'genero')
            ->dropDownList([
                'Masculino' => 'Masculino',
                'Femenino' => 'Femenino',
            ], ['prompt' => 'Seleccionar Género', 'required' => true])
            ->label(false) ?>

        <!-- Campo Teléfono -->
        <?= $form->field($model, 'telefono')
            ->textInput(['placeholder' => 'Número de Teléfono', 'required' => true])
            ->label(false) ?>

        <!-- Botón de Registro -->
        <button type="submit" class="btn-registrarse">Registrarse</button>

        <?php ActiveForm::end(); ?>
    </div>
</div>
