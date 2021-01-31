<?php

namespace app\common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $title
 * @property string $code
 *
 * @property Task[] $tasks
 * @property UserCategory[] $userCategories
 * @property User[] $users
 */
class Category extends \app\common\models\base\Category
{

}
