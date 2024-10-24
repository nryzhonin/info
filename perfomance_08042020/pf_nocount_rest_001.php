<?php
$tokenID = 'XXXXXXXXXXXXXXXXXXXXX';
$host = 'XXXX.ru';
$user = 1;

// Начинаем с нуля или с предыдущего шага.

$leadID = 0;
$finish = false;

while (!$finish)
{
	// Выполняем, пока не заберем все данные.
	// Не забываем и про задержку между хитами, что бы не превышать лимиты

	$http = new \Bitrix\Main\Web\HttpClient();
	$http->setTimeout(5);
	$http->setStreamTimeout(50);

	$json = $http->post(
		'https://'.$host.'/rest/'.$user.'/'.$tokenID.'/crm.lead.list/',
		[
			'order' => ['ID' => 'ASC'],
			'filter' => ['>ID' => $leadID],
			'select' => ['ID', 'TITLE', 'DATE_CREATE'],
			'start' => -1
		]
	);

	$result = \Bitrix\Main\Web\Json::decode($json);
	if (count($result['result']) > 0)
	{
		foreach ($result['result'] as $lead)
		{
			$leadID = $lead['ID'];
		}

		// Выполняем какие-либо действия
	}
	else
	{
		$finish = true;
	}
}

/*
// Пример ответа сервера с подсчетом количества
Array (
	[result] => Array(
		[0] => Array()
		[1] => Array()
		.....
		[49] => Array()

		[next] => 50
		[total] => 2387743
		[time] => Array (
			[start] => 1581607213.4833
			[finish] => 1581607263.3997
			[duration] => 49.916450023651
			[processing] => 49.899916887283
			[date_start] => 2020-02-13T18:20:13+03:00
			[date_finish] => 2020-02-13T18:21:03+03:00
		)
	)
)

// Пример ответа сервера, без выполнения count
Array(
	[result] => Array (
		[0] => Array()
		[1] => Array()
		.....
		[49] => Array()

		[total] => 0
		[time] => Array(
			[start] => 1581609136.3857
			[finish] => 1581609136.4835
			[duration] => 0.097883939743042
			[processing] => 0.068500995635986
			[date_start] => 2020-02-13T18:52:16+03:00
			[date_finish] => 2020-02-13T18:52:16+03:00
		)
	)
)
 */