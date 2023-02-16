<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\EntitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use yii\data\ArrayDataProvider;
use yii\widgets\DetailView;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Entities');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entity-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
      <?= Html::a(Yii::t('app', 'Create Entity'), ['create'], ['class' => 'btn btn-success']) ?>
      <!-- <?=  var_dump($dataProvider) ?> -->
    </p>

    <?php Pjax::begin(); ?>
    <?php  $provider = new ArrayDataProvider([
        'allModels' => $dataProvider,
        'pagination' => [
            'pageSize' => 10,
        ],
        'sort' => [
            'attributes' => ['id', 'entity'],
        ],
    ]); ?>
    <div class = "row">
<?php 
$sheetUrl = fn($project_id) => Yii::$app->urlManager->createAbsoluteUrl(['entity/entity-sheet-data', 'project_id' => $project_id]);
$dataSheetUrl =  fn($id)=>Yii::$app->urlManager->createAbsoluteUrl(['entity/get-entity-data', 'project_id' => $id]);
foreach($dataProvider as $project) {
if(!$project) {
    continue;
}
?>
<div class="col-3">
<!-- <?= var_dump($project) ?> -->
    <div class="card" style="width: 18rem;">

        <div class="card-body">
            <h5 class="card-title text-center"><?= $project->entity_label?></h5>
            <p class="card-text"><?= $project->id ?></p>
            <a href = <?= $sheetUrl($project->id) ?> class="btn btn-primary"> View Data Sheet </a>
            <a href="#" class="btn btn-warning">Delete</a>
        </div>
    </div>
</div>
        <?php
    //  }
  }
?>
</div>
    <?php Pjax::end(); ?>
</div>
