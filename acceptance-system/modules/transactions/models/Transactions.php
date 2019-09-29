<?php

namespace app\modules\transactions\models;

use app\modules\userWallet\models\UserWallet;
use Yii;

/**
 * This is the model class for table "transactions".
 *
 * @property int $id
 * @property int $user_id
 * @property int $transaction_id
 * @property double $summ
 *
 * @property UserWallet $userWalllet
 */
class Transactions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transactions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'transaction_id'], 'integer'],
            [['summ'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'summ' => 'Summ',
            'transaction_id' => 'Transaction ID'
        ];
    }

    public function getUserWallet()
    {
        return $this->hasMany(UserWallet::class, ['user_id' => 'user_id']);
    }

}
