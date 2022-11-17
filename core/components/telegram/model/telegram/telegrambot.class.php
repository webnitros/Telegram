<?php

use Longman\TelegramBot\Entities\BotCommandScope\BotCommandScopeDefault;

class TelegramBot extends xPDOSimpleObject
{
    /* @var \TelegramManager\Bot $telegram */
    private $telegram;

    /* @var null|TelegramCommand[] $commands */
    protected $commands = null;

    /**
     * @return TelegramCommand[]|null
     */
    public function loadCommands()
    {
        if (is_null($this->commands)) {
            $Commands = $this->getMany('Commands');
            if (count($Commands) > 0) {
                $this->commands = $Commands;
            }
        }
        return $this->commands;
    }

    /**
     * {@inheritdoc}
     */
    public function save($cacheFlag = null)
    {
        if ($this->isNew()) {
            if (empty($this->get('createdon'))) {
                $this->set('createdon', time());
            }
        } else {
            $this->set('updatedon', time());
        }
        return parent::save();
    }


    /**
     * @return \TelegramManager\Bot
     */
    public function telegram()
    {
        if (is_null($this->telegram)) {

            if (empty($this->get('token'))) {
                throw new Exception('Не указан token для бота');
            } else if (empty($this->get('username'))) {
                throw new Exception('Не указан username для бота');
            }
            $this->telegram = new \TelegramManager\Bot($this->get('token'), $this->get('username'));
        }
        return $this->telegram;
    }

    public function installWebHook()
    {
        $webhook = $this->get('webhook');
        if (empty($webhook)) {
            throw new Exception('Не указанна ссылка на веб хук');
        }

        $symbol = '?';
        if (strripos($webhook, $symbol) !== false) {
            $symbol = '&';
        }
        $webhook .= $symbol . 'bot_id=' . $this->get('id');
        return $this->telegram()->installWebHook($webhook);
    }

    public function unInstallWebHook()
    {
        return $this->telegram()->unInstallWebHook();
    }

    public function setMyCommands($offsetCommand = null)
    {
        /* @var TelegramCommand[] $Commands */
        $Commands = $this->getMany('Commands', ['bot_id' => $this->get('id')]);
        $commands = [
            'scope' => new BotCommandScopeDefault(),
            'commands' => [],
        ];
        foreach ($Commands as $command) {
            if ($offsetCommand && $offsetCommand === $command->get('id')) {
                continue;
            }
            $commands['commands'][] = $command->getCommand();
        }

        $result = $this->telegram()->setMyCommands($commands);


        if (!$result->isOk()) {
            throw new Exception($result->getDescription());
        }

        /*if ($result->isOk()) {
            $result = $this->getMyCommands();
            $commands = $result->getResult();
            foreach ($commands as $item) {
                $command = $item->command;
                $bot_username = $item->bot_username;

            }
        }*/
        return true;
    }

    public function deleteMyCommands(TelegramCommand $command)
    {
        $result = $this->telegram()->deleteMyCommands([$command->getCommand()]);
        if (!$result->isOk()) {
            throw new Exception($result->getDescription());
        }
        return true;
    }

    public function getMyCommands()
    {
        return $this->telegram()->getMyCommands();
    }
}
