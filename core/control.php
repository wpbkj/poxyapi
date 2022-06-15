<?php
/** POXYAPI核心控制文件，请勿随意修改 */
require_once('core/core.php');

if(!defined('__POXYAPI_ROOT_DIR__')||
  !defined('__POXYAPI_FILE_DIR__')||
  !defined('__POXYAPI_PAGE_DIR__')||
  !defined('__POXYAPI_PUBLIC_DIR__')||
  !defined('__POXYAPI_PAGE_CHARACTER__')
  ){
	POXYAPI_error('没有定义POXYAPI常量','');
	exit;
}

if(__POXYAPI_PAGE_CHARACTER__ == 'index'){
	$urlEnd=$_SERVER['REQUEST_URI'];
	$arr=explode('/',$urlEnd);
	$urlCon=POXYAPI_getSysSet('urlCon',$conn)[1];
	if($urlCon=='1'){
		$module=trim($arr[2]);
		$page=trim($arr[3]);
	}elseif($urlCon=='2'){
		$module=trim($arr[1]);
		$page=trim($arr[2]);
	}
	
	$page=explode('.',$page);
	$packageDir=__POXYAPI_ROOT_DIR__.__POXYAPI_PACKAGE_DIR__.'/'.$page[0].'.php';
}else{
	if(empty($_GET['core'])){
		$core='index';
	}else{
		$core=trim($_GET['core']);
	}
	
	if(empty($_GET['page'])){
		$page='index';
	}else{
		$page=trim($_GET['page']);
	}
	
	if(isset($_GET['sp'])){
		$sp='1';
	}else{
		$sp='';
	}
	
	if(!empty($_GET['usecore'])){
		$usecore=trim($_GET['usecore']);
	}else{
		$usecore='';
	}
	
	if(($core != $page&&empty($sp))||empty($core)||empty($page)){
		POXYAPI_error('链接出错，请检查您的链接是否正确','页面控制错误');
	}

	$coreDir = __POXYAPI_ROOT_DIR__.__POXYAPI_FILE_DIR__.__POXYAPI_PAGE_DIR__.'/core/'.$core.'core.php';
	$pageDir = __POXYAPI_ROOT_DIR__.__POXYAPI_FILE_DIR__.__POXYAPI_PAGE_DIR__.'/'.$core.'.php';

	if(!empty($usecore)){
		$coreDir = __POXYAPI_ROOT_DIR__.__POXYAPI_FILE_DIR__.'/'.$usecore.'/core/'.$core.'core.php';
	}
}

try{
	if(isset($packageDir)){
		router($packageDir);
	}else{
		router($coreDir);
		router($pageDir);
	}
	
} catch(FileException $e){
	die(POXYAPI_error($e->getMessage(),'页面文件丢失'));
} catch(\Exception $e){
	die(POXYAPI_error($e->getMessage(),'其他未知错误'));
}