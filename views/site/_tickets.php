<?php
/**
 * Created by PhpStorm.
 * User: Maxim Gabidullin <after@ya.ru>
 * Date: 12.08.2018
 * Time: 3:07
 */

/** @var $this \yii\web\View */
/** @var $tickets \app\models\Ticket[] */

?>

<?php foreach ($tickets as $ticket): ?>
    <tr class="flight">
        <td>
            <h4><?= $ticket->getAk() ?></h4>
            Рейс №<strong><?= $ticket->getFlightNumber() ?></strong>
        </td>
        <td><br><h4 class="text-muted text-right">Вылет:</h4></td>
        <td>
            <h3>✈ <?= $ticket->getDepartureFrom() ?></h3>
            <h4><?= $ticket->getDepartureAt()->format('d.m H:i') ?></h4>
        </td>
        <td><br><h4 class="text-muted text-right">Прилет:</h4></td>
        <td>

            <h3>✈ <?= $ticket->getArrivalTo() ?></h3>
            <h4><?= $ticket->getArrivalAt()->format('d.m H:i') ?></h4>
        </td>
        <td>
            <br>
            <h6><span class="text-muted">Время в пути: </span></h6>
            <div><?= $ticket->getDuration() ?></div>
        </td>
    </tr>
<?php endforeach ?>
