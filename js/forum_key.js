function validate_forum_key(f){

		$.post( $(f).attr("action"), $(f).serialize(),
			function (data, textStatus, jqXHR){
				console.log(jqXHR);
				$('.forum_key_class').html(data);
			console.log(textStatus);
			}
		);
		return false;
}
