<?php

namespace paulzi\cmyii\admin;

use Yii;
use yii\base\Exception;
use paulzi\cmyii\admin\models\Layout;
use paulzi\cmyii\admin\models\Page;
use paulzi\cmyii\admin\widgets\BlockWidgetAdminTrait;

class CmyiiAdmin extends \yii\base\Module
{
    /**
     * @var string
     */
    public $layout = 'main';

    /**
     * @var array
     */
    public $menu = [
        'sites',
        'layouts',
        'logout',
    ];

    /**
     * @var array
     */
    public $menuSources = [];

    /**
     * @var array
     */
    public $menuAlias = [
        'sites' => [
            'type'      => 'sites',
            'label'     => 'Сайты',
            'icon'      => '&#xE80B;',
            'url'       => ['site/index'],
            'hasChild'  => true,
        ],
        'layouts' => [
            'type'      => 'layout',
            'id'        => 1,
            'label'     => 'Макеты',
            'icon'      => '&#xE53B;',
            'url'       => ['layout/view', 'id' => 1],
            'hasChild'  => true,
        ],
        'logout' => [
            'type'      => 'logout',
            'label'     => 'Выйти',
            'icon'      => '&#xE879;',
            'url'       => ['default/logout'],
        ],
    ];

    /**
     * @var string|array|callable
     */
    public $areasLayout = '@cmyii-admin/views/layouts/_areas';

    /**
     * @var array
     */
    public $adminBlocks = [];

    /**
     * @var array
     */
    protected $adminBlocksMap = [];

    /**
     * @var array
     */
    protected $adminBlocksControllers = [];


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setAliases(['@cmyii-admin' => __DIR__]);
        Yii::$classMap['yii\helpers\Html'] = '@cmyii-admin/helpers/Html.php';
        Yii::$app->user->loginUrl = "{$this->id}/default/login";

        // init admin blocks
        $this->adminBlocksMap = [];
        foreach ($this->adminBlocks as $adminWidgetClass) {
            /** @var \paulzi\cmyii\widgets\BlockWidget|widgets\BlockWidgetAdminTrait $adminWidgetClass */
            $this->adminBlocksMap[$adminWidgetClass::getFrontendWidgetClass()] = $adminWidgetClass;
            $controllers = $adminWidgetClass::registerControllers();
            $this->adminBlocksControllers = array_merge($this->adminBlocksControllers, array_fill_keys(array_keys($controllers), $adminWidgetClass));
            $this->controllerMap = array_merge($this->controllerMap, $controllers);
        }
    }

    /**
     * @param string $widgetClass
     * @return string
     */
    public function getAdminWidgetClass($widgetClass)
    {
        return isset($this->adminBlocksMap[$widgetClass]) ? $this->adminBlocksMap[$widgetClass] : null;
    }

    /**
     * @param string $controllerId
     * @return string
     */
    public function getAdminWidgetClassByControllerId($controllerId)
    {
        return isset($this->adminBlocksControllers[$controllerId]) ? $this->adminBlocksControllers[$controllerId] : null;
    }

    /**
     * @return array
     */
    public function getWidgetsListData()
    {
        $result = [];
        foreach ($this->adminBlocksMap as $widget => $adminWidget) {
            /** @var BlockWidgetAdminTrait $adminWidget */
            $result[$widget] = $adminWidget::getAdminTitle();
        }
        return $result;
    }

    /**
     * @param Page $page
     * @param Layout $layout
     * @return string
     */
    public function renderAdminAreasLayout($page, $layout = null)
    {
        $view = $this->areasLayout;
        if (is_array($view)) {
            $baseLayout = $layout ?: ($page->layout ?: $page->basePage->layout);
            $view = $view[$baseLayout->template];
        } elseif (is_callable($view)) {
            $view = call_user_func($view, $page, $layout);
        }
        return \Yii::$app->getView()->render($view, [
            'page'   => $page,
            'layout' => $layout,
        ]);
    }
}