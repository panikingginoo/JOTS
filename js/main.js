// VARIABLES //
var main_started = 0;
var side_started = 0;

var intervals = [];
// VARIABLES //

// $(".chosen-select").chosen({
//     search_contains: true,
//     width: "100%"
// });

$(".main-body,.log-container").niceScroll({styler:"fb",cursorcolor:"#e8403f", cursorwidth: '6', cursorborderradius: '10px', background: '#404040', spacebarenabled:false,  cursorborder: '', zindex: '1000'});

$.fn.mySelect = function( data = [] ) {
    list = '';
    if( data.length > 0 ) {
        for (var i = 0; i < data.length; i++) {
            list += '<option value="'+data[i].id+'">'+data[i].desc+'</option>';
        }
    }
    
    return this.html( list );
};

function addZero( i ) {
    return i < 10 ? '0'+i : i;
}

function runTime( id,time ) {
    intervals.push( setInterval(function() {
        time = new Date(time);
        now = new Date();

        elapsed = (now.getTime() - time.getTime()) / 1000;

        d = Math.floor(elapsed / 86400);
        h = addZero( Math.floor(elapsed / 3600 % 24) );
        m = addZero( Math.floor(elapsed / 60 % 60) );
        s = addZero( Math.floor(elapsed % 60) );

        // console.log( id );
        $(".time-lapse[data-taskid="+id+"]").text(h+':'+m+':'+s);
    },1000) );
}

function runTimeHeader( time ) {
    intervals.push( setInterval(function() {
        time = new Date(time);
        now = new Date();

        elapsed = (now.getTime() - time.getTime()) / 1000;

        d = Math.floor(elapsed / 86400);
        h = addZero( Math.floor(elapsed / 3600 % 24) );
        m = addZero( Math.floor(elapsed / 60 % 60) );
        s = addZero( Math.floor(elapsed % 60) );

        // console.log( id );
        $("#h1_time").text(h+':'+m+':'+s);
    },1000) );
}

function daysLate( id,start,due ) {
    // t_name = 't_'+id.t;
    setInterval(function() {
        start = new Date(start);
        due = new Date(due);
        now = new Date();

        d = 0;
        if( now >= due ) {
            elapsed = (now.getTime() - due.getTime()) / 1000;
            d = Math.floor(elapsed / 86400);
        }
        
        $(".time-info[data-taskid="+id+"] .days-late i").text( d );
        // if( TaskStatus === 4 ) {
        //     clearTimeout( t_name );
        // }
        // console.log( t_name );

    },1000);
}

function daysLateDone( id,due,end ) {
    due = new Date(due);
    end = new Date(end);

    d = 0;
    if( end >= due ) {
        elapsed = (end.getTime() - due.getTime()) / 1000;
        d = Math.floor(elapsed / 86400);
    }
    console.log( 'due: '+ due );
    console.log( 'end: '+ end );
    
    // $(".time-info[data-taskid="+id+"] .days-late i").text( 12 );
    return d;
}

function myStatus() {
    $.post(base_url+'Home/getMyStatus',function(d) {
        // console.log( d );
        // $("#sel-myStatus").chosen({width: "90%"}).mySelect(d).trigger('chosen:updated');
        stat = '';
        if( d.length > 0 ) {
            switch( d[0] ) {
                case 1:
                    stat = '<i class="fa fa-circle text-warning"></i> '+d[1];
                    break;
                case 2:
                    stat = '<i class="fa fa-circle text-success"></i> '+d[1];
                    break;
                default:
                    stat = '';
                    break;
            }
        }
        
        $(".head-status").html( stat );
    },'json');
}
// myStatus();

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
// myActivity();

