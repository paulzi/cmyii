<?php

namespace paulzi\cmyii\admin\widgets;

use paulzi\cmyii\admin\models\Block;
use yii\base\Widget;
use yii\helpers\Html;

class DataTabs extends Widget
{
    /**
     * @var \paulzi\cmyii\models\Page
     */
    public $page;

    /**
     * @var \paulzi\cmyii\models\Layout
     */
    public $layout;

    /**
     * @var string
     */
    public $area;

    /**
     * @var string
     */
    public $active;

    /**
     * @var string
     */
    public $template = 'data-tabs/main';


    /**
     * @inheritdoc
     */
    public function run()
    {
        $blocks = Block::find()->forArea(null, $this->page, $this->layout)->all();
        Block::getInheritance($blocks, $this->page, $this->layout);
        return $this->render($this->template, [
            'widget' => $this,
            'blocks' => $blocks,
        ]);
    }
}