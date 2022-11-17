<?php
include_once dirname(__FILE__, 3) . '/update.class.php';

class TelegramBotTelegramUnInstallProcessor extends TelegramBotUpdateProcessor
{
    public function beforeSet()
    {
        try {
            $result = $this->object->unInstallWebHook();
            if (!$result->isOk()) {
                return $result->getDescription();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        $this->setProperty('webhook_install', !$result->isOk());
        return true;
    }

}

return 'TelegramBotTelegramUnInstallProcessor';
