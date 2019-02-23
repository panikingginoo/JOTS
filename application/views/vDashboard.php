<?php
    defined('BASEPATH') OR exit('No direct script access allowed'); error_reporting(0);

    $headerTitle = 'Job On Track System'; //all character that is in uppercase will wrap inside a '<span>'
    $title = 'JOTS | Dashboard';
    $icon = 'pph';
    $sidebar_active = FALSE; // default TRUE
    $search_active = FALSE; // default FALSE
    $is_help = FALSE;

    $my_css = ['chosen'];
    $my_asset = [];

    $emps = array(
        0 => array(
            'avatar' => base_url('img/avatars/male.png'),
            'fn' => 'CRISTOPHER EVANGELISTA',
            'status' => array(
                'id' => 2,
                'desc' => 'WIP' 
            ),
            'task_desc' => 'COPY READING'
        ),
        1 => array(
            'avatar' => base_url('img/avatars/male.png'),
            'fn' => 'MIKE BERNARDINO',
            'status' => array(
                'id' => 1,
                'desc' => 'IDLE' 
            ),
            'task_desc' => ''
        ),
        2 => array(
            'avatar' => base_url('img/avatars/male.png'),
            'fn' => 'CHRISTOPHER DELOS REYES',
            'status' => array(
                'id' => 3,
                'desc' => 'BREAK' 
            ),
            'task_desc' => ''
        ),
        3 => array(
            'avatar' => base_url('img/avatars/male.png'),
            'fn' => 'CRISH ESPESO',
            'status' => array(
                'id' => 2,
                'desc' => 'WIP' 
            ),
            'task_desc' => 'COPY READING'
        ),
        4 => array(
            'avatar' => base_url('img/avatars/female.png'),
            'fn' => 'MARY GRACE ESTRELLA',
            'status' => array(
                'id' => 2,
                'desc' => 'WIP' 
            ),
            'task_desc' => 'COPY READING'
        ),
        5 => array(
            'avatar' => base_url('img/avatars/female.png'),
            'fn' => 'SALLY MARTINEZ',
            'status' => array(
                'id' => 2,
                'desc' => 'WIP' 
            ),
            'task_desc' => 'COPY READING'
        ),
    );

    $top_pages = array(
        'Dashboard' => array(
            'href' => 'Dashboard',
            'icon' => 'fa fa-dashboard',
        ),
        'Home' => array(
            'href' => 'Home', //javascript:;
            'icon' => 'fa fa-tasks',
        ),
        'Report' => array(
            'href' => 'Report', //javascript:;
            'icon' => 'fa fa-file-text-o',
        ),
        'Logout' => array(
            'href' => 'Logout',
            'icon' => 'fa fa-key',
        ),
    );

    // include 'include/config_pages.php';
    include 'include/default_head.php';
    
?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/jquery-confirm/jquery-confirm.min.css'); ?>">
    <style type="text/css">
        .head-settings {
            float: right;
        }
        .head-status span {
            display: block;
        }
        .head-status,
        #btnBreakOut {
            float: right;
        }
        .head-status {
            word-spacing: 1px;
            letter-spacing: 1px;
            margin: 10px 10px 0 0;
            font-size: 15px;
            padding: 5px 8px;
        }
        #btnBreakOut {
            border: 1px solid #bfbfbf;
            font-size: 17px;
            margin: 10px 0 0;
            padding: 3px 7px;
            border-radius: 0;
            color: #6D6A69;
            background: #f8f8f8;
        }
        #btnBreakOut:hover {
            border: 1px solid #bfbfbf;
            color: #222;
            transition: all 0s;
            cursor: pointer;
            -webkit-box-shadow: inset 0 0 4px 1px rgba(0,0,0,.08);
            box-shadow: inset 0 0 4px 1px rgba(0,0,0,.08);
        }
        .clearfix {
            text-align: center;
        }
        input#txtSearch {
            display: block;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            width: 30%;
            height: 32px;
            line-height: 32px;
            padding: 5px 10px;
            outline: 0;
            border: 1px solid #BDBDBD;
            border-radius: 0;
            background: #fff;
            font: 13px/16px 'Open Sans',Helvetica,Arial,sans-serif;
            color: #404040;
            appearance: normal;
            -moz-appearance: none;
            -webkit-appearance: none;
            margin: 0 auto;

        }
        input#txtSearch.spinner {
            background: url(<?php echo base_url("img/input-spinner.gif"); ?>) 99% 50% no-repeat !important
        }
        /* EMP CONTAINER */
        .emp {
            position: relative;
            height: 250px;
            min-width: 194px;
            max-width: 335px;
            width: 18%;
            margin: 10px 1%;
            display: inline-block;
            float: left;
            box-shadow: 0 1px 1px grey;
            border-top: thin solid lightgrey;
        }
        .emp .emp-avatar {
            display: block;
            /*height: 70%;*/
            min-height: 175px;
            text-align: center;
            padding: 10px;
            box-shadow: 0 2px 2px -2px grey;
            /*background: #c0dfd9;*/
        }
        .emp-avatar img {
            /*width: 60%;*/
            width: 160px;
            height: 160px;
        }
        .emp-bot {
            position: absolute;
            /* display: block; */
            top: 73%;
            left: 0;
            height: 27%;
            width: 100%;
        }
        .emp-bot span {
            display: block;
            text-align: center;
            font-size: 14px;
            padding: 7px 0;
            height: 50%;
            color: black;
            font-weight: 600;
        }
        .emp-bot .emp-name {
            background: #3b3a36;
            color: white;
        }
        /* EMP CONTAINER */
    </style>
