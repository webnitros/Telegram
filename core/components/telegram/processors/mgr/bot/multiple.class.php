<?php
class TelegramBotMultipleProcessor extends modProcessor
{
   /**
     * @return array|string
     */
    public function process()
    {
        if (!$method = $this->getProperty('method', false)) {
            return $this->failure();
        }
        $ids = json_decode($this->getProperty('ids'), true);
        if (empty($ids)) {
            return $this->success();
        }

        /** @var Telegram $Service */
        $Service = $this->modx->getService('Telegram');
        foreach ($ids as $id) {
            /** @var modProcessorResponse $response */
            $response = $Service->runProcessor('mgr/bot/' . $method, array('id' => $id), array(
                'processors_path' => MODX_CORE_PATH . 'components/telegram/processors/'
            ));
            if ($response->isError()) {
                return $response->getResponse();
            }
        }

        return $this->success();
    }

}

return 'TelegramBotMultipleProcessor';