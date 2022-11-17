<?php
class TelegramUserRemoveProcessor extends modObjectRemoveProcessor
{
    public $objectType = 'TelegramUser';
    public $classKey = 'TelegramUser';
    public $languageTopics = ['telegram:manager','telegram:users'];
    
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

return 'TelegramUserRemoveProcessor';