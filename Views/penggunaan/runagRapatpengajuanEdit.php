<?
if (isset($this->session->userdata['logged_in'])) {
    $username = ($this->session->userdata['logged_in']['username']);
    $hak_akses = ($this->session->userdata['logged_in']['hak_akses']);
} else {
    $hak_akses = 0;
}
?>
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?=base_url();?>assets/AdminLTE/plugins/datepicker/datepicker3.css">

<section class="content" >
    <div class="box box-warning">
        <div class="box-body">
            <?php
            foreach ($data as $k_nomor => $v_nomor) {
                foreach ($v_nomor as $k_event_name => $v_event_name) {
                    foreach ($v_event_name as $k_details => $v_details) {
                        foreach ($v_details as $k_no_surat => $v_no_surat) {
                            foreach ($v_no_surat as $k_id_peminjam => $v_id_peminjam) {
                                foreach ($v_id_peminjam as $k_nama_peminjam => $v_nama_peminjam) {
                                   foreach ($v_nama_peminjam as $k_prodi => $v_prodi) {
                                      foreach ($v_prodi as $k_no_telp => $v_no_telp) {
                                          foreach ($v_no_telp as $k_email => $v_email) {
                                              foreach ($v_email as $k_catatan => $v_catatan) {
                                                 foreach ($v_catatan as $k_jml_peserta => $v_jml_peserta) {
                                                     foreach ($v_jml_peserta as $k_tgl_proses => $v_tgl_proses) {
                                                        foreach ($v_tgl_proses as $k_id_kegiatan => $v_id_kegiatan) {
                                                            foreach ($v_id_kegiatan as $k_tgl_permohonan => $v_tgl_permohonan) {
                                                                $id_kegiatan    = $k_id_kegiatan;
                                                                $nomor          = $k_nomor;
                                                                $no_surat       = $k_no_surat;
                                                                $nama_kegiatan  = $k_event_name;
                                                                $kebutuhan      = $k_details;
                                                                $no_surat       = $k_no_surat;
                                                                $id_peminjam    = $k_id_peminjam;
                                                                $nama_peminjam  = $k_nama_peminjam;
                                                                $unit_kerja     = $k_prodi;
                                                                $no_telp        = $k_no_telp;
                                                                $email          = $k_email;
                                                                $jml_peserta    = $k_jml_peserta;
                                                                $tgl_proses     = date('m/d/Y', strtotime($k_tgl_proses));
                                                                $tgl_permohonan = date('m/d/Y', strtotime($k_tgl_permohonan));
                                                                $catatan        = $k_catatan;
                                                                ?>
			
                                                                <?if($hak_akses==1){?>  <!-- jika masuk sebagai admin maka tampilkan blok isian untuk infrastruktur -->
                                                                <div class="box-header with-border" style="text-align:center">
                                                                    <b class="box-title">Bagian Untuk Diisi Petugas Infrastruktur</b>
                                                                </div>                                                                 
                                                                <input type="hidden" id="id_kegiatan" name="id_kegiatan" value="<?=$id_kegiatan?>" />
                                                                <input type="hidden" id="nomor" name="nomor" value="<?=$nomor?>" />
                                                                <div class="col-md-12">
                                                             
                                                                    <div class="form-group">
                                                                        <label for="no_surat" class="col-sm-3 control-label" style="text-align:right">Nomor</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" id="no_surat" name="no_surat" placeholder="Nomor" class="form-control" required="" value="<?=$no_surat?>">
                                                                        </div>  
                                                                        <div class="col-sm-6">
                                                                            <?
                                                                            $m = date('n');
                                                                            $y = date('Y');
                                                                            echo 'G.05/1/UN2.F9.D4.2/RTK.00/'.$m.'/'.$y;
                                                                            ?>                        
                                                                        </div>                         
                                                                    </div><br>
                                                                    <div class="form-group">
                                                                        <label for="tgl_proses" class="col-sm-3 control-label" style="text-align:right">Tanggal</label>
                                                                        <div class="col-sm-9">
                                                                            <div class="input-group date">
                                                                                <div class="input-group-addon">
                                                                                    <i class="fa fa-calendar"></i>
                                                                                </div>
                                                                                <input id="tgl_proses" name="tgl_proses" class="form-control" size="5" value="<?=$tgl_proses?>"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!--
                                                                    <div class="form-group">
                                                                        <label for="nomor" class="col-sm-3 control-label" style="text-align:right">Lokasi/Area/Ruangan :</label>
                                                                        <div class="col-sm-9">
                                                                            <?php echo $html?>
                                                                        </div>
                                                                    </div>
                                                                    -->
                                                                </div><!-- /.Bagian Untuk Diisi Petugas Infrastruktur -->
                                                                <hr>
                                                                <?} else {?>
                                                                    <input type="hidden" id="id_kegiatan" name="id_kegiatan" value="<?=$id_kegiatan?>" />
                                                                    <input type="hidden" id="nomor" name="nomor" placeholder="Nomor" class="form-control" required="" value="<?=$nomor?>">
                                                                    <input type="hidden" name="no_surat" id="no_surat" value="<?=$no_surat?>" />
                                                                    <input type="hidden" id="tgl_proses" name="tgl_proses" class="form-control" size="5" value="<?=$tgl_proses?>"/>
                                                                <?}?>
                                                                <!-- Bagian Untuk Diisi Pemohon -->
                                                                <div class="box-header with-border" style="text-align:center">
                                                                    <b class="box-title">Bagian Untuk Diisi Pemohon</b>
                                                                </div>
                                                               <div class="well well-sm">
                                                                    Data Pemohon
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                         <div class="form-group">
                                                                            <label for="tgl_permohonan" class="col-sm-3 control-label" style="text-align:right">Tanggal : </label>
                                                                            <div class="col-sm-9">
                                                                                <div class="input-group date">
                                                                                    <div class="input-group-addon">
                                                                                        <i class="fa fa-calendar"></i>
                                                                                    </div>
                                                                                    <input id="tgl_permohonan" name="tgl_permohonan" class="form-control" value="<?=$tgl_permohonan?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>               
                                                                        <div class="form-group">
                                                                            <label for="unit" class="col-sm-3 control-label" style="text-align:right">PAF/Dept/Prog/HM : </label>
                                                                            <div class="col-sm-9">
                                                                                <input id="unit_kerja" name="unit_kerja" placeholder="PAF/Dept/Prog/HM : " class="form-control input-md" required="" type="text" value="<?=$unit_kerja?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="nama_peminjam" class="col-sm-3 control-label" style="text-align:right">Penanggung Jawab : </label>
                                                                            <div class="col-sm-9">
                                                                                <input id="nama_peminjam" name="nama_peminjam" placeholder="nama peminjam" class="form-control input-md" required="" type="text" value="<?=$nama_peminjam?>">
                                                                            </div>
                                               
