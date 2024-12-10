<?php

use yii\helpers\Html;

$this->title = 'Academic Organizer';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Html::encode($this->title) ?></title>
    <style>
        body {
            background: #f4f4f9;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            padding-left: 150px; /* Desplaza todo el contenido hacia la derecha */
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #1e40af;
        }

        .modules {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .module {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .module:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .module-icon {
            font-size: 40px;
            color: #7e22ce;
            margin-bottom: 10px;
        }

        .module-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .module-description {
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Bienvenido a Academic Organizer!</h1>
            <p>Organiza tus archivos, notas y actividades académicas fácilmente.</p>
        </div>
        <div class="modules">
            <div class="module">
                <div class="module-icon">📁</div>
                <div class="module-title">Carpetas</div>
                <div class="module-description">
                    Sube archivos, crea carpetas y organiza todo en un solo lugar.
                </div>
            </div>
            <div class="module">
                <div class="module-icon">🗓️</div>
                <div class="module-title">Recordatorios</div>
                <div class="module-description">
                    Organiza tus eventos y actividades con un calendario integrado.
                </div>
            </div>
            <div class="module">
                <div class="module-icon">📝</div>
                <div class="module-title">Bloc de notas</div>
                <div class="module-description">
                    Crea notas rápidas y accede a ellas en cualquier momento.
                </div>
            </div>
            <div class="module">
                <div class="module-icon">📤</div>
                <div class="module-title">Compartir</div>
                <div class="module-description">
                    Comparte tu contenido académico con tus compañeros por correo.
                </div>
            </div>
        </div>
    </div>
</body>
</html>





