'use strict'
var config = {
    inputSelector : '.bukosan.input-ui'
};

// Input Form UI
$(config.inputSelector).each(function(){

    var elem = $(this);

    var isAutofocus = elem.attr('autofocus');

    // Mendapatkan placeholder
    var placeholder = elem.attr('placeholder');

    var value = elem.attr('value');

    // Mengosongkan placeholder
    elem.attr('placeholder','');

    // Mendapatkan parent node
    var parent = elem.parent();

    // Mendapatkan sibling
    var sibling = {
        next : elem.next(),
        prev : elem.prev()
    };

    // Membuat element baru
    var newParent = $('<div></div>');
    newParent.addClass('input-border');

    // Membuat placeholder yang baru
    var newPlaceholder = $('<span class="input-placeholder"></span>');
    newPlaceholder.text(placeholder);
    newPlaceholder.addClass('placeholder');

    newParent.append(newPlaceholder);

    // Meletakkan elemen baru sebelum elemen yang lama
    $(this).before(newParent);

    // Menghapus elemen yang lama
    $(this).remove();

    // Menambahkan <input type=""> yang baru
    newParent.append(elem);

    if(isAutofocus){
        elem.focus();
        elem.prev().fadeOut(100);
    }

    if(elem.val() != ""){
        elem.prev().fadeOut(100);
    }
});

$('.input-border').find('.placeholder').click(function(){
    $(this).fadeOut(100);
    $(this).parent().find('input').focus();
});

$('.input-border').find('input').on('focus',function(){
    $(this).parent().find('.placeholder').fadeOut(100);
});

$('.input-border').find('input').on('blur',function(){
    if($(this).val() == '')
        $(this).parent().find('.placeholder').fadeIn(100);
});
