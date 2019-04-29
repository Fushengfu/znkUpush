# znkUpush
友盟sdk接口

# 使用规则
## 示例

实例化实例
$umeng = new Umeng(appkey, secret);
```
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
