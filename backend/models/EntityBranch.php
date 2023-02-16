<?php

namespace backend\models;


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
            [['entity_id'], 'required'],
            [['entity_id'], 'integer'],
            [['entity_name'], 'string', 'max' => 255],
        ];
    }

    // public function getAllEntities() {
    //     $entity=Entity::find()->all();
    //     return $entityList=ArrayHelper::map($entity,'id','name');
    // }
    public function getEntity()
    {
        return $this->hasOne(Entity::className(), ['id' => 'entity_id']);
    }


    public function insertEntityBranchData($tableName, $formData)
    {
        $formData['entity_id'] = $_GET['entity_id'];
        return Yii::$app->db->createCommand()->insert($tableName, $formData)->execute();
    }
    public function updateEntityBranchData($tableName, $formData) {

        return Yii::$app->db->createCommand()->update($tableName, $formData)->execute();
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
