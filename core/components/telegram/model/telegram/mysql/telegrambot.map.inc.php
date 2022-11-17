<?php
$xpdo_meta_map['TelegramBot']= array (
  'package' => 'telegram',
  'version' => '1.1',
  'table' => 'telegram_bots',
  'extends' => 'xPDOSimpleObject',
  'tableMeta' => 
  array (
    'engine' => 'InnoDB',
  ),
  'fields' => 
  array (
    'username' => '',
    'token' => '',
    'webhook' => '',
    'description' => '',
    'snippet' => '',
    'updatedon' => 0,
    'createdon' => 0,
    'active' => 1,
    'webhook_install' => 0,
  ),
  'fieldMeta' => 
  array (
    'username' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'token' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '256',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'webhook' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '500',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'snippet' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'updatedon' => 
    array (
      'dbtype' => 'int',
      'precision' => '20',
      'phptype' => 'timestamp',
      'null' => false,
      'default' => 0,
    ),
    'createdon' => 
    array (
      'dbtype' => 'int',
      'precision' => '20',
      'phptype' => 'timestamp',
      'null' => false,
      'default' => 0,
    ),
    'active' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'null' => true,
      'default' => 1,
    ),
    'webhook_install' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'null' => true,
      'default' => 0,
    ),
  ),
  'indexes' => 
  array (
    'username' => 
    array (
      'alias' => 'username',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'username' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'snippet' => 
    array (
      'alias' => 'snippet',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'snippet' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'token' => 
    array (
      'alias' => 'token',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'token' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'active' => 
    array (
      'alias' => 'active',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'active' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'webhook_install' => 
    array (
      'alias' => 'webhook_install',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'webhook_install' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'composites' => 
  array (
    'Commands' => 
    array (
      'class' => 'TelegramCommand',
      'local' => 'id',
      'foreign' => 'bot_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
