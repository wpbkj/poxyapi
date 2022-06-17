<?php
/** POXYAPI安装文件 */
session_start();

$step=trim($_GET['step']);
if(empty($step)){
    $step='preInfo';
}

/** 安装步骤信息提示 */
function POXYAPI_installInfo($step){
    $res=array();
    if($step=='preInfo'){
        $res[1]=0;
        $res[2]='0';
    }elseif($step=='1'){
        $res[1]=25;
        $res[2]='数据库设置';
    }elseif($step=='2'){
        $res[1]=50;
        $res[2]='基本信息';
    }elseif($step=='3'){
        $res[1]=75;
        $res[2]='管理员设置';
    }elseif($step=='4'){
        $res[1]=100;
        $res[2]='开始安装';
    }else{
        header('location:install.php');
    }
    return $res;
}

/** 验证数据库连接 */
function checkDBConn($host,$port,$username,$password,$DBname){
    $conn =@ mysqli_connect("{$host}:{$port}","{$username}","{$password}","{$DBname}"); 
    @ mysqli_set_charset ($conn,'utf8');
    @ mysqli_query($conn,'utf8');
    if (mysqli_connect_errno($conn)) { 
        return false;
    }else{
        return true;
    }
}

/** 创建表 */
function createTable($conn){
    mysqli_query($conn,"CREATE TABLE sysset (
        ID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name text NOT NULL,
        value1 text NULL,
        value2 text NULL,
    )");
}

/** 插入数据库 */

if($_POST['agreement']=='on'){
    $_SESSION['agreement']='on';
}

if($step !='preInfo'&&$_SESSION['agreement'] != 'on'){
    header('location:install.php');
}

if(isset($_GET['restart'])){

}

