<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('ekstensi_file'))
{
	function ekstensi_file($str){
		$str = substr($str, -6);
		$str = explode('.', $str);
		$str = $str[1];
		return $ext_tor = '.'.$str;
	}
}

if (! function_exists('dokumen'))
{
	function dokumen($style_tor,$ext_tor,$nama_file_tor,$view_tor,$style_rundown,$ext_rundown,$nama_file_rundown,$view_rundown,$style_undangan,$ext_undangan,$nama_file_undangan,$view_undangan,$style_lampiran,$ext_lampiran,$nama_file_lampiran,$view_lampiran){
	    echo '
	    <td '.$style_tor.' class="view-dok text-light-blue operator" data-ext="'.$ext_tor.'" data-file="'.$nama_file_tor.'" data-tt="tooltip" title="'.$nama_file_tor.'">'.$view_tor.'</td>
	    <td '.$style_rundown.' class="view-dok text-light-blue" data-ext="'.$ext_rundown.'" data-file="'.$nama_file_rundown.'" data-tt="tooltip" title="'.$nama_file_rundown.'">'.$view_rundown.'</td>
	    <td '.$style_undangan.' class="view-dok text-light-blue" data-ext="'.$ext_undangan.'" data-file="'.$nama_file_undangan.'" data-tt="tooltip" title="'.$nama_file_undangan.'">'.$view_undangan.'</td>
	    <td '.$style_lampiran.' class="view-dok text-light-blue" data-ext="'.$ext_lampiran.'" data-file="'.$nama_file_lampiran.'" data-tt="tooltip" title="'.$nama_file_lampiran.'">'.$view_lampiran.'</td>';
	}
}