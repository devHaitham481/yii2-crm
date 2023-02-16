 <?php

function generateModal($entityBranchUpdateUrl, $project_id, $data, $entityBranchTable, $entityBranchColumnObject) {
$params = Yii::$app->request->csrfParam;
$token = Yii::$app->request->csrfToken;
$template = <<<T

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <!-- Modal -->  
               <form class='form-inline text-right' id="modalForm"  method='post' action={$entityBranchUpdateUrl($project_id, $data['id'], $entityBranchTable)}>
        <input type="hidden" name="{$params}" value="{$token}">
T;

       foreach ($entityBranchColumnObject as $columnObject) {
    if ($columnObject->column_name == 'id') {
        continue;
    }
    if ($columnObject->column_name == 'entity_id') {
        continue;
    }
    if ($columnObject->column_name == 'region') {
$template.= <<<T
                <select id="inlineGridName" class="form-control modalInput" name="EntityBranch[{$columnObject->column_name}]">
T;

        foreach (City::getAllCities() as $city) {
        $template.= "<option value=".$city.">{$city}</option>";
        }
$template.="</select>";
    continue;
    }

$template.="<input type=\"text\" class=\"form-control modalInput\" id=\"inlineGridName\" name=\"EntityBranch[{$columnObject->column_name}]\" placeholder=\"{$columnObject->column_label}\">";
}
$template.=<<<T
     <button type="submit" class="btn btn-primary mb-2">Submit</button>
</form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
T;
return $template; 
}


