<?php


namespace app\controllers\api;


use app\services\KeyService;
use app\services\TransactionService;
use function Couchbase\defaultDecoder;
use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\helpers\Json;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\web\UnprocessableEntityHttpException;

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

        $request = Json::decode(Yii::$app->request->getRawBody());
        if (!isset($request['key']) || !$this->keyService->checkKey($request['key'])) {
            throw new ForbiddenHttpException('Wrong key');

        }
        if (isset($request['transactions'])) {
            $transactions = json_decode($request['transactions']);
            Yii::$app->beanstalk->putInTube('tube', $transactions);


        } else {
            throw new UnprocessableEntityHttpException('No transactions send');
        }

    }
}