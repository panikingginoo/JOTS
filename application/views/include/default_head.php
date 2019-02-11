<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo base_url().'img/'.$icon.'.ico'; ?>">
    <title><?php echo $title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/style-responsive.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>css/fonts_css.php" rel="stylesheet" type="text/css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
    <![endif]-->
    <?php
        foreach ($my_css as $css) {
            echo '<link href="'.base_url().'css/'.$css.'.css" rel="stylesheet" />'; 
        }

        foreach ($my_asset as $asset) {
            echo '<link href="'.base_url().$asset.'" rel="stylesheet" />'; 
        }
    ?>
    <style type="text/css">
        #main-content
        {
            margin-left: <?php echo $sidebar_active ? '250px' : 0; ?>;
        }
        #sidebar {
            width: 250px;
        }
    </style>