<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\EntityBranchColumn;

/**
 * EntityBranchColumnSearch represents the model behind the search form of `backend\models\EntityBranchColumn`.
 */
class EntityBranchColumnSearch extends EntityBranchColumn
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'is_required', 'order', 'main_label_id'], 'integer'],
            [['column_name', 'column_type', 'source_table', 'label'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $project_id)
    {
        
        $query = EntityBranchColumn::find()->where(['project_id' => $project_id]);

	    // $query->leftJoin('label d', 'd.id = entity_branch_column.main_label_id');

        // dd($query->all());
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
            'is_required' => $this->is_required,
            'column_type' => $this->column_type,
            'order' => $this->order
        ]);

        $query->andFilterWhere(['like', 'column_name', $this->column_name])
            ->andFilterWhere(['like', 'main_label_id', $this->main_label_id])
            ->andFilterWhere(['like', 'source_table', $this->source_table]);

        return $dataProvider;
    }
}