if($step=='2'&&isset($_POST['DBHost'])&&isset($_POST['DBPort'])&&isset($_POST['DBName'])&&isset($_POST['DBUsername'])&&isset($_POST['DBPassword'])){
    $host=trim($_POST['DBHost']);
    $port=trim($_POST['DBPort']);
    $username=trim($_POST['DBUsername']);
    $password=trim($_POST['DBPassword']);
    $DBname=trim($_POST['DBName']);
    if(checkDBConn($host,$port,$username,$password,$DBname)){
        $text = "<?php
\$conn =mysqli_connect(\"{$host}:{$port}\",\"{$username}\",\"{$password}\",\"{$DBname}\"); 
@ mysqli_set_charset (\$conn,'utf8');
@ mysqli_query(\$conn,'utf8');
if (mysqli_connect_errno(\$conn)) 
{ 
    echo \"连接 MySQL 失败: \" . mysqli_connect_error(); 
    die();
}";
        file_put_contents('config.php',$text);
    }else{
        $_SESSION['DBError']='数据库连接验证失败，请重新配置数据库';
        header('location:install.php?step=1');
    }
}

if(file_exists('config.php')){
    require_once('config.php');
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>安装-无为API管控系统</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="public/css/bootstrap.min.css" rel="stylesheet">
<script src="public/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<div class="container">
    <header class="bg-light text-dark">
        <div class="text-center">
            <img src="public/images/poxyapi.png" width="200" height="67">
            <h1 class="h2">无为API管控系统安装程序</h1>
        </div>
        <div class="progress">
            <div class="progress-bar bg-secondary" role="progressbar" style="width: 25%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">数据库设置</div>
            <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">基本信息</div>
            <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">管理员设置</div>
            <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">开始安装</div>
        </div>
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?php echo POXYAPI_installInfo($step)[1]?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo POXYAPI_installInfo($step)[1]?>%"><?php echo POXYAPI_installInfo($step)[2]?>:<?php echo POXYAPI_installInfo($step)[1]?>%</div>
        </div>
        <br>
        <div class="dropdown text-center">
            <a href="?restart"><p type="button" class="btn btn-primary"><img src="public/icons/arrow-repeat.svg" alt="arrow-repeat" width="auto" height="auto">重新安装</p></a>
            <a target="_blank" href="https://poxyapi.poxylab.com/support/?moudle=install"><p type="button" class="btn btn-primary"><img src="public/icons/question-circle.svg" alt="question-circle" width="auto" height="auto">安装帮助</p></a>
            <a target="_blank" href="https://poxyapi.poxylab.com/"><p type="button" class="btn btn-primary"><img src="public/icons/window.svg" alt="window" width="auto" height="auto">访问官网</p></a>
            <p type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"><img src="public/icons/inboxes-fill.svg" alt="inboxes-fill" width="auto" height="auto">开源仓库</p>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" target="_blank" href="https://gitee.com/wpbkj/poxyapi">Gitee</a></li>
                <li><a class="dropdown-item" target="_blank" href="https://gitee.com/wpbkj/poxyapi">GitHub</a></li>
            </ul>
        </div>
    </header>
    <hr>
    <main>
<?php
if($step=='preInfo'){
?>
        <h2 class="h3">用户协议</h2>
        <div style="border:2px solid #a1a1a1; border-radius:10px;">
            <p>PoxyAPI基于 <a href="https://www.gnu.org/licenses/old-licenses/gpl-2.0.html">GPL 2.0</a> 协议发布, 您可在 GPL 协议许可的范围内任意使用、 拷贝、修改和分发此程序</p>
            <p>在GPL许可的范围内,您可以自由地将其用于商业以及非商业用途</p>
            <p>如果您遇到使用上的问题、程序中的 BUG以及期许的新功能, 欢迎您PoxyAPI开源仓库中提交Issues</p>
            <p>PoxyAPI版权归<a href="https://www.poxylab.com/">无为代码实验室(POXY CODE LABORATORY/PoxyLAB)</a>所有，开发者为<a href="https://www.wpbkj.com/">WPBKJ</a></p>
        </div>
        <form action="?step=1" method="POST" class="needs-validation  text-center" novalidate>
            <div class="form-group form-check">
		        <label class="form-check-label">
		            <input class="form-check-input" type="checkbox" name="agreement" required> 同意协议
		            <div class="valid-feedback">已确认！</div>
		            <div class="invalid-feedback">同意协议才能开始安装。</div>
		        </label>
	        </div>
            <button type="submit" class="btn btn-primary">开始安装</button>
        </form>
<?php }elseif($step=='1'){?>
        <h2 class="h3">MySQL数据库设置</h2>
<?php
if(isset($_SESSION['DBError'])){
?>
        <p class="text-danger"><?php echo $_SESSION['DBError'];?></p>
<?php }?>
        <form action="?step=2" method="POST" class="needs-validation" novalidate>
            <div style="border:2px solid #a1a1a1; border-radius:10px;">
                <br>
	            <div class="input-group mb-3">
		            <span class="input-group-text" id="inputGroup-sizing-default">数据库地址:</span>
		            <input type="text" class="form-control" placeholder="输入数据库地址（无端口）" name="DBHost" required>
		            <div class="valid-feedback">已输入！</div>
		            <div class="invalid-feedback">请输入数据库地址！</div>
	             </div>
	            <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">数据库端口:</span>
		            <input type="text" class="form-control" placeholder="输入数据库端口号（一般为3306）" name="DBPort" required>
		            <div class="valid-feedback">已输入！</div>
		            <div class="invalid-feedback">请输入数据库端口号！</div>
	            </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">数据库名:</span>
		            <input type="text" class="form-control" placeholder="输入数据库名" name="DBName" required>
		            <div class="valid-feedback">已输入！</div>
		            <div class="invalid-feedback">请输入数据库名！</div>
	            </div>
	            <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">用户名:</span>
                    <input type="text" class="form-control" placeholder="输入用户名" name="DBUsername" required>
                    <div class="valid-feedback">已输入！</div>
                    <div class="invalid-feedback">请输入用户名！</div>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">密码:</span>
                    <input type="password" class="form-control" placeholder="输入密码" name="DBPassword" required>
                    <div class="valid-feedback">已输入！</div>
                    <div class="invalid-feedback">请输入密码！</div>
                </div>
            </div>
            <br>
	        <button type="submit" class="btn btn-primary">验证并提交</button>
            <input type="reset" value="重新输入" class="btn btn-primary">
	    </form>
<?php }elseif($step=='2'){?>
        <h2 class="h3">网站基本信息</h2>
        <form action="?step=3" method="POST" class="needs-validation" novalidate>
            <div style="border:2px solid #a1a1a1; border-radius:10px;">
                <br>
	            <div class="input-group mb-3">
		            <span class="input-group-text" id="inputGroup-sizing-default">网站标题:</span>
		            <input type="text" class="form-control" placeholder="设置网站标题" name="title" required>
		            <div class="valid-feedback">已输入！</div>
		            <div class="invalid-feedback">请设置网站标题！</div>
                </div>
	            <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">默认域名:</span>
		            <input type="text" class="form-control" placeholder="设置默认域名" name="preurl" required>
		            <div class="valid-feedback">已输入！</div>
		            <div class="invalid-feedback">请设置默认域名！</div>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="mySwitch" name="rewrite" value="yes">
                    <label class="form-check-label" for="mySwitch">Rewrite是否开启</label>
                </div>
            </div>
            <br>
	        <button type="submit" class="btn btn-primary">验证并提交</button>
            <input type="reset" value="重新输入" class="btn btn-primary">
	    </form>
<?php }elseif($step=='3'){?>
        <h2 class="h3">管理员设置</h2>
        <form action="?step=4" method="POST" class="needs-validation" novalidate>
            <div style="border:2px solid #a1a1a1; border-radius:10px;">
                <br>
	            <div class="input-group mb-3">
		            <span class="input-group-text" id="inputGroup-sizing-default">用户名:</span>
		            <input type="text" class="form-control" placeholder="输入用户名" name="username" required>
		            <div class="valid-feedback">已输入！</div>
		            <div class="invalid-feedback">请输入用户名！</div>
	             </div>
	            <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">邮箱:</span>
		            <input type="email" class="form-control" placeholder="输入邮箱" name="email" required>
		            <div class="valid-feedback">已输入！</div>
		            <div class="invalid-feedback">请输入邮箱！</div>
	            </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">密码:</span>
                    <input type="password" class="form-control" placeholder="输入密码" name="password" required>
                    <div class="valid-feedback">已输入！</div>
                    <div class="invalid-feedback">请输入密码！</div>
                </div>
            </div>
            <br>
	        <button type="submit" class="btn btn-primary">提交</button>
            <input type="reset" value="重新输入" class="btn btn-primary">
	    </form>
<?php }elseif($step=='4'){?>
        <h2 class="h3">完成安装</h2>
<?php }?>
    </main>
</div>
<script>
// 如果验证不通过禁止提交表单
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // 获取表单验证样式
    var forms = document.getElementsByClassName('needs-validation');
    // 循环并禁止提交
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>
</body>
</html>