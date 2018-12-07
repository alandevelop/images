$(window).on('load', function () {
    $('.like').on('click', function () {
        var btnLike = $(this);
        var btnUnlike = btnLike.siblings('.unlike');

        var id = btnLike.data('id');
        var count = btnLike.siblings('.count_likes');

        $.post('/post/default/like', {id: id}, function (data) {

            count.html(data);
            btnLike.prop("disabled", true);
            btnUnlike.prop("disabled", false);
        })
    });

    $('.unlike').on('click', function () {
        var btnUnlike = $(this);
        var btnLike = btnUnlike.siblings('.like');

        var id = btnUnlike.data('id');
        var count = btnLike.siblings('.count_likes');

        $.post('/post/default/unlike', {id: id}, function (data) {
            count.html(data);
            btnLike.prop("disabled", false);
            btnUnlike.prop("disabled", true);
        })
    })
});