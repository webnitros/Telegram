<?php

class TelegramBotCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'TelegramBot';
    public $classKey = 'TelegramBot';
    public $languageTopics = ['telegram:manager','telegram:bots'];

    /**
     * @return bool
     */
    public function beforeSet()
    {
        $username = trim($this->getProperty('username'));
        if (empty($username)) {
            $this->modx->error->addField('username', $this->modx->lexicon('telegram_bot_err_username'));
        } elseif ($this->modx->getCount($this->classKey, ['username' => $username])) {
            $this->modx->error->addField('username', $this->modx->lexicon('telegram_bot_err_ae'));
        }
        $this->setProperty('mode', 'new');
        return parent::beforeSet();
    }

}

return 'TelegramBotCreateProcessor';
