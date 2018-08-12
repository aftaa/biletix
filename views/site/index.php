<?php

/* @var $this yii\web\View */
/* @var $error string */
/* @var $flights app\models\Flight[] */
/* @var $form \app\models\MockForm */

$this->title = '';
$this->registerCssFile('@web/css/biletix.css');
$this->registerJsFile('@web/js/biletix.js', [
    'depends'  => \yii\web\JqueryAsset::class,
    'position' => \yii\web\View::POS_END,
]);
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">

            <h1 style="float: right;">
                <?= $form->outbound_date ?>
            </h1>
            <h1>
                <?= $form->ak ?> &nbsp; <?= $form->departure_point ?> &#8644; <?= $form->arrival_point ?>
            </h1>

            <?php if ($error): ?>
                <div class="error">
                    <h3>Возникла ошибка:</h3>
                    <?= $error ?>
                </div>
            <?php else: ?>

                <?php if (count($flights)): ?>
                    <table class="table" cellspacing="10">
                        <?php if ($flights) foreach ($flights as $i => $flight): ?>
                            <tbody class="flight">
                            <tr>
                                <td colspan="9" class="bg-info text-center">
                                    <h2><?= $flight->getPrice() ?></h2>
                                </td>
                            </tr>
                            <?= $this->render('_tickets', ['tickets' => $flight->getTicketsTo()]) ?>
                            <tr>
                                <td colspan="9">
                                    <div class="flight-direction">
                                        Обратно:
                                    </div>
                                </td>
                            </tr>
                            <?= $this->render('_tickets', ['tickets' => $flight->getTicketsBack()]) ?>
                            </tbody>
                        <?php endforeach ?>
                    </table>
                    <?php if (count($flights) > 1): ?>
                        <div class="text-center">
                            <br>
                            <input type="button" class="btn btn-info btn-lg" value="Смотреть другие варианты" id="display-more">
                        </div>
                    <?php endif ?>

                <?php else: ?>
                    <p>Рейсов не найдено</p>
                <?php endif ?>

            <?php endif ?>
        </div>

    </div>
</div>
