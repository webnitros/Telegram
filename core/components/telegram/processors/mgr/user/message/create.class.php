<?php

class TelegramUserMessageCreateProcessor extends modProcessor
{
    /**
     * @return array|string
     */
    public function process()
    {
        $id = $this->getProperty('id');
        $text = $this->getProperty('text');


        /* @var TelegramUser $User */
        if (!$User = $this->modx->getObject('TelegramUser', $id)) {
            return $this->failure('Не удалось найти пользователя');
        }
        $res = $User->message($text);

        if (!$res->isOk()) {
            return $this->failure($res->getDescription());
        }
        return $this->success();
    }

}

return 'TelegramUserMessageCreateProcessor';
