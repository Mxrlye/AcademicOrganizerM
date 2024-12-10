<?php
use yii\helpers\Html;

$this->title = 'Perfil del Usuario';
?>
<div class="container mt-5">
    <div class="profile-card shadow p-4 rounded bg-white">
        <h1 class="text-center mb-4"><?= Html::encode($this->title) ?></h1>
        <table class="table table-hover table-striped">
            <tbody>
                <tr>
                    <th scope="row">Nombres</th>
                    <td><?= Html::encode($user['nombres']) ?></td>
                </tr>
                <tr>
                    <th scope="row">Apellidos</th>
                    <td><?= Html::encode($user['apellidos']) ?></td>
                </tr>
                <tr>
                    <th scope="row">Correo</th>
                    <td><?= Html::encode($user['correo']) ?></td>
                </tr>
                <tr>
                    <th scope="row">Género</th>
                    <td><?= Html::encode($user['genero']) ?></td>
                </tr>
                <tr>
                    <th scope="row">Teléfono</th>
                    <td><?= Html::encode($user['telefono']) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<style>
    body {
        background: #f4f4f9;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        color: #333;
        padding-right: 640px;
        font-size: 16px; /* Tamaño estándar para el cuerpo */
    }

    .profile-card {
        max-width: 600px;
        margin: 0 auto;
        font-size: 15px;
    }

    table th, table td {
        font-size: 15px; /* Tamaño estándar de tabla */
        padding: 12px 10px;
    }

    h1 {
        font-family: Arial, sans-serif;
        color: #1e40af;
        font-size: 28px; /* Tamaño del título ajustado para mayor legibilidad */
    }

    table th {
        font-weight: bold;
        text-align: left;
        background-color: #e0e7ff; /* Color sutil para diferenciar encabezados */
    }

    table {
        border-collapse: separate;
        border-spacing: 0 8px; /* Separación entre filas */
    }
</style>


