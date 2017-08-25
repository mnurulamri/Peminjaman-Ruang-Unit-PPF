<?php
if (isset($this->session->userdata['logged_in'])) {
	$username = ($this->session->userdata['logged_in']['username']);	
} else {
	header("location: http://ppf.fisip.ui.ac.id/backend/autentikasi/ldapLogin/loginForm");
}
?>

<header class="main-header">
    <!-- Logo -->
    <a href="<?=base_url()?>penggunaan/ruang" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>P</b>PF</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
        <!--<b style="color:rgb(255,217,97)">P&nbsp;P&nbsp;F&nbsp;</b>&nbsp;&nbsp;F&nbsp;I&nbsp;S&nbsp;I&nbsp;P&nbsp;&nbsp;<font style="color:yellow">U&nbsp;I</font>-->
            <b style="color:rgb(255,217,97)">P&nbsp;P&nbsp;F&nbsp;</b>&nbsp;FISIP&nbsp;<font style="color:yellow"></font>
            <img src="<?=base_url();?>assets/images/logo_UI-Horizontal_frameyelow.png" height="30%" width="30%" />

        </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->
            <li class="dropdown messages-menu">
            </li>
            <!-- Notifications: style can be found in dropdown.less -->
            <li class="dropdown notifications-menu">
            </li>
            <!-- Tasks: style can be found in dropdown.less -->
            <li class="dropdown tasks-menu">
            </li>
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <!-- <img src="<?=base_url();?>assets/AdminLTE/dist/img/avatar2.png" class="user-image" alt="User Image"> -->
                    <?php
                    $photo = 'data:image/png;base64,'.$foto;
                    echo '<img src = '.$photo.' class="user-image" alt="User Image"/>';
                    ?>
                    <span class="hidden-xs"><?=$nama?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                    <li class="user-header">
        				<?php
        				$photo = 'data:image/png;base64,'.$foto;
                        echo '<img src = '.$photo.' class="img-image" alt="User Image"/>';
        				?>
                        <p>
                            <?=$nama?>
                            <small>FISIP UI</small>
                        </p>
                    </li>
                    <!-- Menu Body -->
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <!--<a href="#" class="btn btn-default btn-flat">Profile</a>-->
                        </div>
                        <div class="pull-right">
                            <a href="<?=base_url()?>autentikasi/ldapLogin/logout" class="btn btn-default btn-flat">Sign out</a>
                        </div>
                    </li>
                </ul>
            </li>
          <!-- Control Sidebar Toggle Button -->
                <li>
                    <!--<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>-->
                </li>
            </ul>
        </div>
    </nav>
</header>
