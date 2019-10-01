<?php


namespace app\controllers\api;


use app\services\KeyService;
use app\services\TransactionService;
use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\rest\Controller;
use yii\web\Response;

class ApiController extends Controller
{
    /**
     * @var TransactionService
     */
    private $transactionService;

    /**
     * @var KeyService
     */
    private $keyService;

    public function __construct(
        $id,
        $module,
        TransactionService $transactionService,
        KeyService $keyService,
        $config = []
    ) {
        $this->transactionService = $transactionService;
        $this->keyService = $keyService;
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        return $behaviors;
    }

    public function actionTransactions()
    {
        $request = json_decode(Yii::$app->request->getRawBody());
        if (!isset($request->signature) || !isset($request->transactions)) {
            throw new \Exception('No transactions or signature');
        }

        if($this->keyService->checkKey($request->signature, $request->transactions) == true){
            Yii::$app->beanstalk->putInTube('tube', $request->transactions);
        };
    }
}