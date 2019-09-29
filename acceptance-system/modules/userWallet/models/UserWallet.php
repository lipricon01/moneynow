<?php

namespace app\modules\userWallet\models;

use Yii;

/**
 * This is the model class for table "user_wallet".
 *
 * @property int $id
 * @property int $user_id
 * @property double $summ
 */
class UserWallet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_wallet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
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
        ];
    }
}
