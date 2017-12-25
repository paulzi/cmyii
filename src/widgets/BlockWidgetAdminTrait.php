<?php

namespace paulzi\cmyii\admin\widgets;

use paulzi\cmyii\models\Layout;
use paulzi\cmyii\models\Page;
use yii\base\Model;

/**
 * @mixin \paulzi\cmyii\widgets\BlockWidget
 *
 * @property string $adminTitle
 * @property array $adminTemplates
 */
trait BlockWidgetAdminTrait
{
    /**
     * @return string
     */
    public static function getAdminTitle()
    {
        return static::className();
    }

    /**
     * @return array
     */
    public static function getAdminTemplates()
    {
        return [];
    }

    /**
     * @return string
     */
    public static function getAdminSettingsModelClass()
    {
        return null;
    }

    /**
     * @return string
     */
    public static function getFrontendWidgetClass()
    {
        return get_parent_class();
    }

    /**
     * @return array
     */
    public static function registerControllers()
    {
        return [];
    }

    /**
     * @param Page $page
     * @param Layout $layout
     * @return bool
     */
    public function hasData($page, $layout = null)
    {
        return false;
    }

    /**
     * @return Model
     */
    public function getAdminSettingsModel()
    {
        $settingsClass = $this->getAdminSettingsModelClass();
        if ($settingsClass) {
            /** @var Model $settings */
            $settings = new $settingsClass();
            $settings->setAttributes($this->block->getInitParams());
            return $settings;
        }
        return null;
    }

    /**
     * @param Model $model
     * @param ActiveForm $form
     * @return string
     */
    public function renderSettings($model = null, $form = null)
    {
        $model = $model ?: $this->getAdminSettingsModel();
        if ($model) {
            return $this->render('settings', [
                'widget' => $this,
                'model'  => $model,
                'form'   => $form ?: new ActiveForm(),
            ]);
        }
        return null;
    }
}