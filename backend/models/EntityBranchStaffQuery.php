<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[EntityBranchStaff]].
 *
 * @see EntityBranchStaff
 */
class EntityBranchStaffQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EntityBranchStaff[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EntityBranchStaff|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
