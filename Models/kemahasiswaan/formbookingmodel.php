<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!session_id()) session_start();

class FormBookingModel extends CI_Model 
{
    function __construct()
    {
        parent::__construct();	
    }

    function getDataKegiatan($nomor)
    {
        $sql = "SELECT * FROM kegiatan WHERE nomor = '$nomor'";
        $query = $this->db->query($sql);
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    function getDataKegiatanEntitas($nomor)
    {
        $sql = "SELECT * FROM kegiatan_entitas WHERE nomor = '$nomor'";
        $query = $this->db->query($sql);
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    function getDataKegiatanJenis($nomor)
    {
        $sql = "SELECT * FROM kegiatan_jenis WHERE nomor = '$nomor'";
        $query = $this->db->query($sql);
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    function getDataKegiatanKategori($nomor)
    {
        $sql = "SELECT * FROM kegiatan_kategori WHERE nomor = '$nomor'";
        $query = $this->db->query($sql);
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    function getDataKegiatanPeserta($nomor)
    {
        $sql = "SELECT * FROM kegiatan_peserta WHERE nomor = '$nomor'";
        $query = $this->db->query($sql);
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    function getDataJadwal($nomor)
    {
        $sql = "SELECT event_id, start_date, end_date, DAY(start_date) as tgl, MONTH(start_date) as bulan, YEAR(start_date) as tahun, nm_ruang 
            FROM waktu b, ruang_rapat c 
            WHERE b.ruang = kd_ruang AND nomor = '$nomor'
            ORDER BY YEAR(start_date) DESC, MONTH(start_date) DESC";
        $query = $this->db->query($sql);
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    function updateKegiatan($nomor, $data){
        $this->db->where('nomor', $nomor);
        $this->db->update('kegiatan', $data); 
        echo 'data sudah disimpan!';
    }

    function updateKegiatanMhs($nomor, $data_kegiatan, $data_entitas, $data_kategori, $data_jenis, $data_peserta){
        //update data kegiatan
        $this->db->where('nomor', $nomor);
        $this->db->update('kegiatan', $data_kegiatan); 

        //update data entitas kegiatan
        $sql = "DELETE FROM kegiatan_entitas WHERE nomor = '$nomor'";
        $query = $this->db->query($sql);
        foreach ($data_entitas as $key => $value) {
            $data = array(
                'nomor' => $nomor,
                'entitas' => $value
            );
            $this->db->insert('kegiatan_entitas', $data);
        }

        //update data kategori kegiatan
        $sql = "DELETE FROM kegiatan_kategori WHERE nomor = '$nomor'";
        $query = $this->db->query($sql);
        foreach ($data_kategori as $key => $value) {
            $data = array(
                'nomor' => $nomor,
                'kategori' => $value
            );
           $this->db->insert('kegiatan_kategori', $data);
        }

        //update data jenis kegiatan
        $sql = "DELETE FROM kegiatan_jenis WHERE nomor = '$nomor'";
        $query = $this->db->query($sql);
        foreach ($data_jenis as $key => $value) {
            $data = array(
                'nomor' => $nomor,
                'jenis' => $value
            );
            $this->db->insert('kegiatan_jenis', $data);
        }

        //update data peserta
        $sql = "DELETE FROM kegiatan_peserta WHERE nomor = '$nomor'";
        $query = $this->db->query($sql);
        foreach ($data_peserta as $key => $value) {
            $data = array(
                'nomor' => $nomor,
                'peserta' => $value
            );
            $this->db->insert('kegiatan_peserta', $data);
        }
    }

    function clear_dokumen($nomor)
    {
        //kosongkan data dokumen -> dipisah dengan edit dokumen karena fungsi edit dokumen dipanggil berulang oleh fungsi upload sehingga hanya diperlukan 1 kali kosongkan data
        $clear_value =  array(
            'file_tor' => '',
            'file_rundown' => '',
            'file_undangan' => '',
            'file_lampiran' => ''
        );
        $this->db->where('nomor', $nomor);
        $this->db->update('kegiatan', $clear_value); 
    }

    function edit_dokumen($nomor, $data)
    {
        //isi data dokumen
        $this->db->where('nomor', $nomor);
        $this->db->update('kegiatan', $data);
    }

    function hapus_dokumen($nomor, $field, $nama_file)
    {
        $sql = "UPDATE kegiatan SET $field = '' WHERE nomor = '$nomor'";
        $query = $this->db->query($sql);
        $path = $_SERVER['DOCUMENT_ROOT'].'/app/dokumen/kemahasiswaan/';
        unlink($path.$nama_file);
    }

    public function editJadwal($nomor)
    {  //edit dari form pengajuan

        //fetch input data form
        $event_id       = $this->input->post('event_id');
        //$nomor            = $this->input->post('nomor');
        $ruang          = $this->input->post('ruang');
        $_tgl_kegiatan  = $this->input->post('tgl_kegiatan');
        $jam_awal       = $this->input->post('jam_mulai');
        $menit_awal     = $this->input->post('menit_mulai');
        $jam_akhir      = $this->input->post('jam_selesai');
        $menit_akhir    = $this->input->post('menit_selesai');


        $array = array();

        $event_id = '';

        //ruang
        $ruang = explode(",", $ruang);    
        $i=0;       
        foreach ($ruang as $k => $v) {
            $array[$i]['ruang'] = $v;
            $i++;
        }

        //tanggal kegiatan
        $temp = str_replace(', ', '|', $_tgl_kegiatan);
        $_tgl_kegiatan = explode(",", $temp);
       
        $i=0;
        foreach ($_tgl_kegiatan as $k => $v) {
            $v = str_replace('|', ', ', $v);
            $tgl_kegiatan = tanggalToDb($v);
            $array[$i]['tgl_kegiatan'] = $tgl_kegiatan;
            $array[$i]['nomor'] = $nomor;
            //$array[$i]['event_id'] = $event_id;
            $i++;
        }

        //jam mulai
        $jam_awal = explode(",", $jam_awal);
        $i=0;       
        foreach ($jam_awal as $k => $v) {
            $array[$i]['jam_awal'] = $v;
            $i++;
        }

        //jam akhir
        $jam_akhir = explode(",", $jam_akhir);
        $i=0;       
        foreach ($jam_akhir as $k => $v) {
            $array[$i]['jam_akhir'] = $v;
            $i++;
        }
        
        //menit awal
        $menit_awal = explode(",", $menit_awal);
        $i=0;
        foreach ($menit_awal as $k => $v) {
            $array[$i]['menit_awal'] = $v;
            $i++;
        }
        
        //menit selesai
        $menit_akhir = explode(",", $menit_akhir);
        $i=0;       
        foreach ($menit_akhir as $k => $v) {
            $array[$i]['menit_akhir'] = $v;
            $i++;
        }

        //kelola input/edit data dengan mempertimbangkan jadwal yang bentrok
        //tampilkan pesan bila terjadi jadwal yang bentrok kemudian simpan data bila sudah tidak ada jadwal yang bentrok
        $array_hari = array('Sun'=>'Minggu', 'Mon'=>'Senin', 'Tue'=>'Selasa', 'Wed'=>'Rabu', 'Thu'=>'Kamis', 'Fri'=>'Jumat', 'Sat'=>'Sabtu');
        $array_bulan = array('1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni', '7'=>'Juli',
                            '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember', );
        $data_bentrok = array();
        
        $i=0;       
        foreach ($array as $k => $v) {
            //$event_id = $v['event_id'];
            $ruang = $v['ruang'];
            $start_date = $v['tgl_kegiatan'].' '.$v['jam_awal'].':'.$v['menit_awal'];
            $end_date = $v['tgl_kegiatan'].' '.$v['jam_akhir'].':'.$v['menit_akhir'];

            if ($ruang == 236 OR $ruang == 237) {
                # code...
            } else {
                $jadwal_bentrok = $this->ruangrapatmodel->jadwalBentrok($event_id, $start_date, $end_date, $ruang);
            }
            
            $j=0; //counter data bentrok
            if ($jadwal_bentrok) {
                
                foreach ($jadwal_bentrok as $key => $value) {
                    //tentukan jadwal yang bentrok
                    $event_name = $value->event_name;
                    $ruang      = $value->nm_ruang;
                    $d          = date('D', strtotime($value->start_date));
                    $waktu_awal = date('H:i', strtotime($value->start_date));
                    $waktu_akhir= date('H:i', strtotime($value->end_date));
                    $nama_hari  = $array_hari[$d];
                    $tgl        = $value->tgl;
                    $bulan      = $array_bulan[$value->bulan];
                    $tahun      = $value->tahun;
                    $tanggal    = $tgl.' '.$bulan.' '.$tahun;           
                    //tampilkan pesan bentrok ke dalam form
                    $data_bentrok[$j] = '<div class="well well-sm" style="color:red">Bentrok Dengan Kegiatan '.$event_name.', Hari '.$nama_hari.' Tanggal '.$tanggal.' Jam '.$waktu_awal.'-'.$waktu_akhir.' Ruang '.$ruang.'</div>';
                    echo '<div class="well well-sm">Bentrok Dengan Kegiatan '.$event_name.', Hari '.$nama_hari.' Tanggal '.$tanggal.' Jam '.$waktu_awal.'-'.$waktu_akhir.' Ruang '.$ruang.'</div>'; 
                }
                $j++;       
            } else {
                //bila tidak ada jadwal yang bentrok maka input atau edit nomor surat, ruang, tanggal dan waktunya
                $data = array(
                    'event_id'  =>$event_id,
                    'ruang'     =>$ruang,
                    'nomor'     =>$nomor,
                    'start_date'=>$start_date,
                    'end_date'  =>$end_date
                );
                //echo '<pre>';echo print_r($data);echo '</pre>';;
                $sql = "REPLACE INTO waktu (event_id,ruang,nomor,start_date,end_date) VALUES('$event_id', '$ruang', '$nomor', '$start_date', '$end_date')";
                mysql_query($sql) or die(mysql_error());
                echo '<div>event_id'.$nomor.' data sudah di simpan!...</div>';
                //echo '<pre>'; print_r($sql); echo '</pre>';
            }
        }
        
        //tutup modal bila sudah tidak ada jadwal yang bentrok
        if (count($data_bentrok) == 0) {
            //echo '<script>window.location.replace("daftar-pengajuan");</script>';
        }
    }
}