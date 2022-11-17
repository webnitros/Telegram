<?php
class TelegramCommandRemoveProcessor extends modObjectRemoveProcessor
{
    public $objectType = 'TelegramCommand';
    public $classKey = 'TelegramCommand';
    public $languageTopics = ['telegram:manager','telegram:commands'];
    
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

return 'TelegramCommandRemoveProcessor';