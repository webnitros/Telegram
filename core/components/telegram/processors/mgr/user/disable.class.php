<?php
include_once dirname(__FILE__) . '/update.class.php';
class TelegramUserDisableProcessor extends TelegramUserUpdateProcessor
{
    public function beforeSet()
    {
        $this->setProperty('active', false);
        return true;
    }

}

return 'TelegramUserDisableProcessor';