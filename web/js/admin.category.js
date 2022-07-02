
(function() {

    var selectedCategoryId = null;

    $('.mn-admin-category-remove-btn').on('click', function(){
        selectedCategoryId = $(this).data('category-id');
        $('#mn-admin-category-remove-modal').modal();
    });

    $('#mn-admin-category-remove-confirm').on('click', function(){
        window.location = '/admin/category/remove/' + selectedCategoryId;
    });
})();
