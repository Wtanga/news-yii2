<?php

use yii\helpers\Url;

$this->registerJsFile('@web/js/admin.category.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['/admin']];
$this->params['breadcrumbs']['Admin'] = 'Category List';

?>

<?php if (count($categories)): ?>
    <div class="panel panel-default">
        <div class="panel-heading"><a href="<?= Url::to(['/admin/add-category']) ?>">Add Category</a></div>
        <table class="table">
            <tr>
                <th>ID</th>
                <th>PARENT_ID</th>
                <th>NAME</th>
                <th>EDIT</th>
                <th>REMOVE</th>
            </tr>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= $category['id'] ?></td>
                    <td><?= $category['parent_id'] ? $category['parent_id'] : 'NULL' ?></td>
                    <td><?= $category['name'] ?></td>
                    <td><a href="<?= Url::to(["/admin/category/edit/{$category['id']}"]) ?>"><span
                                    class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></td>
                    <td><a class="mn-admin-category-remove-btn" data-category-id="<?= $category['id'] ?>"><span
                                    class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

<?php endif; ?>

<div id="mn-admin-category-remove-modal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Remove selected category?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" id="mn-admin-category-remove-confirm" class="btn btn-danger">Remove selected?
                </button>
            </div>
        </div>
    </div>
</div>