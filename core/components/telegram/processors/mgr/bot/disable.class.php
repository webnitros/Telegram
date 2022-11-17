<?php
include_once dirname(__FILE__) . '/update.class.php';
class TelegramBotDisableProcessor extends TelegramBotUpdateProcessor
{
    public function beforeSet()
    {
        $this->setProperty('active', false);
        return true;
    }

}

return 'TelegramBotDisableProcessor';