Telegram.grid.Users = function (config) {
    config = config || {}
    if (!config.id) {
        config.id = 'telegram-grid-users'
    }

    if (!config.multiple) {
        config.multiple = 'user'
    }

    Ext.applyIf(config, {
        baseParams: {
            action: 'mgr/user/getlist',
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
    Telegram.grid.Users.superclass.constructor.call(this, config)
}
Ext.extend(Telegram.grid.Users, Telegram.grid.Default, {

    getFields: function () {
        return [
            'id', 'telegram_id', 'first_name', 'username', 'is_bot', 'createdon', 'updatedon', 'active', 'actions'
        ]
    },

    getColumns: function () {
        return [
            {header: _('telegram_user_id'), dataIndex: 'id', width: 20, sortable: true},
            {header: _('telegram_user_telegram_id'), dataIndex: 'telegram_id', sortable: true, width: 150},
            {header: _('telegram_user_first_name'), dataIndex: 'first_name', sortable: false, width: 150},
            {header: _('telegram_user_username'), dataIndex: 'username', sortable: false, width: 150},
            {header: _('telegram_user_is_bot'), dataIndex: 'is_bot', sortable: false, width: 150, renderer: Telegram.utils.renderBoolean},
            {header: _('telegram_user_createdon'), dataIndex: 'createdon', width: 75},
            {header: _('telegram_user_updatedon'), dataIndex: 'updatedon', width: 75},
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
        return [
            '->', this.getSearchField()]
    },

    getListeners: function () {
        return {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex)
                this.createMessage(grid, e, row)
            },
        }
    },

    createMessage: function (btn, e, row) {
        if (typeof (row) != 'undefined') {
            this.menu.record = row.data
        } else if (!this.menu.record) {
            return false
        }
        var w = MODx.load({
            xtype: 'telegram-user-create-message',
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
        w.setValues({
            id: this.menu.record.id
        })
        w.show(e.target)
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
})
Ext.reg('telegram-grid-users', Telegram.grid.Users)
