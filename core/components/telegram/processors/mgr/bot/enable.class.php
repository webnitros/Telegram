<?php
include_once dirname(__FILE__) . '/update.class.php';
class TelegramBotEnableProcessor extends TelegramBotUpdateProcessor
{
    public function beforeSet()
    {
        $this->setProperty('active', true);
        return true;
    }

}

return 'TelegramBotEnableProcessor';