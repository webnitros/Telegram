Telegram.grid.Bots = function (config) {
    config = config || {}
    if (!config.id) {
        config.id = 'telegram-grid-bots'
    }

    if (!config.multiple) {
        config.multiple = 'bot'
    }

    Ext.applyIf(config, {
        baseParams: {
            action: 'mgr/bot/getlist',
            sort: 'id',
            dir: 'DESC'
        },
        stateful: true,
        stateId: config.id,
        viewConfig: {
            forceFit: true,
            enableRowBody: true,
            autoFill: true,
            showPreview: true,
            scrollOffset: 0,
            getRowClass: function (rec) {
                return !rec.data.active
                    ? 'telegram-grid-row-disabled'
                    : ''
            }
        },
        paging: true,
        remoteSort: true,
        autoHeight: true,
    })
    Telegram.grid.Bots.superclass.constructor.call(this, config)
}
Ext.extend(Telegram.grid.Bots, Telegram.grid.Default, {

    getFields: function () {
        return [
            'id', 'username', 'token', 'snippet','webhook_install', 'webhook', 'description', 'createdon', 'updatedon', 'active', 'actions'
        ]
    },

    getColumns: function () {
        return [
            {header: _('telegram_bot_id'), dataIndex: 'id', width: 20, sortable: true},
            {header: _('telegram_bot_username'), dataIndex: 'username', sortable: true, width: 200},
            {header: _('telegram_bot_webhook_install'), dataIndex: 'webhook_install', width: 75, renderer: Telegram.utils.renderBoolean},
            {header: _('telegram_bot_webhook'), dataIndex: 'webhook', sortable: false, width: 250},
            {header: _('telegram_bot_snippet'), dataIndex: 'snippet', sortable: false, width: 250},
            {header: _('telegram_bot_description'), dataIndex: 'description', sortable: false, width: 250},
            {header: _('telegram_bot_createdon'), dataIndex: 'createdon', width: 75},
            {header: _('telegram_bot_updatedon'), dataIndex: 'updatedon', width: 75},
            {header: _('telegram_bot_active'), dataIndex: 'active', width: 75, renderer: Telegram.utils.renderBoolean},
            {
                header: _('telegram_grid_actions'),
                dataIndex: 'actions',
                id: 'actions',
                width: 50,
                renderer: Telegram.utils.renderActions
            }
        ]
    },

    getTopBar: function () {
        return [{
            text: '<i class="icon icon-plus"></i>&nbsp;' + _('telegram_bot_create'),
            handler: this.createItem,
            scope: this
        }, {
            xtype: 'telegram-combo-filter-active',
            name: 'active',
            width: 210,
            custm: true,
            clear: true,
            addall: true,
            value: '',
            listeners: {
                select: {
                    fn: this._filterByCombo,
                    scope: this
                },
                afterrender: {
                    fn: this._filterByCombo,
                    scope: this
                }
            }
        }, {
            xtype: 'telegram-combo-filter-resource',
            name: 'resource',
            width: 210,
            custm: true,
            clear: true,
            addall: true,
            value: '',
            listeners: {
                select: {
                    fn: this._filterByCombo,
                    scope: this
                },
                afterrender: {
                    fn: this._filterByCombo,
                    scope: this
                }
            }
        },
            '->', this.getSearchField()]
    },

    getListeners: function () {
        return {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex)
                this.updateItem(grid, e, row)
            },
        }
    },

    createItem: function (btn, e) {
        var w = MODx.load({
            xtype: 'telegram-bot-window-create',
            id: Ext.id(),
            listeners: {
                success: {
                    fn: function () {
                        this.refresh()
                    }, scope: this
                }
            }
        })
        w.reset()
        w.setValues({active: true})
        w.show(e.target)
    },

    updateItem: function (btn, e, row) {
        if (typeof (row) != 'undefined') {
            this.menu.record = row.data
        } else if (!this.menu.record) {
            return false
        }
        var id = this.menu.record.id

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/bot/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'telegram-bot-window-update',
                            id: Ext.id(),
                            record: r,
                            listeners: {
                                success: {
                                    fn: function () {
                                        this.refresh()
                                    }, scope: this
                                }
                            }
                        })
                        w.reset()
                        w.setValues(r.object)
                        w.show(e.target)
                    }, scope: this
                }
            }
        })
    },

    removeItem: function () {
        this.action('remove')
    },
    disableItem: function () {
        this.action('disable')
    },
    enableItem: function () {
        this.action('enable')
    },
    installWebhook: function () {
        this.action('telegram/webhook/install')
    },
    unInstallWebhook: function () {
        this.action('telegram/webhook/uninstall')
    },
})
Ext.reg('telegram-grid-bots', Telegram.grid.Bots)
