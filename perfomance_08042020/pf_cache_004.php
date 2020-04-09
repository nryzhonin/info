<?php

// Пример добавление в ключ кеша метки времени для корректного переключения кеша. Метка может быть и не из времени.

$cache = Bitrix\Main\Data\Cache::createInstance();
if ($cache->initCache(86450, '/some_key/'.date('myd').'/', '/some_dir/'))
{
	$var = $cache->getVars();
}
else
{
	// Получение данных
	$cache->startDataCache();
	$cache->endDataCache($var);
}
