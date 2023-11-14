<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<section class="body">
    <header>
        <div class="container">
            <div class="header">
                <a href="/">На главную</a>
                <? if (!Yii::$app->user->isGuest) { ?><a href="/admin/">Админка</a><? } ?>
                <? if (Yii::$app->user->isGuest) { ?>
                    <a href="/admin/login">Вход в админку</a>
                <? } else { ?>
                    <a href="/admin/logout">Выход из админки</a>
                <? } ?>
<!--                <a href="#" onclick="openCart(event)">Корзина <span class="menu-quantity">(--><?php //=$_SESSION['cart.totalQuantity'] ? $_SESSION['cart.totalQuantity'] : 0?><!--)</span></a>-->
                 <a href="#" onclick="openCart(event)">Корзина <span class="menu-quantity">(<?= isset($_SESSION['cart']['totalQuantity']) ? $_SESSION['cart']['totalQuantity'] : 0 ?>)</span></a>
                <form action="<?=Url::to(['category/search'])?>" method="get">
                <input type="text" style="padding: 5px" placeholder="Поиск..." name="search">
                </form>
            </div>
        </div>
    </header>

    <div class="container">
<?= $content ?>
    </div>

    <footer>
        <div class="container">
            <div class="footer">
                &copy; Все права защищены Den4ikom
            </div>
        </div>
    </footer>
</section>

<div id="cart" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div style="padding: 15px" class="modal-content">
        </div>
    </div>
</div>

<div id="order" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div style="padding: 15px" class="modal-content">
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
