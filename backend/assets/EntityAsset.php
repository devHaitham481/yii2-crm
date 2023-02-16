<?php    
    namespace backend\assets;
    use yii\web\AssetBundle;

    class EntityAsset extends AssetBundle {
    //directory that contains source asset file
    // List of CSS files that this bundle contains
        public $basePath = '@webroot';
        public $baseUrl = '@web';
        public $css = ['css/entity.css'];
    } 
?>