<?php

$APPLICATION->IncludeComponent(
	"bitrix:intranet.structure.birthday.nearest",
	"widget",
	Array(
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "86450",
		"DATE_FORMAT" => "j F",
		"DETAIL_URL" => "#SITE_DIR#company/personal/user/#USER_ID#/",
		"DEPARTMENT" => "0",
		.....
		"CACHE_DATE" => date('dmy')
	)
);
