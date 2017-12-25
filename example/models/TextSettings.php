<?php

namespace common\cmyii\text\models;

use yii\base\Model;

class TextSettings extends Model
{
    public $flipOrder;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['flipOrder'], 'string'],
            [['flipOrder'], 'default'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'flipOrder' => 'Обратный порядок',
        ];
    }
}