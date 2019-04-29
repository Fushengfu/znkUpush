<?php
require_once './vendor/autoload.php';

function scdir($path)
{
		echo $path;
		$files = scandir($path);
	foreach($files as $file)
	{
		if (!in_array($file, ['..','.']) && is_dir($path.'/'.$file)) {
			$pth = $path.$file.'/';
			echo $pth . PHP_EOL;
			scdir($pth);
		} else {
			if (strripos($path.$file, '.class.php')) {
				rename($path.$file, str_replace('.class.php', '.php', $path.$file));
			}
			echo $path.$file . PHP_EOL;
		}
	}
}
scdir(__DIR__.'/src/');
 