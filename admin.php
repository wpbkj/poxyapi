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
define('__POXYAPI_PAGE_CHARACTER__','admin');

/** 载入POXYAPI核心文件 */
if(!@ include_once('config.php')){
	die(POXYAPI_error('数据库连接文件丢失，系统崩溃','致命错误'));
}

require_once 'core/core.php';

/** 定义根目录 */
define('__POXYAPI_ROOT_DIR__',dirname(__FILE__));

/** 定义package目录 */
define('__POXYAPI_PACKAGE_DIR__','/user/module');

/** 定义总文件目录 */
define('__POXYAPI_FILE_DIR__','/pages');

/** 定义admin文件目录 */
define('__POXYAPI_PAGE_DIR__','/admin');

/** 定义静态文件目录 */
define('__POXYAPI_PUBLIC_DIR__','/public');

/** 载入POXYAPI核心控制文件 */
require_once('core/control.php');

/** 到这就完了奥 */
?>