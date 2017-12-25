<?php

namespace paulzi\cmyii\admin\models;

class User extends \common\models\User implements IToggleable
{
    /**
     * @inheritdoc
     */
    public function getIsDisabled()
    {
        return $this->status === User::STATUS_DELETED;
    }
}