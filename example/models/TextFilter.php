<?php

namespace common\cmyii\text\models;

use Yii;
use yii\base\Model;
use paulzi\cmyii\models\ActiveQuery;

class TextFilter extends Model
{
    public $q;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['q'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'q' => 'Поиск',
        ];
    }

    /**
     * @param ActiveQuery $query
     * @return ActiveQuery
     */
    public function apply($query)
    {
        $query->andFilterWhere(['like', 'content', $this->q]);
        return $query;
    }
}
