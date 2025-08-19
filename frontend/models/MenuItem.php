<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class MenuItem extends ActiveRecord
{
    public static function tableName() {
        return 'menu_items';
    }

    public static function getMenuByRole($role) {
        return self::find()
            ->where(['like', 'roles', $role])
            ->orderBy(['parent_id' => SORT_ASC, 'id' => SORT_ASC])
            ->all();
    }
}
