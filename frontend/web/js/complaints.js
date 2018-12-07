$(window).on('load', function () {
    $('.complain').on('click', function () {
        var btn = $(this);
        var id = btn.attr('data-id');

        $.post('/post/default/complain', {id: id}, function (data) {
            btn.html('Жалоба подана');
            btn.prop('disabled', true)
        });
    });
});