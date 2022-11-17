<?php

/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 14.08.2022
 * Time: 09:59
 *
 * @property modX $modx
 * @property string $classKey
 */
trait CommandTrait
{

    public function checkCommandName()
    {
        $command = strtolower(trim($this->getProperty('command')));
        $criteria = [
            'command' => $command
        ];

        $id = (int)$this->getProperty('id');
        if (!empty($id)) {
            $criteria['id:!='] = $id;
        }

        if (empty($command)) {
            $this->modx->error->addField('command', $this->modx->lexicon('telegram_command_err_command'));
        } else if (!preg_match('~^[a-z0-9_\-]*$~i',$command)) {
       # } else if (!preg_match('/^[^\'\\x3c\\x3e\\(\\);\\x22]+$/', $command)) {
            $this->modx->error->addField('command', $this->modx->lexicon('telegram_command_invalid'));
        } elseif ($this->modx->getCount($this->classKey, $criteria)) {
            $this->modx->error->addField('command', $this->modx->lexicon('telegram_command_err_ae'));
        }


        $botId = (int)$this->getProperty('bot_id');

        if (empty($botId)) {
            $this->modx->error->addField('bot_id', $this->modx->lexicon('telegram_command_err_bot'));
        } else {
            $count = $this->modx->getCount('TelegramBot', array('id' => $botId));
            if ($count === 0) {
                $this->modx->error->addField('bot_id', $this->modx->lexicon('telegram_command_err_bot_id'));

            }
        }
    }
}
