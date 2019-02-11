    <?php
        defined('BASEPATH') OR exit('No direct script access allowed'); error_reporting(0);
        
        $headerTitle = 'System Template'; //all character that is in uppercase will wrap inside a '<span>'
        $title = 'Home';
        $icon = 'pph';
        $sidebar_active = FALSE; // default TRUE
        $search_active = FALSE; // default FALSE
        $is_help = FALSE;
    ?>
    <?php include 'include/config_pages.php'; ?>
    <?php include 'include/default_head.php'; ?>
    <style type="text/css">
        .white-bg {
            box-shadow: 0 1px 3px -2px black;
        }
        .wrapper {
            padding: 5px 4px 0 4px;
            overflow: hidden;
        }
        .site-min-height {
            min-height: 560px;
        }
        .noRadius {
            border-radius: 0;
            margin-bottom: 5px;
        }
        .panel-body {
            padding: 0;
            box-shadow: 0 1px 5px -3px black;
        }
        .side-body {
            /*float: left;
            width: 20%;
            height: 100%;
            display: block;
            padding: 10px;*/
            width: 20%;
            height: 99.2%;
            display: inline-block;
            padding: 10px;
            position: absolute;
            border-right: 2px solid #c9cace99;
        }
        .main-body {
            /*width: 80%;
            float: left;*/
            width: 78%;
            height: 560px;
            min-height: 400px;
            position: absolute;
            top: 0;
            left: 21.1%;
            padding: 10px;
            overflow-y: scroll;
        }
        span.myLabel {
            display: block;
            margin-bottom: 5px;
            text-align: center;
            font-size: 1.5vw;
            text-shadow: 0 1px 1px grey;
            color: lightseagreen;
        }
        #sel-myStatus {
            width: 100%;
            padding: 5px;
        }
        hr {
            margin-top: 10px;
            margin-bottom: 10px;
            border-top: 1px solid #dfdfe2;
        }
        .task-container {
            /*width: 100%;
            display: block;
            min-height: 250px;
            border-bottom: 1px solid #dfdfe2;*/
            width: 100%;
            min-width: 190px;
            display: block;
            height: 250px;
            border-bottom: 1px solid #dfdfe2;
            overflow-x: scroll;
        }
        .task-title {
            display: block;
            margin:5px;
        }
        .task {
            display: inline-block;
            width: 24%;
            min-width: 185px;
            height: 200px;
            margin: 0 0.5%;
            border: 1px solid gray;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.5);
        }
        .myLabel {
            margin-top: 10px;
        }
        .log-container {
            overflow-y: scroll;
            max-height: 415px;
            height: auto;
        }
        ul#myDailyLogs {
            width: 100%;
        }
        #myDailyLogs li {
            padding: 5px 0;
            border-top: 1px solid lightgray;
        }
        #myDailylogs .logDesc,
        #myDailyLogs .logDT {
            display: block;
        }
        #myDailyLogs .logDesc {
            text-align: left;
            font-size: 1vw;
        }
        #myDailyLogs .logDT {
            padding-top: 5px;
            text-align: right;
            font-style: italic;
            font-size: 0.8vw;
            color: lightseagreen;
            text-shadow: 0 1px 1px lightblue;
        }
    </style>
</head>
<body>
    <?php include 'include/default_header.php'; ?>
    <?php include 'include/default_sidebar.php'; ?>
    
    <section id="container" class="">
        <section id="main-content">
            <section class="wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel noRadius">
                            <div class="panel-body site-min-height">
                                <div class="side-body">
                                    <span class="myLabel">My Status</span>
                                    <select id="sel-myStatus">
                                        <option value="1">WIP</option>
                                        <option value="2">BREAK</option>
                                    </select>
                                    <!-- <hr> -->
                                    <span class="myLabel">My Activities</span>
                                    <div class="log-container">
                                        <ul id="myDailyLogs"></ul>
                                    </div>
                                </div>
                                <div class="main-body">
                                    <div class="task-container">
                                        <span class="task-title">New Task</span>
                                        <div class="task"></div>
                                        <div class="task"></div>
                                        <div class="task"></div>
                                        <div class="task"></div>
                                        <div class="task"></div>
                                        <div class="task"></div>
                                        <div class="task"></div>
                                        <div class="task"></div>
                                        <div class="task"></div>
                                        <div class="task"></div>
                                    </div>
                                    <div class="task-container">
                                        <span class="task-title">WIP</span>
                                        <div class="task"></div>
                                        <div class="task"></div>
                                        <div class="task"></div>
                                    </div>
                                    <div class="task-container">
                                        <span class="task-title">Submitted</span>
                                        <div class="task"></div>
                                        <div class="task"></div>
                                    </div>
                                    <div class="task-container">
                                        <span class="task-title">Done</span>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </section>
        </section>
    </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <?php include 'include/default_script.php'; ?>
    <script type="text/javascript">
        $(document).ready(function()
        {
            $(".main-body,.log-container").niceScroll({styler:"fb",cursorcolor:"#e8403f", cursorwidth: '6', cursorborderradius: '10px', background: '#404040', spacebarenabled:false,  cursorborder: '', zindex: '1000'});

            /*var list = '';
            var iLength = 11;
            for (var i = 0; i < iLength; i++) {
                list += '<li>'+
                            '<div class="logDesc">Started task #'+i+'</div>'+
                            '<span class="logDT">Jul 12, 2018 — 8:15 AM</span>'+
                        '</li>';
            }
            $("#myDailyLogs").html( list );

            $(".log-container").scroll(function() {
                // console.log( $(".log-container").scrollTop() + ' - ' + $(".log-container").height() );
                var elemScrolPosition = (this.scrollHeight - this.scrollTop) - this.clientHeight;
                console.log( elemScrolPosition );
                if( parseInt(elemScrolPosition) < 30 ) {
                    iLength += 11;
                    for (i = i; i < iLength; i++) {
                        list += '<li>'+
                                    '<div class="logDesc">Started task #'+i+'</div>'+
                                    '<span class="logDT">Jul 12, 2018 — 8:15 AM</span>'+
                                '</li>';
                    }

                    $("#myDailyLogs").html( list );
                    elemScrolPosition = 0;
                }
            });*/

        });
    </script>
</body>
</html>