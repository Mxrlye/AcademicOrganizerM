<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Modal;

$this->title = 'BLOC DE NOTAS';
$this->params['breadcrumbs'][] = $this->title;

?>

<!-- Incluir Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> <!-- Íconos FontAwesome -->

<!-- Estilos personalizados -->
<style>
    body {
        background: #eef2f7;
        font-family: 'Roboto', sans-serif;
        color: #333;
        padding-left: 250px; /* Desplaza todo el contenido hacia la derecha */
    }

    h1 {
        text-align: center;
        font-weight: 700;
        color: #333;
        margin-bottom: 30px;
    }

    .site-note {
        max-width: 100%;
        padding: 20px;
    }

    /* Lista de notas */
    .note-list {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
        margin-top: 30px;
    }

    /* Íconos de archivos TXT */
    .note-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        width: 120px;
    }

    .note-item i {
        font-size: 60px;
        color: #d4d4d2; /* Color crema/gris */
        transition: transform 0.3s, color 0.3s;
    }

    .note-item i:hover {
        transform: scale(1.1);
        color: #b8b8b6; /* Color más oscuro al pasar el mouse */
    }

    .note-item p {
        margin: 5px 0;
        color: #333;
        font-size: 14px;
        font-weight: 600;
    }

    .note-item small {
        color: #999;
        font-size: 12px;
    }

    /* Botón para crear una nueva nota */
    .btn-primary {
    background-color: #2a34d5; /* Azul */
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 50px;
    font-weight: 600;
    margin-top: -30px; /* Mover hacia arriba */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

    .btn-primary:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    /* Modal */
  

    .modal-content {
        background-color: #ffffff;
        border-radius: 10px;
        padding: 20px;
    }

    

 
 
 /* Modal Header */
.modal-header {
    position: relative; /* Necesario para que la posición de la "X" sea relativa al encabezado */
}

/* Estilo para la "X" del modal */
.modal-header .btn-close {
    color: black !important; /* Cambiar color de la X a negro */
    background-color: transparent !important; /* Sin fondo */
    border: none !important; /* Sin bordes */
    opacity: 1 !important; /* Asegúrate de que sea completamente visible */
    position: absolute; /* Permite mover el botón */
    top: -20px !important; /* Cambia el valor aquí para subir la X */
    right: 15px !important; /* Ajusta si es necesario */
    z-index: 1055; /* Asegúrate de que esté por encima de otros elementos */
}

/* Hover para la "X" */
.modal-header .btn-close:hover {
    color: red !important; /* Cambia a rojo al pasar el mouse */
    opacity: 1 !important;
}


    /* Botones del formulario */
    .btn-success {
        background-color: #28a745;
        border: none;
        padding: 10px 20px;
        border-radius: 50px;
    }

    .btn-success:hover {
        background-color: #77c689;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background-color: #dc3545;
        border: none;
        padding: 10px 20px;
        border-radius: 50px;
        margin-left: 10px; /* Separar botones */
    }

    .btn-secondary:hover {
        background-color: #d36974;
        transform: translateY(-2px);
    }

    /* Campos de formulario */
    .form-control {
        background-color: #f8f9fa;
        color: #495057;
        border: 1px solid #ced4da;
        padding: 10px;
        border-radius: 5px;
    }

    .form-control::placeholder {
        color: #6c757d;
    }

    .form-control:focus {
        background-color: #ffffff;
        color: #495057;
        border-color: #80bdff;
        box-shadow: none;
    }
</style>



<div class="site-note">
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Botón para abrir el modal -->
    <?= Html::button('<i class="fas fa-plus"></i> Crear Nueva Nota', [
        'class' => 'btn btn-primary',
        'data-bs-toggle' => 'modal',
        'data-bs-target' => '#createNoteModal',
    ]) ?>

    <!-- Lista de notas -->
    <div class="note-list mt-4">
        <?php if (!empty($notes)): ?>
            <?php foreach ($notes as $note): ?>
                <div class="note-item">
                    <!-- Ícono de archivo TXT -->
                    <?= Html::a(
                    '<i class="fas fa-file-alt"></i>',
                    ['site/descargar', 'blocID' => $note->blocID], // Aquí pasamos el blocID
                    [
                        'class' => 'text-decoration-none',
                        'target' => '_blank',
                        'data-pjax' => 0,
                    ]
                ) ?>
                    <p><?= Html::encode($note->title) ?></p>
                    <small>Creada el: <?= Html::encode($note->fechaCreaB) ?></small>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No tienes notas aún.</p>
        <?php endif; ?>
    </div>
</div>

<?php
// Modal para crear notas
Modal::begin([
    'title' => '<h5>Crear Nota</h5>',
    'id' => 'createNoteModal',
    'size' => 'modal-md',
    'options' => ['class' => 'text-start'],
    'headerOptions' => ['class' => 'bg-primary text-white'],
    'footer' => false,
]);

$form = ActiveForm::begin([
    'id' => 'note-form',
    'action' => ['site/guardar-nota'],
    'method' => 'post',
]);

// Campo Título
echo $form->field($model, 'title')->textInput([
    'placeholder' => 'Título de la nota',
    'class' => 'form-control',
])->label(false);

// Campo Contenido
echo $form->field($model, 'contenido')->textarea([
    'rows' => 3,
    'placeholder' => 'Contenido de la nota',
    'class' => 'form-control',
])->label(false);

// Botones
echo Html::submitButton('<i class="fas fa-save"></i> Guardar Nota', ['class' => 'btn btn-success']);
echo Html::button('<i class="fas fa-times"></i> Cancelar', [
    'class' => 'btn btn-secondary',
    'data-bs-dismiss' => 'modal',
]);

ActiveForm::end();
Modal::end();
?>

<!-- Incluir scripts de Bootstrap y FontAwesome -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


