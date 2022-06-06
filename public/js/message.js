var updatePercakapan;

$('#message-user').find('ul').find('li').click(function(){
	
	$("#form-chat").show();
	
	var id = $(this).attr('id');
	$(this).prevUntil().removeClass('active');
	$(this).nextUntil().removeClass('active');
	$(this).addClass('active');
	
	$("#to").val(id);
	
	// AJAX
	$.ajax({
		type : 'POST',
		url : url('percakapan'),
		data : 'id=' + id,
		success : function(result){
			$('#message-list').html(result);
			// scroll ke bawah
			obj = document.getElementById('message-list');
			obj.scrollTop = obj.scrollHeight-400;
		}
	});
	
	clearInterval(updatePercakapan);
	
	updatePercakapan = setInterval(function(){
		console.log('jalan');
		$.ajax({
		type : 'POST',
		url : url('percakapan'),
		data : 'id=' + id,
		success : function(result){
			$('#message-list').html(result);
		}
	});
	},500);
	
});

$('#form-chat').ajaxForm({
	success : function(result){
		response = JSON.parse(result);
		if(response.status == 1){
			$('input[name="message"]').val('');
			// AJAX
			$.ajax({
				type : 'POST',
				url : url('percakapan'),
				data : 'id=' + $("#to").attr('id'),
				success : function(result){
					$('#message-list').html(result);
				}
			});
			
		}
	}
});