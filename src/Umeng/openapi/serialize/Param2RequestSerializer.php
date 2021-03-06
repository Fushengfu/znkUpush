<?php
namespace Amulet\Umeng\openapi\serialize;

use Amulet\Umeng\openapi\serialize\Serializer;
use Amulet\Umeng\openapi\policy\DataProtocol;
use Amulet\Umeng\openapi\entity\ByteArray;
use Amulet\Umeng\openapi\entity\SDKDomain;
use Amulet\Umeng\openapi\util\SDKDomainUtil;

class Param2RequestSerializer implements Serializer
{
	public function supportedContentType() {
		return DataProtocol::param2;
	}

	public function serialize($serializer) {
		$serializedResult = array ();
		if($serializer==null){
			return $serializedResult;
		}
		$ref = new \ReflectionObject( $serializer );
		$sdkStdResultArray = null;
		foreach ( $ref->getMethods () as $tempMethod ) {
			$methodName = $tempMethod->name;
			if ("getSdkStdResult" == $methodName) {
				$sdkStdResultArray = $tempMethod->invoke ( $serializer );
			}
		}
		if ($sdkStdResultArray == null) {
			foreach ( $ref->getMethods () as $tempMethod ) {
				$methodName = $tempMethod->name;
				if (strpos ( $methodName, "get" ) === 0 && "getSdkStdResult" != $methodName) {
					$propertyName = substr ( $methodName, 3 );
					$propertyName = lcfirst ( $propertyName );
					$resultValue = $tempMethod->invoke ( $serializer );
					if (($resultValue instanceof DateTime)) {
						$timeValue =$resultValue->getTimestamp();
						$strTime = DateUtil::parseToString ($timeValue );
						$serializedResult [$propertyName] = $strTime;
					} else if (($resultValue instanceof ByteArray)) {
						$tempValue = base64_encode ( $resultValue->getByteValue () );
						$serializedResult [$propertyName] = $tempValue;
					} else if (($resultValue instanceof SDKDomain)) {
						$sdkDomainUtil = new SDKDomainUtil ();
						$tempArray = $sdkDomainUtil->generateSDKDomainArray ( $resultValue );
						$resultJsonValue = json_encode ( $tempArray );
						$serializedResult [$propertyName] = $resultJsonValue;
					} else if (is_array ( $resultValue )) {
						$resultJsonValue = json_encode ( $resultValue );
						$serializedResult [$propertyName] = $resultJsonValue;
					} else {
						$serializedResult [$propertyName] = $resultValue;
					}
				}
			}
		} else {
			foreach ( $sdkStdResultArray as $k => $v ) {
				$resultValue = $v;
				if (($resultValue instanceof DateTime)) {
					$timeValue =$resultValue->getTimestamp();
					$strTime = DateUtil::parseToString ($timeValue );
					$serializedResult [$k] = $strTime;
				} else if (($resultValue instanceof ByteArray)) {
					$tempValue = base64_encode ( $resultValue->getByteValue () );
					$serializedResult [$k] = $tempValue;
				} else if (($resultValue instanceof SDKDomain)) {
					$sdkDomainUtil = new SDKDomainUtil ();
					$tempArray = $sdkDomainUtil->generateSDKDomainArray ( $resultValue );
					$resultJsonValue = json_encode ( $tempArray );
					$serializedResult [$k] = $resultJsonValue;
				} else if (is_array ( $resultValue )) {
					$resultJsonValue = json_encode ( $resultValue );
					$serializedResult [$k] = $resultJsonValue;
				} else {
					$serializedResult [$k] = $resultValue;
				}
			}
		}
		return $serializedResult;
	}
}