<?php

use backend\assets\EntityAsset;
use backend\models\City;
use backend\models\DropDownItem;
    
EntityAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel backend\models\EntitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Entity Data Sheet'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $url = fn($project_id, $id) => Yii::$app->urlManager->createAbsoluteUrl(['entity/view-all-entity-data', 'project_id' => $project_id, 'id' => $id]);

$project_id = $_GET['project_id'];
$sheetUrl = fn($project_id, $id) => Yii::$app->urlManager->createAbsoluteUrl(['entity/entity-sheet-data', 'project_id' => $project_id, 'id' => $id]);
$entitySubmitUrl = fn($project_id, $_entityTable) => Yii::$app->urlManager->createAbsoluteUrl(['entity/create-entity-row', 'project_id' => $project_id, 'entityTable' => $entityTable]);
$entityBranchSubmitUrl = fn($project_id, $entity_id, $tableName) => Yii::$app->urlManager->createAbsoluteUrl(['entity-branch/create-entity-branch-row', 'project_id' => $project_id, 'entity_id' => $entity_id, 'entityBranchTable' => $entityBranchTable]);
$entityBranchUpdateUrl = fn($project_id, $entity_id, $_tableName) => Yii::$app->urlManager->createAbsoluteUrl(['entity-branch/update-entity-branch-row', 'project_id' => $project_id, 'entity_id' => $entity_id, 'tableName' => $entityBranchTable]);
$modals = "";

$js = <<< JS

    $('#makeEditable').SetEditable({
      addButton: $('#but_add'),
      columnsEd: "$entityColumnIndexes"
    });
    
    project_id = {$project_id};
    entityTable = "{$entityTable}";
JS;
$this->registerJs($js, yii\web\View::POS_READY);

// $url =  fn($id)=>Yii::$app->urlManager->createAbsoluteUrl(['entity/view-all-entity-data', 'project_id' => $id]);
// $entityColumnObject -- in form fields for placeholders 
// $entityBranchColumnObject -- in form fields for placeholders 
// $entityColumns -- for countings 
?>
<div class="container" id="wrapper">

<input type="text" class="form-control text-right" id="searchInput" placeholder= "بحث">
        <form class="form-inline" method="post" action=<?=$entitySubmitUrl($project_id, $entityTable)?>>
        
            <input type="hidden" name="<?=Yii::$app->request->csrfParam;?>"
                value="<?=Yii::$app->request->csrfToken;?>" />
                    <div class="col">
<?php
    // dd($entityColumnObject);
    foreach ($entityColumnObject as $columnObject) {
    if ($columnObject->column == 'id') {
        continue;
    }
    if($columnObject->column_type == 'dropdown'){ 
        // dd($columnObject);
        ?>
    
      <select id="inlineGridName" class="form-control" name='Entity[<?=$columnObject->column?>]'>
         <option value="" disabled selected hidden><?=$columnObject->column_label?></option>

    <?php 
        $items = DropDownItem::getDropDown($columnObject->id, 'entity_column');
        foreach($items as $key => $value) { ?> 
        <option value="<?=$key?>"><?=$value?></option>
       <?php } ?>
      </select>
<?php 
continue;
}
    if ($columnObject->column == 'region') { ?>
           <select id="inlineGridName" class="form-control" name='Entity[<?=$columnObject->column?>]'>
    <?php $cities = City::getAllCities();

        foreach ($cities as $city) { ?>
                 <option value="<?=$city?>"><?=$city?></option>
<?php } ?>
          </select>
<?php continue; } ?>

                <input type="text" class="form-control" id="inlineGridName" name="Entity[<?=$columnObject->column?>]" placeholder="<?=$columnObject->column_label?>">
<?php } ?>
                <button type="submit" class="btn btn-primary mb-2">Submit</button>
                <span>
                    <!-- <button id="but_add">Add New Row</button> -->
                </span>
            </div>
    </div>
    </form>
</div>
<table class="table table-striped" id="makeEditable" style="border-collapse:collapse; direction:rtl;">

    <thead class="thead-dark">
        <tr>
<?php
$count = 1;
$x = 0;
foreach ($entityColumns as $column) {
    if ($x == (sizeof($entityColumns) - 1)) {
        // echo "<td colspan = $count class=text-center > " . $entityData["label"] . "</td>";
        echo "<td colspan = '1'></td>";
        break;
    }
    $entityModel = $this->context->getEntityColumnLabels($column);
    if ($entityModel["label"] === $this->context->getEntityColumnLabels($entityColumns[$x + 1])["label"]) {

        $count++;
        $x++;

        continue;

    }

    if ($column === "id") {
        $x++;
        $count++;
        continue;

    }
    $x++;
    echo "<td colspan = $count class=text-center bg-secondary > " . $entityModel["label"] . "</td>";
    $count = 1;
} ?>
        </tr>
        <tr>
<?php foreach ($entityColumnLabels as $column) { ?>
            <th><?=$column?></th>
<?php
} echo "<th class=text-center>تحرير</th>";
?>
        </tr>
    </thead>
