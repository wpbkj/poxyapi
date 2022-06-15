<?php
session_start();
/** 定义当前版本号 */
define('__POXYAPI_VERSION__','1.0.1');

/** POXYAPI错误处理 */
function POXYAPI_error($eMsg,$eStyle){
	if(empty($eStyle)){
		$eStyle='系统错误';
	}
	
	$_SESSION['eMsg']=trim($eMsg);
	$_SESSION['eStyle']=trim($eStyle);
	require('core/error.php');
	exit;
}

/** 远程获取最新版本 */
function POXYAPI_getLastVersion(){
	$url='https://www.wpbkj.com/update.php?v='.__POXYAPI_VERSION__;
	$content =@ file_get_contents($url);
    $data = json_decode($content,true);
	return $data;
}

/** 获取页面URL */
function is_https() {
        if ( !empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
            return 'https://';
        } elseif ( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
            return 'https://';
        } elseif ( !empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
            return 'https://';
        }else{
            return 'http://';
        }
    }

function POXYAPI_getURL(){
	$hs=is_https();

	$url=$hs.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	
	return $url;
}

/** 获取用户IP地址 */
function POXYAPI_getIP(){
	if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } else if (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } else if (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $ip = getenv('REMOTE_ADDR');
    } else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $res =  preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
    return $res;
}

/** cookie相关方法 */
class POXYAPI_cookie
{
	public static function set($name,$value,$time){
		$name=trim($name);
		$value=trim($value);
		$time=trim($time);
		setcookie("{$name}","{$value}",time()+$time);
	}
	
	public static function get($name){
		$name=trim($name);
		return($_COOKIE["{$name}"]);
	}
	
	public static function isset($name){
		$name=trim($name);
		if(isset($_COOKIE["{$name}"])){
			return true;
		}else{
			return false;
		}
	}
}

/** 获取数据库内系统设置方法 */
function POXYAPI_getSysSet($name,$conn){
	if(empty($name)||empty($conn)){
		POXYAPI_error('数据库调用出错，请检查数据库配置文件和自定义文件',' ');
	}

	$sysSql=mysqli_query($conn,"select * from sysset where name='{$name}'");
    $resArr=mysqli_fetch_array($sysSql);
	$res = array();
    $res[1]=$resArr['value1'];
	$res[2]=$resArr['value2'];

	return $res;
}

define('__POXYAPI_PREURL__',POXYAPI_getSysSet('preurl',$conn)[1]);
define('__POXYAPI_HOST__',is_https().$_SERVER['HTTP_HOST']);
define('__POXYAPI_URL__',POXYAPI_getURL());

/** 页面控制拓展方法 */
/** 页面同目录下文件加载 */
function POXYAPI_Need_Page($name,$style){
	$name=trim($name);
	$style=trim($style);
	$Need_Page_Dir=@ __POXYAPI_ROOT_DIR__.__POXYAPI_FILE_DIR__.__POXYAPI_PAGE_DIR__.'/'.$name;
	if($style=='core'){
		@ require_once($Need_Page_Dir);
	}else{
		@ include($Need_Page_Dir);
	}
}

/** 不同模块文件加载 */
function POXYAPI_Other_Page($other,$name,$style){
	$other=trim($other);
	$name=trim($name);
	$style=trim($style);
	$Other_Dir=@ __POXYAPI_ROOT_DIR__.__POXYAPI_FILE_DIR__.'/'.$other.'/'.$name;
	if($style=='core'){
		@ require_once($Other_Dir);
	}else{
		@ include($Other_Dir);
	}
}

/** 静态文件地址 */
function POXYAPI_Public_URL($name){
	$name=trim($name);
	$dir=__POXYAPI_PREURL__.__POXYAPI_PUBLIC_DIR__.'/'.$name;
	$useDir=__POXYAPI_ROOT_DIR__.__POXYAPI_PUBLIC_DIR__.'/'.$name;
	if(file_exists($useDir)){
		return($dir);
	}else{
		return 'error,file not found';
	}
}

/** 引入文件方法 */
class FileException extends \Exception{

}

function router($fileDir){
	if(! file_exists($fileDir)){
		throw new FileException('目标文件不存在，请检查链接！');
	}else{
		require_once($fileDir);
	}
}