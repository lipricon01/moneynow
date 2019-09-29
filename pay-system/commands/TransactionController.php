<?php

namespace app\commands;

use app\repositories\TransactionsRepository;
use GuzzleHttp\Client;
use yii\console\Controller;
use app\helpers\KeyHelper;

class TransactionController extends Controller
{

    /**
     * @var TransactionsRepository
     */
    private $transactionRepository;

    public function __construct($id, $module, TransactionsRepository $transactionsRepository, $config = [])
    {
        $this->transactionRepository = $transactionsRepository;

        parent::__construct($id, $module, $config);
    }

    public function actionSendTransaction()
    {
        $client = new Client();
        $key = KeyHelper::getKey();
        $transactions = json_encode($this->transactionRepository->generateTransactions());
        var_dump($transactions);die;
        $response = $client->post('http://localhost:81/api/transactions', [
            'json' => [
                'key' => $key,
                'transactions' => $transactions,
            ],
        ]);

        var_dump((string)$response);die;
        // while (true) {
           
        //     sleep(20);
        // }

    }
}