<?php 
    // dd($entityColumnObject[4]['column_type']);
    // dd($entityData);
    // dd($project_id, $entityTable);
        foreach ($entityData as $data) {
            
            $entityColumnsCounter = 0;
 ?> 

        <tr data-toggle="collapse" data-target="#demo1" class="accordion-toggle odd" hit-data-id="<?= $data['id']?>">

    <?php foreach ($data as $fname => $field) {
        if($entityColumnObject[$entityColumnsCounter]['column_type'] == 'dropdown'){
            $dropDownItem = $this->context->getDropDownItems($entityColumnObject[$entityColumnsCounter]['id'], $field, 'entity_column');

            $items = DropDownItem::getDropDown($entityColumnObject[$entityColumnsCounter]->id, 'entity_column');
            $encoded_items = json_encode($items);
            // dd($encoded_items);
            $entityColumnsDropDownItems = <<< JS
              dropDownItems = {$encoded_items}; 
              JS;
        $this->registerJs($entityColumnsDropDownItems, yii\web\View::POS_READY);
?>
            <td hit-data='<?=trim($fname)?>' is_dropdown="1"><?=$dropDownItem['name']?></td>
<?php
            $entityColumnsCounter++;
            continue;
}
        $entityColumnsCounter++;
        ?>
        <td hit-data='<?=trim($fname)?>'><?=$field?></td>
<?php } ?>
          </tr>
    <tr>
        <td colspan="<?=sizeof($entityColumns) + 1?>" class="hiddenRow">
            <div class="accordian-body collapse p-3" id="demo1">
                <div class="container-fluid m-2">
                    <form class='form-inline text-right' method='post'
                        action=<?=$entityBranchSubmitUrl($project_id, $data['id'], $entityBranchTable)?>>
                        <input type='hidden' name='<?=Yii::$app->request->csrfParam;?>'
                            value='<?=Yii::$app->request->csrfToken;?>' />
                        <div class='col'>
<?php foreach ($entityBranchColumnObject as $columnObject) {
        // dd($entityBranchColumnObject);
        if ($columnObject->column_name == 'id') {
            continue;
        }
        else if ($columnObject->column_name == 'entity_id') {
            continue;
        }
        else if($columnObject->column_type == 'dropdown'){      
            ?>
            <select id="inlineGridName" class="form-control" name='EntityBranch[<?=$columnObject->column_name?>]'>
               <option value="" disabled selected hidden><?=$columnObject->column_label?></option>

          <?php
            //   dd($items);
              foreach($items as $key => $value) { ?>
              <option value="<?=$key?>"><?=$value?></option>
             <?php } ?>
            </select>
      <?php
      continue;
      }
        else if ($columnObject->column_name == 'region') { ?>
            <select id="inlineGridName" class="form-control" name='EntityBranch[<?=$columnObject->column_name?>]'>
<?php
        $cities = City::getAllCities();

        foreach ($cities as $city) { ?>
                <option value="<?=$city?>"><?=$city?></option>


<?php } ?>

                 </select>
<?php continue; ?>
<?php }
        else { ?>
            <input type='text' class='form-control' id='inlineGridName'
                name='EntityBranch[<?=$columnObject->column_name?>]' placeholder='<?=$columnObject->column_label?>'>
<?php
        }?>

<?php } ?>
                    <button type='submit' class='btn btn-primary mb-2'>Add Row</button>
                     </div>
                    </form>
                </div>
                <table class='table table-bordered table-striped' data-target="#demo2" id='innerTable'>
                    <thead>
                        <tr>
<?php
    $counter = 1;
    $y = 0;
    foreach ($entityBranchColumns as $column) {
        if ($column == "id") {
            $y++;
            continue;
        }

        $entityBranchModel = $this->context->getEntityBranchColumnLabels($column);
        // \backend\assets\AppAsset::dd($this->context->getEntityColumnLabels($entityColumns[$x+1]));
        // dd($entityBranchColumns);
        if ($y == (sizeof($entityBranchColumns) - 1)) {
            echo "<td colspan = $counter class=text-center style=border:3px solid > " . $entityBranchModel["label"] . "</td>";
            break;
        }
        if ($entityBranchModel["label"] == $this->context->getEntityBranchColumnLabels($entityBranchColumns[$y + 1])["label"]) {
            $counter++;
            $y++;
            continue;

        }
        $y++;

        echo "<td colspan = $counter class=text-center style=border:3px solid > " . $entityBranchModel["label"] . "</td>";
        $counter = 1;

    }
    echo "</tr>";
    ?>
<?php
foreach ($entityBranchColumnsLabels as $columnLabel) {
        if ($columnLabel == 'constraint') {
            continue;
        }
        ?>
         <th><?=$columnLabel?></th>

<?php

    }
    ?>
</thead>
<tbody>
<?php
    // dd($entityBranchColumnsData);
    foreach ($entityBranchColumnsData as $dataField) {
        if ($data['id'] == $dataField["entity_id"]) {
            ?>
            <tr data-target="#demo2">
<?php
         $entityBranchColumnsCounter = 0;
        foreach ($dataField as $dataFieldName => $field) {
           if ($dataFieldName == 'entity_id') {
                    continue;
                }
                    // dd($data, $entityColumnObject);
        if($entityBranchColumnObject[$entityBranchColumnsCounter]['column_type'] == 'dropdown'){
            // dd($entityColumnObject, $data);
           $dropDownItem = $this->context->getDropDownItems($entityBranchColumnObject[$entityBranchColumnsCounter]['id'], $field, 'entity_branch_column');

?>
            <td hit-data='<?=trim($fname)?>' is_dropdown="1"><?=$dropDownItem['name']?></td>

        <?php
            $entityBranchColumnsCounter++;
            continue;
        }
        $entityBranchColumnsCounter++;
        ?>
            <td id='field'><?=$field?></td>


<?php
            }
            echo "<td class='text-center'><a class='btn' onclick='edit_branch_row(this)' data-toggle='modal' data-target='#exampleModal'><i class='far fa-edit'></a></i></td>";

        }
        ?>
            </tr>

<?php

    }
    echo "</tbody>";
    echo "</table>";

    echo "</div></td></tr>";



    $modals.= generateModal($entityBranchUpdateUrl, $project_id, $data, $entityBranchTable, $entityBranchColumnObject);

}

?>
                </table>
            </div>


<?php 
echo $modals; 
?>