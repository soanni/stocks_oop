<?php
function html($text){
	return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function htmlout($text){
	echo html($text);
}

function indicesToString($str,$i){
	$str = $str.','.$i;
	return $str;
}