<?php

namespace backend\models;

use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "drop_down_item".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $source_type
 * @property int|null $source_id
 */
class DropDownItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'drop_down_item';
    }

    public function getRelatives()
    {
        if($this->source_type == 'entity_column') {
            return $this->hasOne(EntityColumn::className(), ['id' => 'source_id']);
        }
        elseif($this->source_type == 'entity_branch_column') {
            return $this->hasOne(EntityBranchColumn::className(), ['id' => 'source_id']);
        }
    }

    public function getDropDown($id, $source_type)
    {
        $items = DropDownItem::find()->where(['source_id' => $id, 'source_type' => $source_type])->all();

        return $itemsList = ArrayHelper::map($items, 'key', 'name'); 
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['source_id', 'key'], 'integer'],
            [['name', 'source_type'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'source_type' => Yii::t('app', 'Source Type'),
            'source_id' => Yii::t('app', 'Source ID'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return DropDownItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DropDownItemQuery(get_called_class());
    }
}
