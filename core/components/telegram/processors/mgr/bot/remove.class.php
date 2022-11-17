<?php
class TelegramBotRemoveProcessor extends modObjectRemoveProcessor
{
    public $objectType = 'TelegramBot';
    public $classKey = 'TelegramBot';
    public $languageTopics = ['telegram:manager','telegram:bots'];
    
     /**
     * @return bool|null|string
     */
    public function initialize()
    {
        if (!$this->modx->hasPermission($this->permission)) {
            return $this->modx->lexicon('access_denied');
        }
        return parent::initialize();
    }

}

return 'TelegramBotRemoveProcessor';