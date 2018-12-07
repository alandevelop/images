$(window).on('load', function () {
    let text = $('.descr_text');
    let change = $('.descr_change');
    let form = $('.descr_form');
    let textarea = $('.descr_textarea');
    let cancel = $('.descr_cancel');
    let submit = $('.descr_submit');


    change.on('click', function (e) {
        e.preventDefault();

        form.slideToggle();
        text.slideToggle();

    });

    cancel.on('click', function (e) {
        e.preventDefault();

        form.slideToggle();
        text.slideToggle();

    });

    submit.on('click', function (e) {
        e.preventDefault();

        let data = {
            text: textarea.val(),
            id: textarea.attr('data-id'),
        };

        $.get('/user/profile/change-description', data, function (response) {
            text.find('p').html(response);
            form.slideToggle();
            text.slideToggle();
        });
    });
});