<?php

namespace paulzi\cmyii\admin\widgets;

use Yii;
use paulzi\cmyii\admin\components\TreeMenuSources;
use yii\base\Widget;
use paulzi\cmyii\admin\CmyiiAdmin;

class TreeMenuWidget extends Widget
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $id;

    /**
     * @var array
     */
    public $expanded;

    /**
     * @var string
     */
    public $cookie;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $method = 'treeMenu' . ucfirst($this->type);
        if (isset(CmyiiAdmin::getInstance()->menuSources[$this->type])) {
            $data = call_user_func(CmyiiAdmin::getInstance()->menuSources[$this->type], $this->id);
        } elseif(method_exists(TreeMenuSources::className(), $method)) {
            $data = TreeMenuSources::$method($this->id);
        } else {
            $data = [];
        }
        foreach ($data as &$item) {
            if (is_string($item)) {
                $item = CmyiiAdmin::getInstance()->menuAlias[$item];
            }
        }
        unset($item);
        if ($this->expanded === null && $this->cookie !== null) {
            $list = isset($_COOKIE[$this->cookie]) ? $_COOKIE[$this->cookie] : null;
            $list = array_flip(explode(',', $list));
            $this->expanded = $list;
        }
        return $this->render('tree-menu/view', [
            'type'      => $this->type,
            'id'        => $this->id,
            'data'      => $data,
            'expanded'  => $this->expanded,
        ]);
    }
}