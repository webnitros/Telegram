<?php
class TelegramUserGetlistProcessor extends modObjectGetListProcessor
{
    public $objectType = 'TelegramUser';
    public $classKey = 'TelegramUser';
    public $languageTopics = ['telegram:manager','telegram:users'];

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
                'username:LIKE' => "%%",
                'OR:first_name:LIKE' => "%%",
            ]);
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

        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-send',
            'title' => $this->modx->lexicon('telegram_message_create'),
            'action' => 'createMessage',
            'button' => true,
            'menu' => true,
        ];


        /* // Edit
        $array['actions'][] = [
             'cls' => '',
             'icon' => 'icon icon-edit',
             'title' => $this->modx->lexicon('telegram_user_update'),
             'action' => 'updateItem',
             'button' => true,
             'menu' => true,
         ];

         if (!$array['active']) {
             $array['actions'][] = [
                 'cls' => '',
                 'icon' => 'icon icon-power-off action-green',
                 'title' => $this->modx->lexicon('telegram_user_enable'),
                 'multiple' => $this->modx->lexicon('telegram_users_enable'),
                 'action' => 'enableItem',
                 'button' => true,
                 'menu' => true,
             ];
         } else {
             $array['actions'][] = [
                 'cls' => '',
                 'icon' => 'icon icon-power-off action-gray',
                 'title' => $this->modx->lexicon('telegram_user_disable'),
                 'multiple' => $this->modx->lexicon('telegram_users_disable'),
                 'action' => 'disableItem',
                 'button' => true,
                 'menu' => true,
             ];
         }

         // Remove
         $array['actions'][] = [
             'cls' => '',
             'icon' => 'icon icon-trash-o action-red',
             'title' => $this->modx->lexicon('telegram_user_remove'),
             'multiple' => $this->modx->lexicon('telegram_users_remove'),
             'action' => 'removeItem',
             'button' => true,
             'menu' => true,
         ];*/
        return $array;
    }

}

return 'TelegramUserGetlistProcessor';
