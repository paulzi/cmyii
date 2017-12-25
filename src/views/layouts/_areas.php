<?php
use paulzi\cmyii\admin\widgets\Area;
/**
 * @var yii\web\View $this
 * @var paulzi\cmyii\models\Layout $layout
 * @var paulzi\cmyii\models\Page $page
 */
?>
<?= Area::widget([
    'id'     => 'main',
    'layout' => $layout,
    'page'   => $page,
    'title'  => 'Основная область',
]) ?>