<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Carpetas';

/* @var $this yii\web\View */
/* @var $archivos array */
/* @var $carpetas array */

$iconPath = Yii::getAlias('@web') . '/imagenes/icons/';
?>

<div class="container">
    <!-- Menú desplegable -->
    <div class="menu-desplegable">
        <button class="btn-menu" onclick="toggleMenu()">☰</button>
        <div id="menuOpciones" class="menu-opciones">
            <a href="javascript:void(0);" onclick="abrirExploradorArchivos()" class="menu-item">📤 Subir archivo</a>
            <a href="javascript:void(0);" onclick="abrirModal()" class="menu-item">🗂️ Nueva carpeta</a>
            <a href="javascript:void(0);" onclick="abrirExploradorCarpetas()" class="menu-item">🗃️ Subir carpeta</a>
        </div>
    </div>

    <!-- Formularios para subir archivos y carpetas -->
    <?= Html::beginForm(['site/subirarchivo'], 'post', [
        'enctype' => 'multipart/form-data',
        'id' => 'formSubirArchivo',
        'style' => 'display: none;'
    ]) ?>
        <input type="file" name="archivo" id="archivo" onchange="document.getElementById('formSubirArchivo').submit();">
    <?= Html::endForm() ?>

    <form id="formSubirCarpeta" action="<?= Url::to(['site/subircarpeta']) ?>" method="post" enctype="multipart/form-data" style="display: none;">
        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
        <input type="file" id="inputCarpeta" name="carpeta[]" webkitdirectory multiple onchange="document.getElementById('formSubirCarpeta').submit();" />
    </form>

    <!-- Modal para crear carpetas -->
    <div id="crearCarpetaModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="cerrarModal()">&times;</span>
            <h3>Crear Carpeta</h3>
            <?= Html::beginForm(['site/crearcarpeta'], 'post') ?>
                <div class="form-group">
                    <label for="nombreCarpeta">Nombre de la Carpeta:</label>
                    <input type="text" name="nombreC" id="nombreCarpeta" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Crear</button>
            <?= Html::endForm() ?>
        </div>
    </div>

    <!-- Mostrar carpetas -->
    <div class="file-grid">
    <?php if (!empty($carpetas)): ?>
        <?php foreach ($carpetas as $carpeta): ?>
            <div class="file-item">
                <a href="<?= Url::to(['site/descargarcarpeta', 'nombre' => $carpeta->nombreC]) ?>" download>
                    <img src="<?= Url::to('@web/imagenes/icons/folder-icono.jpeg', true) ?>" alt="Carpeta" class="file-icon">
                    <p><?= Html::encode($carpeta->nombreC) ?></p>
                </a>
                <!-- Botón para eliminar carpeta -->
                <?= Html::a('Eliminar', ['site/eliminarcarpeta', 'id' => $carpeta->carpetaID], [ // Cambiar 'id' a 'carpetaID'
                    'class' => 'btn btn-danger btn-sm',
                    'data' => [
                        'confirm' => '¿Estás seguro de que deseas eliminar esta carpeta?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay carpetas disponibles.</p>
    <?php endif; ?>
</div>




    <!-- Mostrar archivos -->
    <div class="file-display">
    <?php if (!empty($archivos)): ?>
        <?php foreach ($archivos as $archivo): ?>
            <?php
            $extension = pathinfo($archivo->nombreA, PATHINFO_EXTENSION);
            $icon = match (strtolower($extension)) {
                'pdf' => $iconPath . 'pdf-icon.png',
                'doc', 'docx' => $iconPath . 'word-icon.png',
                'xls', 'xlsx' => $iconPath . 'excel-icon.png',
                'jpg', 'jpeg', 'png' => $iconPath . 'image-icon.png',
                'zip', 'rar' => $iconPath . 'zip-icon.png',
                'txt' => $iconPath . 'txt-icon.png',
                default => $iconPath . 'file-icon.png',
            };
            ?>
            <div class="file-item">
                <a href="<?= Yii::$app->request->baseUrl . $archivo->ruta ?>" download="<?= $archivo->nombreA ?>">
                    <img src="<?= $icon ?>" alt="<?= $extension ?> icon" class="file-icon">
                    <p><?= Html::encode($archivo->nombreA) ?></p>
                </a>
                <!-- Botón para eliminar archivo -->
                <?= Html::a('Eliminar', ['site/eliminararchivo', 'id' => $archivo->archivoID], [ // Cambiar 'id' a 'archivoID'
                    'class' => 'btn btn-danger btn-sm',
                    'data' => [
                        'confirm' => '¿Estás seguro de que deseas eliminar este archivo?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay archivos disponibles.</p>
    <?php endif; ?>
</div>


<script>
    function toggleMenu() {
        const menu = document.getElementById("menuOpciones");
        menu.style.display = menu.style.display === "block" ? "none" : "block";
    }

    // Oculta el menú al salir del área
    document.querySelector(".menu-desplegable").addEventListener("mouseleave", function () {
        document.getElementById("menuOpciones").style.display = "none";
    });

    function abrirExploradorArchivos() {
        document.getElementById('archivo').click();
    }

    function abrirExploradorCarpetas() {
        document.getElementById('inputCarpeta').click();
    }

    function abrirModal() {
        document.getElementById('crearCarpetaModal').style.display = 'flex';
    }

    function cerrarModal() {
        document.getElementById('crearCarpetaModal').style.display = 'none';
    }
</script>

<style>
    /* General styles */
    body {
        background-color: #f4f4f9;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .container {
        padding: 20px;
    }

    .menu-desplegable {
    position: fixed;
    top: 80px; /* Baja el botón más abajo (ajusta según lo necesario) */
    right: 10px; /* Mantiene el botón cerca del borde derecho */
    z-index: 1000;
    background-color: rgba(255, 255, 255, 0.9); /* Color de fondo para visibilidad */
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}



    .btn-menu {
        background-color: #004ed6;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .menu-opciones {
        display: none;
        position: absolute;
        top: 40px;
        right: 0;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        width: 200px;
        z-index: 1000;
    }

    .menu-item {
        display: block;
        padding: 10px;
        text-decoration: none;
        color: #333;
        font-size: 14px;
    }

    .menu-item:hover {
        background-color: #004ed6;
        color: white;
    }

    /* Files and folders */
    .file-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .file-item {
    position: relative;
    text-align: center;
    margin: 10px;
}

.file-item .btn {
    display: none;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.file-item:hover .btn {
    display: inline-block;
}


    .file-icon {
        width: 50px;
        height: 50px;
    }
    .file-display {
    display: flex; /* Activa Flexbox */
    flex-wrap: wrap; /* Permite que los elementos salten a la línea siguiente si no caben */
    gap: 15px; /* Espaciado entre elementos */
    justify-content: flex-start; /* Alinea los elementos desde la izquierda */
    align-items: center; /* Alinea los elementos verticalmente al centro */
}



    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
    }
</style>



