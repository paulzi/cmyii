<?php

namespace paulzi\cmyii\admin\widgets;

use paulzi\cmyii\admin\components\IDisplayStates;
use yii\base\Widget;

class DisplayStates extends Widget
{
    /**
     * @var IDisplayStates
     */
    public $container;

    /**
     * @var string
     */
    public $template = 'display-states/main';


    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render($this->template, [
            'container' => $this->container,
        ]);
    }
}