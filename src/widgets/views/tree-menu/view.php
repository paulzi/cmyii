<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var array  $data
 * @var string $type
 * @var string $id
 * @var array  $expanded
 */
$itemId     = $type . ($id !== null ? "-{$id}" : null);
$isExpanded = isset($expanded[$itemId]);
?>
<?= Html::beginTag('ul', [
    'id'    => "pz-tree-{$type}" . ($id !== null ? '-' . $id : null),
    'class' => 'pz-tree collapse' . ($type === 'root' || $isExpanded ? ' in' : null),
    'data'  => $type === 'root' ? ['url' => Url::toRoute(['default/tree-menu'])] : null,
]) ?>
    <?php foreach ($data as $item): ?>
        <?php
        $item['id'] = isset($item['id']) ? $item['id'] : null;
        $itemId     = $item['type'] . ($item['id'] !== null ? "-{$item['id']}" : null);
        $isExpanded = isset($expanded[$itemId]);
        $options = [
            'data'  => [
                'type' => $item['type'],
            ],
        ];
        if ($item['id'] !== null) {
            $options['data']['id'] = $item['id'];
        }
        if ($isExpanded) {
            $options['class'] = 'pz-tree-expand';
        }
        if (Yii::$app->controller->id === $item['type'] && Yii::$app->request->get('id') == $item['id']) {
            Html::addCssClass($options, 'active');
        }
        ?>
        <?= Html::beginTag('li', $options) ?>
            <?php if (!empty($item['hasChild'])): ?>
                <i class="icon icon-more" data-toggle="collapse" data-target="#pz-tree-<?= $itemId ?>">&#xE5CF;</i>
                <i class="icon icon-spin">&#xE5D5;</i>
            <?php endif; ?>
            <a href="<?= Url::toRoute($item['url']) ?>">
                <?php if (!empty($item['icon'])): ?>
                    <i class="icon"><?= $item['icon'] ?></i>
                <?php endif; ?>
                <?= Html::encode($item['label']) ?>
            </a>
            <?php if ($isExpanded): ?>
                <?= \paulzi\cmyii\admin\widgets\TreeMenuWidget::widget([
                    'type'      => $item['type'],
                    'id'        => $item['id'],
                    'expanded'  => $expanded,
                ]) ?>
            <?php endif; ?>
    <?php endforeach; ?>
<?= Html::endTag('ul') ?>