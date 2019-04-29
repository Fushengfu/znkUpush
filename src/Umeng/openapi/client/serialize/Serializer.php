<?php
namespace Amulet\Umeng\openapi\client\serialize;

interface Serializer
{
	public function supportedContentType();
	public function serialize($serializer);
}