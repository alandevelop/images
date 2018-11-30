$(window).on('load', function () {
    var $input = $("#uploadAvatar");

    $input.on('change', (e) => {
        var msg = $('.avatarErrors');
        var fd = new FormData;

        msg.hide();
        msg.html('');
        fd.append('avatar', $input.prop('files')[0]);

        $.ajax({
            url: $input.data('url'),
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                if (data[0] == 'success') {
                    $('#avatarImg').attr('src', data[1]);
                } else {
                    msg.show();
                    for (var key in data) {
                        msg.append('<p>' + data[key][0] + '</p>');
                    }
                }
            }
        });

    });


});