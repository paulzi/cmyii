<?php

namespace common\cmyii\text\models;

use Yii;
use paulzi\cmyii\admin\models\IMarkable;
use paulzi\cmyii\admin\models\ISortable;
use paulzi\cmyii\admin\models\IToggleable;
use paulzi\sortable\SortableBehavior;
use paulzi\sortable\SortableTrait;
use paulzi\cmyii\models\Page;
use paulzi\cmyii\models\Block;
use paulzi\cmyii\models\ActiveQuery;

/**
 * This is the model class for table "{{%text}}".
 *
 * @property integer $id
 * @property integer $block_id
 * @property integer $page_id
 * @property string $content
 * @property integer $sort
 * @property integer $is_disabled
 *
 * @property Page $page
 * @property Block $block
 */
class Text extends \yii\db\ActiveRecord implements IToggleable, ISortable, IMarkable
{
    use SortableTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cmyii_text}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => SortableBehavior::className(),
                'query' => ['block_id', 'page_id'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id', 'block_id', 'sort'], 'integer'],
            [['is_disabled'], 'boolean'],
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'block_id' => 'ID блока',
            'page_id' => 'ID страницы',
            'content' => 'Содержимое',
            'sort' => 'Порядок',
            'is_disabled' => 'Выключен',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlock()
    {
        return $this->hasOne(Block::className(), ['id' => 'block_id']);
    }

    /**
     * @return mixed
     */
    public function getIsDisabled()
    {
        return $this->getAttribute('is_disabled');
    }

    /**
     * @inheritdoc
     * @return ActiveQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActiveQuery(get_called_class());
    }

    /**
     * @return array
     */
    public function sortableCopyCond()
    {
        return [
            'and',
            [
                'entity'   => $this->className(),
                'block_id' => $this->block_id,
                'page_id'  => $this->page_id,
            ],
            ['<>', 'id', $this->id],
        ];
    }

    /**
     * @param self $item
     * @return bool
     */
    public function sortableAllow($item)
    {
        return $item->block_id === $this->block_id && $item->page_id === $this->page_id && $item->id !== $this->id;
    }

    /**
     * @return array
     */
    public function markData()
    {
        return [
            'entity'   => $this->className(),
            'id'       => $this->id,
            'block_id' => $this->block_id,
            'page_id'  => $this->page_id,
        ];
    }
}
