<?php



global $user_ID;



$roles = get_userdata($user_ID)->roles;


echo '<pre>';
//print_r($roles);

if (in_array('editor',$roles,true)) {
	echo 'Едитор';
} else {
	echo 'Не едитор';
}

echo '</pre>';
