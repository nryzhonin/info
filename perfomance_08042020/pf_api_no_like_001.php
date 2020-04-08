<?php
Bitrix\Main\Loader::includeModule('iblock');
$rs = CIBlockElement::GetList(
	[], 
	['CODE' => 'xxx'], // правильно ['=CODE' => 'xxx'], 
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
	'filter' => ['CODE' => 'xxx']
	// правильно 'filter' => ['=CODE' => 'xxx']
]);

/*
SELECT
	`iblock_element`.`ID` AS `ID`,
	`iblock_element`.`NAME` AS `NAME`,
	`iblock_element`.`CODE` AS `CODE`
FROM `b_iblock_element` `iblock_element`
WHERE UPPER(`iblock_element`.`CODE`) like upper('xxx')
*/

Bitrix\Iblock\ElementTable::query()
	->setSelect(['ID', 'NAME', 'CODE'])
	->where('CODE','xxx')->exec();
/*
 * https://dev.1c-bitrix.ru/learning/course/index.php?COURSE_ID=43&LESSON_ID=3030&LESSON_PATH=3913.5062.5748.3030

SELECT
	`iblock_element`.`ID` AS `ID`,
	`iblock_element`.`NAME` AS `NAME`,
	`iblock_element`.`CODE` AS `CODE`
FROM `b_iblock_element` `iblock_element`
WHERE `iblock_element`.`CODE` = 'xxx'

*/