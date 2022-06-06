$('.delete-user').click(function(e){
	e.preventDefault();
	var action = $(this).attr('href');
	var id = $(this).attr('data-id');
	swal({
		title: "Apa anda yakin ?",
		text: "User akan dihapus secara permanen !",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Ya, hapus!",
		cancelButtonText: "Batal",
		closeOnConfirm: false
	},
		function(){
			$.ajax({
				type : "get",
				url : action,
				success : function(result){
					response = JSON.parse(result);
					if(response.status == 1){
						swal('Berhasil Menghapus !','Berhasil menghapus user','success');
					}
					else{
						swal('Gagal Menghapus !','Tidak bisa menghapus user','error');
					}
				}
			});
		});
	
});

$('.delete-kosan').click(function(e){
	e.preventDefault();
	var action = $(this).attr('href');
	var id = $(this).attr('data-id');
	swal({
		title: "Apa anda yakin ?",
		text: "User akan dihapus secara permanen !",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Ya, hapus!",
		cancelButtonText: "Batal",
		closeOnConfirm: false
	},
		function(){
			$.ajax({
				type : "get",
				url : action,
				success : function(result){
					response = JSON.parse(result);
					if(response.status == 1){
						swal('Berhasil Menghapus !','Berhasil menghapus user','success');
					}
					else{
						swal('Gagal Menghapus !','Tidak bisa menghapus user','error');
					}
				}
			});
		});
	
});