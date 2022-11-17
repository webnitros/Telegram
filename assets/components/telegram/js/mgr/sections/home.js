Telegram.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'telegram-panel-home',
            renderTo: 'telegram-panel-home-div'
        }]
    });
    Telegram.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(Telegram.page.Home, MODx.Component);
Ext.reg('telegram-page-home', Telegram.page.Home);