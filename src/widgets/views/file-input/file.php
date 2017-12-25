<?php

use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var \paulzi\cmyii\admin\widgets\FileInput $widget
 */
$isMultiple = substr($widget->name, -2) === '[]';
?>
<?= Html::beginTag('div', $widget->options) ?>
    <div class="file-styler-list">
        <?php foreach ($widget->value as $file): ?>
            <?php $isImage = in_array(pathinfo($file->value, PATHINFO_EXTENSION), ['jpg', 'png', 'gif']); ?>
            <div class="file-styler-item<?= $isImage ? ' file-styler-item-image' : null ?>">
                <?= Html::hiddenInput($widget->name, $file->value) ?>
                <?php if ($isImage): ?>
                    <div class="file-styler-image"><?= Html::img($widget->thumbType ? $file->{$widget->thumbType}->url : $file->url) ?></div>
                <?php endif; ?>
                <div class="file-styler-name"><i class="icon"></i><?= Html::encode(basename($file->value)) ?></div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php for ($i = 0; $i < $widget->basicCount; $i++): ?>
        <label class="file-styler-file">
            <span>Выбрать файлы</span>
            <input type="file" name="<?= $widget->name ?>"<?= $isMultiple ? ' multiple' : null ?><?= $widget->accept ? ' accept="' . implode(',', $widget->accept). '"' : null ?>>
        </label>
    <?php endfor; ?>
    <span class="btn btn-warning file-styler-clear">Убрать файлы</span>
<?= Html::endTag('div') ?>