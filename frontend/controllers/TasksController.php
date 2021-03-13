<?php


namespace frontend\controllers;


use common\models\Category;
use common\models\Task;
use frontend\models\TaskFilterForm;
use taskforce\models\Task as TaskEntity;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class TasksController extends BaseController
{
    public function actionIndex()
    {
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'title');
        $filter = new TaskFilterForm();

        $tasks = Task::find()
            ->where(['status' => TaskEntity::STATUS_NEW])
            ->with(['category', 'city']);

        if(Yii::$app->request->isPost) {
            $filter->load(Yii::$app->request->post());

            if(!empty($filter->category)) {
                $tasks->andWhere(['in', 'category_id', $filter->category]);
            }
            if($filter->has_responses) {
                $tasks->join('LEFT JOIN', 'response', 'task.id = response.task_id')
                      ->andWhere(['response.task_id' => null]);
            }
            if($filter->is_remote) {
                $tasks->andWhere(['city_id' => null]);
            }

            switch ($filter->period) {
                case 'day':
                    $tasks->andWhere(['>', 'task.created_at', new Expression('DATE_SUB(NOW(), INTERVAL 1 DAY)')]);
                    break;
                case 'week':
                    $tasks->andWhere(['>', 'task.created_at', new Expression('DATE_SUB(NOW(), INTERVAL 1 WEEK)')]);
                    break;
                case 'month':
                    $tasks->andWhere(['>', 'task.created_at', new Expression('DATE_SUB(NOW(), INTERVAL 1 MONTH)')]);
                    break;
            }


            if($filter->title) {
                $tasks->andWhere(['like', 'title', $filter->title]);
            }
        }

        $tasks = $tasks->all();

        return $this->render('index', [
            'tasks' => $tasks,
            'filter' => $filter,
            'categories' => $categories
        ]);
    }
}