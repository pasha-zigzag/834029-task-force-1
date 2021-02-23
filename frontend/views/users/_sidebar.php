<?php
/* @var $filter frontend\models\UserFilterForm */
/* @var $categories array */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<section class="search-task">
    <div class="search-task__wrapper">
        <?php
        $form = ActiveForm::begin([
            'options' => [
                'class' => 'search-task__form'
            ],
            'fieldConfig' => [
                'template' => "{label}\n{input}\n",
                'options' => [
                    'tag' => false,
                ],
            ],

        ]); ?>

        <fieldset class="search-task__categories">
            <legend>Категории</legend>
            <?=$form->field($filter, 'category')->checkboxList($categories, [
                'tag' => false,
                'itemOptions' => [
                    'template' => '{label}\n{input}'
                ],
                'item' => function ($index, $label, $name, $checked, $value) {
                    $html = Html::input('checkbox', $name, $value, [
                        'class' => 'visually-hidden checkbox__input'
                    ]);
                    $html .= Html::tag('span', $label);
                    $html = Html::tag('label', $html, [
                        'class' => 'checkbox__legend'
                    ]);
                    return $html;
                }
            ])->label(false); ?>
        </fieldset>

        <fieldset class="search-task__categories">
            <legend>Дополнительно</legend>
            <?=$form->field($filter, 'is_free', [
                'checkboxTemplate' => '<label class="checkbox__legend">{input}<span>{labelTitle}</span></label>'
            ])->checkbox([
                'class' => 'visually-hidden checkbox__input'
            ])?>

            <?=$form->field($filter, 'is_online', [
                'checkboxTemplate' => '<label class="checkbox__legend">{input}<span>{labelTitle}</span></label>'
            ])->checkbox([
                'class' => 'visually-hidden checkbox__input'
            ])?>

            <?=$form->field($filter, 'has_reviews', [
                'checkboxTemplate' => '<label class="checkbox__legend">{input}<span>{labelTitle}</span></label>'
            ])->checkbox([
                'class' => 'visually-hidden checkbox__input'
            ])?>

            <?=$form->field($filter, 'is_favorite', [
                'checkboxTemplate' => '<label class="checkbox__legend">{input}<span>{labelTitle}</span></label>'
            ])->checkbox([
                'class' => 'visually-hidden checkbox__input'
            ])?>
        </fieldset>

        <?= $form->field($filter, 'username', [
            'labelOptions' => ['class' => 'search-task__name']
        ])->textInput(['class' => 'input-middle input']) ?>

        <?= Html::submitButton('Искать', ['class' => 'button']) ?>

        <?php ActiveForm::end(); ?>
    </div>
</section>