<?php

namespace common\cmyii\text\controllers;

use common\cmyii\text\models\Text;
use paulzi\cmyii\admin\controllers\Controller;

class TextController extends Controller
{
    /**
     * @return string
     */
    public function getModelClass()
    {
        return Text::className();
    }
}