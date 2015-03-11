$(function()
{
	$('#post_btn').click(function(){
		var
			uid = $('#post_user_id').val(),
			gid = $('#post_group_id').val(),
			message = $('#post_text').val(),
			attachments = $('#post_image').val(),
			link = $('#post_link').val();

		$.ajax(
		{
			async: false,
		  	type: 'POST',
		  	url: 'post.php',
		  	data: 'uid='+uid+'&gid='+gid+'&message='+message+'&attachments='+attachments+'&link='+link,
		  	success: function(msg)
		  	{
		   	alert('Запись добавлена!')
		   	window.location = '/'
		  	}
		})

		return false
	})
})