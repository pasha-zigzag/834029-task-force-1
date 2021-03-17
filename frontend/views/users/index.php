<?php
/* @var $this yii\web\View */
/* @var $users common\models\User */
/* @var $filter frontend\models\UserFilterForm */
/* @var $categories array */

use frontend\components\RatingWidget;
use yii\helpers\Html;
use frontend\models\UserFilterForm;

$sort = Yii::$app->request->get('sort') ?? '';
$active_link_class = 'user__search-item--current';
?>

<section class="user__search">

    <div class="user__search-link">
        <p>Сортировать по:</p>
        <ul class="user__search-list">
            <li class="user__search-item <?=($sort === UserFilterForm::SORT_RATING) ? $active_link_class : ''?>">
                <?=Html::a('Рейтингу', ['/users', 'sort' => UserFilterForm::SORT_RATING], ['class' => 'link-regular'])?>
            </li>
            <li class="user__search-item <?=($sort === UserFilterForm::SORT_COUNT) ? $active_link_class : ''?>">
                <?=Html::a('Числу заказов', ['/users', 'sort' => UserFilterForm::SORT_COUNT], ['class' => 'link-regular'])?>
            </li>
            <li class="user__search-item <?=($sort === UserFilterForm::SORT_POPULARITY) ? $active_link_class : ''?>">
                <?=Html::a('Популярности', ['/users', 'sort' => UserFilterForm::SORT_POPULARITY], ['class' => 'link-regular'])?>
            </li>
        </ul>
    </div>

    <?php foreach($users as $user) : ?>
        <div class="content-view__feedback-card user__search-wrapper">
            <div class="feedback-card__top">
                <div class="user__search-icon">
                    <a href="#"><img src="<?=$user->avatar ?? '/img/no-photo.jpg'?>" width="65" height="65"></a>
                    <span>
                        <?= Yii::t(
                            'app',
                            '{n, plural, =0{0 заданий} one{# задание} few{# задания} many{# заданий} other{# заданий}}',
                            ['n' => count($user->workerTasks)]
                        ); ?>
                    </span>
                    <span>
                        <?= Yii::t(
                            'app',
                            '{n, plural, =0{0 отзывов} one{# отзыв} few{# отзыва} many{# отзывов} other{# отзывов}}',
                            ['n' => count($user->workerReviews)]
                        ); ?>
                    </span>
                </div>
                <div class="feedback-card__top--name user__search-card">
                    <p class="link-name">
                        <a href="#" class="link-regular">
                            <?=$user->name?>
                        </a>
                    </p>

                    <?= RatingWidget::widget(['rating' => $user->workerRating]) ?>

                    <?php if($user->about) : ?>
                        <p class="user__search-content">
                            <?=$user->about?>
                        </p>
                    <?php endif; ?>
                </div>
                <span class="new-task__time">
                    <?=$user->lastActivity?>
                </span>
            </div>
            <div class="link-specialization user__search-link--bottom">
                <?php if(!empty($user->categories)) : ?>
                    <?php foreach($user->categories as $category) : ?>
                        <a href="#" class="link-regular"><?=$category->title?></a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</section>

<?= $this->render('_sidebar', [
    'filter' => $filter,
    'categories' => $categories
]) ?>
