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
        $counter = 0;

         while (true) {
             $transactions = json_encode($this->transactionRepository->generateTransactions());
             $response = $client->post('http://nginx-acceptance/api/transactions', [
                 'json' => [
                     'key' => $key,
                     'transactions' => $transactions,
                 ],
             ]);

             if ($response->getStatusCode() == 200){
                 $counter++;
                 echo "$counter \n";
             }
             sleep(20);
         }
    }
}
