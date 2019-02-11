<!-- js placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url(); ?>js/jquery-1.8.3.min.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/respond.min.js" ></script>

<?php
	foreach ($my_js as $js) {
		echo '<script src="'.base_url().'js/'.$js.'.js" type="text/javascript"></script>';
	}
?>

<!--common script for all pages-->
<script src="<?php echo base_url(); ?>js/common-scripts.js"></script>
<script type="text/javascript">var base_url = '<?php echo base_url(); ?>';</script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#helpBtn").on("click",function()
		{
			$("#help-modal").modal("show");
		});
	})
</script>