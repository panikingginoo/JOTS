    <?php
        defined('BASEPATH') OR exit('No direct script access allowed'); //error_reporting(0);
        
        $headerTitle = 'System Template'; //all character that is in uppercase will wrap inside a '<span>'
        $title = 'Home';
        $icon = 'pph';
        $sidebar_active = TRUE; // default TRUE
        $search_active = FALSE; // default FALSE
        $is_help = FALSE;

        $my_css = ['chosen'];
        $my_asset = [];
    ?>
    <?php include 'include/config_pages.php'; ?>
    <?php include 'include/default_head.php'; ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/jquery-confirm/jquery-confirm.min.css'); ?>">

    <style type="text/css">
        #tblMyActivity {
            width: 90%;
            margin: 0 auto;
        }
        #tblMyActivity th,
        #tblMyActivity td {
            background: white;
            padding: 3px;
        }
        .wrapper {
            padding: 0 5px;
        }
        .nopad {
            padding: 0;
        }
        .inner-header {
            width: 100%;
            position: -webkit-sticky;
            position: sticky;
            top: 61px;
            background: white;
            -webkit-box-shadow: 0px 0px 1px 0px rgba(0,0,0,0.75);
            -moz-box-shadow: 0px 0px 1px 0px rgba(0,0,0,0.75);
            box-shadow: 0px 0px 1px 0px rgba(0,0,0,0.75);
        }
        .inner-header a {
            width: 24.77%;
            display: inline-block;
            text-align: center;
            font-weight: bold;
            padding: 5px 0;
            font-size: 1vw;
        }
        .inner-header a.active,
        .inner-header a:hover {
            background: rgb(42, 53, 66);
            color: white;
            /* text-shadow: 0 1px 1px white; */
        }
        .panel {
            margin-bottom: 0;
        }
        .panel-body {
            border-left: 1px solid #ababab;
            border-right: 1px solid #ababab;
            border-bottom: 1px solid #ababab;
        }
        .tab{
            min-height: 89vh;
            padding: 10px;
        }
        .tab:not(:last-child) {
            border-bottom: 1px solid #ababab;
        }
        .tab section {
            width: 49.8%;
            display: inline-block;
            min-height: 100vh;
            padding: 10px;
            vertical-align: top;
        }
        section#sec-wip {
            border-right: 1px solid #ababab;
        }
        .tab section .task {
            width: 100%;
            margin: 0 auto 10px auto;
        }
        .task {
            vertical-align: top;
            display: inline-block;
            width: 47.5%;
            min-width: 225px;
            min-height: 150px;
            margin: 0 0.5% 10px 0.5%;
            border: 1px solid gray;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.5);
            padding: 5px;
            padding: 10px;
            border-radius: 15px;
        }
        /*.task-header {
            margin-bottom: 10px;
        }*/
        .task .task-header div {
            display: inline-block;
            width: 32.2%;
            vertical-align: middle;
        }
        .task-cnt {
            font-weight: bold;
            font-size: 16px;
        }
        .task-buttons {
            text-align: right;
        }
        .task-body p {
            margin-bottom: 3px;
        }
        .txtSearch {
            float: right;
            width: 40%;
            max-width: 450px;
            min-width: 200px;
            border: 1px solid gray;
            padding: 5px 10px;
            border-radius: 30px;
            -webkit-border-radius: 30px;
        }
        #nav-accordion span {
            display: block;
            text-align: center;
            color: white;
            padding: 5px 0;
        }
        select#sel-myStatus {
            padding: 3px;
            width: 90%;
            margin: 0px 5%;
        }
        .topBtn {
            padding: 10px 10px 0 10px;
        }
        .task-date {
            margin: 5px 0;
        }
        .task-date span:not(:last-child) {
            width: 40%;
            display: inline-block;
        }
        .form-group {
            margin-bottom: 5px;
        }
        textarea {
            resize: none;
        }
    </style>
