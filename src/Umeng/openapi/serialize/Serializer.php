<?php
namespace Amulet\Umeng\openapi\serialize;

interface Serializer
{
	public function supportedContentType();
	public function serialize($serializer);
}