<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    $dev = MODX_BASE_PATH . 'Extras/Telegram/';
    /** @var xPDOCacheManager $cache */
    $cache = $modx->getCacheManager();
    if (file_exists($dev) && $cache) {
        if (!is_link($dev . 'assets/components/telegram')) {
            $cache->deleteTree(
                $dev . 'assets/components/telegram/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_ASSETS_PATH . 'components/telegram/', $dev . 'assets/components/telegram');
        }
        if (!is_link($dev . 'core/components/telegram')) {
            $cache->deleteTree(
                $dev . 'core/components/telegram/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_CORE_PATH . 'components/telegram/', $dev . 'core/components/telegram');
        }
    }
}

return true;