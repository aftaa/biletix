<?php
/**
 * Created by PhpStorm.
 * User: Maxim Gabidullin <after@ya.ru>
 * Date: 11.08.2018
 * Time: 5:53
 */

namespace app\models;


class RTFlightFactory
{
    /**
     * @param object           $offer
     * @param Currency         $currency
     * @param string           $ak
     * @param RTFlightStrategy $flightStrategy
     *
     * @return RTFlight
     */
    public static function createFromWsdlStorageOffer(object $offer, Currency $currency, string $ak, RTFlightStrategy $flightStrategy): RTFlight
    {
        $price = new Cost($offer->products->Product->price, $currency);
        $flight = new RTFlight($price, $ak, $flightStrategy);

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