<?php

use yii\helpers\Url;

$this->registerJsFile('@web/js/admin.news.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['/admin']];
$this->params['breadcrumbs'][] = 'News List';

?>

<?php if (count($news)): ?>
    <div class="panel panel-default">
        <div class="panel-heading"><a href="<?= Url::to(['/admin/add-news']) ?>">Add News</a></div>
        <table class="table">
            <tr>
                <th>ID</th>
                <th>CATEGORY</th>
                <th>TITLE</th>
                <th>TEXT</th>
                <th>EDIT</th>
                <th>REMOVE</th>
            </tr>
            <?php foreach ($news as $new): ?>
                <tr>
                    <td><?= $new['id'] ?></td>
                    <td><?= $new['category_id'] ?></td>
                    <td><?= $new['title'] ?></td>
                    <td><?= $new['text'] ?></td>
                    <td><a href="<?= Url::to(["/admin/news/edit/{$new['id']}"]) ?>"><span
                                    class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></td>
                    <td><a class="mn-admin-news-remove-btn" data-news-id="<?= $new['id'] ?>"><span
                                    class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

<?php endif; ?>

<div id="mn-admin-news-remove-modal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Remove selected news?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" id="mn-admin-news-remove-confirm" class="btn btn-danger">Remove selected?</button>
            </div>
        </div>
    </div>
</div>
