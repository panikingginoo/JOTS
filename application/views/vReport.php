<?php
defined('BASEPATH') or exit('No direct script access allowed'); //error_reporting(0);

$headerTitle = 'Job On Track System'; //all character that is in uppercase will wrap inside a '<span>'
$title = 'JOTS | Home';
$icon = 'pph';
$sidebar_active = false; // default TRUE
$search_active = false; // default FALSE
$is_help = false;

$my_css = ['chosen', 'datepicker', 'jquery.dataTables.min'];
$my_asset = [];

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
?>
    <?php include 'include/config_pages.php'; ?>
    <?php include 'include/default_head.php'; ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/jquery-confirm/jquery-confirm.min.css'); ?>">

    <style type="text/css">
        .filter-container {
            min-width: 640px;
            width: 70%;
            display: inline-block;
        }
        .filter-group {
            width: 100%;
            display: inline-block;
            margin: 3px 0;
        }
        .filter-col {
            display: block;
            float: left;
            width: 58%;
        }
        .filter-col:not(:last-child) {
            width: 20%;
            margin-right: 1%;
        }
        .filter-col:not(:last-child) .chosen-select{
            width: 90%;
        }
        .filter-col .checkbox {
            margin: 0;
        }
        #btnApply {
            margin-top: 10px;
        }
        .filter-container .form-control {
            border: 1px solid #aaaa;
            color: black;
            height: 28px;
            font-size: 12px;
            padding: 6px 8px;
        }
        .input-group {
            display: inline-block;
        }
        .filter-container .input-group-btn {
            display: table;
        }
        .filter-container .input-group-btn .btn {
            padding: 3px 7px;
        }
        .datepicker {
            width: 130px!important;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include 'include/default_header.php'; ?>
    
    <section id="container" class="">
        <section id="main-content">
            <section class="wrapper">
                <div class="col-lg-12 nopad">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="filter-container">
                                <div class="filter-group"> <!-- STATUS -->
                                    <div class="filter-col">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" class="cbWhere" checked> Status
                                            </label>
                                        </div>
                                    </div>
                                    <div class="filter-col">
                                        <select class="chosen-select">
                                            <option value="=">is</option>
                                            <option value="<>">is not</option>
                                        </select>
                                    </div>
                                    <div class="filter-col">
                                        <select class="chosen-select" id="sel_status"></select>
                                    </div>
                                </div>
                                <div class="filter-group"> <!-- ASSIGNEE -->
                                    <div class="filter-col">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" class="cbWhere"> Assignee
                                            </label>
                                        </div>
                                    </div>
                                    <div class="filter-col">
                                        <select class="chosen-select">
                                            <option value="=">is</option>
                                            <option value="<>">is not</option>
                                        </select>
                                    </div>
                                    <div class="filter-col">
                                        <select class="chosen-select" id="sel_assignee"></select>
                                    </div>
                                </div>
                                <div class="filter-group"> <!-- CATEGORY -->
                                    <div class="filter-col">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" class="cbWhere"> Category
                                            </label>
                                        </div>
                                    </div>
                                    <div class="filter-col">
                                        <select class="chosen-select">
                                            <option value="=">is</option>
                                            <option value="<>">is not</option>
                                        </select>
                                    </div>
                                    <div class="filter-col">
                                        <select class="chosen-select" id="sel_category"></select>
                                    </div>
                                </div>
                                <div class="filter-group"> <!-- DESCRIPTION -->
                                    <div class="filter-col">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" class="cbWhere"> Description
                                            </label>
                                        </div>
                                    </div>
                                    <div class="filter-col">
                                        <select class="chosen-select">
                                            <option value="=">is</option>
                                            <option value="LIKE">contains</option>
                                            <option value="NOT LIKE">does not contains</option>
                                        </select>
                                    </div>
                                    <div class="filter-col">
                                        <input type="text" id="txtCategory" name="txtCategory" class="form-control" />
                                    </div>
                                </div>
                                <div class="filter-group"> <!-- CREATED -->
                                    <div class="filter-col">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" class="cbWhere"> Created
                                            </label>
                                        </div>
                                    </div>
                                    <div class="filter-col">
                                        <select class="chosen-select chosen-date">
                                            <option value="1">is</option>
                                            <option value="2">>=</option>
                                            <option value="3"><=</option>
                                            <option value="4">between</option>
                                            <option value="5">days ago</option>
                                            <option value="6">today</option>
                                            <option value="7">yesterday</option>
                                            <option value="8">this week</option>
                                            <option value="9">last week</option>
                                            <option value="10">this month</option>
                                            <option value="11">last month</option>
                                            <option value="12">this year</option>
                                        </select>
                                    </div>
                                    <div class="filter-col">
                                        <div class="divIs dt">
                                            <div class="input-group">
                                                <input type="text" id="txtCreated_is" class="form-control datepicker" placeholder="Click to set date">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="divDaysAgo dt" style="display:none;">
                                            <input type="text" id="txtCreated_daysAgo" class="form-control" />
                                        </div>
                                        <div class="divBetween dt" style="display:none;">
                                            <div class="input-group">
                                                <input type="text" id="txtCreated_from" class="form-control datepicker" placeholder="Click to set date">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                                </span>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" id="txtCreated_to" class="form-control datepicker" placeholder="Click to set date">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="filter-group"> <!-- UPDATED -->
                                    <div class="filter-col">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" class="cbWhere"> Updated
                                            </label>
                                        </div>
                                    </div>
                                    <div class="filter-col">
                                        <select class="chosen-select chosen-date">
                                            <option value="1">is</option>
                                            <option value="2">>=</option>
                                            <option value="3"><=</option>
                                            <option value="4">between</option>
                                            <option value="5">days ago</option>
                                            <option value="6">today</option>
                                            <option value="7">yesterday</option>
                                            <option value="8">this week</option>
                                            <option value="9">last week</option>
                                            <option value="10">this month</option>
                                            <option value="11">last month</option>
                                            <option value="12">this year</option>
                                        </select>
                                    </div>
                                    <div class="filter-col">
                                        <div class="divIs dt">
                                            <div class="input-group">
                                                <input type="text" id="txtUpdated_is" class="form-control datepicker" placeholder="Click to set date">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="divDaysAgo dt" style="display:none;">
                                            <input type="text" id="txtUpdated_daysAgo" class="form-control" />
                                        </div>
                                        <div class="divBetween dt" style="display:none;">
                                            <div class="input-group">
                                                <input type="text" id="txtUpdated_from" class="form-control datepicker" placeholder="Click to set date">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                                </span>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" id="txtUpdated_to" class="form-control datepicker" placeholder="Click to set date">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="filter-group"> <!-- START DATE -->
                                    <div class="filter-col">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" class="cbWhere"> Start Date
                                            </label>
                                        </div>
                                    </div>
                                    <div class="filter-col">
                                        <select class="chosen-select chosen-date">
                                            <option value="1">is</option>
                                            <option value="2">>=</option>
                                            <option value="3"><=</option>
                                            <option value="4">between</option>
                                            <option value="5">days ago</option>
                                            <option value="6">today</option>
                                            <option value="7">yesterday</option>
                                            <option value="8">this week</option>
                                            <option value="9">last week</option>
                                            <option value="10">this month</option>
                                            <option value="11">last month</option>
                                            <option value="12">this year</option>
                                        </select>
                                    </div>
                                    <div class="filter-col">
                                        <div class="divIs dt">
                                            <div class="input-group">
                                                <input type="text" id="txtStartDate_is" class="form-control datepicker" placeholder="Click to set date">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="divDaysAgo dt" style="display:none;">
                                            <input type="text" id="txtStartDate_daysAgo" class="form-control" />
                                        </div>
                                        <div class="divBetween dt" style="display:none;">
                                            <div class="input-group">
                                                <input type="text" id="txtStartDate_from" class="form-control datepicker" placeholder="Click to set date">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                                </span>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" id="txtStartDate_to" class="form-control datepicker" placeholder="Click to set date">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="filter-group"> <!-- DUE DATE -->
                                    <div class="filter-col">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" class="cbWhere"> Due Date
                                            </label>
                                        </div>
                                    </div>
                                    <div class="filter-col">
                                        <select class="chosen-select chosen-date">
                                            <option value="1">is</option>
                                            <option value="2">>=</option>
                                            <option value="3"><=</option>
                                            <option value="4">between</option>
                                            <option value="5">days ago</option>
                                            <option value="6">today</option>
                                            <option value="7">yesterday</option>
                                            <option value="8">this week</option>
                                            <option value="9">last week</option>
                                            <option value="10">this month</option>
                                            <option value="11">last month</option>
                                            <option value="12">this year</option>
                                        </select>
                                    </div>
                                    <div class="filter-col">
                                        <div class="divIs dt">
                                            <div class="input-group">
                                                <input type="text" id="txtCreated_is" class="form-control datepicker" placeholder="Click to set date">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="divDaysAgo dt" style="display:none;">
                                            <input type="text" id="txtCreated_daysAgo" class="form-control" />
                                        </div>
                                        <div class="divBetween dt" style="display:none;">
                                            <div class="input-group">
                                                <input type="text" id="txtCreated_from" class="form-control datepicker" placeholder="Click to set date">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                                </span>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" id="txtCreated_to" class="form-control datepicker" placeholder="Click to set date">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-danger date-set"><i class="fa fa-calendar"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" id="btnApply" class="btn btn-round btn-success">Apply</button>
                            </div>

                            <!-- TABLE -->
                            <hr>
                            <div class='adv-table'>
                                <table cellpadding="0" cellspacing="0" border="0" class='display table table-bordered' id='main-table'>
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th>Assignee</th>
                                            <th>Updated At</th>
                                            <th>Start Date</th>
                                            <th>Due Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Status</td>
                                            <td>Category</td>
                                            <td>Description</td>
                                            <td>Assignee</td>
                                            <td>Updated At</td>
                                            <td>Start Date</td>
                                            <td>Due Date</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
        </section>
    </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <?php $my_js = ['chosen.jquery.min', 'datepicker', 'jquery.dataTables.min']; ?>
    <?php include 'include/default_script.php'; ?>
    <script type="text/javascript">
        $(document).ready(function()
        {
            var sWhere = [];
                
            var mainTable = $('#main-table').DataTable( {
                // "searching": false,
                "deferRender": true,
                // serverSide: true,
                // ajax: {
                //     url: '',
                //     type: 'GET'
                // },
                "columnDefs": [
                    { "orderable": false, "targets": 4 }
                ]
            });

            $('.datepicker').datepicker().keypress(function(e) {
                return false;
            });

            $(document).on('click','.input-group-btn',function() {
                $(this).parent().find('.datepicker').datepicker("show");
                // alert(  $(this).parent().find('.datepicker').attr('id') );
            });

            function getList() {
                
                $.post(base_url+'Report/getList',function(d) {
                    if( d.status.length > 0 && d.status.length > 0 && d.status.length > 0 ) {
                        
                        console.log( d );
                        listStatus = '';
                        for (i = 0; i < d.status.length; i++) {
                            listStatus += '<option value='+d.status[i].id+'>'+d.status[i].desc+'</option>';
                        }
                        $("#sel_status").html(listStatus).trigger('chosen:updated');

                        listAssignee = '';
                        for (i = 0; i < d.assignee.length; i++) {
                            listAssignee += '<option value='+d.assignee[i].id+'>'+d.assignee[i].desc+'</option>';
                        }
                        $("#sel_assignee").html(listAssignee).trigger('chosen:updated');

                        listCategory = '';
                        for (i = 0; i < d.category.length; i++) {
                            listCategory += '<option value='+d.category[i].id+'>'+d.category[i].desc+'</option>';
                        }
                        $("#sel_category").html(listCategory).trigger('chosen:updated');

                        $(".chosen-select").chosen({
                            search_contains: true,
                            allow_single_deselect: true
                        });

                        
                    } else {
                        alert('ERROR: Fetching list');
                    }
                },'json');
            }

            $(document).on('change','.chosen-date',function() {
                val = parseInt($(this).val());
                filterVal = $(this).parents('.filter-group');

                filterVal.find('.dt').hide();
                switch ( val  ) {
                    case 1:
                    case 2:
                    case 3:
                        filterVal.find('.divIs').show();
                        break;
                    case 4:
                        filterVal.find('.divBetween').show();
                        break;
                    case 5:
                        filterVal.find('.divDaysAgo').show();
                        break;
                    default:
                        filterVal.find('.dt').hide();
                        break;
                }
            });

            getList();

            $(document).on('change','.cbWhere',function() {
                
            });
        });
    </script>
</body>
</html>