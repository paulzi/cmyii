<?php

namespace common\cmyii\text;

use Yii;
use yii\data\ActiveDataProvider;
use paulzi\cmyii\admin\widgets\BlockWidgetAdminTrait;
use common\cmyii\text\controllers\TextController;
use common\cmyii\text\models\TextSettings;
use common\cmyii\text\models\TextFilter;


class TextAdminWidget extends TextWidget
{
    use BlockWidgetAdminTrait;

    /**
     * @inheritdoc
     */
    public static function getAdminTitle()
    {
        return 'Текст';
    }

    /**
     * @inheritdoc
     */
    public static function getAdminTemplates()
    {
        return [
            'index' => 'основной',
            'clear' => 'чистый вывод',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function getAdminSettingsModelClass()
    {
        return TextSettings::className();
    }

    /**
     * @inheritdoc
     */
    public static function registerControllers()
    {
        return ['text' => TextController::className()];
    }

    /**
     * @inheritdoc
     */
    public function hasData($page, $layout = null)
    {
        return $this->block->page_id || ($layout && $this->block->layout_id);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $filter = new TextFilter();
        $filter->load(Yii::$app->request->post());
        $query = $filter->apply($this->getBaseQuery());

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  => false,
        ]);



        return $this->render('admin', [
            'widget'        => $this,
            'dataProvider'  => $dataProvider,
            'filter'        => $filter,
        ]);
    }
}