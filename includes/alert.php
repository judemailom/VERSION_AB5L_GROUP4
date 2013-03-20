<?php if($status = 'success'){ ?>
<div class="alert alert-success">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Congratulations!</strong> Successfully <?php echo $mode; ?> the <?php echo $item; ?>(s).
</div>
<?php 
}
else{ ?>
<div class="alert alert-error">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Sorry!</strong> Something went wrong. Please try again.
</div>
<?php } ?>