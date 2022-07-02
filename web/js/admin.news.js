
(function() {

    var selectedNewsId = null;

    $('.mn-admin-news-remove-btn').on('click', function(){
        selectedNewsId = $(this).data('news-id');
        $('#mn-admin-news-remove-modal').modal();
    });

    $('#mn-admin-news-remove-confirm').on('click', function(){
        window.location = '/admin/news/remove/' + selectedNewsId;
    });
})();
