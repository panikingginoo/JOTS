<?php
    defined('BASEPATH') OR exit('No direct script access allowed'); error_reporting(0);

    $headerTitle = 'Order Monitoring Feed - '.$area; //all character that is in uppercase will wrap inside a '<span>'
    $title = 'stats_harmonic_mean(a)';
    $icon = 'pph';
    $sidebar_active = TRUE; // default TRUE
    $search_active = FALSE; // default FALSE
    $is_help = true;

    $my_css = ['gallery']; //add your css here, NO NEED to put extension (.css) eg. 'my_css'
    $my_asset = ['assets/fancybox/source/jquery.fancybox.css']; //add your asset path here

    include 'include/config_pages.php';
    include 'include/default_head.php';

?>
</head>
<body>
    <?php include 'include/default_header.php'; ?>
    <?php include 'include/default_sidebar.php'; ?>
    
    <section id="container" class="">
        <section id="main-content">
            <section class="wrapper site-min-height">
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Home
                            </header>
                            <div class="panel-body">
                                
                            </div>
                        </section>
                    </div>
                </div>
            </section>
        </section>
    </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <?php $my_js = ['chosen.jquery.min','jquery.maskMoney.min','datepicker','jquery.dataTables.min'];  //add your js here, NO NEED to put ?> 
    <?php include 'include/default_script.php'; ?>
    <script type="text/javascript">
        $(document).ready(function()
        {

        });
    </script>
</body>
</html>