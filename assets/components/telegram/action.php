<?php

use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Entities\KeyboardButton;
use Longman\TelegramBot\Entities\KeyboardButtonPollType;
use Longman\TelegramBot\Entities\MessageEntity;
use Longman\TelegramBot\Request;
use TelegramManager\CommandAction;
use TelegramManager\Hook;

define('MODX_API_MODE', true);

/** @noinspection PhpIncludeInspection */
require dirname(__FILE__, 4) . '/index.php';


$body = @file_get_contents('php://input');
$array = $modx->fromJSON($body);


$command = null;
if (!empty($array['message']['entities'][0]['type']) && $array['message']['entities'][0]['type'] === 'bot_command') {
    $command = ltrim($array['message']['text'], '/');
}

/* @var Telegram $Telegram */
$Telegram = $modx->getService('telegram', 'Telegram', $modx->getOption('telegram_core_path', $scriptProperties, $modx->getOption('core_path') . 'components/telegram/') . 'model/');


$bot_id = @$_GET['bot_id'];


/* @var TelegramBot $Bot */
if (!$Bot = $modx->getObject('TelegramBot', $bot_id)) {
    exit('Bot not found');
}

try {
    $Hook = new \TelegramManager\Hook($Bot->telegram(), $array);
    $Action = new CommandAction();

    if ($Commands = $Bot->loadCommands()) {
        /* @var $command TelegramCommand */
        foreach ($Commands as $command) {
            if ($command->get('snippet')) {
                $Action->addCommandHandler($command->get('command'), function (Hook $Hook) use ($modx, $command, $Bot) {
                    $modx->runSnippet($command->get('snippet'), [
                        'Hook' => $Hook,
                        'Command' => $command,
                        'Bot' => $Bot
                    ]);
                });
            }
        }
    }

    if (!empty($Bot->get('snippet'))) {
        // Запускается всегда когда не определена команда
        $Action->addCommandHandler('', function (Hook $Hook) use ($modx, $Bot) {
            $modx->runSnippet($Bot->get('snippet'), [
                'Hook' => $Hook,
                'Bot' => $Bot
            ]);
        });
    }

    $Hook->run($Action);

    //TelegramUser

    if ($id = $Hook->user()->telegramId()) {
        $criteria = [
            'telegram_id' => $id,
            'bot_id' => $Bot->get('id')
        ];

        echo $Hook->user()->firstName() . PHP_EOL;

        /* @var TelegramUser $TelegramUser */
        if (!$TelegramUser = $modx->getObject('TelegramUser', $criteria)) {
            /* @var TelegramUser $TelegramUser */
            $TelegramUser = $modx->newObject('TelegramUser');
            $TelegramUser->set('bot_id', $Bot->get('id'));
            $TelegramUser->set('telegram_id', $id);
        }


        $TelegramUser->set('is_bot', $Hook->user()->isBot());
        $TelegramUser->set('first_name', $Hook->user()->firstName());
        $TelegramUser->set('username', $Hook->user()->username());
        $TelegramUser->set('language_code', $Hook->user()->languageCode());

        $TelegramUser->save();
    }

    exit('run hook');
} catch (Exception $e) {
    exit($e->getMessage());
}

