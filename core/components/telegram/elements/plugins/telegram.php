<?php
/** @var modX $modx */
/* @var array $scriptProperties */
switch ($modx->event->name) {
    case 'OnHandleRequest':
        /* @var Telegram $Telegram*/
        $Telegram = $modx->getService('telegram', 'Telegram', $modx->getOption('telegram_core_path', $scriptProperties, $modx->getOption('core_path') . 'components/telegram/') . 'model/');
        if ($Telegram instanceof Telegram) {
            $Telegram->loadHandlerEvent($modx->event, $scriptProperties);
        }
        break;
}
return '';