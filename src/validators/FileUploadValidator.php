<?php

namespace paulzi\cmyii\admin\validators;

use paulzi\fileBehavior\FileMultiple;
use Yii;
use yii\helpers\Html;
use yii\validators\FileValidator;
use yii\web\UploadedFile;

class FileUploadValidator extends FileValidator
{
    protected $onReal;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->onReal = $this->on;
        $this->on = ['_none_'];
    }

    /**
     * @inheritdoc
     */
    public function isActive($scenario)
    {
        return !in_array($scenario, $this->except, true) && (empty($this->onReal) || in_array($scenario, $this->onReal, true));
    }

    /**
     * @inheritdoc
     */
    public function validateAttributes($model, $attributes = null)
    {
        $files    = [];
        $uploaded = [];
        $isMultiple = $this->maxFiles > 1;
        foreach ($this->attributes as $attribute) {
            $files[$attribute]    = $model->$attribute;
            $uploaded[$attribute] = $isMultiple ? UploadedFile::getInstances($model, $attribute) : UploadedFile::getInstance($model, $attribute);
            $model->$attribute    = $uploaded[$attribute];
        }

        parent::validateAttributes($model, $this->attributes);

        foreach ($this->attributes as $attribute) {
            $model->$attribute = $files[$attribute];
            $isMultipleFile = is_array($model->$attribute) || $model->$attribute instanceof FileMultiple;
            $data  = Yii::$app->request->post($model->formName() ?: []);
            $value = isset($data[$attribute]) ? $data[$attribute] : null;
            $value = is_array($value) ? array_filter($value) : ($value ? [$value] : []);
            $cur   = $uploaded[$attribute];
            $cur   = $isMultiple ? $cur : ($cur ? [$cur] : []);
            if ($isMultipleFile) {
                $value = array_merge($value, $cur);
            } else {
                $value = reset($cur) ?: ($value ? $value[0] : null);
            }
            if (!$isMultipleFile) {
                if ($model->$attribute->getValue() !== $value) {
                    $model->$attribute->setValue($value);
                }
            } else {
                $old = [];
                foreach ($model->$attribute as $file) {
                    $old[$file->getValue()] = $file;
                }
                $new = [];
                foreach ($value as $item) {
                    if (is_string($item) && isset($old[$item])) {
                        $new[] = $old[$item];
                    } elseif ($item instanceof UploadedFile) {
                        $new[] = $item;
                    }
                }
                $model->$attribute->setValue($new);
            }
        }
    }
}
