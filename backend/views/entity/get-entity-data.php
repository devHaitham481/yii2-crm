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
// use Yii;


// $this->title = $model->entity;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Entity'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<p>
     <?= Html::a(Yii::t('app', 'Create Entity Column'), ['entity-column/create'], ['class' => 'btn btn-success']) ?>
</p>
<?php 
// $project = Project::findOne
$url =  fn($project_id, $id)=>Yii::$app->urlManager->createAbsoluteUrl(['entity/view-all-entity-data', 'project_id' => $project_id, 'id' => $id]);
$project_id = $_GET['project_id'];
$sheetUrl = fn($project_id, $id) => Yii::$app->urlManager->createAbsoluteUrl(['entity/entity-sheet-data', 'project_id' => $project_id, 'id' => $id]);

// I have to pass entity_id in url

// $url =  fn($id)=>Yii::$app->urlManager->createAbsoluteUrl(['entity/view-all-entity-data', 'project_id' => $id]);

$columns = explode(",", $columns);
// \backend\assets\AppAsset::dd($entityData);
?>
<div class = "container">
<table class="table">
<thead class="thead-dark">
  <div>
    <th> Action </th>
</div>
<?php 


foreach($columns as $column ) {
?>

<th><?= $column ?></th> 
<?php  
}
?>
</thead>
</div>
<?php 
foreach($entityData as $data) {
  ?>
  <tr>

  <td>
    <a href= <?= $url($project_id, $data['id']) ?> class="btn btn-primary">View All Data</a>
    <a href = <?= $sheetUrl($project_id, $data['id']) ?> class="btn btn-warning"> View Data Sheet </a>
  </button>
</td>


    <?php
 foreach($data as $field) {
  //  var_dump($data['id']);
  ?>
  <td><?= $field ?></td>
<?php   
} 
?>
</tr>
 <?php   
} ?>

</table>
</div>

<?php   
  $url = fn($_entityTable, $project_id) => Url::to(['entity/create-entity-data', 'entityTable' => $entityTable, 'project_id' => $project_id]);
  // $entity_id = $_GET['id'];
  // \backend\assets\AppAsset::dd($entityTable, $columns, $entityData);
 ?>
</table>
<h1> Create Entity Row </h1> 
<form action=<?= $url($entityTable, $project_id) ?> method = "post" > 
<input type="hidden" name="_csrf-backend" value="qII7tPdNFXCi_kzXTM1Tub-Fgudegzy4MuAtML7vldjnzHT2rz5ePvuNCoYfiWfxz8vygTi1W9RBs2FF6J7CkQ==">
<div class="form-group">
<?php 
foreach($columns as $column) {
?>
    <label for="entity-<?= $column ?>"><?= $column ?> </label>
    <input class="form-control" id = "entity-<?= $column ?>" name= "Entity[<?= $column ?>]" >

<?php } ?> 
<button type="submit" class="btn btn-success">Submit</button>

</div> 
</form>