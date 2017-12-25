<?php

namespace paulzi\cmyii\admin\actions;

use paulzi\cmyii\admin\models\ISortable;
use Yii;
use yii\db\BaseActiveRecord;

class ReorderAction extends ModelAction
{
    /**
     * @var string
     */
    public $message = 'Порядок сохранён';


    /**
     * @param array $array
     * @param integer $idx1
     * @param integer $idx2
     */
    protected function swapInArray(&$array, $idx1, $idx2) {
        $tmp = $array[$idx1];
        $array[$idx1] = $array[$idx2];
        $array[$idx2] = $tmp;
    }

    /**
     */
    public function run()
    {
        $ids = Yii::$app->request->post('mass', []);
        if (!$ids) {
            Yii::$app->session->setFlash('error', 'Не найдено ни одного элемента');
            return $this->controller->goBack();
        }
        /** @var BaseActiveRecord $modelClass */
        $modelClass = $this->modelClass;
        $primaryKey = $modelClass::primaryKey()[0];
        /** @var BaseActiveRecord[]|ISortable[] $models */
        $models = $modelClass::findAll([$primaryKey => $ids]);
        usort($models, function ($a, $b) {
            /**
             * @var ISortable $a
             * @var ISortable $b
             */
            return $a->getSortablePosition() - $b->getSortablePosition();
        });

        $ids = array_flip($ids);
        $last = count($ids) - 1;

        $t = 0;
        do {
            $from = $to = 0;
            $target = false;
            for ($i = 0; $i <= $last; $i++) {
                $v1 = $i > 0 ? $ids[$models[$i - 1]->primaryKey] : 0;
                $v2 = $ids[$models[$i]->primaryKey];
                $v3 = $i < $last ? $ids[$models[$i + 1]->primaryKey] : $last + 1;
                if ($v1 > $v2 || $v2 > $v3) {
                    $prev = 0;
                    $k = false;
                    for ($j = 0; $j <= $last + 1; $j++) {
                        if ($j !== $i) {
                            $k = $k === false ? $j : $k;
                            $cur = $j <= $last ? $ids[$models[$j]->primaryKey] : false;
                            if ($cur === false || $cur < $prev) {
                                if ($j - $k > $to - $from) {
                                    $target = $i;
                                    $from   = $k;
                                    $to     = $j;
                                }
                                $k = $j;
                            }
                            $prev = $cur;
                        }
                    }
                }
            }

            if ($target !== false) {
                for ($i = $from; $i <= $to; $i++) {
                    if ($i !== $target && ($i === $to || $ids[$models[$i]->primaryKey] > $ids[$models[$target]->primaryKey])) {
                        if ($i < $to) {
                            $dif1 = $i > 0     ? abs($models[$i - 1]->getSortablePosition() - $models[$i]->getSortablePosition()) : false;
                            $dif2 = $i < $last ? abs($models[$i + 1]->getSortablePosition() - $models[$i]->getSortablePosition()) : false;
                        } else {
                            $dif1 = $dif2 = false;
                        }
                        if ($dif2 === false || $dif1 > $dif2) {
                            $models[$target]->moveAfter($models[$i - 1])->save(false);
                        } else {
                            $models[$target]->moveBefore($models[$i])->save(false);
                        }
                        array_splice($models, $i - ($target < $i ? 1 : 0), 0, array_splice($models, $target, 1));
                        break;
                    }
                }
            }
        } while ($target !== false && ++$t < 3);

        return $this->redirectSuccess(Yii::t('app', $this->message), [$models]);
    }
}