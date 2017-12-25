<?php

namespace paulzi\cmyii\admin\models;

use paulzi\cmyii\admin\CmyiiAdmin;
use paulzi\cmyii\admin\widgets\BlockWidgetAdminTrait;
use paulzi\sortable\SortableBehavior;
use paulzi\sortable\SortableTrait;
use Yii;

/**
 * @property string $adminWidgetClass
 * @property \paulzi\cmyii\widgets\BlockWidget|BlockWidgetAdminTrait $adminWidgets
 */
class Block extends \paulzi\cmyii\models\Block implements IToggleable, ISortable, IMarkable
{
    use SortableTrait;

    /**
     * @var \paulzi\cmyii\widgets\BlockWidget|BlockWidgetAdminTrait
     */
    private $_adminWidget;


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => SortableBehavior::className(),
                'query' => ['page_id', 'layout_id', 'area'],
            ]
        ]);
    }

    /**
     * @return string
     */
    public function getAdminWidgetClass()
    {
        return CmyiiAdmin::getInstance()->getAdminWidgetClass($this->widget_class);
    }

    /**
     * @return \paulzi\cmyii\widgets\BlockWidget|BlockWidgetAdminTrait
     * @throws \yii\base\InvalidConfigException
     */
    public function getAdminWidget()
    {
        $widgetClass = $this->getAdminWidgetClass();
        if ($this->_adminWidget === null && $widgetClass) {
            $this->_adminWidget = Yii::createObject(array_merge($this->getInitParams(), ['class' => $widgetClass]));
            $this->_adminWidget->block = $this;
        }
        return $this->_adminWidget;
    }

    /**
     * @return array
     */
    public function getTemplatesData()
    {
        /** @var BlockWidgetAdminTrait $adminWidgetClass */
        $adminWidgetClass = $this->getAdminWidgetClass();
        if ($adminWidgetClass) {
            return $adminWidgetClass::getAdminTemplates();
        } else {
            return [];
        }
    }

    /**
     * @inheritdoc
     */
    public function getSortablePosition()
    {
        return $this->sort;
    }

    /**
     * @return array
     */
    public function sortableCopyCond()
    {
        return [
            'and',
            [
                'entity'    => $this->className(),
                'area'      => $this->area,
                'page_id'   => $this->page_id,
                'layout_id' => $this->layout_id,
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
        return $item->area === $this->area && $item->page_id === $this->page_id && $item->layout_id === $this->layout_id && $item->id !== $this->id;
    }

    /**
     * @return array
     */
    public function markData()
    {
        return [
            'entity'    => $this->className(),
            'id'        => $this->id,
            'area'      => $this->area,
            'page_id'   => $this->page_id,
            'layout_id' => $this->layout_id,
        ];
    }
}