<?php
function is_price($element) {
    return preg_match("#^-?\d+\.?\d*$#",$element);
}

function is_phone_number($element) {
	return preg_match("#^\d{9}|\d{3}-\d{3}-\d{3}$#",$element);
}

function is_name($element) {
	return preg_match("#^[^0-9\\|!&;@#£$§%&/()=?{[\]}'\«»*+]+$#",$element);
}

function is_username($element){
	return preg_match("#^[a-zA-Z][\w]{3,8}[a-zA-Z]$#",$element);
}

function is_postCode($element){
	return preg_match("#^[0-9]{4}-[0-9]{3}|[0-9]{4}$#",$element);
}

function is_password($element){
	return preg_match("#^[a-zA-Z0-9]{6,}$#",$element);
}

function is_text($element){
	return preg_match("#^[a-zA-Z0-9\s\n\\\.\?\!\+\(\)\;\:\,\-]+$#",$element);
}

function is_email($element){
	return preg_match("#^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$#",$element);
}

?>

