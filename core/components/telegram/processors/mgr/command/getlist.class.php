<?php

class TelegramCommandGetlistProcessor extends modObjectGetListProcessor
{
    public $objectType = 'TelegramCommand';
    public $classKey = 'TelegramCommand';
    public $languageTopics = ['telegram:manager', 'telegram:commands'];

    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';

    /**
     * We do a special check of permissions
     * because our objects is not an instances of modAccessibleObject
     *
     * @return boolean|string
     */
    public function beforeQuery()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }
        return true;
    }


    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $query = trim($this->getProperty('query'));
        if ($query) {
            $c->where([
                'command:LIKE' => "%%",
                'OR:description:LIKE' => "%%",
            ]);
        }
        $active = $this->getProperty('active');
        if ($active != '') {
            $c->where("active=");
        }
        $bot = trim($this->getProperty('bot'));
        if (!empty($bot)) {
            $c->where("bot_id=" . $bot);
        }
        return $c;
    }


    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {


        $array = $object->toArray();

        $array['bot'] = ($bot = $object->bot()) ? $bot->get('username') : '';

        $array['actions'] = [];


        if (!$array['install']) {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('telegram_command_install'),
                'action' => 'installWebhook',
                'button' => false,
                'menu' => true,
            ];
        } else {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('telegram_command_uninstall'),
                'action' => 'unInstallWebhook',
                'button' => false,
                'menu' => true,
            ];
        }


        // Edit
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('telegram_command_update'),
            'action' => 'updateItem',
            'button' => true,
            'menu' => true,
        ];

        // Copy
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-copy',
            'title' => $this->modx->lexicon('telegram_command_copy'),
            'action' => 'copyItem',
            'button' => false,
            'menu' => true,
        ];

      /*  if (!$array['active']) {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('telegram_command_enable'),
                'multiple' => $this->modx->lexicon('telegram_commands_enable'),
                'action' => 'enableItem',
                'button' => true,
                'menu' => true,
            ];
        } else {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('telegram_command_disable'),
                'multiple' => $this->modx->lexicon('telegram_commands_disable'),
                'action' => 'disableItem',
                'button' => true,
                'menu' => true,
            ];
        }*/

        // Remove
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('telegram_command_remove'),
            'multiple' => $this->modx->lexicon('telegram_commands_remove'),
            'action' => 'removeItem',
            'button' => false,
            'menu' => true,
        ];
        return $array;
    }

}

return 'TelegramCommandGetlistProcessor';
