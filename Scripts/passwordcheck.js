$('body').on('focus', '.login input', function (event) {
    $(this).parent().addClass('active');
});

$('body').on('blur', '.login input', function () {
    if (!$(this).val().length > 0) {
        $(this).parent().removeClass('active');
    }
});

$('body').on('focus', '.password input', function (event) {
    $(this).parent().addClass('active');
});

$('body').on('blur', '.password input', function () {
    if (!$(this).val().length > 0) {
        $(this).parent().removeClass('active');
    }
});

$('body').on('keyup', '.password input', function () {
    $('.tips .from').text($(this).val().length);

    if ($(this).val().length >= 6) {
        $('.tips .count').addClass('active');
    } else {
        $('.tips .count').removeClass('active');
    }

    if ($(this).val().search(/\d/) != -1) {
        $('.tips .number').addClass('active');
    } else {
        $('.tips .number').removeClass('active');
    }

    if (/[A-Z]/.test($(this).val())) {
        $('.tips .upper').addClass('active');
    } else {
        $('.tips .upper').removeClass('active');
    }

    if (/[^a-zA-Z0-9]/.test($(this).val())) {
        $('.tips .special').addClass('active');
    } else {
        $('.tips .special').removeClass('active');
    }
});



$('body').on('click', '.password svg:not(.active)', function () {
    $(this).addClass('active');
    $('.password input').attr('type', 'text');
});

$('body').on('click', '.password svg.active', function () {
    $(this).removeClass('active');
    $('.password input').attr('type', 'password');
});