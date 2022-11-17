<?php

class TelegramUser extends xPDOSimpleObject
{

    /**
     * {@inheritdoc}
     */
    public function save($cacheFlag = null)
    {
        if ($this->isNew()) {
            if (empty($this->get('createdon'))) {
                $this->set('createdon', time());
            }
        } else {
            $this->set('updatedon', time());
        }
        return parent::save();
    }

    public function message($body, $parse_mode = 'markdown')
    {
        /* @var TelegramBot $Bot */
        if ($Bot = $this->getOne('Bot')) {
            return $Bot->telegram()->message($this->get('telegram_id'), $body, $parse_mode);
        }
        return false;
    }

}
