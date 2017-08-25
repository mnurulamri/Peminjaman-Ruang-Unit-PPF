<table >
	<tr>
		<td class="blok-ruang">
			<?php
				echo '<div class="list-group"><li class="list-group-item bg-light-blue color-palette">Gedung E</li>';
				foreach ($ruang as $k => $v) {
					if (substr($v->nm_ruang, 0, 1)=='E') echo'<a href="'.base_url().'peminjaman/schedulerRuangRapat/ruang/'.$v->kd_ruang.'" id="'.$v->kd_ruang.'" class="cek-ruang list-group-item" target="_blank" >'.nama_ruang($v->nm_ruang).'</a>';
				}
				echo '</div>';
			?>
		</td>
		<td class="blok-ruang">
			<?php
				echo '<div class="list-group"><li class="list-group-item bg-aqua color-palette">Gedung F</li>';
				foreach ($ruang as $k => $v) {
					if (substr($v->nm_ruang, 0, 1)=='F') echo'<a href="'.base_url().' peminjaman/schedulerRuangRapat/ruang/'.$v->kd_ruang.'" id="'.$v->kd_ruang.'" class="cek_ruang list-group-item" target="_blank">'.nama_ruang($v->nm_ruang).'</a>';
				}
				echo '</div>';
			?>
	<!--</td>
		<td class="blok-ruang">-->
			<?php
				echo '<div class="list-group"><li class="list-group-item bg-green color-palette">Gedung G</li>';
				foreach ($ruang as $k => $v) {
					if (substr($v->nm_ruang, 0, 1)=='G') echo'<a href="'.base_url().'peminjaman/schedulerRuangRapat/ruang/'.$v->kd_ruang.'" id="'.$v->kd_ruang.'" class="cek_ruang list-group-item" target="_blank">'.nama_ruang($v->nm_ruang).'</a>';
				}
				echo '</div>';
			?>
		</td>
		<td class="blok-ruang">
			<?php
				echo '<div class="list-group"><li class="list-group-item bg-purple color-palette">Gedung M</li>';
				foreach ($ruang as $k => $v) {
					if (substr($v->nm_ruang, 0, 1)=='H') echo'<a href="'.base_url().'peminjaman/schedulerRuangRapat/ruang/'.$v->kd_ruang.'" id="'.$v->kd_ruang.'" class="cek_ruang list-group-item" targer="_blank">'.nama_ruang($v->nm_ruang).'</a>';
				}
				echo '</div>';
			?>
		</td>
		<td class="blok-ruang">
			<?php
				echo '<div class="list-group"><li class="list-group-item bg-yellow color-palette">Gedung H</li>';
				foreach ($ruang as $k => $v) {
					if (substr($v->nm_ruang, 0, 1)=='M') echo'<a href="'.base_url().'peminjaman/schedulerRuangRapat/ruang/'.$v->kd_ruang.'" id="'.$v->kd_ruang.'" class="cek_ruang list-group-item" targer="_blank">'.$v->nm_ruang.'</a>';
				}
				echo '</div>';
			?>
		</td>		
		<td class="blok-ruang">
			<?php
				echo '<div class="list-group"><li class="list-group-item bg-red color-palette">Non Kelas</li>';
				foreach ($ruang as $k => $v) {
					if ($v->kd_ruang >= 201 && $v->pengelola=='PPF') echo'<a href="'.base_url().'peminjaman/schedulerRuangRapat/ruang/'.$v->kd_ruang.'" id="'.$v->kd_ruang.'" class="cek_ruang list-group-item" target="_blank">'.$v->nm_ruang.'</a>';
				}
				echo '</div>';
			?>
		</td>
	</tr>
	<style>
		table{margin:auto;}
		.blok-ruang{vertical-align:top;padding:0px;}
		/*.item-ruang{border:1px solid gray;padding:0px;width:30px;}
		a.list-group-item{font-weight:bold;color:#777;background:#39CCCC;}*/
	</style>

<?php
function nama_ruang($var){
	switch (substr($var,0,3)) {
		case 'E.E':
			$nama_ruang = str_replace('E.E', 'E.', $var);
			break;
		case 'F.F':
			$nama_ruang = str_replace('F.F', 'F.', $var);
			break;
		case 'G.G':
			$nama_ruang = str_replace('G.G', 'G.', $var);
			break;
		case 'H.H':
			$nama_ruang = str_replace('H.H', 'H.', $var);
			break;
		case 'M':
		$nama_ruang= str_replace('M','M.', $var);
		break;
		default:
			$nama_ruang = '';
			break;
	}
	return $nama_ruang;
}

/*
foreach ($ruang as $k => $v) {
	echo $v->kd_ruang.' '.$v->nm_ruang.'<br>';
	echo'
	<tr>
		<td>';if (substr($v->nm_ruang, 0, 1)=='E') echo'<table><tr><td id="'.$v->kd_ruang.'">'.$v->nm_ruang.'</td></tr></table></td>';echo'
		<td>';if (substr($v->nm_ruang, 0, 1)=='F') echo'<table><tr><td id="'.$v->kd_ruang.'">'.$v->nm_ruang.'</td></tr></table></td>';echo'
		<td>';if (substr($v->nm_ruang, 0, 1)=='G') echo'<table><tr><td id="'.$v->kd_ruang.'">'.$v->nm_ruang.'</td></tr></table></td>';echo'
		<td>';if (substr($v->nm_ruang, 0, 1)=='H') echo'<table><tr><td id="'.$v->kd_ruang.'">'.$v->nm_ruang.'</td></tr></table></td>';echo'		
	</tr>';
}
*/
?>
</table>