<?php

// Различные вызовы АПИ и запросы которые они генерируют

Bitrix\Main\Loader::includeModule('iblock');
$rs = CIBlockElement::GetList(
	[], 
	['CODE' => 'xxx'], // правильно вариант данного фильтра ['=CODE' => 'xxx'], 
	false, 
	false, 
	['ID', 'CODE', 'NAME']
);

/*
SELECT BE.ID as ID,BE.CODE as CODE,BE.NAME as NAME
FROM
	b_iblock B
	INNER JOIN b_lang L ON B.LID=L.LID
	INNER JOIN b_iblock_element BE ON BE.IBLOCK_ID = B.ID
WHERE
	1=1 AND ( ((((BE.CODE LIKE 'xxx')))))
		AND (((BE.WF_STATUS_ID=1 AND BE.WF_PARENT_ELEMENT_ID IS NULL))
	)
*/

Bitrix\Iblock\ElementTable::getList([
	'select' => ['ID', 'NAME', 'CODE'],
	'filter' => ['CODE' => 'xxx'] // правильный вариант фильтра 'filter' => ['=CODE' => 'xxx']
]);

/*
SELECT
	`iblock_element`.`ID` AS `ID`,
	`iblock_element`.`NAME` AS `NAME`,
	`iblock_element`.`CODE` AS `CODE`
FROM `b_iblock_element` `iblock_element`
WHERE UPPER(`iblock_element`.`CODE`) like upper('xxx')
*/


// С новым фильтром не получится допустить ошибку!!!
// документация по фильтру https://clck.ru/MsSRG
Bitrix\Iblock\ElementTable::query()
	->setSelect(['ID', 'NAME', 'CODE'])
	->where('CODE','xxx')->exec();

/*
SELECT
	`iblock_element`.`ID` AS `ID`,
	`iblock_element`.`NAME` AS `NAME`,
	`iblock_element`.`CODE` AS `CODE`
FROM `b_iblock_element` `iblock_element`
WHERE `iblock_element`.`CODE` = 'xxx'
*/