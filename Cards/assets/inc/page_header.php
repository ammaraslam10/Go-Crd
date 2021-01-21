<?php
/**
 * page_header.php
 *
 * Author: pixelcave
 *
 * The header of each page
 *
 */
?>
<!-- Header -->
<!-- In the PHP version you can set the following options from inc/config file -->
<!--
    Available header.navbar classes:

    'navbar-default'            for the default light header
    'navbar-inverse'            for an alternative dark header

    'navbar-fixed-top'          for a top fixed header (fixed main sidebar with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar())
        'header-fixed-top'      has to be added on #page-container only if the class 'navbar-fixed-top' was added

    'navbar-fixed-bottom'       for a bottom fixed header (fixed main sidebar with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar()))
        'header-fixed-bottom'   has to be added on #page-container only if the class 'navbar-fixed-bottom' was added
-->
<header class="navbar<?php if ($template['header_navbar']) { echo ' ' . $template['header_navbar']; } ?><?php if ($template['header']) { echo ' '. $template['header']; } ?>">
    <!-- Left Header Navigation -->
    <ul class="nav navbar-nav-custom">
        <!-- Main Sidebar Toggle Button -->
        <li>
            <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
                <i class="fa fa-ellipsis-v fa-fw animation-fadeInRight" id="sidebar-toggle-mini"></i>
                <i class="fa fa-bars fa-fw animation-fadeInRight" id="sidebar-toggle-full"></i>
            </a>
        </li>
        <!-- END Main Sidebar Toggle Button -->

        <?php if ($template['header_link']) { ?>
        <!-- Header Link -->
        <li class="hidden-xs animation-fadeInQuick">
            <a href=""><strong><?php echo $template['header_link']; ?></strong></a>
        </li>
        <!-- END Header Link -->
        <?php } ?>
    </ul>
    <!-- END Left Header Navigation -->

    <!-- Right Header Navigation -->
    <ul class="nav navbar-nav-custom pull-right">
        <!-- Search Form -->
        <li>
            <form action="page_ready_search_results.php" method="post" class="navbar-form-custom">
                <input type="text" id="top-search" name="top-search" class="form-control" placeholder="Search..">
            </form>
        </li>
        <!-- END Search Form -->

        <!-- Alternative Sidebar Toggle Button -->
        <!--<li>
            <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar-alt');this.blur();">
                <i class="gi gi-settings"></i>
            </a>
        </li>-->
        <!-- END Alternative Sidebar Toggle Button -->

        <!-- User Dropdown -->
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo $img_url;?>" alt="avatar">
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li class="dropdown-header">
                    <strong>ADMINISTRATOR</strong>
                </li>
                <li>
                    <a href="edit_profile">
                        <i class="fa fa-pencil-square fa-fw pull-right"></i>
                         Edit Profile
                    </a>
                </li>
                <li class="divider"><li>
                <li>
                    <a href="logout">
                        <i class="fa fa-power-off fa-fw pull-right"></i>
                        Log out
                    </a>
                </li>
            </ul>
        </li>
        <!-- END User Dropdown -->
    </ul>
    <!-- END Right Header Navigation -->
</header>
<!-- END Header -->
