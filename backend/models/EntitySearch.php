<?php

namespace backend\models;

use backend\models\Entity;
use backend\models\Project;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * ProjectSearch represents the model behind the search form of `backend\models\Project`.
 */
class EntitySearch extends Entity
{
    /**
     * {@inheritdoc}
     */
    // public function rules()
    // {
    //     return [
    //         [['id'], 'integer'],
    //         [['name'], 'safe'],
    //     ];
    // }

    /**
     * {@inheritdoc}
     */

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function getAllEntities()
    {
        $entityList = Project::find()->select('id, entity_label')->all();
        return $entityList;
    }
    public function getEntityLabels($main_label_id)
    {
        $projectEntity = Project::findOne(['id' => $project_id]);

        $entityLabels = Yii::$app->db->createCommand("SELECT * FROM label WHERE id = {$main_label_id}");
    }

    private function filterDropDownColumns($columns){
        
        return array_filter($columns, function($value){
            return ($value['column'] == 'dropdown');
        });

    }

    public function getEntityData($project_id)
    {
        // get Table name
        $projectEntity = Project::findOne(['id' => $project_id]);
        // var_dump($projectEntity->entity);die();
        $entityTable = $projectEntity->entity;
        // get columns of Entity Table
        $entityColumnsObject = EntityColumn::find()->where(['project_id' => $project_id, 'hide_columns' => 0])->orderBy([
            'order'=> SORT_ASC,
            'main_label_id' => SORT_ASC,
        ])->all();
        $entityColumns = Yii::$app->db->createCommand("SELECT `column`, main_label_id, column_label, id FROM entity_column WHERE project_id= {$project_id} AND hide_columns = 0 ORDER BY `order` ASC, main_label_id ASC")->queryAll();
        // dd($entityColumnsObject, $entityColumns);
        // dd($entityColumns);
        // $dropDownColumns = $this->filterDropDownColumns($entityColumns);
        // $dropDownItems = Yii::$app->db->createCommand("SELECT * FROM drop_down_item WHERE source_id={$source_id}");
        // dd($dropDownItems);
        // dd($entityColumns);
        $entityColumnLabels = array_column($entityColumns, 'column_label');
        // $entityColumnLabels = array_merge(array_splice($entityColumnLabels, -1), $entityColumnLabels);
        // dd($entityColumnLabels);
        // \backend\assets\AppAsset::dd($entityColumnLabels);
        $entityLabelIds = array_column($entityColumns, 'main_label_id');

        $entityLabelIds = implode(",", $entityLabelIds);

        $entityLabels = Yii::$app->db->createCommand("SELECT label FROM label WHERE id IN ({$entityLabelIds}) AND label != 'tool'")->queryAll();
        $entityColumns = array_column($entityColumns, 'column');
        // $entityColumns = array_merge(array_splice($entityColumns, -1), $entityColumns);
        $entityColumnsList = implode(",", $entityColumns);
        // dd($entityColumnsList);
        // \backend\assets\AppAsset::dd($entityLabels);
        $entityColumnIndexes = array_keys($entityColumns);
        unset($entityColumnIndexes[0]);
       
        $entityColumnIndexes = implode(",", $entityColumnIndexes);
        //   dd($entityColumnIndexes);
//        $entityColumnsList = implode(',', json_decode($entityColumns, true));

        // get data of columns of the Entity table
        $entityData = Yii::$app->db->createCommand("SELECT {$entityColumnsList} FROM {$projectEntity->entity}")->queryAll();
        // dd($entityData);
        // dd($entityColumnsObject);
        // dd($entityColumns);
        // $entityList = json_decode(json_encode($entityData), true);
        // \backend\assets\AppAsset::dd($entityData);
        // $entityDataObject = json_encode($entityData);
        // $entityDataList = implode(',', json_decode($entityDataObject, true));
        // $entityList = [];
        // foreach($entityData as $entity) $entityList[]=$entity;
        // \backend\assets\AppAsset::dd($entityData);

        return [
            "entityData" => $entityData,
            "entityColumns" => $entityColumns,
            "projectEntity" => $projectEntity->entity,
            "entityTable" => $entityTable,
            "entityLabels" => $entityLabels,
            "entityColumnsLiteral" => $entityColumns,
            "entityColumnLabels" => $entityColumnLabels,
            "entityColumnIndexes" => $entityColumnIndexes, 
            "entityColumnObject" => $entityColumnsObject];

    }
}

// public function search($params)
// {
//     $query = new Query;
//     $query->select('entity')
//      ->from('project')
//      ->limit(10);
//     $rows = $query->all();
//     // var_dump($rows);

//     // $this->load($params);

//     // if (!$this->validate()) {
//     //     // uncomment the following line if you do not want to return any records when validation fails
//     //     // $query->where('0=1');
//     //     return $dataProvider;
//     // }

//     // // grid filtering conditions
//     // $query->andFilterWhere([
//     //     'id' => $this->id,
//     // ]);

//     // $query->andFilterWhere(['like', 'name', $this->name])
//     //     ->andFilterWhere(['like', 'details', $this->details])
//     //     ->andFilterWhere(['like', 'category', $this->category])
//     //     ->andFilterWhere(['like', 'entity', $this->entity])
//     //     ->andFilterWhere(['like', 'entity_branch', $this->entity_branch])
//     //     ->andFilterWhere(['like', 'entity_label', $this->entity_label])
//     //     ->andFilterWhere(['like', 'entity_branch_label', $this->entity_branch_label]);

//     return $rows;
// }