<?php

class TelegramUserCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'TelegramUser';
    public $classKey = 'TelegramUser';
    public $languageTopics = ['telegram:manager','telegram:users'];

    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('telegram_user_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['name' => $name])) {
            $this->modx->error->addField('name', $this->modx->lexicon('telegram_user_err_ae'));
        }
        $this->setProperty('mode', 'new');
        return parent::beforeSet();
    }

}

return 'TelegramUserCreateProcessor';