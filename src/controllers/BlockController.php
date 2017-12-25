<?php

namespace paulzi\cmyii\admin\controllers;

use paulzi\cmyii\admin\widgets\ActiveForm;
use paulzi\cmyii\admin\widgets\BlockWidgetAdminTrait;
use paulzi\cmyii\Cms;
use paulzi\cmyii\admin\CmyiiAdmin;
use paulzi\cmyii\admin\models\Block;
use paulzi\cmyii\Cmyii;
use paulzi\cmyii\models\BlockState;
use paulzi\cmyii\admin\models\Layout;
use paulzi\cmyii\admin\models\Page;
use Yii;
use yii\base\Model;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;


/**
 * Page controller
 */
class BlockController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = array_diff_key(parent::actions(), array_flip(['create', 'update']));
        return $actions;
    }

    /**
     * @inheritdoc
     */
    public function getModelClass()
    {
        return Block::className();
    }

    /**
     * @param $area
     * @return mixed
     */
    public function actionIndex($area)
    {
        Yii::$app->user->setReturnUrl(Yii::$app->request->url);
        return $this->render('index', ['area' => $area]);
    }

    /**
     * @param $widget
     * @param $block
     * @param Page $page
     * @param Layout $layout
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionSettings($widget, $block = null, $page = null, $layout = null)
    {
        list($page, $layout) = $this->findPageOrLayout($page, $layout, false);
        if ($block) {
            /** @var Block $block */
            $block = $this->findModel((string)$block);
            $block->inherit($page, $layout);
        } else {
            $block = new Block([
                'page_id'   => $page             ? $page->id   : null,
                'layout_id' => !$page && $layout ? $layout->id : null,
            ]);
        }
        /** @var Block $block */
        $block->widget_class = $widget;
        return $this->renderPartial('settings', [
            'block'    => $block,
            'settings' => $block->getAdminWidget()->getAdminSettingsModel(),
            'form'     => new ActiveForm(),
        ]);
    }

    /**
     * @param $area
     * @param Page $page
     * @param Layout $layout
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionCreate($area, $page = null, $layout = null)
    {
        $isInline = substr($area, 0, 5) === 'area-';
        if (!$isInline) {
            list($page, $layout) = $this->findPageOrLayout($page, $layout);
        }
        $block = new Block([
            'page_id'   => $page             ? $page->id   : null,
            'layout_id' => !$page && $layout ? $layout->id : null,
            'area'      => $area,
        ]);
        $state = new BlockState($block->getAttributes(['page_id', 'layout_id']));
        if ($this->processBlockForm($block, $state, $settings)) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Блок создан'));
            return $this->goBack();
        }
        return $this->render('create', [
            'block'    => $block,
            'state'    => $state,
            'settings' => $settings,
            'page'     => $page,
            'layout'   => $layout,
        ]);
    }

    /**
     * @param $id
     * @param Page $page
     * @param Layout $layout
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id, $page = null, $layout = null)
    {
        Yii::$app->user->setReturnUrl(Yii::$app->request->url);
        /** @var Block $block */
        $block = Block::findOne((string)$id);
        if (substr($block->area, 0, 5) !== 'area-') {
            list($page, $layout) = $this->findPageOrLayout($page, $layout);
            $block->inherit($page, $layout);
        }
        $state = BlockState::findOne([
            'block_id'  => $block->id,
            'page_id'   => $page             ? $page->id   : null,
            'layout_id' => !$page && $layout ? $layout->id : null,
        ]);
        if (!$state) {
            $state = new BlockState([
                'page_id'   => $page             ? $page->id   : null,
                'layout_id' => !$page && $layout ? $layout->id : null,
            ]);
        }
        if ($this->processBlockForm($block, $state, $settings)) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Изменения сохранены'));
            return $this->goBack();
        }
        return $this->render('update', [
            'block'    => $block,
            'state'    => $state,
            'settings' => $settings,
            'page'     => $page,
            'layout'   => $layout,
        ]);
    }

    /**
     * @param $id
     * @param $page_id
     * @param $layout_id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionData($id, $page_id = null, $layout_id = null)
    {
        Yii::$app->user->setReturnUrl(Yii::$app->request->url);
        list($page, $layout) = $this->findPageOrLayout($page_id, $layout_id);
        $block = Block::find()
            ->andWhere(['id' => $id])
            ->forArea(null, $page, $layout)
            ->one();
        if (!$block) {
            throw new NotFoundHttpException();
        }
        Block::getInheritance([$block], $page, $layout);
        $block->adminWidget->page   = $page;
        $block->adminWidget->layout = $layout;
        return $this->render('data', [
            'page'   => $page,
            'layout' => $layout,
            'block'  => $block,
        ]);
    }

    /**
     * @param mixed $pageId
     * @param mixed $layoutId
     * @param bool $throw
     * @return array
     * @throws NotFoundHttpException
     */
    protected function findPageOrLayout($pageId, $layoutId, $throw = true)
    {
        $page   = $pageId   ? Page::findOne($pageId)     : null;
        $layout = $layoutId ? Layout::findOne($layoutId) : null;
        if (!$page && !$layout && $throw) {
            throw new NotFoundHttpException();
        }
        return [$page, $layout];
    }

    /**
     * @param Block $block
     * @param BlockState $state
     * @param Model $settings
     * @return bool
     */
    protected function processBlockForm($block, $state, &$settings)
    {
        $block->load(Yii::$app->request->post());
        $state->load(Yii::$app->request->post());
        $widget   = $block->getAdminWidget();
        $settings = $widget ? $widget->getAdminSettingsModel() : null;

        if (!Yii::$app->request->isPost) {
            return false;
        }

        if ($settings) {
            $settings->load(Yii::$app->request->post());
            if ($settings->validate()) {
                $params = array_filter($settings->toArray(), function ($value) { return $value !== null; });
                $state->params = $params ? Json::encode($params) : null;
            }
        }

        if ($block->validate() && $state->validate() && (!$settings || $settings->validate())) {
            //$params = array_filter($settings->toArray(), function ($value) { return $value !== null; });
            //$state->params = $params ? Json::encode($params) : null;
            if ($block->save(false)) {
                $state->block_id = $block->id;
                if ($state->state === null && $state->state_children === null && $state->params === null) {
                    return $state->getIsNewRecord() || $state->delete();
                } elseif ($state->save(false)) {
                    return true;
                }
            }
        }

        return false;
    }
}