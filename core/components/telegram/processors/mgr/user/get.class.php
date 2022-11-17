<?php
class TelegramUserGetProcessor extends modObjectGetProcessor
{
    public $objectType = 'TelegramUser';
    public $classKey = 'TelegramUser';
    public $languageTopics = ['telegram:manager','telegram:users'];
    
    /**
     * We doing special check of permission
     * because of our objects is not an instances of modAccessibleObject
     *
     * @return mixed
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        return parent::process();
    }
}

return 'TelegramUserGetProcessor';