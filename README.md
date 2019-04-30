# znkUpush
集成封装友盟开放接口
*友盟消息推送
*友盟openapi接口类
***
|Author|Amulet|
|---|---
|E-mail|shengfu8161980541@qq.com

## 安装要求
php: ~7.0
## 安装教程
`composer require amulet/znk-upush`
## 消息推送示例
### 消息推送类 Umeng
```
use Amulet\Umeng;
$umeng = new Umeng(appkey, secret);

请求参数

$data = [
    'device_tokens'=> $post['device_tokens'],
    'content'=> $post['content'],
    'title'=> $post['title'],
    'subtitle'=> $post['subtitle']??'',
    'url'=> $post['url']??'',
    'task'=> $post['task'],
    'after_open'=> $post['after_open']
];

//指定用户推送消息
$result = $upush->setParams($data)->unicast($deviceType);// $deviceType 设备类型 ios 、 android

//广播
$result = $upush->setParams($data)->broadcast($deviceType);
```

### 请求openapi接口类  Client

```
use Amulet\Client;
$client = new Client('apiKey', 'apiSecurity');
$result = $client->getAppCount();
var_dump($result);
```
