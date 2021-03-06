<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        ['web/css/site.css', 'rel' => 'preload stylesheet', 'as' => 'style','onload'=>'this.onload=null;this.rel=\'stylesheet\''],
        ['web/css/busy-load.min.css', 'rel' => 'preload stylesheet', 'as' => 'style','onload'=>'this.onload=null;this.rel=\'stylesheet\''],
        ['web/js/typeahead/typeahead.min.css', 'rel' => 'preload stylesheet', 'as' => 'style','onload'=>'this.onload=null;this.rel=\'stylesheet\''],
        ['web/js/typeahead/typeahead-kv.min.css', 'rel' => 'preload stylesheet', 'as' => 'style','onload'=>'this.onload=null;this.rel=\'stylesheet\'']
    ];
    public $js = [
        ['web/js/typeahead/typeahead.bundle.min.js'],
        ['web/js/busy-load.min.js'],
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'yii\bootstrap5\BootstrapPluginAsset',
    ];
}
