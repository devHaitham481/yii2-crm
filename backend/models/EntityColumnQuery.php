<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[EntityColumn]].
 *
 * @see EntityColumn
 */
class EntityColumnQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EntityColumn[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EntityColumn|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
