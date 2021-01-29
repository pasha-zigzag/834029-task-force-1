<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password_hash
 * @property string $register_at
 * @property int|null $city_id
 * @property string|null $avatar
 * @property string $role
 * @property string|null $birthday
 * @property string|null $about
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $telegram
 * @property int $is_show_profile
 * @property int $is_show_contacts
 * @property int $is_notify_about_message
 * @property int $is_notify_about_action
 * @property int $is_notify_about_review
 *
 * @property Favorite[] $favorites
 * @property Favorite[] $favorites0
 * @property User[] $workers
 * @property User[] $customers
 * @property Message[] $messages
 * @property Portfolio[] $portfolios
 * @property Response[] $responses
 * @property Review[] $reviews
 * @property Review[] $reviews0
 * @property Task[] $tasks
 * @property Task[] $tasks0
 * @property City $city
 * @property UserCategory[] $userCategories
 * @property Category[] $categories
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password_hash'], 'required'],
            [['name', 'email', 'password_hash', 'avatar', 'role', 'about', 'phone', 'skype', 'telegram'], 'string'],
            [['register_at', 'birthday'], 'safe'],
            [['city_id', 'is_show_profile', 'is_show_contacts', 'is_notify_about_message', 'is_notify_about_action', 'is_notify_about_review'], 'integer'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'register_at' => 'Register At',
            'city_id' => 'City ID',
            'avatar' => 'Avatar',
            'role' => 'Role',
            'birthday' => 'Birthday',
            'about' => 'About',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'telegram' => 'Telegram',
            'is_show_profile' => 'Is Show Profile',
            'is_show_contacts' => 'Is Show Contacts',
            'is_notify_about_message' => 'Is Notify About Message',
            'is_notify_about_action' => 'Is Notify About Action',
            'is_notify_about_review' => 'Is Notify About Review',
        ];
    }

    /**
     * Gets query for [[Favorites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorite::class, ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Favorites0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites0()
    {
        return $this->hasMany(Favorite::class, ['worker_id' => 'id']);
    }

    /**
     * Gets query for [[Workers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorkers()
    {
        return $this->hasMany(User::class, ['id' => 'worker_id'])->viaTable('favorite', ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Customers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(User::class, ['id' => 'customer_id'])->viaTable('favorite', ['worker_id' => 'id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Portfolios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolios()
    {
        return $this->hasMany(Portfolio::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::class, ['worker_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews0()
    {
        return $this->hasMany(Review::class, ['worker_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Task::class, ['worker_id' => 'id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * Gets query for [[UserCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCategories()
    {
        return $this->hasMany(UserCategory::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->viaTable('user_category', ['user_id' => 'id']);
    }
}
