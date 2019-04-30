# znkUpush
友盟sdk接口

# 使用规则
## 安装
```
composer require amulet/znk-upush
```
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
