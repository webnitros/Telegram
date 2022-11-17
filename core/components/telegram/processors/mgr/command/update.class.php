<?php
include_once dirname(__FILE__).'/CommandTrait.php';

class TelegramCommandUpdateProcessor extends modObjectUpdateProcessor
{
    use CommandTrait;
    /* @var TelegramCommand $object */
    public $object;
    public $objectType = 'TelegramCommand';
    public $classKey = 'TelegramCommand';
    public $languageTopics = ['telegram:manager', 'telegram:commands'];

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
        $name = trim($this->getProperty('command'));
        if (empty($id)) {
            return $this->modx->lexicon('telegram_command_err_ns');
        }


        $this->checkCommandName();



        return parent::beforeSet();
    }

}

return 'TelegramCommandUpdateProcessor';
