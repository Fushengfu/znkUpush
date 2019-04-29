<?php

namespace Amulet\Umeng\Notifications;

use Amulet\Umeng\Notifications\UmengNotification;

class AndroidNotification extends UmengNotification {
	// The array for payload, please see API doc for more information
	protected $androidPayload = [
		"display_type"  =>  "notification",
		"body"         	=>  [
			"ticker"       => null,
			"title"        => null,
			"text"         => null,
			"url"          => "",
			"play_vibrate" => "true", 
			"play_lights"  => "true",
			"play_sound"   => "true",
			"after_open"   => null,
		]
	];

	// Keys can be set in the payload level
	protected $PAYLOAD_KEYS = array("display_type");

	// Keys can be set in the body level
	protected $BODY_KEYS    = [
		"ticker",
		"title",
		"text",
		"builder_id",
		"icon",
		"largeIcon",
		"img",
		"play_vibrate",
		"play_lights",
		"play_sound",
		"after_open",
		"url",
		"activity", "custom"
	];

	public function __construct($type) {
		$this->data["type"] = $type;
		parent::__construct();
		$this->data["payload"] = $this->androidPayload;

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
		} else if (in_array($key, $this->PAYLOAD_KEYS)) {
			$this->data["payload"][$key] = $value;
			if ($key == "display_type" && $value == "message") {
				$this->data["payload"]["body"]["ticker"] = "";
				$this->data["payload"]["body"]["title"] = "";
				$this->data["payload"]["body"]["text"] = "";
				$this->data["payload"]["body"]["after_open"] = "";
				if (!array_key_exists("custom", $this->data["payload"]["body"])) {
					$this->data["payload"]["body"]["custom"] = null;
				}
			}
		} else if (in_array($key, $this->BODY_KEYS)) {
			$this->data["payload"]["body"][$key] = $value;
			if ($key == "after_open" && $value == "go_custom" && !array_key_exists("custom", $this->data["payload"]["body"])) {
				$this->data["payload"]["body"]["custom"] = null;
			}
		} else if (in_array($key, $this->POLICY_KEYS)) {
			$this->data["policy"][$key] = $value;
		} else {
			if ($key == "payload" || $key == "body" || $key == "policy" || $key == "extra") {
				throw new Exception("You don't need to set value for ${key} , just set values for the sub keys in it.");
			} else {
				throw new Exception("Unknown key: ${key}");
			}
		}
	}

	// Set extra key/value for Android notification
	public function setExtraField($key, $value) {
		if (!is_string($key))
			throw new Exception("key should be a string!");
		$this->data["payload"]["extra"][$key] = $value;
	}
}