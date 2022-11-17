Telegram.window.CreateMessage = function (config) {
    config = config || {}
    config.url = Telegram.config.connector_url

    Ext.applyIf(config, {
        title: _('telegram_message'),
        width: 600,
        cls: 'telegram_windows',
        baseParams: {
            action: 'mgr/user/message/create',
        }
    })
    Telegram.window.CreateMessage.superclass.constructor.call(this, config)
}
Ext.extend(Telegram.window.CreateMessage, Telegram.window.Default, {

    getFields: function (config) {
        return [
            {xtype: 'hidden', name: 'id', id: config.id + '-id'},
            {
                xtype: 'textarea',
                fieldLabel: _('telegram_message_text'),
                name: 'text',
                id: config.id + '-text',
                height: 100,
                anchor: '99%'
            }
        ]
    }
})
Ext.reg('telegram-user-create-message', Telegram.window.CreateMessage)
