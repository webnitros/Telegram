<?php
include_once dirname(__FILE__) . '/update.class.php';
class TelegramCommandEnableProcessor extends TelegramCommandUpdateProcessor
{
    public function beforeSet()
    {
        $this->setProperty('active', true);
        return true;
    }

}

return 'TelegramCommandEnableProcessor';