<?php

namespace paulzi\cmyii\admin\widgets;

use paulzi\cmyii\admin\components\DisplayStatesTrait;
use paulzi\cmyii\admin\components\IDisplayStates;
use yii\base\Widget;
use yii\db\BaseActiveRecord;

class Card extends Widget implements IDisplayStates
{
    use DisplayStatesTrait;

    /**
     * @var array
     */
    public $options = [];

    /**
     * @var BaseActiveRecord
     */
    public $model;

    /**
     * @var ListView
     */
    public $listView;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $heading;

    /**
     * @var string
     */
    public $massName = 'mass[]';

    /**
     * @var string
     */
    public $massValue;

    /**
     * @var Actions|array|null
     */
    public $actions;

    /**
     * @var string
     */
    public $view = 'card/standard';


    /**
     * @inheritdoc
     */
    public function init()
    {
        ob_start();
        ob_implicit_flush(false);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $actions = $this->actions;
        if ($actions && !is_object($actions)) {
            if (!isset($actions['class'])) {
                $actions['class'] = Actions::className();
            }
            $actions = \Yii::createObject($actions);
        }

        $this->addStandardStates($this->model);

        return $this->render($this->view, [
            'content' => ob_get_clean(),
            'actions' => $actions,
            'widget'  => $this,
        ]);
    }
}