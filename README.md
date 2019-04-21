url管理类
====
项目中经常会遇到对一个url的解析，并修改参数后生成新的地址后使用。

url解析使用原理
--------------------
通过`parse_url`函数解析，并暂存起所有参数


url类提供方法
--------------------
* 构造方法 __construct($url)
* 删除url参数 delQuerys($name)
* 添加url参数 addQuerys($key,$val)
* 设置url协议头 setScheme($scheme)
* 设置端口号 setPort($port)
* 设置host  setHost($host)
* 设置path  setPath($path)
* 设置锚点  setFragment($fragment)
* 获取新的url getUrl()


使用方法
--------------------
```php
require './vendor/autoload.php';

$urlManage = new \songyongzhan\url\Url("www.xiaosongit.com:8088/index.php/user/edit?name=jim&age=11#two");

// print_r($urlMange->querys); 得到问号后边的参数
// print_r($urlMange->host); 得到域名
$urlManage->delQuerys('name')->setHost('new.xiaosongit.com')->setPort(80)->addQuerys('page', 1)->setFragment('one');

$urlManage->setPath('/list/3.html');

echo $u->getUrl();

```




