# 欢迎使用无为API管控系统（未完成）
![LOGO](https://www.wpbkj.com/poxyapi/poxyapi.png)

## 简介

无为API管控系统由PHP+MySQL构建，开发人员：[WPBKJ](https://www.wpbkj.com/)

[![wpbkj/无为API管控系统_PHP](https://gitee.com/wpbkj/poxyapi/widgets/widget_card.svg?colors=4183c4,ffffff,ffffff,e3e9ed,666666,9b9b9b)](https://gitee.com/wpbkj/poxyapi)

相关功能正在开发中

## 联系开发者
WPBKJ：
QQ:64345171
Email:wpbkj123@163.com

## 使用

### 1、将仓库所有文件下载到服务器

### 2、完成站点配置（同其他PHP类CMS）
在服务器面板或使用PHP Server完成站点配置
> 注意：由于本程序在rewrite配置后可更好表现，请使用Nginx/Apache + PHP 便于配置rewrite

### 3、完成rewrite配置
rewrite配置：

Nginx Rewrite：
``` nginx
location / {
index index.html index.php;
if (-f $request_filename/index.html) {
rewrite (.*) $1/index.html break;
}
if (-f $request_filename/index.php) {
rewrite (.*) $1/index.php;
}
if (!-f $request_filename) {
rewrite (.*) /index.php;
}
}
```
Apache Rewrite：
``` apache
RewriteRule ^(.*) $1/index.html
RewriteRule ^(.*) $1/index.php
RewriteRule ^(.*) index.php
```
### 4、安装程序
上述配置完成后直接访问网站首页进行数据库，网站默认配置等相关设置即可
#### 安装界面截图
![Info](https://www.wpbkj.com/poxyapi/1.png)
![step1](https://www.wpbkj.com/poxyapi/2.png)
![step2](https://www.wpbkj.com/poxyapi/3.png)
![step3](https://www.wpbkj.com/poxyapi/4.png)

### 5、体验
安装完后由于功能上不完善，本程序先预制了一个1-100随机数api，可供用户体验功能  
文件地址：`/user/module/rand.php`  
链接：  
开启rewrite：`/api/rand.api`  
未开启erwrite：`/index.php/api/rand.api`  
返回示例：  
> {"status":"successfull","result":67}


