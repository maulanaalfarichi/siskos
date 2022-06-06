$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': Bukosan.csrfToken
    }
});

function url(path) {
    return window.Bukosan.baseUrl + '/' + path;
}

// Mengganti input type hidden untuk boolean-input

$('.boolean-input').each(function () {
    elem = $(this);
    newBtn = $('<button type="button"></button>');
    newBtn.addClass('btn btn-boolean');
    newBtn.attr('data-target', $(this).attr('id'));
    childMark = $('<div></div>');
    childMark.addClass('btn-mark');
    newBtn.append(childMark);
    elem.before(newBtn);
    if ($(this).val() == 1) {
        childMark.css('left', '32px');
        newBtn.addClass('active');
    }
});

$('.btn-boolean').click(function (ev) {
    ev.preventDefault();
    if ($(this).hasClass('active')) {
        $(this).find('.btn-mark').animate({'left': '0px'}, 150);
        $('#' + $(this).attr('data-target')).val(0);
    }
    else {
        $(this).find('.btn-mark').animate({'left': '32px'}, 150);
        $('#' + $(this).attr('data-target')).val(1);
    }
    $(this).toggleClass('active');
});

function dropdownAction(elem) {
    var parent = elem.parent().parent().parent();
    var button = parent.find('button').eq(0);
    var target = parent.attr('target');
    $(target).val(elem.attr('data-value'));
    button.html(elem.text() + '&nbsp;&nbsp;<span class="caret"></span>');
}

$('.dropdown-menu').find('a').click(function (e) {
    if($(this).parent().parent().attr('role') != 'menu') {
        e.preventDefault();
        dropdownAction($(this));
    }
});

$('.dropdown-menu').find('.autocomplete').on('keyup', function (e) {
    e.preventDefault();
    var keyword = $(this).val();
    var list = $(this).parent().find('li');
    list.each(function () {
        if ($(this).text().toLowerCase().indexOf(keyword.toLowerCase()) !== -1) {
            $(this).show();
        }
        else {
            $(this).hide();
        }
    });
});

function AjaxKelurahan(elem) {
    var kecamatan = elem.attr('data-value');
    var dropdown = $('#kelurahan-drop').find('.dropdown-menu');
    $.ajax({
        url: url('daftar/kelurahan/' + kecamatan),
        type: 'get',
        success: function (result) {
            dropdown.find('li').remove();
            var response = JSON.parse(result);
            for (x in response) {
                var li = $('<li></li>');
                var a = $('<a href="#"></a>');
                a.text(response[x].nama);
                a.attr('data-value', response[x].id);
                a.click(function (e) {
                    e.preventDefault();
                    dropdownAction($(this));
                });
                li.append(a);
                dropdown.append(li);
            }
        }
    });
}


function AjaxKecamatan(elem) {
    var kotakab = elem.attr('data-value');
    var dropdown = $('#kecamatan-drop').find('.dropdown-menu');
    $.ajax({
        url: url('daftar/kecamatan/' + kotakab),
        type: 'get',
        success: function (result) {
            dropdown.find('li').remove();
            var response = JSON.parse(result);
            for (x in response) {
                var li = $('<li></li>');
                var a = $('<a href="#"></a>');
                a.text(response[x].nama);
                a.attr('data-value', response[x].id);
                a.click(function (e) {
                    e.preventDefault();
                    AjaxKelurahan($(this));
                    dropdownAction($(this));
                });
                li.append(a);
                dropdown.append(li);
            }
        }
    });
}

$('#provinsi-drop').find('a').click(function (e) {
    e.preventDefault();
    var provinsi = $(this).attr('data-value');
    var dropdown = $('#kotakab-drop').find('.dropdown-menu');
    $.ajax({
        url: url('daftar/kotakab/' + provinsi),
        type: 'get',
        success: function (result) {
            dropdown.find('li').remove();
            var response = JSON.parse(result);
            for (x in response) {
                var li = $('<li></li>');
                var a = $('<a href="#"></a>');
                a.text(response[x].nama);
                a.attr('data-value', response[x].id);
                a.click(function (e) {
                    e.preventDefault();
                    AjaxKecamatan($(this));
                    dropdownAction($(this));
                });
                li.append(a);
                dropdown.append(li);
            }
        }
    });
});

$('.favorit').click(function () {
    var id = $(this).attr('data-fav');
    var elem = $(this);
    $.ajax({
        url: url('favorit'),
        type: 'post',
        data: 'id=' + id,
        success: function (result) {
            var response = JSON.parse(result);
            if (response.status == 'deleted') {
                elem.removeClass('fa-star favorited').addClass('fa-star-o');
            }
            else if (response.status == 'saved') {
                elem.addClass('fa-star favorited').removeClass('fa-star-o');
            }
        }
    });
});

$('.filter-btn').click(function () {
    var icon = $(this).find('i').eq(0);
    if (icon.hasClass('fa-chevron-circle-down')) {
        icon.removeClass('fa-chevron-circle-down').addClass('fa-chevron-circle-up');
        $('.filter-tron').slideUp(150);
    }
    else {
        icon.removeClass('fa-chevron-circle-up').addClass('fa-chevron-circle-down');
        $('.filter-tron').slideDown(150);
    }
});

$('.check-input').each(function () {
    elem = $('<div></div>');
    elem.addClass('btn-check');
    elem.attr('data-target', $(this).attr('id'));
    if ($(this).val() == 1)
        elem.addClass('checked');
    $(this).before(elem);
});

$('.btn-check').click(function () {
    $("#" + $(this).attr('data-target')).val(($(this).hasClass('checked')) ? 0 : 1);
    $(this).toggleClass('checked');
});

$(".image-zoom-area").each(function () {
    $(this).height($(this).parent().width());
    $(this).css("background-size", $(".image-main").width() + "%");
});

$(".image-main").on("mousemove", function (ev) {
    var top = (ev.pageY - $(this).offset().top) - 50,
        left = (ev.pageX - $(this).offset().left) - 50;
    if (top <= 0) {
        top = 0;
    }
    else if (top >= $(this).height() - 100) {
        top = $(this).height() - 100;
    }
    if (left <= 0) {
        left = 0;
    }
    else if (left >= $(this).width() - 100) {
        left = $(this).width() - 100;
    }
    $(this).find(".image-zoomer").css({"top": top + "px", "left": left + "px"});
    $(".image-zoom-area").css({"background-position": (left) / ($(".image-main").width() - 100) * 100 + "% " + (top) / ($(".image-main").height() - 100) * 100 + "%"});
}).hover(function () {
        $(".image-zoom-area").slideDown(150);
    },
    function () {
        $(".image-zoom-area").slideUp(150);
    });

$(".image-list").find("img").click(function () {
    console.log('tes');
    $(this).addClass("active");
    $(this).prevUntil().removeClass("active");
    $(this).nextUntil().removeClass("active");
    $(".image-main").css("background-image", "url('" + $(this).attr("src") + "')");
    $(".image-zoom-area").css("background-image", "url('" + $(this).attr("src") + "')");
});