</head>
<body>
    <?php
        $head_settings
        ='<div class="head-settings">
            <button type="button" title="Break Out" class="btn btn-warning " id="btnBreakOut"><i class="fa fa-coffee"></i></button>
            <span class="head-status"><i class="fa fa-circle text-success"></i> WORK IN PROGRESS</span>
        </div>';

    ?>
    <?php include 'include/default_header.php'; ?>
    <?php include 'include/default_sidebar.php'; ?>

    <section id="container" class="">
        <section id="main-content">
            <section class="wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <div class="panel-body">
                                <div class="clearfix">

                                    <!-- <div class="input-group-btn open">
                                        <button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                        </ul>
                                    </div> -->
                                    <input type="text" id="txtSearch" placeholder="Search employee name here...">
                                </div>
                                <div class="emp-container"></div> 
                            </div>
                        </section>
                    </div>
                </div>
            </section>
        </section>
    </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <?php $my_js = [];  //add your js here, NO NEED to put ?> 
    <?php include 'include/default_script.php'; ?>
    <script type="text/javascript" src="<?php echo base_url('assets/jquery-confirm/jquery-confirm.min.js'); ?>"></script>
    <script type="text/javascript">
        $(document).ready(function()
        {
            $('#txtSearch').on('focus',function() {
                $(this).removeAttr('placeholder');
            },'blur',function() {
                $(this).attr('placeholder','Search employee here...');
            });

            $("#btnBreakOut").on('click',function() {
                $.confirm({
                    title: 'Break Out?',
                    // content: 'Break Out?',
                    theme: 'supervan',
                    buttons: {
                        confirm: function () {
                            self = this;
                            $.post(base_url+'Home/breakOut',function(d) {
                                if( d == 0 ) {
                                    location.reload();
                                } else {
                                    $.alert({
                                        title: 'Encountered an error!',
                                        content: d,
                                    });
                                }
                            },'json');

                            return false;
                        },
                        cancel: function () {
                            // $.alert('Canceled!');
                        },
                        
                    }
                });
            });

            function getEmployeesStatus( search = '' ) {
                $.post(base_url+'Dashboard/getEmployeesStatus',{search:search},function( d ) {
                    console.log( d );
                    $("#txtSearch").removeClass('spinner');
                    // $(".emp-container").html('');
                    emp = '';
                    if( d.length > 0 ) {
                        for (var i = 0; i < d.length; i++) {
                        
                            switch ( d[i]['status'].id ) {
                                case 2: // WIP
                                    e_class = 'label-success';
                                    e_desc = d[i]['task_desc'];
                                    break;
                                case 3: // BREAK
                                    e_class = 'label-default';
                                    e_desc = d[i]['status']['desc'];
                                    break;
                                default: // IDLE
                                    e_class = 'label-warning';
                                    e_desc = d[i]['status'].desc;
                                    break;
                            }

                            emp += '<div class="emp '+e_class+'">'+
                                    '<div class="emp-avatar">'+
                                        '<img src="'+d[i]['avatar']+'">'+
                                    '</div>'+
                                    '<div class="emp-bot">'+
                                        '<span class="emp-status wip">'+e_desc+'</span>'+
                                        '<span class="emp-name">'+d[i]['fn']+'</span>'+
                                    '</div>'+
                                '</div>';
                        }
                    }
                    
                    $(".emp-container").html( emp );
                },'json');
            }

            getEmployeesStatus();

            $("#txtSearch").on('keyup',function(e) {
                $(this).addClass('spinner');
                console.log( e.which );
                search = $(this).val()
                if( (e.which > 64 && e.which < 91) || e.which == 8 || e.which == 190 ) {
                    getEmployeesStatus( search );
                }
            });

        });
    </script>
</body>
</html>