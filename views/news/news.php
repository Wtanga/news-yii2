<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = $news['title'];

$this->params['breadcrumbs'][] = $news['title'];
?>

<div>
    <h1><?= $news['title'] ?></h1>
    <p><?= $news['text'] ?></p>
    <h4><?= strftime("%B %d, %Y", strtotime($news['date'])) ?></h4>
</div>
<hr class="mn-news-hr">

<?php if (count($comments)): ?>
    <h2>Comments</h2>
    <?php foreach ($comments as $comment): ?>
        <div>
            <p>Author: <?= $comment['name'] ?> (<?= strftime("%B %d, %Y", strtotime($comment['date'])) ?>)</p>
            <p><?= $comment['text'] ?></p>
        </div>
        <hr class="mn-news-hr">
    <?php endforeach; ?>
<?php endif; ?>

<h3>Post a new comment</h3>

<?php $activeForm = ActiveForm::begin(['options' => ['id' => 'comment-form']]); ?>

<?= $activeForm->field($commentModel, 'name'); ?>
<?= $activeForm->field($commentModel, 'text')->textArea(['rows' => 5]); ?>
<?= $activeForm->field($commentModel, 'news_id')->hiddenInput(['value' => $news['id']])->label(false); ?>

<?= Html::submitButton('Send', ['class' => 'btn btn-success']); ?>

<?php $activeForm = ActiveForm::end(); ?>
