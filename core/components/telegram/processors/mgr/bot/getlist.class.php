<?php

class TelegramBotGetlistProcessor extends modObjectGetListProcessor
{
    public $objectType = 'TelegramBot';
    public $classKey = 'TelegramBot';
    public $languageTopics = ['telegram:manager', 'telegram:bots'];

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
                'name:LIKE' => "%%",
                'OR:description:LIKE' => "%%",
            ]);
        }
        $active = $this->getProperty('active');
        if ($active != '') {
            $c->where(".active=");
        }
        $resource = trim($this->getProperty('resource'));
        if (!empty($resource)) {
            $c->where(".resource_id=");
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

        $array['actions'] = [];


        if (!$array['webhook_install']) {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('telegram_bot_install_webhook'),
                'action' => 'installWebhook',
                'button' => false,
                'menu' => true,
            ];
        } else {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('telegram_bot_uninstall_webhook'),
                'action' => 'unInstallWebhook',
                'button' => false,
                'menu' => true,
            ];
        }


        // Edit
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('telegram_bot_update'),
            'action' => 'updateItem',
            'button' => true,
            'menu' => true,
        ];

        if (!$array['active']) {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('telegram_bot_enable'),
                'multiple' => $this->modx->lexicon('telegram_bots_enable'),
                'action' => 'enableItem',
                'button' => true,
                'menu' => true,
            ];
        } else {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('telegram_bot_disable'),
                'multiple' => $this->modx->lexicon('telegram_bots_disable'),
                'action' => 'disableItem',
                'button' => true,
                'menu' => true,
            ];
        }

        // Remove
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('telegram_bot_remove'),
            'multiple' => $this->modx->lexicon('telegram_bots_remove'),
            'action' => 'removeItem',
            'button' => true,
            'menu' => true,
        ];
        return $array;
    }

}

return 'TelegramBotGetlistProcessor';