function myTask() {
    // clear all intervals
    if( intervals.length > 0 ) {
        for (var i = 0; i < intervals.length; i++) {
            window.clearInterval(intervals[i]);
        }
    }
    main_started = 0;
    side_started = 0;

    $.get(base_url+'Home/getMyTask',function(d) {
        // console.log( d );

        myStatus();

        task = '';
        newTask = '';
        wipTask = '';
        submitTask = '';
        doneTask = '';

        for (var i = 0; i < d.my_task.length; i++) {
            if( d.my_task[i].isRunning && d.my_task[i].CategoryID === 1 ) { // MAIN TASK RUNNING
                main_started = 1;
            }

            if( d.my_task[i].isRunning && d.my_task[i].CategoryID === 2 ) { // SIDE TASK RUNNING
                side_started = 1;
            }
        }

        // console.log( 'main_started '+main_started );
        // console.log( 'side_started '+side_started );

        for (var i = 0; i < d.my_task.length; i++) {
            startDate = d.my_task[i].StartDate === null ? '&nbsp;' : d.my_task[i].StartDate;
            // timeLapse = d.my_task[i].TaskStatus === 2 ? '00:00:00' : '';
            dLateDone = 0;

            if( d.my_task[i].isRunning && d.my_task[i].StopTime === null ) { //RUNNING
                runTime( d.my_task[i].id,d.my_task[i].StartTime );
                // started = 1;
            }
            if( d.my_task[i].TaskStatus !== 4 ) { // NOT DONE
                daysLate( d.my_task[i].id,d.my_task[i].StartDate,d.my_task[i].DueDate );
            }
            if( d.my_task[i].TaskStatus === 4 ) { // DONE
                dLateDone = daysLateDone( d.my_task[i].id,d.my_task[i].DueDate,d.my_task[i].EndTime );
            }

            switch( d.my_task[i].TaskStatus ) {
                case 1:
                    s_play = '<button class="btn btn-success btn-xs btnStart" data-catid='+d.my_task[i].CategoryID+' data-taskid='+d.my_task[i].id+'><i class="fa fa-play"></i></button>';
                    s_delete = d.my_task[i].AssignedTo == d.my_task[i].AssignedBy ? '<button class="btn btn-danger btn-xs btnDelete" data-catid='+d.my_task[i].CategoryID+' data-taskid='+d.my_task[i].id+'><i class="fa fa-trash-o"></i></button>' : '';

                    if( d.my_task[i].CategoryID === 1 ) {
                        s_play = main_started == 0 ? s_play : '';
                    } else {
                        s_play = side_started == 0 ? s_play : '';
                    }

                    btn = s_play + s_delete;

                    break;
                case 2:
                    s_stop = '<button class="btn btn-danger btn-xs btnStop" data-catid='+d.my_task[i].CategoryID+' data-taskid='+d.my_task[i].id+'><i class="fa fa-stop"></i></button>';
                    s_play = '<button class="btn btn-success btn-xs btnStart" data-catid='+d.my_task[i].CategoryID+' data-taskid='+d.my_task[i].id+'><i class="fa fa-play"></i></button>';
                    s_delete = d.my_task[i].AssignedTo == d.my_task[i].AssignedBy ? '<button class="btn btn-danger btn-xs btnDelete" data-catid='+d.my_task[i].CategoryID+' data-taskid='+d.my_task[i].id+'><i class="fa fa-trash-o"></i></button>' : '';

                    // s_play = (d.my_task[i].isRunning ? s_stop : s_play);

                    if( d.my_task[i].isRunning ) {
                        s_play = s_stop;
                    } else {
                        if( d.my_task[i].CategoryID === 1 ) {
                            s_play = main_started == 0 ? s_play : '';
                        } else {
                            s_play = side_started == 0 ? s_play : '';
                        }
                    }

                    btn = s_play+'<button class="btn btn-info btn-xs btnSubmit" data-taskid='+d.my_task[i].id+'><i class="fa fa-mail-forward"></i></button>'+s_delete;

                    break;
                case 3:
                    btn = '';
                    if( userLevel == 3 ) { // IF SUPERVISOR
                        btn = '<button class="btn btn-info btn-xs btnReturn" data-taskid='+d.my_task[i].id+'><i class="fa fa-mail-reply"></i></button>';
                        btn += '<button class="btn btn-success btn-xs btnDone" data-taskid='+d.my_task[i].id+'><i class="fa fa-check"></i></button>';
                    }
                    break;
                case 4:
                    btn = '';
                    break;
                default:

                    break;
            }

            isBackJob = d.my_task[i].TaskStatus === 2 && d.my_task[i].SubmittedBy !== null ? ' backjob' : '';

            task = '<div class="task'+isBackJob+'" title="'+(isBackJob == '' ? '' : 'BACK JOB')+'">'+
                        '<span class="task-info" title="View info" data-th_id='+d.my_task[i].id+'><i class="fa fa-info"></i></span>'+
                        '<div class="task-btn">'+btn+'</div>'+
                        '<span class="time-lapse" data-taskid='+d.my_task[i].id+'></span>'+
                        '<span class="task-title">'+d.my_task[i].Description+'</span>'+
                        '<div class="time-info" data-taskid='+d.my_task[i].id+'>'+
                            '<div class="dt start-date">'+
                                '<b>START DATE</b>'+
                                '<i>'+startDate+'</i>'+
                            '</div>'+
                            '<div class="dt due-date">'+
                                '<b>DUE DATE</b>'+
                                '<i>'+d.my_task[i].DueDate+'</i>'+
                            '</div>'+
                            '<div class="dt days-late">'+
                                '<b>DAYS LATE</b>'+
                                '<i>'+dLateDone+'</i>'+
                            '</div>'+
                        '</div>';
                if( d.my_task[i].TaskStatus === 3 && userLevel === 3 ) {
                    task += '<div class="submitted-info">'+
                                '<i>by '+d.my_task[i].SubmittedBy+'</i>'+
                            '</div>';
                }
            task += '</div>';

            switch( d.my_task[i].TaskStatus ) {
                case 1:
                    newTask += task;
                    break;
                case 2:
                    wipTask += task;
                    break;
                case 3:
                    submitTask += task;
                    break;
                case 4:
                    doneTask += '<div class="col-33">'+task+'</div>';
                    break;
                default:

                    break;
            }
        }

        $(".wip-btn").html('');
        if( d.current_wip.length > 0 ) {
            if( d.current_wip[0].isRunning ) {
                $(".wip-btn").html('<i class="fa fa-stop" data-catid='+d.current_wip[0].CategoryID+' data-taskid='+d.current_wip[0].id+' title="STOP CURRENT WIP?"></i>');
            } else {
                $(".wip-btn").html('<i class="fa fa-play" data-catid='+d.current_wip[0].CategoryID+' data-taskid='+d.current_wip[0].id+' title="PLAY CURRENT WIP?"></i>');
            }
        }

        wip_h1 = d.current_wip.length > 0 ? d.current_wip[0].Description : 'NO CURRENT WIP';
        wip_span = d.current_wip.length > 0 ? d.current_wip[0].attributes[0]['val'] : '';

        if( d.current_wip.length > 0 && d.current_wip[0].isRunning ) {
            runTimeHeader( d.current_wip[0].StartTime );
        } else { $("#h1_time").text('00:00:00'); }

        // console.log( d.current_wip.length );

        $(".wip-desc h1#h1_title").text( wip_h1 );
        $(".wip-desc span").text( 'ITEM CODE: '+ wip_span );
        
        $('.new-container').html( newTask );
        $('.wip-container').html( wipTask );
        $('.submitted-container').html( submitTask );
        $('.task-container .done').html( doneTask );

        // console.log( intervals );

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
// taskType();
function getList( comp,name,sel_i ) {
    $.post(base_url+'Home/getList',{comp:comp,name:name},function(d) {
        items = '';
        for (var i = 0; i < d.length; i++) {
            items += '<option value="'+d[i].val+'">'+d[i].txt+'</option>';
        }

        $("select[data-i="+sel_i+"]").html( items ).trigger('chosen:updated');
    },'json');
}

$(document).on('click','#btnNewTask',function() {
    $.post(base_url+'Home/getTaskAttributes',function(d) {
        // console.log( d );

        $("#sel-task").mySelect( d.task_type ).trigger('chosen:updated');
        $("#sel-assignedTo").mySelect( d.employee ).trigger('chosen:updated');

        $(".attr-container").html('');
        for (var i = 0; i < d.attr.length; i++) {
            isReq = d.attr[i].isRequired > 0 ? 'required' : '';
            switch( parseInt( d.attr[i].HTMLTypeID ) ) {
                case 2: //SELECT
                    getList( 'PHOENIX PUBLISHING HOUSE',d.attr[i].Name,i );

                    attr = '<div class="form-group">'+
                                '<label for="inputEmail1" class="col-lg-3 col-sm-3 control-label">'+d.attr[i].Name+'</label>'+
                                '<div class="col-lg-9">'+
                                    '<select class="chosen-select myTaskAttributes '+d.attr[i].Class+'" '+isReq+' data-i='+i+' data-id='+d.attr[i].TaskAttributeID+'></select>'+
                                '</div>'+
                            '</div>';
                    break;
                case 3: //TEXTAREA
                    attr = '<div class="form-group">'+
                            '<label for="inputEmail1" class="col-lg-3 col-sm-3 control-label">'+d.attr[i].Name+'</label>'+
                            '<div class="col-lg-9">'+
                                '<textarea class="form-control myTaskAttributes '+d.attr[i].Class+'" '+isReq+' data-i='+i+' row=3 data-id='+d.attr[i].TaskAttributeID+'></textarea>'+
                            '</div>'+
                        '</div>';
                    break;
                case 3: //NUMBER
                    attr = '<div class="form-group">'+
                            '<label for="inputEmail1" class="col-lg-3 col-sm-3 control-label">'+d.attr[i].Name+'</label>'+
                            '<div class="col-lg-9">'+
                                '<input type="number" class="form-control myTaskAttributes '+d.attr[i].Class+'" '+isReq+' data-i='+i+' data-id='+d.attr[i].TaskAttributeID+' />'+
                            '</div>'+
                        '</div>';
                    break;
                default:
                    attr = '<div class="form-group">'+
                                '<label for="inputEmail1" class="col-lg-3 col-sm-3 control-label">'+d.attr[i].Name+'</label>'+
                                '<div class="col-lg-9">'+
                                    '<input type="text" class="form-control myTaskAttributes '+d.attr[i].Class+'" '+isReq+' data-i='+i+' data-id='+d.attr[i].TaskAttributeID+' />'+
                                '</div>'+
                            '</div>';

                    break;
            }
            
            $(".attr-container").append( attr );
            $(".chosen-select").chosen({width: "100%"});
            
        }
        attr = '<div class="form-group">'+
                '<label for="inputEmail1" class="col-lg-3 col-sm-3 control-label">DUE DATE</label>'+
                '<div class="col-lg-9">'+
                    '<input type="text" class="form-control datepicker" id="txtDueDate" required />'+
                '</div>'+
            '</div>';
        $(".attr-container").append( attr );

        $(".datepicker").datepicker();
        $("#new-modal").modal('show');
    },'json');
});

// $("#frmNewTask").on('submit',function() {
//     taskAttrValue = [];
//     $(".myTaskAttributes").each(function() {
//         taskAttrValue.push({
//             'id' : $(this).data('id'),
//             'val' : $(this).val()
//         });
//     });

//     $.confirm({
//         title: 'NEW TASK',
//         content: 'Save this task?',
//         theme: 'supervan',
//         buttons: {
//             confirm: function () {
//                 self = this;
//                 $.post(base_url+'Home/addTask',{data:taskAttrValue,taskid:$("#sel-task").val(),dueDate:$("#txtDueDate").val()},function(d) {
//                     if( d == 0 ) {
//                         myTask();
//                         $("#new-modal").modal('hide');
//                         self.close();
//                     } else {
//                         $.alert({
//                             title: 'Encountered an error!',
//                             content: d,
//                         });
//                     }
//                 });

//                 return false;
//             },
//             cancel: function () {
//                 // $.alert('Canceled!');
//             },
//             // somethingElse: {
//             //     text: 'Something else',
//             //     btnClass: 'btn-blue',
//             //     keys: ['enter', 'shift'],
//             //     action: function(){
//             //         $.alert('Something else?');
//             //     }
//             // }
//         }
//     });

//     return false;
// });

$(document).on('click','.btnDelete',function() {
    task = $(this).parent().parent().find('.task-title').text();
    id = $(this).data('taskid');
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

$(document).on('click','.btnStop',function() {
    task = $(this).parent().parent().find('.task-title').text();
    id = $(this).data('taskid');
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

$(document).on('change','#sel-task',function() {
    taskID = $(this).val();
    $.get(base_url+'Home/getTaskAttributes/'+taskID,function(d) {
        $(".attr-container").html('');
        for (var i = 0; i < d.attr.length; i++) {
            isReq = d.attr[i].isRequired > 0 ? 'required' : '';
            switch( parseInt( d.attr[i].HTMLTypeID ) ) {
                case 2: //SELECT
                    getList( 'PHOENIX PUBLISHING HOUSE',d.attr[i].Name,i );

                    attr = '<div class="form-group">'+
                                '<label for="inputEmail1" class="col-lg-3 col-sm-3 control-label">'+d.attr[i].Name+'</label>'+
                                '<div class="col-lg-9">'+
                                    '<select class="chosen-select myTaskAttributes" '+isReq+' data-i='+i+' data-id='+d.attr[i].TaskAttributeID+'></select>'+
                                '</div>'+
                            '</div>';
                    break;
                case 3: //TEXTAREA
                    attr = '<div class="form-group">'+
                            '<label for="inputEmail1" class="col-lg-3 col-sm-3 control-label">'+d.attr[i].Name+'</label>'+
                            '<div class="col-lg-9">'+
                                '<textarea class="form-control myTaskAttributes" '+isReq+' data-i='+i+' row=3 data-id='+d.attr[i].TaskAttributeID+'></textarea>'+
                            '</div>'+
                        '</div>';
                    break;
                case 3: //NUMBER
                    attr = '<div class="form-group">'+
                            '<label for="inputEmail1" class="col-lg-3 col-sm-3 control-label">'+d.attr[i].Name+'</label>'+
                            '<div class="col-lg-9">'+
                                '<input type="number" class="form-control myTaskAttributes" '+isReq+' data-i='+i+' data-id='+d.attr[i].TaskAttributeID+' />'+
                            '</div>'+
                        '</div>';
                    break;
                default:
                    attr = '<div class="form-group">'+
                                '<label for="inputEmail1" class="col-lg-3 col-sm-3 control-label">'+d.attr[i].Name+'</label>'+
                                '<div class="col-lg-9">'+
                                    '<input type="text" class="form-control myTaskAttributes" '+isReq+' data-i='+i+' data-id='+d.attr[i].TaskAttributeID+' />'+
                                '</div>'+
                            '</div>';

                    break;
            }

            $(".attr-container").append( attr );
            $(".chosen-select").chosen({
                width: "100%",
                search_contains: true,
                allow_single_deselect: true
            });
        }

    },'json');
});

$(document).on('click','.btnSubmit',function() {
    task = $(this).parent().parent().find('.task-title').text();
    id = $(this).data('taskid');
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

$(document).on('click','.btnStart',function() {
    task = $(this).parent().parent().find('.task-title').text();
    catid = $(this).data('catid');
    id = $(this).data('taskid');
    // console.log( id );
    if( main_started > 0 && side_started > 0 ) {
        if( catid == 1 ) {
            $.alert({
                title: 'Warning!',
                content: 'Unable to start task, You can only start One Book Related task and One Cost Center task',
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
                                if( catid == 1 ) {
                                    main_started = 1;
                                } else {
                                    side_started = 1;
                                }
                                // console.log( catid +' - '+ main_started + ' - '+ side_started );
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
                            if( catid == 1 ) {
                                main_started = 1;
                            } else {
                                side_started = 1;
                            }
                            // console.log( catid +' - '+ main_started + ' - '+ side_started );
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

$(document).on('click','.wip-btn .fa-play',function() {
    task = $('.wip-desc #h1_title').text();
    catid = $(this).data('catid');
    id = $(this).data('taskid');
    // console.log( id );
    $.confirm({
        title: task,
        content: 'Start this task?',
        theme: 'supervan',
        buttons: {
            confirm: function () {
                self = this;
                $.post(base_url+'Home/startTask',{id:id},function(d) {
                    if( d.error === 0 ) {
                        if( catid == 1 ) {
                            main_started = 1;
                        } else {
                            side_started = 1;
                        }
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
});

$(document).on('click','.wip-btn .fa-stop',function() {
    task = $('.wip-desc #h1_title').text();
    catid = $(this).data('catid');
    id = $(this).data('taskid');
    // console.log( id );
    $.confirm({
        title: task,
        content: 'Stop current task?',
        theme: 'supervan',
        buttons: {
            confirm: function () {
                self = this;
                $.post(base_url+'Home/stopTask',{id:id},function(d) {
                    if( d == 0 ) {
                        if( catid == 1 ) {
                            main_started = 1;
                        } else {
                            side_started = 1;
                        }
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

$(document).on('click','.task-info',function() {
    TaskHistoryID = $(this).data('th_id');

    $.post(base_url+'Home/getMyTaskAttributes',{'TaskHistoryID':TaskHistoryID},function(d) {
        // console.log( d );
        attr = '';
        for (var i = 0; i < d.length; i++) {
            attr += '<div class="form-group">'+
                        '<label class="col-lg-3 col-sm-3 control-label">'+d[i].label+'</label>'+
                        '<div class="col-lg-9 i">'+d[i].val+'</div>'+
                    '</div>';
        }
        $('#frmInfo').html( attr );
        $("#info-modal").modal('show');
    },'json');
});