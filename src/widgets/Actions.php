<?php

namespace paulzi\cmyii\admin\widgets;

use yii\base\Widget;
use yii\bootstrap\Dropdown;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Actions extends Widget
{
    /**
     * @var array
     */
    public $params = [];

    /**
     * @var bool
     */
    public $useForm = false;

    /**
     * @var array
     */
    public $options = ['class' => 'actions'];

    /**
     * @var array
     */
    public $buttons = [];

    /**
     * @var array
     */
    public $fixed = [];

    /**
     * Set order of buttons and white/blacklist
     * @var array
     */
    public $template;


    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->useForm) {
            return Html::beginForm('', 'post', $this->options) . $this->renderButtons() . Html::endForm();
        } else {
            $tag = ArrayHelper::remove($this->options, 'tag', 'div');
            return Html::tag($tag, $this->renderButtons(), $this->options);
        }
    }

    /**
     * @return string
     */
    protected function renderButtons()
    {
        $fixed = $generic = null;
        foreach ($this->getButtonsProcessed() as $id => $button) {
            $isFixed = in_array($id, $this->fixed);
            if (is_callable($button)) {
                $button = call_user_func($button, $this->params, $this);
            }
            if (is_array($button)) {
                $options = [];
                if (isset($button['label'])) {
                    $options['title'] = $button['label'];
                }
                if (isset($button['options'])) {
                    $options = ArrayHelper::merge($options, $button['options']);
                }
                if (!empty($options['title'])) {
                    Html::addCssClass($options, 'has-tooltip');
                }
                $iconOptions = !empty($button['iconOptions']) ? $button['iconOptions'] : [];
                Html::addCssClass($options, 'actions-item');
                Html::addCssClass($iconOptions, 'icon');
                $content  = null;
                $content .= isset($button['icon'])  ? Html::tag('i', $button['icon'], $iconOptions) : null;
                $content .= isset($button['label']) ? ' <span>' . Html::encode($button['label']) . '</span>' : null;
                $url      = isset($button['url'])   ? $button['url'] : null;
                $tag      = ArrayHelper::remove($button, 'tag', 'a');
                $dropdown = $isFixed && !empty($button['dropdown']) ? $button['dropdown'] : null;
                if ($dropdown) {
                    $options['data-toggle'] = 'dropdown';
                    $options['data-target'] = "#{$this->id}-{$id}";
                }
                if ($tag === 'a') {
                    $content = Html::a($content, $url, $options);
                } else {
                    $content = Html::tag($tag, $content, $options);
                }
                if ($dropdown) {
                    $content .= $this->buildDropDown($id, $button['dropdown']);
                }
                $button = $content;
            }
            if ($isFixed) {
                $fixed .= $button;
            } else {
                $generic .= Html::tag('li', $button);
            }
        }

        $result = $fixed;
        if ($generic) {
            $result .= Html::beginTag('div', ['class' => 'dropdown dropdown-more']);
            $result .= Html::a('<i class="icon">&#xE5D4;</i>', '#', [
                'aria-expanded' => 'false',
                'aria-haspopup' => 'true',
                'data-toggle'   => 'dropdown',
            ]);
            $result .= Html::tag('ul', $generic, ['class' => 'dropdown-menu dropdown-menu-right']);
            $result .= Html::endTag('div');
        }

        return $result;
    }

    /**
     * @return array
     */
    protected function getButtonsProcessed()
    {
        if ($this->template === null) {
            return $this->buttons;
        }
        $flip = array_flip($this->template);
        $result = [];
        foreach ($this->template as $id) {
            if ($id === '...') {
                foreach ($this->buttons as $buttonId => $button) {
                    if (!isset($flip[$buttonId]) && !isset($flip["!{$buttonId}"])) {
                        $result[$buttonId] = $button;
                    }
                }
            } elseif (isset($this->buttons[$id]) && !isset($flip["!{$id}"])) {
                $result[$id] = $this->buttons[$id];
            }
        }
        return $result;
    }

    /**
     * @param string $id
     * @param array $items
     * @return string
     */
    protected function buildDropDown($id, $items) {
        $items = array_map(function ($item) {
            $content  = null;
            $content .= isset($item['icon'])    ? '<i class="icon">' . $item['icon'] . '</i> '        : null;
            $content .= isset($item['label'])   ? '<span>' . Html::encode($item['label']) . '</span>' : null;
            $url      = isset($item['url'])     ? $item['url'] : null;
            $tag      = ArrayHelper::remove($item, 'tag', 'a');
            if ($tag === 'a') {
                $content = Html::a($content, $url);
            } else {
                $content = Html::tag($tag, $content);
            }
            return Html::tag('li', $content);
        }, $items);
        $ul = Html::tag('ul', implode($items), ['class' => 'dropdown-menu dropdown-menu-right']);
        return Html::tag('div', $ul, ['class' => 'dropdown', 'id' => "{$this->id}-{$id}"]);
    }
}