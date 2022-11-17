<?php
include_once dirname(__FILE__) . '/update.class.php';
class TelegramCommandDisableProcessor extends TelegramCommandUpdateProcessor
{
    public function beforeSet()
    {
        $this->setProperty('active', false);
        return true;
    }

}

return 'TelegramCommandDisableProcessor';