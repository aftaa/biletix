<?php
/**
 * Created by PhpStorm.
 * User: Maxim Gabidullin <after@ya.ru>
 * Date: 10.08.2018
 * Time: 16:38
 */

namespace app\models;


class TicketFactory
{
    const WSDL_DIRECTIONS = [
        'TO' => TicketTo::class,
        'BACK' => TicketBack::class
    ];

    /**
     * @param string $direction
     * @param object $segment
     * @return Ticket
     */
    public static function createFromWsdlStorageAirSegment(string $direction, object $segment): Ticket
    {
        $class = self::WSDL_DIRECTIONS[$direction];
        /** @var Ticket $ticket */
        $ticket = new $class;
        $ticket->setDepartureFrom($segment->departure_airport_code);
        $ticket->setDepartureAt(new \DateTime($segment->departure_utc));
        $ticket->setArrivalTo($segment->arrival_airport_code);
        $ticket->setArrivalAt(new \DateTime($segment->arrival_utc));
        $ticket->setDuration($segment->duration);
        $ticket->setAk($segment->ak);
        $ticket->setFlightNumber($segment->flight_number);
        return $ticket;
    }
}