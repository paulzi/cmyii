<?php
use yii\helpers\Html;
use paulzi\cmyii\admin\assets\CmsAsset;

/* @var $this \yii\web\View */
/* @var $content string */

CmsAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="no-js">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <header id="l-header">
            <div class="side-toggler toggle-off" data-toggle="toggle" data-target="#l-side, .side-toggler">
                <i class="icon icon-menu">&#xE5d2;</i>
                <i class="icon icon-arrow-back">&#xE5c4;</i>
            </div>
            <div class="logo">
                <a href="#"><?= Html::encode(Yii::$app->name) ?></a>
            </div>
        </header>
        <div id="l-main">
            <?php if (!Yii::$app->user->isGuest): ?>
                <aside id="l-side" class="toggle-off">
                    <div>
                        <nav>
                            <?php if (Yii::$app->user->can('admin')): ?>
                                <?= \paulzi\cmyii\admin\widgets\TreeMenuWidget::widget([
                                    'type'      => 'root',
                                    'cookie'    => 'pz-tree',
                                ]) ?>
                            <?php endif; ?>
                        </nav>
                    </div>
                </aside>
            <?php endif; ?>
            <main>
                <div class="container">
                    <?= $content ?>
                </div>
            </main>
        </div>
        <footer id="l-footer">
            Copyright © <?= date('Y') ?> CMYii <?= \paulzi\cmyii\Cmyii::getInstance()->getVersion() ?> / Yii Framework <?= Yii::getVersion() ?>
        </footer>

        <?= \paulzi\cmyii\admin\widgets\Alert::widget() ?>

        <div class="modal fade" id="modal-remote" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content"></div>
            </div>
        </div>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
