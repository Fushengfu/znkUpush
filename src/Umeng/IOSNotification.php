<?php
namespace Amulet\Umeng;

use Amulet\Umeng\UmengNotification;

class IOSNotification extends UmengNotification {
	// The array for payload, please see API doc for more information
	protected $iosPayload = [
		"aps"=>  [
			"alert"=>  null,
		]
	//"key1"	=>	"value1",
	//"key2"	=>	"value2"
	];

	// Keys can be set in the aps level
	protected $APS_KEYS    = ['alert', "badge", "sound", "content-available"];

	public function __construct($type) {
		$this->data["type"] = $type;
		parent::__construct();
		$this->data["payload"] = $this->iosPayload;
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
	public function setPredefinedKeyValue($key, $value) {
		if (!is_string($key))
			throw new Exception("key should be a string!");

		if (in_array($key, $this->DATA_KEYS)) {
			$this->data[$key] = $value;
		} else if (in_array($key, $this->APS_KEYS)) {
			$this->data["payload"]["aps"][$key] = $value;
		} else if (in_array($key, $this->POLICY_KEYS)) {
			$this->data["policy"][$key] = $value;
		} else {
			if ($key == "payload" || $key == "policy" || $key == "aps") {
				throw new Exception("You don't need to set value for ${key} , just set values for the sub keys in it.");
			} else {
				throw new Exception("Unknown key: ${key}");
			}
		}
	}

	// Set extra key/value for Android notification
	public function setCustomizedField($key, $value) {
		if (!is_string($key))
			throw new Exception("key should be a string!");
		$this->data["payload"][$key] = $value;
	}
}