</head>
<body>
    <?php include 'include/default_header.php'; ?>
    <aside>
        <div id="sidebar"  class="nav-collapse ">
            <ul class="sidebar-menu" id="nav-accordion">
                <span>My Status</span>
                <select id="sel-myStatus">
                    
                </select>
                <span>My Activity</span>
                <table id="tblMyActivity">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th width="20%">Date</th>
                            <th width="35%">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </ul>
        </div>
    </aside>
    
    <section id="container" class="">
        <section id="main-content">
            <section class="wrapper">
                <div class="col-lg-12 nopad">
                    <section class="panel">
                        <div class="panel-body nopad">
                            <div class="inner-header">
                                <a href="javascript:;" data-tab="1" class="btnTab">NEW TASK</a>
                                <a href="javascript:;" data-tab="2" class="btnTab">WIP</a>
                                <a href="javascript:;" data-tab="3" class="btnTab">SUBMITTED</a>
                                <a href="javascript:;" data-tab="4" class="btnTab">DONE</a>
                            </div>
                            <div class="topBtn">
                                <!-- <input type="text" placeholder="Search here..." class="txtSearch" data-stat="1"> -->
                            </div>
                            <section class="tab" data-tab="1" data-stat="1">
                                
                            </section>
                            <section class="tab" style="padding: 0;" data-tab="2">
                                <section id="sec-wip" data-stat="2">
                                </section>
                                <section id="sec-side" data-stat="5">
                                </section>
                            </section>
                            <section class="tab" data-tab="3" data-stat="3"></section>
                            <section class="tab" data-tab="4" data-stat="4"></section>

                            <div aria-hidden="true" aria-labelledby="addCan" role="dialog" tabindex="-1" id="new-modal" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title"></h4>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" id='frmBookTask' role="form" autocomplete="off">
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
                        </div>
                    </section>
                </div>
            </section>
        </section>
    </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <?php $my_js = ['jquery.waypoints.min','chosen.jquery.min']; ?>
    <?php include 'include/default_script.php'; ?>

    <script type="text/javascript" src="<?php echo base_url('assets/jquery-confirm/jquery-confirm.min.js'); ?>"></script>
    <script type="text/javascript">
        $(document).ready(function()
        {
            // VARIABLES //
            var started = 0;
            var taskAttrValue = [];
            var taskid = 0;
            // VARIABLES //

            $(".main-body,.log-container").niceScroll({styler:"fb",cursorcolor:"#e8403f", cursorwidth: '6', cursorborderradius: '10px', background: '#404040', spacebarenabled:false,  cursorborder: '', zindex: '1000'});

            $.fn.mySelect = function( data = [] ) {
                list = '';
                if( data.length > 0 ) {
                    for (var i = 0; i < data.length; i++) {
                        list += '<option value="'+data[i].value+'">'+data[i].text+'</option>';
                    }
                }
                
                return this.html( list );
            };

            function addZero( i ) {
                return i < 10 ? '0'+i : i;
            }

            function runTime( id,time ) {
                timer = setInterval(function() {
                    time = new Date(time);
                    now = new Date();

                    elapsed = (now.getTime() - time.getTime()) / 1000;

                    d = Math.floor(elapsed / 86400);
                    h = addZero( Math.floor(elapsed / 3600 % 24) );
                    m = addZero( Math.floor(elapsed / 60 % 60) );
                    s = addZero( Math.floor(elapsed % 60) );

                    // console.log( id );
                    $(".task[data-taskid="+id+"] .task-elapse").html('<i><b>Time: </b>'+h+':'+m+':'+s+'</i>');
                },1000);
            }

            function daysLate( id,start,due,TaskStatus ) {
                // t_name = 't_'+id.t;
                t_name = setInterval(function() {
                    start = new Date(start);
                    due = new Date(due);
                    now = new Date();

                    d = 0;
                    if( now > due ) {
                        elapsed = (now.getTime() - due.getTime()) / 1000;
                        d = Math.floor(elapsed / 86400);
                    }
                    
                    $(".task[data-taskid="+id+"] .date-late").html('<i><b>Days Late: </b> '+d+'</i>');
                    if( TaskStatus === 4 ) {
                        clearTimeout( t_name );
                    }
                    console.log( t_name );

                },1000);
            }

            function myActivity() {
                $.post(base_url+'Home/getMyActivity',function(d) {
                    // console.log( d );
                    for (var i = 0; i < d.length; i++) {
                        logs = '<tr>'+
                                    '<td>'+d[i].task+'</td>'+
                                    '<td>'+d[i].dt.d+'</td>'+
                                    '<td>'+d[i].dt.t+'</td>'+
                                '</tr>';

                        $("#tblMyActivity tbody").append( logs );
                    }

                },'json');
            }
            myActivity();

            function myTask() {
                $.get(base_url + 'Home/getMyTask',true,function(d) {
                    task = '';
                    $("section[data-stat]").html('');
                    // console.log( d );
                    for (var i = 0; i < d.length; i++) {
                        StartDate = '';

                        switch( d[i].TaskStatus ) {
                            case 1:
                                btns = '<button type="button" class="btn btn-info btn-xs btnStart">Start</button> <button class="btn btn-danger btn-xs btnDelete"><i class="fa fa-times"></i></button>';
                                break;
                            case 2:
                                btn1 = d[i].isRunning ? '<button type="button" class="btn btn-danger btn-xs btnStop">Stop</button>' : '<button type="button" class="btn btn-info btn-xs btnStart">Start</button>';
                                btns = btn1+' <button type="button" class="btn btn-success btn-xs btnSubmit">Submit</button>';

                                StartDate = '<i><b>Start Date: </b> '+d[i].StartDate+'</i>';
                                break;
                            default:
                                btns = '';
                                break;
                        }

                        if( d[i].isRunning ) {
                            runTime( d[i].id,d[i].StartTime );
                        }

                        daysLate( d[i].id,d[i].StartDate,d[i].DueDate,d[i].TaskStatus );

                        task = '<div class="task" data-taskid='+d[i].id+'>'+
                                    '<div class="task-header">'+
                                        '<div class="task-cnt">'+d[i].TaskNo+'</div>'+
                                        '<div class="task-elapse"></div>'+
                                        '<div class="task-buttons">'+btns+'</div>'+
                                    '</div>'+
                                    '<div class="task-date">'+
                                        '<span class="date-start">'+StartDate+'</span>'+
                                        '<span class="date-due"><i><b>Due Date: </b> '+d[i].DueDate+'</i></span>'+
                                        '<span class="date-late"></span>'+
                                    '</div>'+
                                    '<div class="task-body">';
                                    attrs = d[i].attributes;
                                        for (var ii = 0; ii < attrs.length; ii++) {
                                            desc = attrs[ii].desc === null || attrs[ii].desc === '' ? '' : '<i> ('+attrs[ii].desc+')</i>';
                                            val = attrs[ii].val === null || attrs[ii].val === '' ? '' : attrs[ii].val;

                                            task += '<p><b>'+attrs[ii].name+desc+':</b> '+val+'</p>';
                                        }
                        task +=     '</div>'+
                                '</div>';

                        if( d[i].isRunning ) { started = 1; }

                        $("section[data-stat='"+d[i].TaskStatus+"']").append( task );
                    }
                    
                    // console.log( started );
                },'json');
            }
            myTask();

            function taskType() {
                $.post(base_url+'Home/getTasksType',function(d) {
                    for (var i = 0; i < d.length; i++) {
                        btn = '<button type="button" class="btn btn-round btn-primary btnNewtask" data-name="'+d[i].desc+'" data-id='+d[i].id+'>'+d[i].desc+' <i class="fa fa-plus"></i></button>';

                        $(".topBtn").append( btn );
                    }
                },'json');
            }
            taskType();

            $("#sel-myStatus").mySelect([
                { value: 1, text: 'WIP' },
                { value: 2, text: 'BREAK' },
                { value: 3, text: 'COMPLETED' }
            ]);

            $('.tab').waypoint(function (event, direction) {
                id = this.element.dataset.tab;
                $('.btnTab').removeClass('active');
                $('.btnTab[data-tab="'+ id +'"]').addClass('active');
                // console.log( direction +' '+id );
            },{ offset: 85 });

            $(document).on('click','.btnTab',function() {
                tab = $(this).data('tab');
                offset = $(this).offset().top;
                $(".btnTab").removeClass('active');
                $(this).addClass('active');

                // console.log( $('.tab[data-tab='+tab+']').offset().top );

                $('html, body').animate({
                    scrollTop: $('.tab[data-tab='+tab+']').offset().top - 89
                }, 500,function() {
                    // console.log( $('.tab[data-tab='+tab+']').offset().top );
                });
            });

            // var items;
            function getList( comp,name,sel_i ) {
                $.post(base_url+'Home/getList',{comp:comp,name:name},function(d) {
                    items = '';
                    for (var i = 0; i < d.length; i++) {
                        items += '<option value="'+d[i].val+'">'+d[i].txt+'</option>';
                    }

                    $("select[data-i="+sel_i+"]").html( items ).trigger('chosen:updated');
                },'json');
            }

            $(document).on('click','.btnNewtask',function() {
                taskid = $(this).data('id');
                task = $(this).data('name');
                $.post(base_url+'Home/getTaskAttributes',{id:taskid},function(d) {
                    console.log( d );
                    $(".attr-container").html('');
                    for (var i = 0; i < d.length; i++) {

                        switch( parseInt( d[i].HTMLTypeID ) ) {
                            case 2: //SELECT
                                getList( 'PHOENIX PUBLISHING HOUSE',d[i].Name,i );

                                attr = '<div class="form-group">'+
                                            '<label for="inputEmail1" class="col-lg-3 col-sm-3 control-label">'+d[i].Name+'</label>'+
                                            '<div class="col-lg-9">'+
                                                '<select class="chosen-select myTaskAttributes" data-i='+i+' data-id='+d[i].TaskAttributeID+'></select>'+
                                            '</div>'+
                                        '</div>';
                                break;
                            case 3: //TEXTAREA
                                attr = '<div class="form-group">'+
                                        '<label for="inputEmail1" class="col-lg-3 col-sm-3 control-label">'+d[i].Name+'</label>'+
                                        '<div class="col-lg-9">'+
                                            '<textarea class="form-control myTaskAttributes" data-i='+i+' row=3 data-id='+d[i].TaskAttributeID+'></textarea>'+
                                        '</div>'+
                                    '</div>';
                                break;
                            case 3: //NUMBER
                                attr = '<div class="form-group">'+
                                        '<label for="inputEmail1" class="col-lg-3 col-sm-3 control-label">'+d[i].Name+'</label>'+
                                        '<div class="col-lg-9">'+
                                            '<input type="number" class="form-control myTaskAttributes" data-i='+i+' data-id='+d[i].TaskAttributeID+' />'+
                                        '</div>'+
                                    '</div>';
                                break;
                            default:
                                attr = '<div class="form-group">'+
                                            '<label for="inputEmail1" class="col-lg-3 col-sm-3 control-label">'+d[i].Name+'</label>'+
                                            '<div class="col-lg-9">'+
                                                '<input type="text" class="form-control myTaskAttributes" data-i='+i+' data-id='+d[i].TaskAttributeID+' />'+
                                            '</div>'+
                                        '</div>';

                                break;
                        }

                        $(".attr-container").append( attr );
                        $(".chosen-select").chosen({width: "100%"});
                    }
                    

                    //<div class="form-group">
                    //     <label for="inputEmail1" class="col-lg-3 col-sm-3 control-label">Company</label>
                    //     <div class="col-lg-9">
                    //         <select class="chosen-select" id="esel-comp"></select>
                    //     </div>
                    // </div>

                    //attr-container
                    $("#new-modal .modal-title").text( task ); 
                    $("#new-modal").modal('show');
                },'json');
            });

            $(document).on('click','.btnStart',function() {
                task = $(this).parent().parent().find('.task-cnt').text();
                id = $(this).parent().parent().parent().data('taskid');
                // console.log( id );
                if( started > 0 ) {
                    $.alert({
                        title: 'Warning!',
                        content: 'Unable to start task, Please the running task',
                    });
                } else {
                    $.confirm({
                        title: task,
                        content: 'Start this task?',
                        theme: 'supervan',
                        buttons: {
                            confirm: function () {
                                self = this;
                                $.post(base_url+'Home/startTask',{id:id},function(d) {
                                    if( d.error === 0 ) {
                                        myTask();
                                        self.close();
                                    } else {
                                        $.alert({
                                            title: 'Encountered an error!',
                                            content: d.error,
                                        });
                                    }
                                },'json');

                                return false;
                            },
                            cancel: function () {
                                // $.alert('Canceled!');
                            },
                            /*somethingElse: {
                                text: 'Something else',
                                btnClass: 'btn-blue',
                                keys: ['enter', 'shift'],
                                action: function(){
                                    $.alert('Something else?');
                                }
                            }*/
                        }
                    });
                }                
            });

            $(document).on('click','.btnDelete',function() {
                task = $(this).parent().parent().find('.task-cnt').text();
                id = $(this).parent().parent().parent().data('taskid');
                // console.log( id );
                $.confirm({
                    title: task,
                    content: 'Delete this task?',
                    theme: 'supervan',
                    buttons: {
                        confirm: function () {
                            self = this;
                            $.post(base_url+'Home/deleteTask',{id:id},function(d) {
                                if( d == 0 ) {
                                    myTask();
                                    self.close();
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

            $("#frmBookTask").on('submit',function() {
                taskAttrValue = [];
                $(".myTaskAttributes").each(function() {
                    taskAttrValue.push({
                        'id' : $(this).data('id'),
                        'val' : $(this).val()
                    });
                });
                //console.log( taskAttrValue );

                $.confirm({
                    title: task,
                    content: 'Save this task?',
                    theme: 'supervan',
                    buttons: {
                        confirm: function () {
                            self = this;
                            $.post(base_url+'Home/addTask',{data:taskAttrValue,taskid:taskid},function(d) {
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
                        // somethingElse: {
                        //     text: 'Something else',
                        //     btnClass: 'btn-blue',
                        //     keys: ['enter', 'shift'],
                        //     action: function(){
                        //         $.alert('Something else?');
                        //     }
                        // }
                    }
                });

                return false;
            });
            
            $(document).on('click','.btnStop',function() {
                task = $(this).parent().parent().find('.task-cnt').text();
                id = $(this).parent().parent().parent().data('taskid');
                // console.log( id );
                $.confirm({
                    title: task,
                    content: 'Stop this task?',
                    theme: 'supervan',
                    buttons: {
                        confirm: function () {
                            self = this;
                            $.post(base_url+'Home/stopTask',{id:id},function(d) {
                                if( d == 0 ) {
                                    myTask();
                                    self.close();
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

            $(document).on('click','.btnSubmit',function() {
                task = $(this).parent().parent().find('.task-cnt').text();
                id = $(this).parent().parent().parent().data('taskid');
                // console.log( id );
                $.confirm({
                    title: task,
                    content: 'Submit this task?',
                    theme: 'supervan',
                    buttons: {
                        confirm: function () {
                            self = this;
                            $.post(base_url+'Home/submitTask',{id:id},function(d) {
                                if( d == 0 ) {
                                    myTask();
                                    self.close();
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

        });
    </script>
</body>
</html>