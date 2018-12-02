$(window).on('load', function () {
    $('.like').on('click', function () {
        var id = $(this).data('id');
        $.post('/post/default/like', {id: id}, postLiked)
    });

    $('.unlike').on('click', function () {
        var id = $(this).data('id');
        $.post('/post/default/unlike', {id: id}, postUnliked)
    })
});

var count = $('.count_likes');

function postLiked(data) {
    count.html(data);
    $('.like').prop("disabled", true);
    $('.unlike').prop("disabled", false);
}

function postUnliked(data) {
    count.html(data);
    $('.like').prop("disabled", false);
    $('.unlike').prop("disabled", true);
}