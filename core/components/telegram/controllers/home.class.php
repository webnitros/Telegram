<?php

/**
 * The home manager controller for Telegram.
 *
 */
class TelegramHomeManagerController extends modExtraManagerController
{
    /** @var Telegram $Telegram */
    public $Telegram;


    /**
     *
     */
    public function initialize()
    {
        $this->Telegram = $this->modx->getService('Telegram', 'Telegram', MODX_CORE_PATH . 'components/telegram/model/');
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return ['telegram:manager', 'telegram:default', 'telegram:bots', 'telegram:actions', 'telegram:commands', 'telegram:users'];
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('telegram');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->Telegram->config['cssUrl'] . 'mgr/main.css');
        $this->addJavascript($this->Telegram->config['jsUrl'] . 'mgr/telegram.js');
        $this->addJavascript($this->Telegram->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->Telegram->config['jsUrl'] . 'mgr/misc/combo.js');
        $this->addJavascript($this->Telegram->config['jsUrl'] . 'mgr/misc/default.grid.js');
        $this->addJavascript($this->Telegram->config['jsUrl'] . 'mgr/misc/default.window.js');
        $this->addJavascript($this->Telegram->config['jsUrl'] . 'mgr/widgets/bots/grid.js');
        $this->addJavascript($this->Telegram->config['jsUrl'] . 'mgr/widgets/bots/windows.js');
        $this->addJavascript($this->Telegram->config['jsUrl'] . 'mgr/widgets/users/grid.js');
        $this->addJavascript($this->Telegram->config['jsUrl'] . 'mgr/widgets/users/message.js');
        $this->addJavascript($this->Telegram->config['jsUrl'] . 'mgr/widgets/commands/grid.js');
        $this->addJavascript($this->Telegram->config['jsUrl'] . 'mgr/widgets/commands/windows.js');
        $this->addJavascript($this->Telegram->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->Telegram->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addJavascript(MODX_MANAGER_URL . 'assets/modext/util/datetime.js');

        $this->Telegram->config['date_format'] = $this->modx->getOption('telegram_date_format', null, '%d.%m.%y <span class="gray">%H:%M</span>');
        $this->Telegram->config['help_buttons'] = ($buttons = $this->getButtons()) ? $buttons : '';

        $this->addHtml('<script type="text/javascript">
        Telegram.config = ' . json_encode($this->Telegram->config) . ';
        Telegram.config.connector_url = "' . $this->Telegram->config['connectorUrl'] . '";
        Ext.onReady(function() {MODx.load({ xtype: "telegram-page-home"});});
        </script>');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        $this->content .=  '<div id="telegram-panel-home-div"></div>';
        return '';
    }

    /**
     * @return string
     */
    public function getButtons()
    {
        $buttons = null;
        $name = 'Telegram';
        $path = "Extras/{$name}/_build/build.php";
        if (file_exists(MODX_BASE_PATH . $path)) {
            $site_url = $this->modx->getOption('site_url').$path;
            $buttons[] = [
                'url' => $site_url,
                'text' => $this->modx->lexicon('telegram_button_install'),
            ];
            $buttons[] = [
                'url' => $site_url.'?download=1&encryption_disabled=1',
                'text' => $this->modx->lexicon('telegram_button_download'),
            ];
            $buttons[] = [
                'url' => $site_url.'?download=1',
                'text' => $this->modx->lexicon('telegram_button_download_encryption'),
            ];
        }
        return $buttons;
    }
}
