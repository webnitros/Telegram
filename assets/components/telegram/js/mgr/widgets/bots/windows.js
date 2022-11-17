Telegram.window.CreateBot = function (config) {
    config = config || {}
    config.url = Telegram.config.connector_url

    Ext.applyIf(config, {
        title: _('telegram_bot_create'),
        width: 600,
        cls: 'telegram_windows',
        baseParams: {
            action: 'mgr/bot/create',
            resource_id: config.resource_id
        }
    })
    Telegram.window.CreateBot.superclass.constructor.call(this, config)

    this.on('success', function (data) {
        if (data.a.result.object) {
            // Авто запуск при создании новой подписик
            if (data.a.result.object.mode) {
                if (data.a.result.object.mode === 'new') {
                    var grid = Ext.getCmp('telegram-grid-bots')
                    grid.updateItem(grid, '', {data: data.a.result.object})
                }
            }
        }
    }, this)
}
Ext.extend(Telegram.window.CreateBot, Telegram.window.Default, {

    getFields: function (config) {
        return [
            {xtype: 'hidden', name: 'id', id: config.id + '-id'},
            {
                xtype: 'textfield',
                fieldLabel: _('telegram_bot_username'),
                name: 'username',
                id: config.id + '-username',
                anchor: '99%',
                allowBlank: false,
            }, {
                xtype: 'textfield',
                fieldLabel: _('telegram_bot_token'),
                name: 'token',
                id: config.id + '-token',
                anchor: '99%',
                allowBlank: false,
            }, {
                xtype: 'textfield',
                fieldLabel: _('telegram_bot_webhook'),
                name: 'webhook',
                id: config.id + '-webhook',
                anchor: '99%',
                allowBlank: false,
            }, {
                xtype: 'textfield',
                fieldLabel: _('telegram_bot_snippet'),
                name: 'snippet',
                id: config.id + '-snippet',
                anchor: '99%',
                allowBlank: true,
            }, {
                html: _('telegram_bot_snippet_desc'),
                cls: 'telegram-windows-description',
            }, {
                xtype: 'textarea',
                fieldLabel: _('telegram_bot_description'),
                name: 'description',
                id: config.id + '-description',
                height: 100,
                anchor: '99%'
            }, {
                xtype: 'xcheckbox',
                boxLabel: _('telegram_bot_active'),
                name: 'active',
                id: config.id + '-active',
                checked: true,
            }
        ]

    }
})
Ext.reg('telegram-bot-window-create', Telegram.window.CreateBot)

Telegram.window.UpdateBot = function (config) {
    config = config || {}

    Ext.applyIf(config, {
        title: _('telegram_bot_update'),
        baseParams: {
            action: 'mgr/bot/update',
            resource_id: config.resource_id
        },
    })
    Telegram.window.UpdateBot.superclass.constructor.call(this, config)
}
Ext.extend(Telegram.window.UpdateBot, Telegram.window.CreateBot)
Ext.reg('telegram-bot-window-update', Telegram.window.UpdateBot)
