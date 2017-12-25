<?php

namespace paulzi\cmyii\admin\widgets;

use yii\helpers\Html;

class ActiveField extends \yii\widgets\ActiveField
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!isset($this->inputOptions['placeholder'])) {
            $this->inputOptions['placeholder'] = $this->model->getAttributeLabel($this->attribute);
        }
    }

    /**
     * @param array $options
     * @return $this
     */
    public function switcher($options = [])
    {
        $this->parts['{input}'] = Html::activeSwitcher($this->model, $this->attribute, $options);
        $this->parts['{label}'] = '';
        $this->adjustLabelFor($options);
        return $this;
    }

    /**
     * @param array $items
     * @param array $options
     * @return $this
     */
    public function triStateCheckbox($items = null, $options = [])
    {
        $this->parts['{input}'] = Html::activeTriStateCheckbox($this->model, $this->attribute, $items, $options);
        return $this;
    }

    /**
     * @param array $items
     * @param array $options
     * @return $this
     */
    public function triStateSwitcher($items = null, $options = [])
    {
        $this->parts['{input}'] = Html::activeTriStateSwitcher($this->model, $this->attribute, $items, $options);
        return $this;
    }

    /**
     * @return $this
     */
    public function inline()
    {
        ob_start();
        return $this;
    }

    /**
     * @return $this
     */
    public function inlineEnd()
    {
        $this->parts['{input}'] = ob_get_clean();
        return $this;
    }
}