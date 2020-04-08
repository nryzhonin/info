<?php
Bitrix\Main\Application::getInstance()->getConnectionPool()->useMasterOnly(true);

// Какие либо обновления и изменения

Bitrix\Main\Application::getInstance()->getConnectionPool()->useMasterOnly(false);
