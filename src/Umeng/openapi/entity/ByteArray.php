<?php
namespace Amulet\Umeng\openapi\entity;

class ByteArray {

	private $bytesValue;
	
	public function setBytesValue($bytesValue) {
		$this->bytesValue = $bytesValue;
	}
	
	public function getByteValue() {
		return $this->bytesValue;
	}
}