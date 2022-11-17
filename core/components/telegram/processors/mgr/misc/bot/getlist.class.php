<?php


class TelegramBotGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'TelegramBot';
    public $classKey = 'TelegramBot';
    public $languageTopics = array('telegram:manager');
    public $defaultSortField = 'username';

    /** {@inheritDoc} */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $id = $this->getProperty('id');
        if (!empty($id) AND $this->getProperty('combo')) {
            $q = $this->modx->newQuery($this->objectType);
            $q->where(array('id!=' => $id));
            $q->select('id');
            $q->limit(11);
            $q->prepare();
            $q->stmt->execute();
            $ids = $q->stmt->fetchAll(PDO::FETCH_COLUMN, 0);
            $ids = array_merge_recursive(array($id), $ids);
            $c->where(array(
                "{$this->objectType}.id:IN" => $ids
            ));
        }

        if ($this->getProperty('combo')) {
            $c->select('id,username');
        }
        $query = $this->getProperty('query');
        if (!empty($query)) {
            $c->where(array('username:LIKE' => '%' . $query . '%'));
        }

        return $c;
    }

    /** {@inheritDoc} */
    public function prepareRow(xPDOObject $object)
    {
        if ($this->getProperty('combo')) {
            $array = array(
                'id'        => $object->get('id'),
                'username' => $object->get('username')
            );
        } else {
            $array = $object->toArray();
        }

        return $array;
    }
}

return 'TelegramBotGetListProcessor';
