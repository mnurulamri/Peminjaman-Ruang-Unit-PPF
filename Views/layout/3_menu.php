<?php
if (isset($this->session->userdata['logged_in'])) {
	$username = ($this->session->userdata['logged_in']['username']);
} else {
	header("location: http://ppf.fisip.ui.ac.id/backend/autentikasi/ldapLogin/loginForm");
}
?>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
      <!-- Sidebar user panel -->
		<div class="user-panel">
			<div class="pull-left image">
                <?php
                //$photo = 'data:image/png;base64,'.$foto;
                //echo '<img src = '.$photo.' class="direct-chat-img" alt="User Image"/>';
                ?>
			</div>
			<div class="pull-left info">
				<p><?//=$username?></p>
				<!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
			</div>
		</div>
      	<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu" data-widget="tree">
			<li class="header" style="font-size:13px; color:#aaa"> ADMINISTRASI PEMINJAMAN RUANG </li>
			<li><a class="page" href="<?=base_url()?>penggunaan/ruang/data-user"><i class="fa fa-user text-white"></i> Data Pengguna </a></li>

			<li class="treeview">
				<a href="#">
					<i class="fa fa-share text-aqua"></i> <span>Cek Ruang Kosong</span>
					<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="treeview">
						<a href="<?=base_url()?>penggunaan/ruangRapat/daftarRuang"><i class="fa fa-calendar text-aqua"></i> Per Ruangan </a>

                        <ul class="treeview-menu">
                            
                               
                            <div class="dropdown list-group">
                                <a class="nama-gedung list-group-item list-group-item-danger active">Non Kelas</a>
                                <div class="dropdown-content list-group-item list-group-item-danger">                                    
                                    <?php
                                    foreach ($ruang as $k => $v) {
                                        if ($v->kd_ruang >= 201 && $v->pengelola=='PPF') {
                                            echo '<p><a class="list-group-item" href="'.base_url().'penggunaan/ruang/cek-ruang-non-kelas/'.$v->kd_ruang.'">'. $v->nm_ruang .'</a></p>';
                                        }
                                    }
                                    ?>                                    
                                </div>
                            </div>                                    

                            <div class="dropdown list-group">
                                <a class="nama-gedung list-group-item list-group-item-success active">Gedung H</a>
                                <div class="dropdown-content list-group-item list-group-item-success">
                                    
                                    <?php
                                    foreach ($ruang as $k => $v) {
                                        if (substr($v->nm_ruang, 0, 1)=='H' && (substr(str_replace('H.H', 'H.', $v->nm_ruang), 0, 3)=='H.1' OR substr(str_replace('H.H', 'H.', $v->nm_ruang), 0, 3)=='H.2' OR substr(str_replace('H.H', 'H.', $v->nm_ruang), 0, 3)=='H.3')) {
                                            echo '<p><a class="list-group-item" href="'.base_url().'penggunaan/ruang/cek-ruang-kelas/'.$v->kd_ruang.'">'. str_replace('H.H', 'H.', $v->nm_ruang) .'</a></p>';
                                        }
                                    }
                                    ?>                                    
                                </div>
                            </div>                               
                        
                        
                            <div class="dropdown list-group">
                                <a class="nama-gedung list-group-item list-group-item-success active">Gedung H</a>
                               <div class="dropdown-content list-group-item list-group-item-success">
                                    
                                        <?php
                                        foreach ($ruang as $k => $v) {
                                            if (substr($v->nm_ruang, 0, 1)=='H' && (substr(str_replace('H.H', 'H.', $v->nm_ruang), 0, 3)=='H.4' OR substr(str_replace('H.H', 'H.', $v->nm_ruang), 0, 3)=='H.5')) {
                                                echo '<p><a class="list-group-item" href="'.base_url().'penggunaan/ruang/cek-ruang-kelas/'.$v->kd_ruang.'">'. str_replace('H.H', 'H.', $v->nm_ruang) .'</a></p>';
                                            }
                                        }
                                        ?>
                                    
                                </div>
                            </div>                                    
                        
                        
                            <div class="dropdown list-group">
                                <a class="nama-gedung list-group-item list-group-item-warning active">Gedung E</a>
                                <div class="dropdown-content list-group-item list-group-item-warning">
                                    
                                        <?php
                                        foreach ($ruang as $k => $v) {
                                            if (substr($v->nm_ruang, 0, 1)=='E') {
                                                echo '<p><a class="list-group-item" href="'.base_url().'penggunaan/ruang/cek-ruang-kelas/'.$v->kd_ruang.'">'. str_replace('E.E', 'E.', $v->nm_ruang) .'</a></p>';
                                            }
                                        }
                                        ?>
                                    
                                </div>
                            </div>                                 
                        
                       
                            <div class="dropdown list-group">
                                <a class="nama-gedung list-group-item list-group-item-info active">Gedung F</a>
                                <div class="dropdown-content list-group-item list-group-item-info">
                                        <?php
                                        foreach ($ruang as $k => $v) {
                                            if (substr($v->nm_ruang, 0, 1)=='F') {
                                                echo '<p><a class="list-group-item" href="'.base_url().'penggunaan/ruang/cek-ruang-kelas/'.$v->kd_ruang.'">'. str_replace('F.F', 'F.', $v->nm_ruang) .'</a></p>';
                                            }
                                        }
                                        ?>
                                </div>
                            </div>                                   
                        </ul>     
                    </li>
                

					
					<li class="treeview">
						<a href="#"><i class="fa fa-calendar text-aqua"></i> Per Tanggal
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="<?=base_url()?>penggunaan/ruang/cek-semua-ruang-kelas"><i class="fa fa-calendar-o text-aqua"></i> Ruang Kelas</a></li>
							<li><a href="<?=base_url()?>penggunaan/ruang/cek-semua-ruang-non-kelas"><i class="fa fa-calendar-o text-aqua"></i> Ruang Non Kelas</a></li>
						</ul>
					</li>
				</ul>
			</li>			
			
			<li><a class="page" href="<?=base_url()?>penggunaan/ruang/daftar-pengajuan"><i class="fa fa-list text-yellow"></i> Daftar Pengajuan </a></li>
			<li><a class="page" href="<?=base_url()?>penggunaan/ruang/status"><i class="fa fa-flag-o text-green"></i> Status Peminjaman </a></li>
			
			<!--
			<li class="header"> MAIN NAVIGATION </li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-share"></i> <span>Administrasi Ruang</span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><a class="page" href="<?=base_url()?>penggunaan/ruangRapat/daftar"><i class="fa fa-circle-o text-red"></i> Daftar Ruang </a></li>
					<li><a class="page" href="<?=base_url()?>penggunaan/ruangRapat/pengajuanList"><i class="fa fa-circle-o text-yellow"></i> Daftar Pengajuan </a></li>
					<li><a class="page" href="<?=base_url()?>penggunaan/ruangRapat/status"><i class="fa fa-circle-o text-aqua"></i> Status Peminjaman </a></li>
				</ul>
			</li>
			-->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

<style>
.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    margin-top: 1px;  /* -2px  65px */
    margin-left: 55;  /* -15px 65px */
    min-width: 127px;  /* 100px */
    padding: 2px 2px 2px 2px;  /* 2px 2px 2px 16px;  */
    z-index: 1; 
    line-height: 5px;
    /*color: #555;  
    background: #f9f9f9;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);color: #555;*/
}

.dropdown:hover .dropdown-content {
    display: block;
}

.nama-gedung {
    padding:0px 0px 0px 0px;
    cursor:pointer;
    min-width: 90px;
    text-align:center;
}

a.list-group-item {

}
/**/
p > a.list-group-item{
    padding: 10px !important;  
    min-width: 83px !important;
    color:#444 !important;
    text-align: center;
}
p:hover {
    background: lightgray;
}

</style>