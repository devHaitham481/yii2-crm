<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "entity_branch".
 *
 * @property int $id
 * @property string|null $entity_name
 * @property int $entity_id
 */
class EntityBranch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'entity_branch';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'entity_id'], 'required'],
            [['id', 'entity_id'], 'integer'],
            [['entity_name'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'entity_name' => Yii::t('app', 'Entity Name'),
            'entity_id' => Yii::t('app', 'Entity ID'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return EntityBranchQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EntityBranchQuery(get_called_class());
    }
}
