<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['/admin']];
$this->params['breadcrumbs'][] = ['label' => 'News List', 'url' => ['/admin/news']];
$this->params['breadcrumbs'][] = 'News Form';

?>

<h1>News Form</h1>

<?php $activeForm = ActiveForm::begin(['options' => ['id' => 'comment-form']]); ?>

<?= $activeForm->field($newsModel, 'category_id')->dropDownList($categoriesList); ?>

<?= $activeForm->field($newsModel, 'title'); ?>
<?= $activeForm->field($newsModel, 'short_text')->textArea(['rows' => 5]); ?>
<?= $activeForm->field($newsModel, 'text')->textArea(['rows' => 5]); ?>

<?= $activeForm->field($newsModel, 'is_active')
    ->checkbox([
            'value' => '1',
            'checked ' => true,
        ]
    ); ?>

<?= Html::submitButton('Send', ['class' => 'btn btn-success']); ?>

<?php $activeForm = ActiveForm::end(); ?>
