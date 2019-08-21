<?php

namespace paulzi\cmyii\admin\components;

use paulzi\cmyii\admin\CmyiiAdmin;
use paulzi\cmyii\models\Layout;
use paulzi\cmyii\models\Page;
use paulzi\cmyii\models\Site;
use yii\base\BaseObject;
use yii\web\NotFoundHttpException;

abstract class TreeMenuSources extends BaseObject
{
    /**
     * @param null $id
     * @return array
     */
    public static function treeMenuRoot($id = null)
    {
        return CmyiiAdmin::getInstance()->menu;
    }

    /**
     * @param null $id
     * @return array
     */
    public static function treeMenuSites($id = null)
    {
        $sites = Site::find()
            ->select(['title'])
            ->indexBy('id')
            ->asArray()
            ->column();
        $result = [];
        foreach ($sites as $id => $title) {
            $result[] = [
                'type'      => 'site',
                'id'        => $id,
                'label'     => $title,
                'icon'      => '&#xE80B;',
                'url'       => ['site/update', 'id' => $id],
                'hasChild'  => true,
            ];
        }
        return $result;
    }

    /**
     * @param int $id
     * @return array
     * @throws NotFoundHttpException
     */
    public static function treeMenuSite($id)
    {
        $site = Site::findOne($id);
        if ($site === null || $site->root === null) {
            throw new NotFoundHttpException;
        }
        return [[
            'type'      => 'page',
            'id'        => $site->root->id,
            'label'     => $site->root->title,
            'icon'      => '&#xE24D;',
            'url'       => ['page/view', 'id' => $site->root->id],
            'hasChild'  => true,
        ]];
    }

    /**
     * @param int $id
     * @return array
     * @throws NotFoundHttpException
     */
    public static function treeMenuPage($id)
    {
        $page = Page::findOne($id);
        if ($page === null) {
            throw new NotFoundHttpException;
        }
        $result = [];
        foreach ($page->getChildren()->with('children')->all() as $child) {
            /** @var Page $child */
            $result[] = [
                'type'      => 'page',
                'id'        => $child->id,
                'label'     => $child->title,
                'icon'      => '&#xE24D;',
                'url'       => ['page/view', 'id' => $child->id],
                'hasChild'  => (bool)$child->children,
            ];
        }
        return $result;
    }

    /**
     * @param int $id
     * @return array
     * @throws NotFoundHttpException
     */
    public static function treeMenuLayout($id)
    {
        $layout = Layout::findOne($id);
        if ($layout === null) {
            throw new NotFoundHttpException;
        }
        $result = [];
        foreach ($layout->children as $child) {
            $result[] = [
                'type'      => 'layout',
                'id'        => $child->id,
                'label'     => $child->title,
                'icon'      => '&#xE53B;',
                'url'       => ['layout/view', 'id' => $child->id],
                'hasChild'  => true,
            ];
        }
        return $result;
    }
}