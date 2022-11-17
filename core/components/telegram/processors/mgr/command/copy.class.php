<?php

class TelegramCommandCopyProcessor extends modProcessor
{
    /**
     * @return array|string
     */
    public function process()
    {
        $id = $this->getProperty('id');

        /* @var TelegramCommand $Old */
        if (!$Old = $this->modx->getObject('TelegramCommand', $id)) {
            return $this->failure('Не удалось найти');
        }


        /* @var TelegramCommand $object */
        $object = $this->modx->newObject('TelegramCommand');
        $object->fromArray($Old->toArray());
        $object->set('command', $Old->get('command') . '_copy');
        $object->set('install', false);
        $object->set('active', false);

        if (!$object->save()) {
            return $this->failure('Не удалось сохранить');
        }

        return $this->success();
    }

}

return 'TelegramCommandCopyProcessor';
