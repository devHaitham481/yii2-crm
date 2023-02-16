<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[DropDownItem]].
 *
 * @see DropDownItem
 */
class DropDownItemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return DropDownItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return DropDownItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
