# ppxy
这是一个使用Laravel5.1+Bootstrap3开发的校园二手交易系统，为本人在2015年5月份写成，主要包含用户登录系统(包含手机短信验证、通知)，商品发布、修改以及订单组件，无论是拿来用还是来学习都是可以的。

如果有任何疑问也可以联系本人，谢谢。

# 预览
[http://www.ppxiaoyuan.com](http://www.ppxiaoyuan.com)


#安装

- clone

```bash
    git clone https://github.com/xuwenzhi/ppxy.git
```

- composer install

```
    在ppxy目录下执行 composer install
```

- 新建.env文件

```
DOMAIN_NAME=http://www.ppxiaoyuan.com
#环境配置，生产环境请关闭APP_DEBUG
APP_ENV=local
APP_DEBUG=true
APP_KEY=32位加密串
#DB配置
DB_HOST=localhost
DB_DATABASE=dbname
DB_USERNAME=dbuser
DB_PASSWORD=dbpass

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

MAIL_DRIVER=smtp
MAIL_HOST=smtp.163.com
MAIL_PORT=25
MAIL_USERNAME=xxx@163.com
MAIL_PASSWORD=163pass
MAIL_SIGN=PP校园

#第三方短信网关
SMS_HP=xxxxxxxxxx
SMS_SIGN=PP校园
SMS_KEY=xxxxxxxxxx
SMS_URL=第三方短信地址

```

- 数据库配置

新建数据库，请查看此数据表结构及基础数据[ppxy.sql](http://xuwenzhi.com/wp-content/uploads/2016/03/ppxy.txt)，把数据注入对应DB。

- 加个host吧（方法自行百度）

```
yourip www.ppxy.com
```
- nginx配置到你的nginx/conf下

```
server {
    listen 80;
    server_name www.ppxy.com ppxy.com;
    access_log /home/work/var/log/ppxy.log main;
    error_log /home/work/var/log/ppxy.error.log;
    root /home/work/html/ppxy/public;
    index  index.php index.html index.htm;
    location / {
    try_files $uri $uri/ /index.php?$query_string;
    }
    location ~ \.php$ {
            set $real_script_name $fastcgi_script_name;
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_index  index.php;
            fastcgi_param  SCRIPT_FILENAME  $document_root$real_script_name;
            include        fastcgi_params;
        }
}
```

- OK
浏览器访问 [http://www.ppxy.com](http://www.ppxy.com)

