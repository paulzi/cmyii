<?php

namespace paulzi\cmyii\admin\widgets;

use paulzi\cmyii\admin\models\Block;

class Area extends \paulzi\cmyii\widgets\Area
{
    /**
     * @var bool
     */
    public $showDisabled = true;

    /**
     * @var bool
     */
    public $checkRoles = false;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $template = 'area/main';

    /**
     * @var \paulzi\cmyii\admin\models\Block[] $blocks
     */
    protected $blocks = [];


    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render($this->template, [
            'widget' => $this,
            'blocks' => $this->blocks,
            'title'  => isset($this->title) ? $this->title : $this->id,
        ]);
    }

    /**
     * @return string
     */
    protected static function getBlockClass()
    {
        return Block::className();
    }
}