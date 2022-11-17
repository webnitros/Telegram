<?php
include_once dirname(__FILE__).'/CommandTrait.php';
class TelegramCommandCreateProcessor extends modObjectCreateProcessor
{
    use CommandTrait;
    public $objectType = 'TelegramCommand';
    public $classKey = 'TelegramCommand';
    public $languageTopics = ['telegram:manager','telegram:commands'];

    /**
     * @return bool
     */
    public function beforeSet()
    {

$this->checkCommandName();

        $this->setProperty('mode', 'new');
        return parent::beforeSet();
    }

}

return 'TelegramCommandCreateProcessor';
