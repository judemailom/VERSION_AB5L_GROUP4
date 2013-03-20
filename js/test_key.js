function validate_test_key(f){

		$.post( $(f).attr("action"), $(f).serialize(),
			function (data, textStatus, jqXHR){
				console.log(jqXHR);
				$('.test_key_class').html(data);
			console.log(textStatus);
			}
		);
		return false;
}