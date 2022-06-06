
/**
 * Memanipulasi tampil input type=file
 */
$('.btn-chooser').click(function(){
    var real = $(this).attr('data-input');
    $(real).click();
});

/**
 * Mengunggah gambar setelah memilih gambar
 */
$('.file-upload').find('input[type="file"]').change(function () {
    if(($(this)[0].files.length + $("#image-show").find('img').length) <= 4) {
        $(this).parent().submit();
    }
    else{
        alert('Jumlah gambar tidak boleh lebih dari 4 !');
        $(this).val('');
    }
});

/**
 * Ajax untuk mengahpus foto
 */
function AjaxHapusFoto(elem){
    var action = elem.attr('href');
    var parent = elem.parent().parent().parent();
    $.ajax({
        url : action,
        type : 'post',
        data : 'foto=' + elem.attr('data-img'),
        success : function(result){
            response = JSON.parse(result);
            if(typeof response != 'undefined'){
                if(response.status == 1){
                    // alert('Berhasil menghapus !');
                    parent.slideUp(150,function(){
                        $(this).remove();
                    })
                }
                else {
                    alert('Gagal menghapus !')
                }
            }
            else {
                alert('Gagal menghapus !');
            }
        }
    });
}

/**
 * Melakukan Ajax untuk mengunggah file
 */
$('.file-upload').ajaxForm({
    beforeSend: function () {
        $('#progress').parent().slideDown();
    },
    uploadProgress: function (event, position, total, percentComplete) {
        $('#progress').width(percentComplete+'%')
    },
    success: function (response) {
        $('#progress').width('0%');
        $('#progress').parent().slideUp();
        var result = JSON.parse(response);
        var fullurl = result.fullurl;
        var name = result.name;
        for(image in fullurl){
            var col = $('<div class="col-lg-6"></div>');
            var thumb = $('<div class="thumbnail"></div>');
            var newimage = $('<img style="height:150px" class="img-responsive"/>');
            var capt = $('<div class="caption"></div>');
            var btn = $('<a class="btn btn-danger delete-foto">Hapus</a>');
            newimage.attr('src',fullurl[image]);
            btn.attr('data-img',name[image]);
            btn.attr('href',url('hapus/foto'));
            btn.click(function(e){
                e.preventDefault();
                AjaxHapusFoto($(this));
            });
            capt.append(btn);
            thumb.append(newimage);
            thumb.append(capt);
            col.append(thumb);
            capt.append();
            $("#image-show").append(col);
        }
        $("#image").val(name.join());
    }
});

$('#jeniskosan-drop').find('a').click(function(e){
    e.preventDefault();
    if($(this).attr('data-value') === 'keluarga'){
        $('#jeniskelamin-form').hide();
    }
    else{
        $('#jeniskelamin-form').show();
    }
});

$('a.delete-kosan').click(function(e){
    e.preventDefault();
    var action = $(this).attr('href');
    var elem = $('.kosan-'+$(this).attr('data-id'));
    swal({
            title: "Apa anda yakin ?",
            text: "Kosan akan dihapus secara permanen !",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal",
            closeOnConfirm: false
        },
        function(){
            $.ajax({
                url : action,
                type : 'get',
                success : function(result){
                    response = JSON.parse(result);
                    if(typeof response !== 'undefined'){
                        if(response.status){
                            swal('Berhasil !','Berhasil Menghapus Kosan !','success');
                            elem.slideUp(150,function(){
                                $(this).remove();
                            })
                        }
                        else {
                           swal('Gagal !','Gagal menghapus kosan !','error');
                        }
                    }
                    else {
                        swal('Gagal !','Gagal menghapus kosan !','error');
                    }
                }
            });
        });
});

$('a.delete-kamar').click(function(e){
    e.preventDefault();
    var action = $(this).attr('href');
    var elem = $('.kamar-'+$(this).attr('data-id'));
    swal({
            title: "Apa anda yakin ?",
            text: "Kamar Kosan akan dihapus secara permanen !",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal",
            closeOnConfirm: false
        },
        function(){
            $.ajax({
                url : action,
                type : 'get',
                success : function(result){
                    response = JSON.parse(result);
                    if(typeof response !== 'undefined'){
                        if(response.status){
                            swal('Berhasil !','Berhasil menghapus kamar kosan !','success');
                            elem.slideUp(150,function(){
                                $(this).remove();
                            })
                        }
                        else {
                           swal('Gagal !','Gagal menghapus kamar kosan !','error');
                        }
                    }
                    else {
                        swal('Gagal !','Gagal menghapus kamar kosan !','error');
                    }
                }
            });
        });
});

$('a.delete-foto').click(function(e){
    e.preventDefault();
    AjaxHapusFoto($(this));
});

$('#file-ava').change(function(){
    if($(this)[0].files.length == 1) {
        $(this).parent().submit();
    }
});

$('#ava-chooser').click(function(){
    $('#file-ava').click();
});

$('#form-ava').ajaxForm({
    beforeSend: function () {

    },
    uploadProgress: function (event, position, total, percentComplete) {

    },
    success: function (response) {
        result = JSON.parse(response);
        var url = result.fullUrl;
        var val = result.name;
        $('#ava').val(val);
        $('#avatar').attr('src',url);
    }
});

$('#change-password').ajaxForm({
    success : function (result) {
        response = JSON.parse(result);
        if(response.error === 0){
            swal('Berhasil !','Berhasil mengganti password !','success');
        }
        else if(response.error === 1){
            swal('Gagal !','Password lama tidak sesuai !','error');
        }
        else{
            swal('Gagal !','Konfirmasi password tidak sesuai !','error');
        }
        $('input[name="plama"]').val('');
        $('input[name="pbaru"]').val('');
        $('input[name="konfirmasipbaru"]').val('');
    }
});
