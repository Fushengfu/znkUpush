<?php

namespace Amulet;

use Amulet\Umeng\AndroidNotification;
use Amulet\Umeng\IOSNotification;
use Log;

class Umeng 
{
	protected $appkey           = null; 
	protected $appMasterSecret  = null;
	protected $timestamp        = null;
	protected $validation_token = null;
	protected $sendBody = null;
	protected $device_tokens = null;
	protected $content = null;
	protected $title = null;
	protected $type = null;
	protected $url = null;
	protected $task = null;
	protected $subtitle = null;
	protected $after_open = 'go_app';

	protected $PARAMS_KEY = ['device_tokens', 'content', 'title', 'subtitle', 'after_open', 'task', 'url'];


	public function __construct($key, $secret) {
		$this->appkey = $key;
		$this->appMasterSecret = $secret;
		$this->timestamp = strval(time());
	}

	/**
	* reports
	* @Author Amulet
	* @Email 2061802928@qq.com
	* @Create Date 2019/04/11
	* @Create Time 10:41
	* @Describe 数据处理
	* @param Request $request
	* @return mixed
	*/
	public function setParams(array $data)
	{
		foreach ($this->PARAMS_KEY as $key) {
			if ($data[$key]??false) {
				$this->$key = $data[$key];
			}
		}
		$this->sendBody = [
			"title"		=>	$this->title,
			"subtitle"	=>	$this->subtitle??$this->title,
			"body"		=>	$this->content
		];
		return $this;
	}

	public function sendAndroidCast() {
		try {
			$notify = new AndroidNotification($this->type);
			$notify->setAppMasterSecret($this->appMasterSecret);
			$notify->setPredefinedKeyValue("appkey",           $this->appkey);
			$notify->setPredefinedKeyValue("timestamp",        $this->timestamp);
			if ($this->device_tokens) {
				$notify->setPredefinedKeyValue("device_tokens",    $this->device_tokens); 
			}
			$notify->setPredefinedKeyValue("ticker",           "宠来了消息提示");
			$notify->setPredefinedKeyValue("title",            $this->title);
			if ($this->url) {
				$notify->setPredefinedKeyValue("url",             $this->url);
			}
			$notify->setPredefinedKeyValue("text",             $this->content);
			$notify->setPredefinedKeyValue("after_open",       $this->after_open);
			// Set 'production_mode' to 'false' if it's a test device. 
			// For how to register a test device, please see the developer doc.
			$notify->setPredefinedKeyValue("production_mode", "false");
			// [optional]Set extra fields
			$notify->setExtraField("test", $this->task);
			return $notify->send();
		} catch (\Exception $e) {
			Log::error("友盟推送: " . $e->getMessage().$this->after_open);
		}
	}

	public function sendIosCast() {
		try {
			$notify = new IOSNotification($this->type);
			$notify->setAppMasterSecret($this->appMasterSecret);
			$notify->setPredefinedKeyValue("appkey",           $this->appkey);
			$notify->setPredefinedKeyValue("timestamp",        $this->timestamp);
			// Set your device tokens here
			if ($this->device_tokens) {
				$notify->setPredefinedKeyValue("device_tokens",    $this->device_tokens); 
			}
			$notify->setPredefinedKeyValue("alert", 		   $this->sendBody);
			$notify->setPredefinedKeyValue("badge", 0);
			$notify->setPredefinedKeyValue("sound", "chime");
			// Set 'production_mode' to 'true' if your app is under production mode
			$notify->setPredefinedKeyValue("production_mode", "false");
			// Set customized fields
			$notify->setCustomizedField("test", $this->task);
			return $notify->send();
		} catch (\Exception $e) {
			Log::error("友盟推送: " . $e->getMessage());
		}
	}

	public function __call($method, $params)
	{
		$func = 'send'.ucfirst($params[0]).'Cast';
		$this->type = $method;
		if (method_exists($this, $func)) {
			return $this->$func();
		} else {
			Log::error($method);
			return false;
		}
	}
}