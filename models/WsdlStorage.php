<?php
/**
 * Created by PhpStorm.
 * User: Maxim Gabidullin <after@ya.ru>
 * Date: 09.08.2018
 * Time: 4:30
 */

namespace app\models;


use SoapClient;
use SoapFault;

/**
 * Class WsdlStorage
 * @package app\models
 */
class WsdlStorage
{
    /** @var SoapClient */
    private $client;

    /** @var string */
    private $sessionToken;

    /** @var array */
    private $config = [];

    /**
     * WsdlStorage constructor.
     *
     * @param array $config
     *
     * @throws WsdlStorageException
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->startSession();
    }

    /**
     * @throws WsdlStorageException
     */
    public function startSession(): void
    {
        try {
            $this->client = new SoapClient($this->config['wsdl']);
            $result = $this->client->StartSession($this->config['auth']);

            if ('OK' != $result->error->code) {
                throw new WsdlStorageException($result->error->code);
            }

            $this->sessionToken = $result->session_token;
        } catch (SoapFault $e) {
            throw new WsdlStorageException($e->getMessage(), 0, $e);
        }
    }

    /**
     * @param array $form
     *
     * @return RTFlight[]
     * @throws WsdlStorageException
     */
    public function getOptimalFares(array $form): array
    {
        $form['session_token'] = $this->sessionToken;
        $form['hash'] = $this->config['hash'];

        try {
            $optimalFares = $this->client->GetOptimalFares($form);

            if ('OK' != $optimalFares->error->code) {
                throw new WsdlStorageException($optimalFares->error->code);
            }

            $flights = $this->parseOptimalFaresIntoFlights($optimalFares, $form['ak']);
            return $flights;

        } catch (SoapFault $e) {
            throw new WsdlStorageException($e->getMessage(), 0, $e);
        }
    }

    /**
     * @param object $result
     * @param string $ak
     *
     * @return RTFlight[]
     * @throws \Exception
     */
    public function parseOptimalFaresIntoFlights(object $result, string $ak): array
    {
        $currency = Currency::currencyFactory($result->currency);
        $flightStrategy = RTFlightStrategyFactory::create($this->config['backTheSameCompany']);

        /** @var RTFlight[] $flights */
        $flights = [];
        if (!empty($result->offers->GetOptimalFaresOffer)) {
            foreach ($result->offers->GetOptimalFaresOffer as $offer) {
                if ($offer->ak == $ak) {
                    $flight = RTFlightFactory::createFromWsdlStorageOffer($offer, $currency, $ak, $flightStrategy);
                    if ($flight->hasTickets()) {
                        $flights[] = $flight;
                    }
                }
            }
        }
        return $flights;
    }
}