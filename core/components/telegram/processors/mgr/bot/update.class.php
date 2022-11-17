<?php

class TelegramBotUpdateProcessor extends modObjectUpdateProcessor
{
    /* @var TelegramBot $object */
    public $object;
    public $objectType = 'TelegramBot';
    public $classKey = 'TelegramBot';
    public $languageTopics = ['telegram:manager', 'telegram:bots'];

    /**
     * We doing special check of permission
     * because of our objects is not an instances of modAccessibleObject
     *
     * @return bool|string
     */
    public function beforeSave()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return true;
    }


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $id = (int)$this->getProperty('id');
        $username = trim($this->getProperty('username'));
        if (empty($id)) {
            return $this->modx->lexicon('telegram_bot_err_ns');
        }

        if (empty($username)) {
            $this->modx->error->addField('username', $this->modx->lexicon('telegram_bot_err_username'));
        } elseif ($this->modx->getCount($this->classKey, ['username' => $username, 'id:!=' => $id])) {
            $this->modx->error->addField('username', $this->modx->lexicon('telegram_bot_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'TelegramBotUpdateProcessor';
