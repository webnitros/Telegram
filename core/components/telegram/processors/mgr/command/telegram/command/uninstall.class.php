<?php
include_once dirname(__FILE__, 3) . '/update.class.php';

class TelegramBotTelegramCommandUnInstallProcessor extends TelegramCommandUpdateProcessor
{
    public function beforeSet()
    {
        try {
            $this->object->bot()->setMyCommands($this->object->get('id'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
        $this->setProperty('install', false);
        $this->setProperty('active', false);
        return true;
    }

}

return 'TelegramBotTelegramCommandUnInstallProcessor';
