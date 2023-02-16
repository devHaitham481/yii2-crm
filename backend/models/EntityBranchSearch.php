<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\EntityBranch;
use Yii;
/**
 * EntityBranchSearch represents the model behind the search form of `backend\models\EntityBranch`.
 */
class EntityBranchSearch extends EntityBranch
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'entity_id'], 'integer'],
            [['entity_name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }



    // This needs to be moved to the EntitySearch Model 
    public function ViewAllEntityData($project_id)
    {
        // get Table name
        $projectEntity = Project::findOne(['id'=>$project_id]);
        $entityBranchColumnObject = EntityBranchColumn::find()->where(['project_id' => $project_id, 'hide_columns' => 0])->orderBy('main_label_id', `order`)->all();
        // dd($entityBranchColumnObject);
        // get columns of Entity Table
//         \backend\assets\AppAsset::dd($projectEntity["entity_branch"]);
        $entityBranchTable = $projectEntity["entity_branch"];
        
        // $entityColumns = Yii::$app->db
        // ->createCommand("SHOW COLUMNS FROM {$projectEntity->entity}")
        // ->queryAll();
        $entityColumns = Yii::$app->db->createCommand("SELECT `column`, main_label_id, column_label FROM entity_column WHERE project_id= {$project_id} AND hide_columns = 0 ORDER BY main_label_id ASC, `order` ASC")->queryAll();
       

        $entityLabelIds = array_column($entityColumns, 'main_label_id');
      
        $entityLabelIds = implode(",", $entityLabelIds);
        // \backend\assets\AppAsset::dd($entityColumns);
        //process each item here
        // foreach($entityColumns as $item) $columnsList[]=$item['Field'];

        // $excludedEntityColumns = array("updated_at", "deleted_at", "project_id", "created_at");
        // $columnsList = array_diff($columnsList, $excludedEntityColumns);
        // // \backend\assets\AppAsset::dd($columnsList);
        // $entityBranchColumns = Yii::$app->db
        // ->createCommand("SHOW COLUMNS FROM {$projectEntity->entity_branch}")
        // ->queryAll();
        
        $entityBranchColumns = Yii::$app->db
        ->createCommand("SELECT `column_name`, main_label_id, `column_label` FROM entity_branch_column WHERE project_id = {$project_id} AND hide_columns = 0 ORDER BY main_label_id ASC, `order` ASC")->queryAll();

        // $entityBranchColumnsLiteral = Yii::$app->db
        //     ->createCommand("SELECT `column`, main_label_id, column_label FROM entity_branch_column 
        //     WHERE project_id = {$project_id} AND hide_columns = 0
        //     ORDER BY main_label_id ASC, `order` ASC")->queryAll();
        // \backend\assets\AppAsset::dd($entityBranchColumns);
        // dd($entityBranchColumns);
        //get all columns labels 
        $entityBranchColumnsLabels = array_column($entityBranchColumns, 'column_label'); 
        //get id column label to be at first of the array
        // $entityBranchColumnsLabels = array_merge(array_splice($entityBranchColumnsLabels, -2), $entityBranchColumnsLabels);
        // dd($entityBranchColumnsLabels);
        $entityBranchLabelIds = array_column($entityBranchColumns, 'main_label_id'); 
        $entityBranchLabelIds = implode(",", $entityBranchLabelIds);         
        $entityBranchLabels = Yii::$app->db->createCommand("SELECT label FROM label WHERE id IN ({$entityBranchLabelIds}) AND label != 'tool'")->queryAll();
        // \backend\assets\AppAsset::dd($entityBranchColumnsLabels);
        //get all entity branch columns
        $entityBranchColumns = array_column($entityBranchColumns, 'column_name');
        //get id column to be first of the array 
        // \backend\assets\AppAsset::dd($entityBranchColumns);
        // $entityBranchColumns = array_merge(array_splice($entityBranchColumns, -2), $entityBranchColumns); 
        // \backend\assets\AppAsset::dd($entityBranchColumnsLiteral);
        // \backend\assets\AppAsset::dd($entityBranchColumns);
        $entityBranchColumnsList= implode(",",$entityBranchColumns);
        // \backend\assets\AppAsset::dd($entityBranchColumnsList);
        // foreach($entityBranchColumns as $item) $entityBranchColumnsList[]=$item['Field'];
        // if (($key = array_search("entity_id", $entityBranchColumnsList)) !== false) {
        //     // unset($entityBranchColumnsList[$key]);
        // }
        // dd($entityBranchColumnsLabels);
        // $excludedBranchColumns = array("updated_at", "deleted_at", "created_at");
        // $entityBranchColumnsList = array_diff($entityBranchColumnsList, $excludedBranchColumns);
        // \backend\assets\AppAsset::dd($columnsListString);

        $entityBranchColumnsData = Yii::$app->db->createCommand("SELECT {$entityBranchColumnsList} FROM {$projectEntity->entity_branch}")
        ->queryAll();
        // \backend\assets\AppAsset::dd($entityBranchColumnsData);
        // \backend\assets\AppAsset::dd($entityBranchColumnsData);
        
        // \backend\assets\AppAsset::dd($entityBranchColumnsData[0]['entity_id']);
        return ["projectEntity" => $projectEntity->entity,
         "entityBranchColumns" => $entityBranchColumns, 
         "entityBranchColumnsData" => $entityBranchColumnsData,
         "entityBranchTable" => $entityBranchTable, 
         "entityBranchLabels" => $entityBranchLabels,
         "entityBranchColumnsLabels" => $entityBranchColumnsLabels,
         "entityBranchColumnObject" => $entityBranchColumnObject];

    }

    

    public function viewEntitiesDataSheet($project_id, $entity_id)
    {
        // get Table name
        $projectEntity = Project::findOne(['id'=>$project_id]);
        // get columns of Entity Table
        // \backend\assets\AppAsset::dd($projectEntity["entity_branch"]);
        $entityBranchTable = $projectEntity["entity_branch"];
        
        $entityColumns = Yii::$app->db
        ->createCommand("SHOW COLUMNS FROM {$projectEntity->entity}")
        ->queryAll();

        
        // \backend\assets\AppAsset::dd($entityColumns);
        $columnsList = [];

        //process each item here
        foreach($entityColumns as $item) $columnsList[]=$item['Field'];
        if (($key = array_search("project_id", $columnsList)) !== false) {
            unset($columnsList[$key]);
        }
        // \backend\assets\AppAsset::dd($columnsList);
        $entityBranchColumns = Yii::$app->db
        ->createCommand("SHOW COLUMNS FROM {$projectEntity->entity_branch}")
        ->queryAll();
        // \backend\assets\AppAsset::dd($entityBranchColumns);
        $entityBranchColumnsList = [];
        foreach($entityBranchColumns as $item) $entityBranchColumnsList[]=$item['Field'];
        $excludedColumns = array("created_at", "updated_at", "deleted_at", "created_at");
        $entityBranchColumnsList = array_diff($entityBranchColumnsList, $excludedColumns);

        if (($key = array_search("entity_id", $entityBranchColumnsList)) !== false) {
            // unset($entityBranchColumnsList[$key]);
        }

        $entityBranchColumnsListString = json_encode($entityBranchColumnsList);
        $columnsListString = implode(',', json_decode($entityBranchColumnsListString, true));
        // \backend\assets\AppAsset::dd($columnsListString);

        $entityBranchColumnsData = Yii::$app->db->createCommand("SELECT {$columnsListString} FROM {$projectEntity->entity_branch}")
        ->queryAll();
        
        // \backend\assets\AppAsset::dd($entityBranchColumnsData[0]['entity_id']);
        return ["projectEntity" => $projectEntity->entity, "columnsList" => $columnsList,
         "entityBranchColumnsList" => $columnsListString, 
         "entityBranchColumnsData" => $entityBranchColumnsData,
         "entityBranchTable" => $entityBranchTable];

    }

    public function getEntityBranchData($project_id, $entity_id)
    {
        $projectEntity = Project::findOne(['id'=>$project_id]);
        // get columns of Entity Table
        // \backend\assets\AppAsset::dd($projectEntity["entity_branch"]);
        $entityBranchTable = $projectEntity["entity_branch"];
        

        $entityColumns = Yii::$app->db
        ->createCommand("SHOW COLUMNS FROM {$projectEntity->entity}")
        ->queryAll();



        
        // \backend\assets\AppAsset::dd($entityColumns);
        $columnsList = [];

        //process each item here
        foreach($entityColumns as $item) $columnsList[]=$item['Field'];
        if (($key = array_search("project_id", $columnsList)) !== false) {
            unset($columnsList[$key]);
        }
        // \backend\assets\AppAsset::dd($columnsList);
        $entityBranchColumns = Yii::$app->db
        ->createCommand("SHOW COLUMNS FROM {$projectEntity->entity_branch}")
        ->queryAll();
        // \backend\assets\AppAsset::dd($entityBranchColumns);
        $entityBranchColumnsList = [];
        foreach($entityBranchColumns as $item) $entityBranchColumnsList[]=$item['Field'];
        if (($key = array_search("entity_id", $entityBranchColumnsList)) !== false) {
            unset($entityBranchColumnsList[$key]);
        }
        $entityBranchColumnsListString = json_encode($entityBranchColumnsList);
        $columnsListString = implode(',', json_decode($entityBranchColumnsListString, true));
        // \backend\assets\AppAsset::dd($columnsListString);

        $entityBranchColumnsData = Yii::$app->db->createCommand("SELECT {$columnsListString} FROM {$projectEntity->entity_branch} WHERE entity_id = {$entity_id}")
        ->queryAll();
        // \backend\assets\AppAsset::dd($entityBranchColumnsData);
        return ["projectEntity" => $projectEntity->entity, "columnsList" => $columnsList,
         "entityBranchColumnsList" => $columnsListString, 
         "entityBranchColumnsData" => $entityBranchColumnsData,
         "entityBranchTable" => $entityBranchTable];


    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = EntityBranch::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'entity_id' => $this->entity_id,
        ]);

        $query->andFilterWhere(['like', 'entity_name', $this->entity_name]);

        return $dataProvider;
    }
}
