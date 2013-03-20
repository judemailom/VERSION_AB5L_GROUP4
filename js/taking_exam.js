<script>
$(document).ready(function() {
     $('#taking_exam').modal('show');
});
function closeDialog () {
		$('#taking_exam').modal('hide'); 
		};
function okClicked(){
		closeDialog();
		window.location = '?page=tests';
}
</script>