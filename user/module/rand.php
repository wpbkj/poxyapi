<?php
header('Content-Type: application/json; charset=utf8');
$package_name='随机数字（1-100）';
$package_author='WPBKJ';
$package_desc='随机数字简单api';

function main(){
	$data=array();
	$sum=rand(1,100);
	$status='successfull';
	$data['status']=$status;
	$data['result']=$sum;
	$datajson=json_encode($data);
	print_r($datajson);
}

main();