<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['/admin']];
$this->params['breadcrumbs'][] = ['label' => 'News List', 'url' => ['/admin/news']];
$this->params['breadcrumbs'][] = 'News Form';

?>

<h1>News Form</h1>

<?php $activeForm = ActiveForm::begin(['options' => ['id' => 'comment-form']]); ?>

<?= $activeForm->field($model, 'category_id')->dropDownList($categoriesList); ?>

<?= $activeForm->field($model, 'title'); ?>
<?= $activeForm->field($model, 'short_text')->textArea(['rows' => 5]); ?>
<?= $activeForm->field($model, 'text')->textArea(['rows' => 5]); ?>

<?= $activeForm->field($model, 'is_active')
    ->checkbox([
            'value' => '1',
            'checked ' => true,
        ]
    ); ?>

<?= Html::submitButton('Send', ['class' => 'btn btn-success']); ?>

<?php $activeForm = ActiveForm::end(); ?>
