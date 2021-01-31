<?php

namespace app\common\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property int $id
 * @property string $name
 * @property float|null $latitude
 * @property float|null $longitude
 *
 * @property Task[] $tasks
 * @property User[] $users
 */
class City extends \app\common\models\base\City
{

}
