<?php


use app\services\KeyService;
use app\services\TransactionService;
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
        $container->setSingleton(TransactionService::class);
        $container->setSingleton(KeyService::class);

    }
}