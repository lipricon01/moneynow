<?php

namespace app\commands\workers;

use app\services\TransactionService;
use udokmeci\yii2beanstalk\BeanstalkController;

class WorkerController extends BeanstalkController
{
    /**
     * @var TransactionService
     */
    private $transactionService;

    public function __construct($id, $module, TransactionService $transactionService, $config = [])
    {
        $this->transactionService = $transactionService;
        parent::__construct($id, $module, $config);
    }

    public function listenTubes()
    {
        return ["tube"];
    }

    public function actionTube($job)
    {
        $data = $job->getData();
        try {
            if ($data && $this->transactionService->saveTransactions($data)) {
               return self::DELETE;
            }
        } catch (\Exception $exception) {
            return self::BURY;
        }
    }

}