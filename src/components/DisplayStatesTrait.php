<?php

namespace paulzi\cmyii\admin\components;

use paulzi\cmyii\admin\models\IToggleable;
use yii\base\Model;

trait DisplayStatesTrait
{
    /**
     * @var array
     */
    public $states = [];

    /**
     * @var array
     */
    public static $stateIcons = [
        IDisplayStates::STATE_SUCCESS => '&#xE5CA;',
        IDisplayStates::STATE_INFO    => '&#xE88E;',
        IDisplayStates::STATE_WARNING => '&#xE002;',
        IDisplayStates::STATE_DANGER  => '&#xE000;',
    ];


    /**
     * @param string $type
     * @param string $message
     * @param string $icon
     */
    public function addState($type, $message = null, $icon = null)
    {
        $this->states[] = [
            'type'    => $type,
            'message' => $message,
            'icon'    => $icon,
        ];
    }

    /**
     * @return string|null
     */
    public function getMaxState()
    {
        $list   = array_flip(array_keys(static::$stateIcons));
        $result = null;
        foreach ($this->states as $state) {
            if ($result === null || $list[$result] < $list[$state['type']]) {
                $result = $state['type'];
            }
        }
        return $result;
    }

    /**
     * @param Model $model
     */
    public function addStandardStates($model) {
        if ($model instanceof IToggleable) {
            if ($model->getIsDisabled()) {
                $this->addState(IDisplayStates::STATE_INFO, 'Элемент отключён', '&#xE8AC;');
            }
        }
    }
}