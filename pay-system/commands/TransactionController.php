<?php

namespace app\commands;

use app\repositories\TransactionsRepository;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
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
        $counter = 0;
        while (true) {
            $transactions = ($this->transactionRepository->generateTransactions());
            $signature = KeyHelper::getSignature($transactions);
            $response = $client->post('http://nginx-acceptance/api/transactions', [
                RequestOptions::JSON => [
                    'signature' => $signature,
                    'transactions' => $transactions,
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                $counter++;
                echo "$counter \n";
            }
            sleep(20);
        }
    }
}
