<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EntityBranch]].
 *
 * @see EntityBranch
 */
class EntityBranchQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EntityBranch[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EntityBranch|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
