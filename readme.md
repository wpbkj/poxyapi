# 欢迎使用无为API管控系统（未完成）
![LOGO](https://www.wpbkj.com/poxyapi/poxyapi.png)

## 简介

无为API管控系统由PHP构建，开发人员：[WPBKJ](https://www.wpbkj.com/)

支持API限定次数访问，API访问数据分析等API分析工具，帮助API管理员更好的管理API数据，实时监控API使用情况。

相关功能正在开发中

## 联系开发者
WPBKJ：
QQ:64345171
Email:wpbkj123@163.com

## 使用

###1、将仓库所有文件下载到服务器

###2、完成站点配置（同其他PHP类CMS）

在服务器面板或使用PHP Server完成站点配置
> 注意：由于本程序在rewrite配置后可更好表现，请使用Nginx/Apache + PHP 便于配置rewrite

###3、完成rewrite配置
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




