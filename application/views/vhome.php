    <?php
        defined('BASEPATH') OR exit('No direct script access allowed'); //error_reporting(0);
        
        $headerTitle = 'Job On Track System'; //all character that is in uppercase will wrap inside a '<span>'
        $title = 'JOTS | Home';
        $icon = 'pph';
        $sidebar_active = FALSE; // default TRUE
        $search_active = FALSE; // default FALSE
        $is_help = FALSE;

        $my_css = ['chosen','main','datepicker'];
        $my_asset = [];

        $top_pages = array(
            'Home' => array(
                'href' => 'Home', //javascript:;
                'icon' => 'fa fa-tasks',
            ),            
            'Logout' => array(
                'href' => 'Logout',
                'icon' => 'fa fa-key',
            ),
        );
    ?>
    <?php include 'include/config_pages.php'; ?>
    <?php include 'include/default_head.php'; ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/jquery-confirm/jquery-confirm.min.css'); ?>">

    <style type="text/css">
        
    </style>
</head>
<body>
    <?php
        $head_settings
        ='<div class="head-settings">
            <button type="button" title="Break Out" class="btn btn-warning " id="btnBreakOut"><i class="fa fa-coffee"></i></button>
            <span class="head-status"></span>
        </div>';

    ?>
    <?php include 'include/default_header.php'; ?>
    <!-- <aside>
        <div id="sidebar"  class="nav-collapse ">
            <ul class="sidebar-menu" id="nav-accordion">
                <button type="button" class="btn btn-round btn-warning" id="btnBreakOut">BREAK OUT</button>
                <span class="sidebar-span">STATUS</span>
                <span id="my_status"></span>
                
                <span class="sidebar-span">ACTIVITY</span>
                <table id="tblMyActivity">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th width="20%">Date</th>
                            <th width="35%">Time</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </ul>
        </div>
    </aside> -->
    
    <section id="container" class="">
        <section id="main-content">
            <section class="wrapper">
                <div class="col-lg-12 nopad">
                    <section class="panel">
                        <div class="panel-body nopad">
                            <div class="wip-cont">
                                <div class="wip-btn">
                                    <!-- <i class="fa fa-pause" title="PAUSE CURRENT WIP?"></i> -->
                                </div>
                                <div class="wip-desc">
                                    <div class="wip-div">
                                        <h1 id='h1_title'></h1>
                                        <span></span>
                                    </div>
                                    <div class="wip-div">
                                        <h1 id='h1_time'>00:00:00</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="task-container">
                                <div class="col-33"> <!-- NEW COLUMN -->
                                    <div class="btnNew" id="btnNewTask">
                                        <!-- <i class="fa fa-plus-circle"></i> -->
                                        + NEW TASK
                                    </div>
                                    <div class="new-container"></div>
                                </div>
                                <!-- <div class="divider"></div> -->
                                <div class="col-33"> <!-- WIP COLUMN -->
                                    <!-- <div class="btnNew">
                                        <i class="fa fa-plus-circle"></i>
                                        NEW WIP
                                    </div> -->
                                    <span class="task-desc">WIP</span>
                                    <div class="wip-container"></div>
                                </div>
                                <!-- <div class="divider"></div> -->
                                <div class="col-33"> <!-- SUBMITTED COLUMN -->
                                    <span class="task-desc">SUBMITTED</span>
                                    <div class="submitted-container"></div>
                                </div>
                            </div>
                            <div class="task-container">
                                <span class="task-desc">DONE</span>
                                <div class="done"></div>
                            </div>

                            <div aria-hidden="true" aria-labelledby="addCan" role="dialog" tabindex="-1" id="new-modal" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title">New Task</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" id='frmNewTask' role="form" autocomplete="off">
                                                <div class="form-group">
                                                    <label for="inputEmail1" class="col-lg-3 col-sm-3 control-label">Task</label>
                                                    <div class="col-lg-9">
                                                        <select class="chosen-select" id="sel-task"></select>
                                                    </div>
                                                </div>
                                                <div class="attr-container"></div>
                                                <div class="form-group">
                                                    <div class="col-lg-offset-3 col-lg-9">
                                                        <button type="submit" class="btn btn-info">
                                                            <i class="fa fa-save"></i> Save
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div aria-hidden="true" aria-labelledby="addCan" role="dialog" tabindex="-1" id="info-modal" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title">Task Information</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" id='frmInfo' role="form" autocomplete="off">
                                                <!-- <div class="info-container"></div> -->
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
        </section>
    </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <?php $my_js = ['jquery.waypoints.min','chosen.jquery.min','datepicker']; ?>
    <?php include 'include/default_script.php'; ?>

    <script type="text/javascript" src="<?php echo base_url('assets/jquery-confirm/jquery-confirm.min.js'); ?>"></script>
    <script type="text/javascript">
        var userLevel = <?php echo $userLevel; ?>;
    </script>
    <script type="text/javascript" src="<?php echo base_url('js/main.js'); ?>"></script>
    <script type="text/javascript">
        $(document).ready(function()
        {
            $("#frmNewTask").on('submit',function() {
                taskAttrValue = [];
                $(".myTaskAttributes").each(function() {
                    taskAttrValue.push({
                        'id' : $(this).data('id'),
                        'val' : $(this).val()
                    });
                });

                $.confirm({
                    title: 'NEW TASK',
                    content: 'Save this task?',
                    theme: 'supervan',
                    buttons: {
                        confirm: function () {
                            self = this;
                            $.post(base_url+'Home/addTask',{data:taskAttrValue,taskid:$("#sel-task").val(),dueDate:$("#txtDueDate").val()},function(d) {
                                if( d == 0 ) {
                                    myTask();
                                    $("#new-modal").modal('hide');
                                    self.close();
                                } else {
                                    $.alert({
                                        title: 'Encountered an error!',
                                        content: d,
                                    });
                                }
                            });

                            return false;
                        },
                        cancel: function () {
                            // $.alert('Canceled!');
                        },
                    }
                });

                return false;
            });
            
        });
    </script>
</body>
</html>