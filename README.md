# ppxy
这是一个使用Laravel5.1+Bootstrap3开发的校园二手交易系统，为本人在2015年5月份写成，主要包含用户登录系统(包含手机短信验证)，商品发布、修改以及订单组件，还是很值得学习的。

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

```

- 数据库配置
新建数据库，在此下载数据库表结构[http://xuwenzhi.com/wp-content/uploads/2016/03/ppxy.sql](http://xuwenzhi.com/wp-content/uploads/2016/03/ppxy.txt)，将.txt改为.sql，然后执行改SQL文件。

- 实验
在浏览器中输入yourhostname.com/ppxy/public/index.php



#OK..

