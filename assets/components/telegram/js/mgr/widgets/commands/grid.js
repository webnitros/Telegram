Telegram.grid.Commands = function (config) {
    config = config || {}
    if (!config.id) {
        config.id = 'telegram-grid-commands'
    }

    if (!config.multiple) {
        config.multiple = 'command'
    }

    Ext.applyIf(config, {
        baseParams: {
            action: 'mgr/command/getlist',
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
                    ? 'telegram-row-disabled'
                    : ''
            }
        },
        paging: true,
        remoteSort: true,
        autoHeight: true,
    })
    Telegram.grid.Commands.superclass.constructor.call(this, config)
}
Ext.extend(Telegram.grid.Commands, Telegram.grid.Default, {

    getFields: function () {
        return [
            'id', 'command', 'description', 'bot', 'snippet', 'active', 'createdon','updatedon','install', 'actions'
        ]
    },

    getColumns: function () {
        return [
            {header: _('telegram_command_id'), dataIndex: 'id', width: 20, sortable: true},
            {header: _('telegram_command_bot'), dataIndex: 'bot', sortable: true, width: 200},
            {header: _('telegram_command_command'), dataIndex: 'command', sortable: true, width: 200},
            {header: _('telegram_command_snippet'), dataIndex: 'snippet', sortable: true, width: 200},
            {header: _('telegram_command_description'), dataIndex: 'description', sortable: false, width: 250},
            {header: _('telegram_command_createdon'), dataIndex: 'createdon', width: 75},
            {header: _('telegram_command_updatedon'), dataIndex: 'updatedon', width: 75},
            {header: _('telegram_command_is_install'), dataIndex: 'install', width: 75, renderer: Telegram.utils.renderBoolean},
          /*  {header: _('telegram_command_active'), dataIndex: 'active', width: 75, renderer: Telegram.utils.renderBoolean},*/
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
            text: '<i class="icon icon-plus"></i>&nbsp;' + _('telegram_command_create'),
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
            xtype: 'telegram-combo-filter-bot',
            name: 'bot',
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
            xtype: 'telegram-command-window-create',
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
                action: 'mgr/command/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'telegram-command-window-update',
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
    copyItem: function () {
        this.action('copy')
    },
    installWebhook: function () {
        this.action('telegram/command/install')
    },
    unInstallWebhook: function () {
        this.action('telegram/command/uninstall')
    },
})
Ext.reg('telegram-grid-commands', Telegram.grid.Commands)
