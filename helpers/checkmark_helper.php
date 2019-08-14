<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('rubah_checkbox'))
{
	function rubah_checkbox($string){
		$old = '<span style="font-family: wingdings; font-size: 150%; font-weight: bold;">&#9745;</span>';
		$new = '<span style="font-family: wingdings; font-size: 150%; ">
							<i class="fa fa-check-square-o" aria-hidden="true"></i>
						</span>';
		$str = str_replace($old, $new, $string);
		
		$old = '<span style="font-family: wingdings; font-size: 150%; font-weight: bold;">&#9744;</span>';
		$new = '<span style="font-family: wingdings; font-size: 150%; ">
							<i class="fa fa-square-o" aria-hidden="true"></i>
						</span>';
		$check = str_replace($old, $new, $str);
		$old = '<label>';
		$new = '';
		$check = str_replace($old, $new, $check);
		$old = '</label>';
		$new = '';
		$check = str_replace($old, $new, $check);
		return $check;
	}
}