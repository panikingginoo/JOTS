<header class="header white-bg">
    <?php
        if( $sidebar_active )
        {
            echo '<div class="sidebar-toggle-box">
                    <div data-original-title="Toggle Navigation" data-placement="right" class="fa fa-bars tooltips"></div>
                 </div>';
        }
    ?>
    <!--logo start-->
    <div class='logo-cont'>
        <a href="<?php echo base_url() ?>home"><img src="<?php echo base_url().'img/'.$icon.'.ico'; ?>" /></a>
    </div>
    <!--logo end-->

    <!-- HEADER TITLE start -->
    <?php
        if( trim($headerTitle) != '' )
        {
            echo '<a href="'.base_url().'" class="logo" >'; 
            $headerTitle = str_split($headerTitle);
            //print_r($headerTitle);
            foreach ($headerTitle as $char)
            {
                echo $char === strtoupper($char) && $char !== ' ' ? '<span>'.$char.'</span>' : $char;
            }
            echo '</a>';
        }
    ?>
    <!-- HEADER TITLE end -->
    
    <div class="top-nav ">
        <ul class="nav pull-right top-menu">
            <?php
                if( $search_active )
                {
                    echo '<li>
                            <input type="text" class="form-control search" placeholder="Search">
                         </li>';
                }
            ?>
            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:;">
                    <img alt="" src="<?php echo base_url().'img/avatar-mini'.rand(2,4).'.jpg'; ?>">
                    <span class="username"><?php echo end(session_data())['ufullname']; ?></span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <div class="log-arrow-up"></div>
                    <li><a href="javascript:;"><i class="fa fa-suitcase"></i>Profile</a></li>
                    <li><a href="javascript:;"><i class="fa fa-cog"></i> Settings</a></li>
                    <li><a href="javascript:;"><i class="fa fa-bell-o"></i> Notification</a></li>
                    <li><a href="<?php echo base_url() ?>Logout"><i class="fa fa-key"></i> Log Out</a></li>
                </ul>
            </li>
            <!-- user login dropdown end -->
        </ul>
        <?php if( $is_help ) { ?>
            <a href="javascript:;" id="helpBtn" class="tooltips" data-html="true" data-placement="bottom" data-original-title="<b class='r'>Email:</b> jaeson@phoenix.com.ph<br><b class='r'>Local number:</b> 173">Help?</a>
        <?php } ?>
    </div>
</header>