<script>
$(document).ready(function() {
     $('#exam_taken_score').modal('show');
});
function closeDialog () {
		$('#exam_taken_score').modal('hide'); 
		};
function okClicked(){
		closeDialog();
		window.location = '?page=tests';
}
</script>