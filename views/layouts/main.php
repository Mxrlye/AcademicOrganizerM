<?php
/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Html;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/Imagenes/Logoo.ico')]);
$this->registerCssFile('@web/css/site.css');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        .navbar-nav {
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #d0d1da;
            height: 100%;
            width: 180px;
            padding: 10px 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
            justify-content: space-between;
        }

        .navbar-nav .nav-link {
            color: black;
            padding: 10px 15px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            background-color: #34495e;
            color: #ffffff;
        }

        .navbar-nav .nav-link.active {
            background-color: #2980b9;
            color: white;
        }

        .navbar-nav .nav-link img {
            width: 20px;
            height: 20px;
        }

        .container {
            margin-left: 200px;
            padding: 20px;
        }

        footer {
            margin-left: 200px;
        }

        .navbar-nav .profile-section {
            margin-top: auto;
            padding-top: 15px;
            border-top: 1px solid #7f8c8d;
        }

        .navbar-nav .dropdown-menu {
            position: absolute;
            left: 0;
            transform: translateY(-100%);
            width: 180px;
            background-color: #34495e;
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .navbar-nav .dropdown-menu .dropdown-item {
            color: #ecf0f1;
            padding: 10px;
            transition: background-color 0.3s ease;
        }

        .navbar-nav .dropdown-menu .dropdown-item:hover {
            background-color: #2980b9;
            color: white;
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<?php if (!Yii::$app->user->isGuest): ?>
<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => '',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-vertical'],
        'items' => [
            ['label' => Html::img('@web/Imagenes/Logoo.png') . ' ACADEMIC ORGANIZER', 'url' => ['/site/index'], 'encode' => false],
            ['label' => Html::img('@web/Imagenes/carpetas.png') . ' Carpetas', 'url' => ['/site/carpetas'], 'encode' => false],
            ['label' => Html::img('@web/Imagenes/calendario.png') . ' Recordatorio', 'url' => ['/site/about'], 'encode' => false],
            ['label' => Html::img('@web/Imagenes/blocN.png') . ' Bloc de Notas', 'url' => ['/site/contact'], 'encode' => false],
            ['label' => Html::img('@web/Imagenes/compartir.png') . ' Compartir', 'url' => ['/site/compartir'], 'encode' => false],
            [
                'label' => Html::img('@web/Imagenes/user-icon.png', ['alt' => 'Usuario', 'class' => 'user-icon']) . ' Perfil',
                'url' => '#',
                'options' => ['class' => 'profile-section'],
                'encode' => false,
                'items' => [
                    ['label' => 'Perfil', 'url' => ['/site/profile']],
                    ['label' => 'Salir', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
                ],
            ],
        ],
    ]);
    NavBar::end();
    ?>
</header>
<?php endif; ?>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?= $content ?>
    </div>
</main>

<?php if (!Yii::$app->user->isGuest): ?>
<footer id="footer" class="mt-auto py-1 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-4 text-center text-md-start">&copy; Academic Organizer <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>
<?php endif; ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>




