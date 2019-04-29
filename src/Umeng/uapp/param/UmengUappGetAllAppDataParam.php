<?php
namespace Amulet\Umeng\uapp\param;

use Amulet\Umeng\openapi\client\entity\SDKDomain;
use Amulet\Umeng\openapi\client\entity\ByteArray;

class UmengUappGetAllAppDataParam
{


	private $sdkStdResult=array();

	public function getSdkStdResult(){
		return $this->sdkStdResult;
	}

}