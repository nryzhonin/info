<?php
Bitrix\Iblock\PropertyIndex\Manager::enableDeferredIndexing();
Bitrix\Catalog\Product\Sku::enableDeferredCalculation();

\CAllIBlock::disableTagCache($iblockID);

// Импорт элементов 

\CAllIBlock::enableTagCache($iblockID);
\CAllIBlock::clearIblockTagCache($iblockID);

Bitrix\Catalog\Product\Sku::disableDeferredCalculation();
Bitrix\Catalog\Product\Sku::calculate();

Bitrix\Iblock\PropertyIndex\Manager::disableDeferredIndexing();
Bitrix\Iblock\PropertyIndex\Manager::runDeferredIndexing($iblockID);
