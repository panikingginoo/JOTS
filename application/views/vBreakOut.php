<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/pph.ico">

    <title>JOTS | Break Out</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
        .lock-wrapper {
            max-width: 30%;
            position: fixed;
            top: 25%;
            left: 20px;
            margin: 0;
            text-align: center;
        }
        html,.myBg {
            background: #02bac6 url(<?php echo base_url(); ?>img/breakout.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
        }
        #time {
            margin-bottom: 10px;
        }
        #time,.btn-primary {
            font-size: 4.3vw;
            text-shadow: 0 1px 1px black;
        }
    </style>
</head>

<body class="lock-screen">

    <div class="lock-wrapper">

        <div id="time">00:00:00</div>
        <button type="button" id="btnBreakIn" class="btn btn-primary">BREAK IN <i class="fa fa-arrow-right"></i></button>
    </div>
    <script src="<?php echo base_url(); ?>js/jquery-1.8.3.min.js"></script>
    <script>
        $(document).ready(function() {
            base_url = "<?php echo base_url(); ?>";

            function addZero( i ) {
                return i < 10 ? '0'+i : i;
            }

            function runTime( breakOut ) {
                setInterval(function() {
                    breakOut = new Date(breakOut);
                    now = new Date();

                    elapsed = (now.getTime() - breakOut.getTime()) / 1000;

                    d = Math.floor(elapsed / 86400);
                    h = addZero( Math.floor(elapsed / 3600 % 24) );
                    m = addZero( Math.floor(elapsed / 60 % 60) );
                    s = addZero( Math.floor(elapsed % 60)-10 );

                    // console.log( id );
                    $("#time").text(h+':'+m+':'+s);
                },1000)
            }
            runTime( "<?php echo $breakInfo->BreakOut; ?>" );

            // console.log( new Date() + ' - ' + new Date("<?php echo $breakInfo->BreakOut; ?>") );

            $("#btnBreakIn").on('click',function() {
                $.post(base_url+'Home/breakIn',function(d) {
                    if( d == 0 ) {
                        location.reload();
                    } else {
                        alert( d );
                    }                    
                });
            });
        });
    </script>
</body>
</html>
