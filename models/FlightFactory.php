<?php
/**
 * Created by PhpStorm.
 * User: Maxim Gabidullin <after@ya.ru>
 * Date: 11.08.2018
 * Time: 5:53
 */

namespace app\models;


class FlightFactory
{
    /**
     * @param object   $offer
     * @param Currency $currency
     *
     * @return Flight
     */
    public static function createFromWsdlStorageOffer(object $offer, Currency $currency): Flight
    {
        $price = new Cost($offer->products->Product->price, $currency);
        $flight = new Flight($price);

        foreach ($offer->directions->GetOptimalFaresDirection as $direction) {

            $optimalFaresFlight = $direction->flights->GetOptimalFaresFlight;

            if (is_object($optimalFaresFlight)) {
                $flight->addTicket(self::createTicket($direction->direction, $optimalFaresFlight->segments->AirSegment));
            } elseif (is_array($optimalFaresFlight)) {
                foreach ($optimalFaresFlight as $optimalFaresFlight) {
                    $flight->addTicket(self::createTicket($direction->direction, $optimalFaresFlight->segments->AirSegment));
                }
            }
        }
        return $flight;
    }

    /**
     * @param string $direction
     * @param object $airSegment
     *
     * @return Ticket
     */
    private static function createTicket(string $direction, object $airSegment): Ticket
    {
        return TicketFactory::createFromWsdlStorageAirSegment($direction, $airSegment);
    }
}