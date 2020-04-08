<?php

$cache = Bitrix\Main\Data\Cache::createInstance();
if ($cache->initCache(86450, '/some_key/'.date('myd').'/', '/some_dir/'))
{
		$var = $cache->getVars();
}
else
{
//	.....
	$cache->startDataCache();
	$cache->endDataCache($var);
}
