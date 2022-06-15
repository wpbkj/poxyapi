<?php
if(!defined('__POXYAPI_ROOT_DIR__')||
  !defined('__POXYAPI_FILE_DIR__')||
  !defined('__POXYAPI_PAGE_DIR__')||
  !defined('__POXYAPI_PUBLIC_DIR__')
  ){
	exit;
}
echo 'INDEX';
POXYAPI_Need_Page('public/header.html','');
POXYAPI_Other_Page('admin','index.php','');
echo POXYAPI_Public_URL('css/bootstrap-grid.css');