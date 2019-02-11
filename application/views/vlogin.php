<?php
	defined('BASEPATH') OR exit('No direct script access allowed'); error_reporting(0);
	$title = 'Login';
	$icon = 'favicon';
	include 'include/default_head.php';
?>
    <link href="<?php echo base_url(); ?>css/chosen.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/tipsy.css" rel="stylesheet" />

    <style type="text/css">
    	.form-control
	    {
			font-size: 20px!important;
	    	color:black!important;
	    	border:1px solid #C7B9B9!important;
	    }
	    .chosen-container,.default { width: 100%!important; }
	    .chosen-container-single .chosen-single { height: 35px!important }
	    .chosen-container-single .chosen-single div b
	    {
	      background: url(<?php echo base_url().'css/chosen-sprite.png';  ?>) no-repeat 0px 5px!important;
	    }
	    .chosen-container-single .chosen-single
	    {
	      padding: 4px 0 0 8px!important;
	    }
	    .chosen-container-multi .chosen-choices
	    {
	    	border-radius: 3px;
	    }
	    .chosen-container
	    {
	    	margin-bottom: 5px;
	    }
	    .form-signin input[type="text"], .form-signin input[type="password"]
	    {
	    	margin-bottom: 5px!important;
	    }
	    .registration
    	{
    		text-align: right;
    	}
    	.tipsy-inner
    	{
    		text-align: left!important;
    	}
    	.tipsy b{color:#41cac0!important;}
    	#error,.r
    	{
    		color:red;
    	}
    </style>
</head>
<body class="login-body">

	<div class="container">

		<form class="form-signin" action="<?php echo base_url(); ?>Login" method="POST" autocomplete="off">
			<h2 class="form-signin-heading">Job On Track System</h2>
			<div class="login-wrap">
				<p id='error'><?php echo $_SESSION['error']; ?></p>
				<input type="text" class="form-control" placeholder="Spark ID" name='user' id='user' autofocus>
				<input type="password" class="form-control" placeholder="Password" name='pass' id='pass'>
				<button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>
				<div class="registration">
					<a  class="tooltips" href="javascript:;" data-placement="top" data-html="true" data-original-title="<b class='r'>Email:</b> jaeson@phoenix.com.ph<br><b class='r'>Local number:</b> 173">
						Can't login? Forgot password?
					</a>
				</div>
			</div>
		</form>
	</div>

	<!-- js placed at the end of the document so the pages load faster -->
    <?php include 'include/default_script.php'; ?>
    <script src="<?php echo base_url(); ?>/js/chosen.jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>/js/tipsy.js" ></script>
    <script type="text/javascript">
    	$(document).ready(function()
    	{
    		$(".chosen-select").chosen({
				search_contains: true,
				allow_single_deselect: true
		    });

    		console.log("<?php echo $_SESSION['error']; ?>");
    	});
    </script>
</body>
</html>