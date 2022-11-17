Telegram.window.CreateCommand = function (config) {
    config = config || {}
    config.url = Telegram.config.connector_url

    Ext.applyIf(config, {
        title: _('telegram_command_create'),
        width: 600,
        cls: 'telegram_windows',
        baseParams: {
            action: 'mgr/command/create',
            resource_id: config.resource_id
        }
    })
    Telegram.window.CreateCommand.superclass.constructor.call(this, config)

    this.on('success', function (data) {
        if (data.a.result.object) {
            // Авто запуск при создании новой подписик
            if (data.a.result.object.mode) {
                if (data.a.result.object.mode === 'new') {
                    var grid = Ext.getCmp('telegram-grid-commands')
                    grid.updateItem(grid, '', {data: data.a.result.object})
                }
            }
        }
    }, this)
}
Ext.extend(Telegram.window.CreateCommand, Telegram.window.Default, {

    getFields: function (config) {

        var install = false
        if (config.record && config.record.object) {
            if (config.record.object.install) {
                install = true
            }
        }

        return [
            {xtype: 'hidden', name: 'id', id: config.id + '-id'},
            {
                xtype: 'telegram-combo-filter-bot',
                fieldLabel: _('telegram_command_bot_id'),
                name: 'bot_id',
                id: config.id + '-bot_id',
                height: 150,
                anchor: '99%'
            }, {
                xtype: 'textfield',
                fieldLabel: _('telegram_command_command'),
                name: 'command',
                id: config.id + '-command',
                anchor: '99%',
                allowBlank: false,
                readOnly: install,
            }, {
                xtype: 'textarea',
                fieldLabel: _('telegram_command_description'),
                description: _('telegram_command_description_desc'),
                name: 'description',
                id: config.id + '-description',
                height: 100,
                anchor: '99%',
                allowBlank: false
            }, {
                xtype: 'textfield',
                fieldLabel: _('telegram_command_snippet'),
                name: 'snippet',
                id: config.id + '-snippet',
                anchor: '99%',
                allowBlank: true
            }, {
                html: _('telegram_command_snippet_desc'),
                cls: 'telegram-windows-description',
            }/*,   {
                xtype: 'xcheckbox',
                boxLabel: _('telegram_command_active'),
                name: 'active',
                id: config.id + '-active',
                checked: true,
            }*/
        ]

    }
})
Ext.reg('telegram-command-window-create', Telegram.window.CreateCommand)

Telegram.window.UpdateCommand = function (config) {
    config = config || {}

    Ext.applyIf(config, {
        title: _('telegram_command_update'),
        baseParams: {
            action: 'mgr/command/update',
            resource_id: config.resource_id
        },
    })
    Telegram.window.UpdateCommand.superclass.constructor.call(this, config)
}
Ext.extend(Telegram.window.UpdateCommand, Telegram.window.CreateCommand)
Ext.reg('telegram-command-window-update', Telegram.window.UpdateCommand)
