<?php

namespace yii\helpers;

class Html extends BaseHtml
{
    /**
     * @inheritdoc
     */
    public static function input($type, $name = null, $value = null, $options = [])
    {
        $result   = parent::input($type, $name, $value, $options);
        $stylized = ArrayHelper::remove($options, 'stylized');
        if ($stylized) {
            $result = static::tag('div', $result, ['class' => 'form-control-wrap']);
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public static function textInput($name, $value = null, $options = [])
    {
        if (!isset($options['stylized'])) {
            $options['stylized'] = true;
        }
        return parent::textInput($name, $value, $options);
    }

    /**
     * @inheritdoc
     */
    public static function passwordInput($name, $value = null, $options = [])
    {
        if (!isset($options['stylized'])) {
            $options['stylized'] = true;
        }
        return parent::textInput($name, $value, $options);
    }

    /**
     * @inheritdoc
     */
    public static function textarea($name, $value = '', $options = [])
    {
        $result   = parent::textarea($name, $value, $options);
        $stylized = ArrayHelper::remove($options, 'stylized');
        if ($stylized) {
            $result = static::tag('div', $result, ['class' => 'form-control-wrap']);
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public static function dropDownList($name, $selection = null, $items = [], $options = [])
    {
        $result   = parent::dropDownList($name, $selection, $items, $options);
        $stylized = ArrayHelper::remove($options, 'stylized');
        if ($stylized) {
            $result = static::tag('div', $result, ['class' => 'form-control-wrap']);
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public static function listBox($name, $selection = null, $items = [], $options = [])
    {
        $result   = parent::listBox($name, $selection, $items, $options);
        $stylized = ArrayHelper::remove($options, 'stylized');
        if ($stylized) {
            $result = static::tag('div', $result, ['class' => 'form-control-wrap']);
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public static function activeTextInput($model, $attribute, $options = [])
    {
        if (!isset($options['stylized'])) {
            $options['stylized'] = true;
        }
        return parent::activeTextInput($model, $attribute, $options);
    }

    /**
     * @inheritdoc
     */
    public static function activePasswordInput($model, $attribute, $options = [])
    {
        if (!isset($options['stylized'])) {
            $options['stylized'] = true;
        }
        return parent::activePasswordInput($model, $attribute, $options);
    }

    /**
     * @inheritdoc
     */
    public static function activeTextarea($model, $attribute, $options = [])
    {
        if (!isset($options['stylized'])) {
            $options['stylized'] = true;
        }
        return parent::activeTextarea($model, $attribute, $options);
    }

    /**
     * @inheritdoc
     */
    public static function activeDropDownList($model, $attribute, $items, $options = [])
    {
        if (!isset($options['stylized'])) {
            $options['stylized'] = true;
        }
        return parent::activeDropDownList($model, $attribute, $items, $options);
    }

    /**
     * @inheritdoc
     */
    public static function activeListBox($model, $attribute, $items, $options = [])
    {
        if (!isset($options['stylized'])) {
            $options['stylized'] = true;
        }
        return parent::activeListBox($model, $attribute, $items, $options);
    }

    /**
     * @param array $options
     * @param string $baseClass
     */
    protected static function switchOptions(&$options, $baseClass)
    {
        $stylized = ArrayHelper::remove($options, 'stylized', true);
        if ($stylized) {
            if (!isset($options['labelOptions'])) {
                $options['labelOptions'] = [];
            }
            static::addCssClass($options['labelOptions'], $baseClass);
            if (isset($options['label'])) {
                $options['label'] = '<i></i>' . static::tag('span', $options['label']);
            } else {
                $options['label'] = '<i></i>';
            }
        }
    }

    /**
     * @inheritdoc
     */
    public static function checkbox($name, $checked = false, $options = [])
    {
        static::switchOptions($options, 'switch switch-check');
        return parent::checkbox($name, $checked, $options);
    }

    /**
     * @inheritdoc
     */
    public static function radio($name, $checked = false, $options = [])
    {
        static::switchOptions($options, 'switch switch-radio');
        return parent::radio($name, $checked, $options);
    }

    /**
     * @param string $name
     * @param bool $checked
     * @param array $options
     * @return string
     */
    public static function switcher($name, $checked = false, $options = [])
    {
        static::switchOptions($options, 'switch switch-swipe');
        return parent::checkbox($name, $checked, $options);
    }

    /**
     * @param \yii\base\Model $model
     * @param string $attribute
     * @param array $options
     * @return string
     */
    public static function activeSwitcher($model, $attribute, $options = [])
    {
        return static::activeBooleanInput('switcher', $model, $attribute, $options);
    }

    /**
     * @param string $name
     * @param string $selection
     * @param array $items In order - [off, null, on] or [off, on]
     * @param array $options You can add 'values' property
     * @return string
     */
    protected static function triState($name, $selection = null, $items = [], $options = [])
    {
        if (count($items) === 2) {
            static::addCssClass($options, 'tristate-2');
            $defaultValues = ['0', '1'];
        } else {
            static::addCssClass($options, 'tristate-3');
            $defaultValues = ['0', '', '1'];
        }
        $inputs = $labels = [];
        $id     = isset($options['id']) ? $options['id'] : str_replace(['[]', '][', '[', ']', ' ', '.'], ['', '-', '-', '', '-', '-'], $name);
        $values = ArrayHelper::remove($options, 'values', $defaultValues);
        foreach ($items as $i => $label) {
            $value = $values[$i];
            $inputs[] = parent::radio($name, "$selection" === "$value", [
                'id'    => "{$id}-{$i}",
                'value' => $value,
            ]);
            $labels[] = parent::label($label, $id . '-' . ($i < count($items) - 1 ? $i + 1 : 0));
        }

        return Html::tag('span', implode($inputs) . '<i></i>' . implode($labels), $options);
    }

    /**
     * @param string $name
     * @param string $selection
     * @param array $items
     * @param array $options
     * @return string
     */
    public static function triStateCheckbox($name, $selection = null, $items = [], $options = [])
    {
        static::addCssClass($options, 'switch switch-check tristate');
        return static::triState($name, $selection, $items, $options);
    }

    /**
     * @param string $name
     * @param string $selection
     * @param array $items
     * @param array $options
     * @return string
     */
    public static function triStateSwitcher($name, $selection = null, $items = [], $options = [])
    {
        static::addCssClass($options, 'switch switch-swipe tristate');
        return static::triState($name, $selection, $items, $options);
    }

    /**
     * @param \yii\base\Model $model
     * @param string $attribute
     * @param array $items
     * @param array $options
     * @return string
     */
    public static function activeTriStateCheckbox($model, $attribute, $items = null, $options = [])
    {
        $name = isset($options['name']) ? $options['name'] : static::getInputName($model, $attribute);
        $value = static::getAttributeValue($model, $attribute);
        if ($items === null) {
            $label = static::encode($model->getAttributeLabel(static::getAttributeName($attribute)));
            $items = [$label, $label, $label];
        }
        return static::triStateCheckbox($name, $value, $items, $options);
    }

    /**
     * @param \yii\base\Model $model
     * @param string $attribute
     * @param array $items
     * @param array $options
     * @return string
     */
    public static function activeTriStateSwitcher($model, $attribute, $items = null, $options = [])
    {
        $name = isset($options['name']) ? $options['name'] : static::getInputName($model, $attribute);
        $value = static::getAttributeValue($model, $attribute);
        if ($items === null) {
            $label = static::encode($model->getAttributeLabel(static::getAttributeName($attribute)));
            $items = [$label, $label, $label];
        }
        return static::triStateSwitcher($name, $value, $items, $options);
    }

    /**
     * @inheritdoc
     */
    protected static function activeListInput($type, $model, $attribute, $items, $options = [])
    {
        $name = isset($options['name']) ? $options['name'] : static::getInputName($model, $attribute);
        $selection = ArrayHelper::remove($options, 'selection', static::getAttributeValue($model, $attribute));
        if (!array_key_exists('unselect', $options)) {
            $options['unselect'] = '';
        }
        if (!array_key_exists('id', $options)) {
            $options['id'] = static::getInputId($model, $attribute);
        }
        return static::$type($name, $selection, $items, $options);
    }
}