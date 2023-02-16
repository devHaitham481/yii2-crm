<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\EntityBranchStaff;

/**
 * EntityBranchStaffSearch represents the model behind the search form of `backend\models\EntityBranchStaff`.
 */
class EntityBranchStaffSearch extends EntityBranchStaff
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'entity_branch_id', 'user_id'], 'integer'],
            [['position'], 'safe'],
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
    public function search($params)
    {
        $query = EntityBranchStaff::find();

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
            'entity_branch_id' => $this->entity_branch_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'position', $this->position]);

        return $dataProvider;
    }
}
