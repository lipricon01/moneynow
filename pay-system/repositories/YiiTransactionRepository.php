<?php

namespace app\repositories;


use app\modules\transactions\models\Transactions;

class YiiTransactionRepository implements TransactionsRepository
{

    public function generateTransactions()
    {
        $transactionArray = [];

        for ($i = 0; $i <= rand(1, 10); $i++) {
            $transaction = new Transactions();
            $transaction->summ = rand(10, 500);
            $transaction->commission = rand(5, 20)/10;
            $transaction->order_number = rand(1, 20);
            if($transaction->save()){
                $transactionArray[] = $transaction->getAttributes();
            }
        }
        return $transactionArray;
    }

}