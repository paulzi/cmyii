<?php

namespace paulzi\cmyii\admin\widgets;

use paulzi\fileBehavior\File;
use yii\base\Model;
use yii\base\Widget;
use yii\helpers\Html;

class FileInput extends Widget
{
    /**
     * @var Model
     */
    public $model;

    /**
     * @var string
     */
    public $attribute;

    /**
     * @var string
     */
    public $name;

    /**
     * @var File|File[]
     */
    public $value;

    /**
     * @var int
     */
    public $basicCount = 3;

    /**
     * @var string
     */
    public $thumbType;

    /**
     * @var array
     */
    public $options = [];

    /**
     * @var array
     */
    public $accept;

    /**
     * @var string
     */
    public $template = 'file-input/file';


    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->model && $this->attribute) {
            $this->value = $this->value ?: $this->model->{$this->attribute};
            $this->name  = $this->name  ?: Html::getInputName($this->model, $this->attribute) . (is_array($this->value) ? '[]' : null);
        }
        $this->value = is_array($this->value) ? $this->value : ($this->value && $this->value->value ? [$this->value] : []);

        Html::addCssClass($this->options, 'file-styler file-styler-uninitialized');
        if (!$this->value) {
            Html::addCssClass($this->options, 'file-styler-empty');
        }
        if ($this->accept === null && strpos($this->options['class'], 'file-styler-type-image') !== false) {
            $this->accept = ['.jpg', '.jpeg', '.png', '.gif'];
        }
        return $this->render('file-input/file', ['widget' => $this]);
    }
}