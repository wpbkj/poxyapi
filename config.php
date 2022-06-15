<?php  
$conn =mysqli_connect("localhost","poxyapi","qwertyuiop","poxyapi_wpbkj"); 
@ mysqli_set_charset ($conn,'utf8');
@ mysqli_query($conn,'utf8');
if (mysqli_connect_errno($conn)) 
{ 
    echo "连接 MySQL 失败: " . mysqli_connect_error(); 
	die();
}

?>