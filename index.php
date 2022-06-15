<?php
/**
*POXY API MANAGER SYSTEM
*
*@author    WPBKJ
*@copyright PoxyLAB(www.poxylab.com)
*@license   GNU General Public License 2.0
*@version   $Id:index.php 1.0.1 2022/6/10 10:00 $
*/

/** 定义页面角色 */
define('__POXYAPI_PAGE_CHARACTER__','index');

if(!@ include_once('config.php')){
	if(file_exists('poxyapi.installed')){
		die('安装失败，请删除poxyapi.installed文件后重新安装');
	}else{
		file_exists('install.php')?header('location:install.php'):die('安装配置文件丢失，请重新上传文件');
	}
}

/** 载入POXYAPI核心文件 */
require_once 'core/core.php';

/** 定义根目录 */
define('__POXYAPI_ROOT_DIR__',dirname(__FILE__));

/** 定义package目录 */
define('__POXYAPI_PACKAGE_DIR__','/user/module');

/** 定义总文件目录 */
define('__POXYAPI_FILE_DIR__','/pages');

/** 定义index文件目录 */
define('__POXYAPI_PAGE_DIR__','/index');

/** 定义静态文件目录 */
define('__POXYAPI_PUBLIC_DIR__','/public');

/** 载入POXYAPI核心控制文件 */
require_once('core/control.php');

/** 到这就完了奥 */
?>