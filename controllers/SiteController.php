<?php

namespace app\controllers;

use app\models\MockForm;
use app\models\WsdlStorage;
use app\models\WsdlStorageException;
use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays the test task.
     *
     * @return string
     */
    public function actionIndex()
    {
        try {
            $config = Yii::$app->params['biletix'];
            $form = new MockForm;
            $storage = new WsdlStorage($config);
            $flights = $storage->getOptimalFares($form->toArray());

            return $this->render('index', [
                'flights' => $flights,
                'form'    => $form,
            ]);

        } catch (WsdlStorageException $e) {
            return $this->render('index', [
                'error' => $e->getMessage(),
            ]);
        }

    }

}
