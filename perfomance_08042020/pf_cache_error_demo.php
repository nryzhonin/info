<?php

// Демонстрация ошибки при работе с кешем

global $CACHE_MANAGER;
function getKey($key)
{
	$dir = '/tagdir1/';		// Не корректный вариант, удалятся все ключи, при очистке одного по тегу
	$dir = '/tagdir1/'.$key.'/';	// Не корректный вариант, так как в файловом кеше будет много папок на одном уровне
	//$dir = '/tagdir1/'.substr(md5($key),2,2)./.$key.'/';	// Правильный вариант
	$cache = Bitrix\Main\Data\Cache::createInstance();
	if ($cache->initCache(3600, $key, $dir))
	{
		$var = $cache->getVars();
	}
	else
	{
		$taggedCache = \Bitrix\Main\Application::getInstance()->getTaggedCache();
		$taggedCache->StartTagCache($dir);
		$taggedCache->RegisterTag($key);

		$cache->startDataCache();
		$cache->endDataCache(['time' => getmicrotime()]);
		$taggedCache->EndTagCache();

		$var['time'] = "Empty cache";
	}

	return $key.":".$var['time'];
}

$taggedCache = \Bitrix\Main\Application::getInstance()->getTaggedCache();

echo getKey('K611')."\n";
echo getKey('K622')."\n";
echo getKey('K633')."\n";

sleep(1); $taggedCache->ClearByTag('K622'); echo "\n";

echo getKey('K611')."\n";
echo getKey('K622')."\n";
echo getKey('K633')."\n";
