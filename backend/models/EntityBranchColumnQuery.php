<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[EntityBranchColumn]].
 *
 * @see EntityBranchColumn
 */
class EntityBranchColumnQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EntityBranchColumn[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EntityBranchColumn|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
