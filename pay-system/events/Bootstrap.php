<?php
namespace app\events;

use Yii;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param  \yii\base\Application  $app  the application currently running
     */
    public function bootstrap($app)
    {
        $container = Yii::$container;
        $container->setSingleton('app\repositories\TransactionsRepository',
            'app\repositories\YiiTransactionRepository');

    }
}