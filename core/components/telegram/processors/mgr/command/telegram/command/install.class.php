<?php
include_once dirname(__FILE__, 3) . '/update.class.php';

class TelegramBotTelegramCommandInstallProcessor extends TelegramCommandUpdateProcessor
{
    public function beforeSet()
    {
        try {
            $this->object->bot()->setMyCommands();
        } catch (Exception $e) {
            return $e->getMessage();
        }

        $this->setProperty('install', true);
        $this->setProperty('active', true);
        return true;
    }

}

return 'TelegramBotTelegramCommandInstallProcessor';
