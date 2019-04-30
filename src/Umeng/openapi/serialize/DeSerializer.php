<?php
namespace Amulet\Umeng\openapi\serialize;

interface DeSerializer
{
	public function supportedContentType();
	public function deSerialize($deSerializer,$resultType,$charSet);
	public function buildException($deSerializer,$resultType,$charSet);
}
?>