<?php
use yii\helpers\Html;
$this->title = 'Archivos';

/* @var $this yii\web\View */
/* @var $archivos array */

// Definir la ruta de la carpeta de íconos
$iconPath = Yii::getAlias('@web') . '/Imagenes/icons/';

?>

<h1><?= Html::encode($this->title) ?></h1>
<body style='background-color:#e6effa'></body>
<?php if (!empty($archivos)): ?>
    <div style="display: flex; flex-wrap: wrap; gap: 20px;">
        <?php foreach ($archivos as $archivo): ?>
            <?php
                // Obtener la extensión del archivo
                $extension = pathinfo($archivo, PATHINFO_EXTENSION);
                
                // Asignar el ícono según la extensión del archivo
                switch ($extension) {
                    case 'pdf':
                        $icon = $iconPath . 'pdf-icon.png';
                        break;
                    case 'docx':
                        $icon = $iconPath . 'word-icon.png';
                        break;
                    case 'txt':
                        $icon = $iconPath . 'txt-icon.png';
                        break;
                    case 'xlsx':
                        $icon = $iconPath . 'excel-icon.png';
                        break;
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                        $icon = $iconPath . 'image-icon.png';
                        break;
                    case 'txt':
                        $icon = $iconPath . 'txt-icon.png';
                        break;
                    default:
                        $icon = $iconPath . 'file-icon.png'; // Ícono genérico
                        break;
                }
            ?>
            <div style="width: 140px; height: 160px; text-align: center;">
                <div style="background-color: #ffffff; padding: 10px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                    <!-- Mostrar el ícono del archivo con tamaño fijo -->
                    <img src="<?= $icon ?>" alt="<?= $extension ?> icon" style="width: 50px; height: 50px; margin-bottom: 10px;">
                    <!-- Enlace al archivo -->
                    <p style="margin: 0; font-size: 12px; text-align: center;">
                        <?= Html::a($archivo, ['uploads/' . $archivo], ['target' => '_blank', 'style' => 'text-decoration: none; color: #333;']) ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No hay archivos subidos.</p>
<?php endif; ?>

