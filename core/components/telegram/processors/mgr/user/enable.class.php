<?php
include_once dirname(__FILE__) . '/update.class.php';
class TelegramUserEnableProcessor extends TelegramUserUpdateProcessor
{
    public function beforeSet()
    {
        $this->setProperty('active', true);
        return true;
    }

}

return 'TelegramUserEnableProcessor';