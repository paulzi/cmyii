<?php

namespace paulzi\cmyii\admin\widgets;

use Yii;
use yii\helpers\Html;
use yii\base\Widget;

class Alert extends Widget
{
    const TYPE_SUCCESS = 'success';
    const TYPE_DANGER  = 'danger';
    const TYPE_WARNING = 'warning';
    const TYPE_INFO    = 'info';

    public static $cssClassMap = [
        self::TYPE_SUCCESS => 'alert alert-success',
        self::TYPE_DANGER  => 'alert alert-danger',
        self::TYPE_WARNING => 'alert alert-warning',
        self::TYPE_INFO    => 'alert alert-info',
    ];

    /**
     * @var array
     */
    public $options = [];


    /**
     * @inheritdoc
     */
    public function run()
    {
        $options = $this->options;
        Html::addCssClass($options, 'alert-fixed');
        $result = Html::beginTag('div', $options);
        $session = Yii::$app->getSession();
        $flashes = $session->getAllFlashes();
        foreach ($flashes as $type => $data) {
            if (isset(static::$cssClassMap[$type])) {
                foreach ((array)$data as $i => $message) {
                    $result .= static::item($message, $type);
                }
                $session->removeFlash($type);
            }
        }
        $result .= Html::endTag('div');

        return $result;
    }

    /**
     * Возвращает разметку элемента алерта
     * @param string $content
     * @param string|null $type
     * @param array $options
     * @return string
     */
    public static function item($content, $type = null, array $options = [])
    {
        Html::addCssClass($options, 'alert');
        if ($type !== null) {
            $class = isset(static::$cssClassMap[$type]) ? static::$cssClassMap[$type] : null;
            if ($class) {
                Html::addCssClass($options, $class);
            }
        }
        return Html::tag('div', $content, $options);
    }
}
