$(window).on('load', function () {

    let deleteBtn = $('.deleteBtn');

    deleteBtn.on('click', function (e) {
        e.preventDefault();

        if (!confirm('Удалить пост?')) {
            return false;
        }

        let thisBtn = $(this);
        let postItem = $(this).closest('.postItem');
        let data = {
            id: thisBtn.attr('data-id')
        };

        $.post('/post/default/delete/', data, function (response) {
            postItem.slideUp();
            console.log(response);
        });
    });
});