var Telegram = function (config) {
    config = config || {};
    Telegram.superclass.constructor.call(this, config);
};
Ext.extend(Telegram, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}, buttons: {}
});
Ext.reg('telegram', Telegram);

Telegram = new Telegram();