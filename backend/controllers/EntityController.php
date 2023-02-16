<?php

namespace backend\controllers;

use backend\models\EntityBranch;
use backend\models\Entity;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use backend\models\EntitySearch;
use backend\models\Project;
use backend\models\EntityBranchSearch;
use backend\models\DropDownItem;
use backend\models\City; 

/**
 * EntityBranchController implements the CRUD actions for EntityBranch model.
 */
class EntityController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]       
        );
    }

    /**
     * Lists all EntityBranch models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EntitySearch();
        $dataProvider = $searchModel->getAllEntities();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            // 'dataProvider' => $dataProvider,
        ]);
    }

    public function getEntityBranchColumnLabels($column_name) 
    {
        // dd($column_name);
        $searchModel = new EntityBranchSearch(); 
        $labelId = Yii::$app->db->createCommand("SELECT main_label_id FROM entity_branch_column WHERE `column_name` LIKE '{$column_name}'")->queryOne();
        $labelId = array_values($labelId); 
        $labelId = implode(",", $labelId); 
        $label = Yii::$app->db->createCommand("SELECT label FROM label WHERE id = {$labelId}")->queryAll();
        $label = array_map(fn($l) => $l['label'], $label);

        $label = implode(",", $label);

        return ["label" => $label, 
                "labelId" => $labelId];
    }

    public function getEntityColumnLabels($column_name) 
    {
        $searchModel = new EntitySearch(); 
        $labelId = Yii::$app->db->createCommand("SELECT main_label_id FROM entity_column WHERE `column` LIKE '{$column_name}'")->queryOne();
        $labelId = array_values($labelId);
        $labelId = implode(",", $labelId);
        $label = Yii::$app->db->createCommand("SELECT label FROM label WHERE id = {$labelId}")->queryAll();
        $label = array_map(fn($l) => $l['label'], $label);

        $label = implode(",", $label);

        // $entityLabelIds = implode(",", $entityLabelIds);


        return ["label" => $label, 
                "labelId" => $labelId];
    }
    public function getDropDownItems($id, $key, $source_type) 
    {
         $dropDownItems = Yii::$app->db->createCommand($sql = "SELECT name FROM drop_down_item WHERE source_id={$id} AND `key`={$key} AND source_type LIKE '{$source_type}'")->queryOne();
         return $dropDownItems;
    }

    public function actionGetEntityData($project_id)
    {   
        $searchModel = new EntitySearch();
    
        $model = $searchModel->getEntityData($project_id);
        return $this->render('get-entity-data', 
        ['entityData' => $model["entityData"],
         'columns' => $model["columns"], 
         'projectEntity' => $model["projectEntity"],
         'entityTable' => $model["entityTable"]
        ]);
    }
    public function actionCreateEntityData() {
        $model = new Entity();
        $tableName = $_GET['entityTable'];
        $project_id = $_GET['project_id'];

        // \backend\assets\AppAsset::dd($tableName);
        if ($this->request->isPost) {

            if ($model->load($this->request->post())) {
                $request = Yii::$app->request->post();
                $keys = array_keys($request);
                $formData = $request['Entity'];
                $columns = array_keys($formData);
                $fields = array_values($formData);
                $model->insertEntityData($tableName, $formData, $project_id);

            
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('get-entity-data', [
            'model' => $model,
            'columns' => $columns
        ]);
};
}
    public function actionCreateEntityRow() {
        $model = new Entity(); 
        $entitySearch = new EntitySearch(); 
        $tableName = $_GET['entityTable']; 
        $project_id = $_GET['project_id']; 
        if($this->request->isPost) {
            if($model->load($this->request->post())) {
                $request = Yii::$app->request->post();
                $keys = array_keys($request);
                $formData = $request['Entity'];
                $columns = array_keys($formData);

                $fields = array_values($formData);
                // \backend\assets\AppAsset::dd($tableName, $columns, $fields, "VALUES");
                $model->insertEntityData($tableName, $formData, $project_id);
            }
            else {
                $model->loadDefaultValues(); 
            }
            return $this->redirect(['entity/entity-sheet-data', 'project_id' => $project_id]);

        }
    }
    public function actionUpdateEntityRow() {
        $model = new Entity(); 
        $entitySearch = new EntitySearch(); 

        if($this->request->isPost) {
            try{

                $request = Yii::$app->request->post(); 
                $tableName = $_GET['entityTable']; 
                $project_id = $_GET['project_id']; 
                $keys = array_keys($request); 
                $formData = $request; 
                // dd($tableName, $project_id, $formData, $_POST);
                $columns = array_keys($formData); 
                $fields = array_values($formData); 
                $model->updateEntityData($tableName, $formData, $project_id);
                return $this->redirect(['entity/entity-sheet-data', 'project_id' => $project_id]);

            }
            catch(\yii\db\Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    public function actionUpdateEntityBranchRow() {
        $model = new EntityBranch(); 

        if($this->request->isPost) {
            $request = Yii::$app->request->post(); 
            $tableName = $_GET['entityTable']; 
            $project_id = $_GET['project_id']; 
            // $keys = array_keys($request); 
            $formData = $request; 
            $model->updateEntityBranchData($tableName, $formData); 
        }
    }

    public function getEntitiesBranchesData($project_id, $entity_id) 
    {
        $entityBranchSearchModel = new EntityBranchSearch(); 
        $entityModel = new Entity(); 
        $entitySearchModel = new EntitySearch(); 
        $entityBranchModelData = $entityBranchSearchModel->ViewAllEntityData($project_id, $id);
        
    }

    public function actionEntitySheetData($project_id) 
    {
        $entityBranchSearchModel = new EntityBranchSearch();
        $entityModel = new Entity(); 
        $entitySearchModel = new EntitySearch();
        $entityBranchModelData = $entityBranchSearchModel->ViewAllEntityData($project_id);
        $entityModelData = $entitySearchModel->getEntityData($project_id);
        
            return $this->render('entity-data-sheet', [
                // projectEntity is the Entity Table Name 
                'projectEntity' => $entityBranchModelData["projectEntity"], 
                // entity branch table columns list 
                'entityBranchColumns' => $entityBranchModelData["entityBranchColumns"], 
                'entityBranchColumnsData' => $entityBranchModelData["entityBranchColumnsData"], 
                'entityBranchTable' => $entityBranchModelData["entityBranchTable"], 
                'entityBranchLabels' => $entityBranchModelData["entityBranchLabels"],
                'entityBranchColumnsLabels' => $entityBranchModelData["entityBranchColumnsLabels"],
                'entityBranchColumnObject' => $entityBranchModelData["entityBranchColumnObject"],
                // Entity
                'entityData' => $entityModelData["entityData"], 
//                'entityColumns' => $entityBranchModelData["columnsList"],
                'entityTable' => $entityModelData["entityTable"],
                'entityLabels' => $entityModelData["entityLabels"],
                'entityColumns' => $entityModelData["entityColumns"],
                'entityColumnLabels' => $entityModelData["entityColumnLabels"],
                'entityColumnIndexes' => $entityModelData["entityColumnIndexes"],
                'entityColumnObject' => $entityModelData["entityColumnObject"]
                // 'cities' => $cities
            ]);
        }

    public function actionViewAllEntityData($project_id, $id)
    {
        $searchModel = new EntityBranchSearch(); 
        $model = $searchModel->ViewAllEntityData($project_id, $id);
        return $this->render('entity-index-data', [
            'projectEntity' => $model["projectEntity"], 
            'columnsList' => $model["columnsList"], 
            'entityBranchColumnsList' => $model["entityBranchColumnsList"], 
            'entityBranchColumnsListData' => $model["entityBranchColumnsData"],
            'entityBranchTable' => $model["entityBranchTable"]

        ]);
    
    }

    //action View Entity Branch



    /**
     * Displays a single EntityBranch model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    /**
     * Creates a new EntityBranch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCreate()
    // {
    //     $model = new EntityBranch();

    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post()) && $model->save()) {
                
    //             return $this->redirect(['view', 'id' => $model->id]);
    //         }
    //     } else {
    //         $model->loadDefaultValues();
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    // /**
    //  * Updates an existing EntityBranch model.
    //  * If update is successful, the browser will be redirected to the 'view' page.
    //  * @param int $id ID
    //  * @return mixed
    //  * @throws NotFoundHttpException if the model cannot be found
    //  */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }

    // /**
    //  * Deletes an existing EntityBranch model.
    //  * If deletion is successful, the browser will be redirected to the 'index' page.
    //  * @param int $id ID
    //  * @return mixed
    //  * @throws NotFoundHttpException if the model cannot be found
    //  */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    /**
     * Finds the EntityBranch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return EntityBranch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Entity::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
