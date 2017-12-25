<?php

namespace paulzi\cmyii\admin\assets;

use yii\web\AssetBundle;

class CmsAsset extends AssetBundle
{
    public $sourcePath = '@cmyii-admin/web';
    public $css = [
        'css/app.css',
    ];
    public $js = [
        'js/app.js',
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}
