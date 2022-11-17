<?php
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
    /** @noinspection PhpIncludeInspection */
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
} else {
    require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php';
}
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var Telegram $Telegram */
$Telegram = $modx->getService('Telegram', 'Telegram', MODX_CORE_PATH . 'components/telegram/model/');
$modx->lexicon->load('telegram:default');

// handle request
$corePath = $modx->getOption('telegram_core_path', null, $modx->getOption('core_path') . 'components/telegram/');
$path = $modx->getOption('processorsPath', $Telegram->config, $corePath . 'processors/');
$modx->getRequest();

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest([
    'processors_path' => $path,
    'location' => '',
]);