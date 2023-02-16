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


// VALUES {
//     $projectEntity, 
//     $columnsList, 
//     $entityBranchColumnsList, 
//     $entityBranchColumnsListData
// }

// $this->title = $model->entity;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Entity Complete Data'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>



<?php 
// $project = Project::findOne
// $url =  fn($id)=>Yii::$app->urlManager->createAbsoluteUrl(['entity/view-all-entity-data', 'project_id' => $id]);
// $projectId = 109;
// $_GET['project_id'];

// $url =  fn($id)=>Yii::$app->urlManager->createAbsoluteUrl(['entity/view-all-entity-data', 'project_id' => $id]);

// $columnsList = explode(",", $columnsList);
// \backend\assets\AppAsset::dd(explode(",", $entityBranchColumnsList));
$entityBranchColumnsArray = [];
$entityBranchColumnsArray = explode(",", $entityBranchColumnsList);
// \backend\assets\AppAsset::dd($entityBranchColumnsListData);
?>

<table class="table">
<thead class="thead-dark">
<?php 
// \backend\assets\AppAsset::dd($entityBranchTable);

foreach($entityBranchColumnsArray as $column ) {
?>
<th><?= $column ?></th> 
<?php  
}
?>
</thead>

<?php 
foreach($entityBranchColumnsListData as $data) {
  ?>
  <tr>
    <?php
 foreach($data as $field) {
  ?>
<td><?= $field ?></td>

<?php   
} 
?>
</tr>
 

      
 <?php   
  $url = fn($entity_id, $_entityBranchTable) => Url::to(['entity-branch/create-data', 'entity_id' => $entity_id, 'entityBranchTable' => $_entityBranchTable]);
  $entity_id = $_GET['id'];
} ?>
</table>

<h1> Create Entity Branch Row </h1> 

<form action=<?= $url($entity_id, $entityBranchTable) ?> method = "post" > 
<input type="hidden" name="_csrf-backend" value="qII7tPdNFXCi_kzXTM1Tub-Fgudegzy4MuAtML7vldjnzHT2rz5ePvuNCoYfiWfxz8vygTi1W9RBs2FF6J7CkQ==">
<div class="form-group">
<?php 
foreach($entityBranchColumnsArray as $column) {
?>

    <label for="entity-<?= $column ?>"><?= $column ?> </label>
    <input class="form-control" id = "entity-<?= $column ?>" name= "Entity[<?= $column ?>]" >

<?php } ?> 
<button type="submit" class="btn btn-success">Submit</button>

</div> 
</form>



<!-- 
<form action=method = "post" >
 
<div class="form-group">


  </div>
  <label for="sel1">Select Entity Branch:</label>
  <select class="form-control" id="sel1">
    <option>1</option>
    <option>2</option>
    <option>3</option>
    <option>4</option>
  </select>
  <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" class="form-control" id="pwd">
  </div>
  <div class="checkbox">
    <label><input type="checkbox"> Remember me</label>
  </div>
  <button type="submit" class="btn btn-default">Submit</button>

 </form>  -->