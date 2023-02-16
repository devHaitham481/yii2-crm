<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "entity_branch_staff".
 *
 * @property int $id
 * @property int|null $entity_branch_id
 * @property int|null $user_id
 * @property string|null $position
 */
class EntityBranchStaff extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'entity_branch_staff';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'entity_branch_id', 'user_id'], 'integer'],
            [['position'], 'string', 'max' => 255],
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
            'entity_branch_id' => Yii::t('app', 'Entity Branch ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'position' => Yii::t('app', 'Position'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return EntityBranchStaffQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EntityBranchStaffQuery(get_called_class());
    }
}
