<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Html as BaseHtml;

$this->title = 'Iniciar Sesión';
$this->params['breadcrumbs'][] = $this->title;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= BaseHtml::encode($this->title) ?></title>
    <style>
        body {
            background: #f4f4f9;
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-right: 200px;
            margin: 0;
            color: #333;
        }

        .site-login {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
            text-align: center;
            position: relative;
        }

        h1 {
            margin-top: 20px;
            font-size: 32px;
            color: black;
            font-weight: bold;
        }

        .logo {
            max-width: 80px;
            position: absolute;
            top: -40px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .form-group {
            margin-top: 20px;
        }

        .form-control {
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            padding: 10px 12px;
            margin-bottom: 20px;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #1a92cf;
            box-shadow: 0 0 5px rgba(26, 146, 207, 0.5);
            outline: none;
        }

        .form-control::placeholder {
            color: #999;
            font-style: italic;
        }

        .btn-acceder {
            padding: 10px 15px;
            font-size: 16px;
            width: 100%;
            max-width: 300px;
            border-radius: 10px;
            background-color: #004ed6;
            color: white;
            border: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-acceder:hover {
            background-color: #7297d7;
            color: white;
        }

        .link-container {
            margin-top: 15px;
            font-size: 14px;
        }

        .link-container a {
            color: #004ed6;
            text-decoration: none;
        }

        .link-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="site-login">
        <!-- Logo en el centro arriba del cuadro -->
        <img class="logo" src="<?= Yii::getAlias('@web/Imagenes/Logoo.png') ?>" alt="Logo">

        <h1><?= BaseHtml::encode($this->title) ?></h1>

        <div class="row">
            <div class="col-lg-12">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'fieldConfig' => [
                        'template' => "{input}\n{error}",
                        'inputOptions' => ['class' => 'form-control'],
                        'errorOptions' => ['class' => 'invalid-feedback'],
                    ],
                ]); ?>

                <?= $form->field($model, 'username')->textInput([
                    'placeholder' => 'Usuario o Correo electrónico',
                    'autofocus' => true
                ]) ?>

                <?= $form->field($model, 'password')->passwordInput([
                    'placeholder' => 'Contraseña'
                ]) ?>

                <?= $form->field($model, 'rememberMe')->checkbox([
                    'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div>{error}</div>",
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Iniciar Sesión', ['class' => 'btn btn-primary btn-acceder', 'name' => 'login-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>

                <div class="link-container">
                    <a href="<?= \yii\helpers\Url::to(['site/olvido']) ?>">Olvidaste la Contraseña</a>
                    <p>¿Primera Vez? <a href="<?= \yii\helpers\Url::to(['site/registro']) ?>">Crear Cuenta</a></p>

                </div>
            </div>
        </div>
    </div>
</body>
</html>









