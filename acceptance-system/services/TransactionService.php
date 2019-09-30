<?php

namespace app\services;

use app\modules\transactions\models\Transactions;
use app\modules\userWallet\models\UserWallet;
use Yii;

class TransactionService
{
    public function saveTransactions($transactions)
    {
        $dbTransaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($transactions as $index => $transaction) {
                $transactionModel = new Transactions();
                $transactionModel->summ = $transaction->summ + $transaction->summ * ($transaction->commission / 10);
                $transactionModel->user_id = $transaction->order_number;
                $transactionModel->transaction_id = $transaction->id;
                if ($transactionModel->save()) {
                    $this->updateOrCreateUserWallet($transactionModel);
                }
            }
            $dbTransaction->commit();
        } catch (\Exception $exception) {
            $dbTransaction->rollBack();
            throw $exception;
        }

        return true;
    }

    private function updateOrCreateUserWallet(Transactions $transaction)
    {
        $userWallet = UserWallet::findOne(['user_id' => $transaction->user_id]);

        if ($userWallet){
            $userWallet->summ += $transaction->summ;
        }else{
            $userWallet = new UserWallet();
            $userWallet->user_id = $transaction->user_id;
            $userWallet->summ = $transaction->summ;
        }
        $userWallet->save();
    }

}