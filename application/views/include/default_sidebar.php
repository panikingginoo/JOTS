<?php if( $sidebar_active ) { ?>
<aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
            <?php
                foreach ($pages as $page => $attr)
                {
                    $liClass = count($attr['class']) > 0 ? 'class="'.strtolower(implode($attr['class'],' ')).'"' : '';
                    $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                    $href = base_url().$attr['href'];
                    if( $attr['has_sub_menu'] === FALSE )
                    {
                        $active = strtolower($href) === strtolower($url) ? 'class="active"' : '';

                        echo '<li '.$liClass.'>
                                <a '.$active.' href="'.$href.'">
                                    <i class="'.$attr['icon'].'"></i>
                                    <span>'.ucwords(strtolower($page)).'</span>
                                </a>
                            </li>';
                    }
                    else
                    {
                        $subLink = array();
                        $subList = '';
                        $icon = $attr['icon'];
                        foreach ($attr['sub_menu'] as $sub_menu => $attr)
                        {
                            $href = base_url().$attr['href'];
                            array_push($subLink, strtolower($href));
                            $subActive = strtolower($href) === strtolower($url) ? ' active' : '';
                            $subLiClass = count($attr['class']) > 0 ? 'class="'.strtolower(implode($attr['class'],' ')).$subActive.'"' : '';
                            $subList .= '<li '.$subLiClass.'><a href="'.$href.'">'.ucwords(strtolower($sub_menu)).'</a></li>';
                        }
                        
                        $liClass = count($attr['class']) > 0 ? strtolower(implode($attr['class'],' ')) : '';
                        $parentActive = in_array(strtolower($url), $subLink) ? 'class="active"' : '';

                        echo '<li class="sub-menu '.$liClass.'">
                                <a href="javascript:;" '.$parentActive.'>
                                    <i class="'.$icon.'"></i>
                                    <span>'.ucwords(strtolower($page)).'</span>
                                </a>
                                <ul class="sub">
                                '.$subList.'
                                </ul>
                            </li>'; 
                    }
                }
            ?>
        </ul>
    </div>
</aside>
<?php } ?>