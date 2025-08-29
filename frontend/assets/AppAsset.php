<?php
// frontend/assets/AppAsset.php
namespace frontend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // You can move your CSS here later
    ];
    public $js = [
        // Optional: custom JS
    ];
    public $depends = [
        'yii\web\YiiAsset',           // ← REQUIRED: provides yii.js (form handling, events)
        'yii\bootstrap5\BootstrapAsset', // Bootstrap CSS
        'yii\bootstrap5\BootstrapPluginAsset', // Bootstrap JS
    ];
}