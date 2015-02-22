$(function()
{
	$('#post_btn').click(function(){
		var
			uid = $('#post_user_id').val(),
			gid = $('#post_group_id').val(),
			message = $('#post_text').val(),
			attachments = $('#post_image').val();

		$.ajax(
		{
			async: false,
		  	type: 'POST',
		  	url: 'post.php',
		  	data: 'uid='+uid+'&gid='+gid+'&message='+message+'&attachments='+attachments+'',
		  	success: function(msg)
		  	{
		   	alert('Запись добавлена!')
		   	window.location = '/'
		  	}
		})

		return false
	})
})