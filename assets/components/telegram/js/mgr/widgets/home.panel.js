Telegram.panel.Home = function (config) {
    config = config || {}
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',

        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('telegram') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            stateful: true,
            stateId: 'telegram-panel-home',
            stateEvents: ['tabchange'],
            getState: function () {return {activeTab: this.items.indexOf(this.getActiveTab())}},
            items: [

                {
                    title: _('telegram_bots'),
                    layout: 'anchor',
                    items: [{
                        html: _('telegram_intro_msg'),
                        cls: 'panel-desc',
                    }, {
                        xtype: 'telegram-grid-bots',
                        cls: 'main-wrapper',
                    }]
                },
                {
                    title: _('telegram_commands'),
                    layout: 'anchor',
                    items: [{
                        html: _('telegram_intro_msg'),
                        cls: 'panel-desc',
                    }, {
                        xtype: 'telegram-grid-commands',
                        cls: 'main-wrapper',
                    }]
                },
                {
                    title: _('telegram_users'),
                    layout: 'anchor',
                    items: [{
                        html: _('telegram_intro_msg'),
                        cls: 'panel-desc',
                    }, {
                        xtype: 'telegram-grid-users',
                        cls: 'main-wrapper',
                    }]
                },
            ]
        }]
    })
    Telegram.panel.Home.superclass.constructor.call(this, config)
}
Ext.extend(Telegram.panel.Home, MODx.Panel)
Ext.reg('telegram-panel-home', Telegram.panel.Home)

Ext.onReady(function () {
    if (Telegram.config.help_buttons.length > 0) {
        Telegram.buttons.help = function (config) {
            config = config || {}
            for (var i = 0; i < Telegram.config.help_buttons.length; i++) {
                if (!Telegram.config.help_buttons.hasOwnProperty(i)) {
                    continue
                }
                Telegram.config.help_buttons[i]['handler'] = this.loadPaneURl
            }
            Ext.applyIf(config, {
                buttons: Telegram.config.help_buttons
            })
            Telegram.buttons.help.superclass.constructor.call(this, config)
        }
        Ext.extend(Telegram.buttons.help, MODx.toolbar.ActionButtons, {
            loadPaneURl: function (b) {
                var url = b.url
                var text = b.text
                if (!url || !url.length) { return false }
                if (url.substring(0, 4) !== 'http') {
                    url = MODx.config.base_help_url + url
                }
                MODx.helpWindow = new Ext.Window({
                    title: text
                    , width: 850
                    , height: 350
                    , resizable: true
                    , maximizable: true
                    , modal: false
                    , layout: 'fit'
                    , bodyStyle: 'padding: 0;'
                    , items: [{
                        xtype: 'container',
                        layout: {
                            type: 'vbox',
                            align: 'stretch'
                        },
                        width: '100%',
                        height: '100%',
                        items: [{
                            autoEl: {
                                tag: 'iframe',
                                src: url,
                                width: '100%',
                                height: '100%',
                                frameBorder: 0
                            }
                        }]
                    }]
                    //,html: '<iframe src="' + url + '" width="100%" height="100%" frameborder="0"></iframe>'
                })
                MODx.helpWindow.show(b)
                return true
            }
        })

        Ext.reg('telegram-buttons-help', Telegram.buttons.help)
        MODx.add('telegram-buttons-help')
    }
})
