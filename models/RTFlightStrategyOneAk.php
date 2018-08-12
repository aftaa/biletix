<?php
/**
 * Created by PhpStorm.
 * User: Maxim Gabidullin <after@ya.ru>
 * Date: 13.08.2018
 * Time: 1:42
 */

namespace app\models;


class RTFlightStrategyOneAk implements RTFlightStrategy
{
    /**
     * @param RTFlight $flight
     * @param Ticket   $ticket
     *
     * @return bool
     */
    public function ticketCorrect(RTFlight $flight, Ticket $ticket): bool
    {
        return $flight->getAk() == $ticket->getAk();
    }
}