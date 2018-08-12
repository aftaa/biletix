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
     * @param array $config
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
     * @param array $params
     * @return Flight[]
     * @throws WsdlStorageException
     */
    public function getOptimalFares(array $params): array
    {
        $params['session_token'] = $this->sessionToken;
        $params['hash'] = $this->config['hash'];

        try {
            $optimalFares = $this->client->GetOptimalFares($params);

            if ('OK' != $optimalFares->error->code) {
                throw new WsdlStorageException($optimalFares->error->code);
            }

            $flights = $this->parseOptimalFaresIntoFlights($optimalFares, $params['ak']);
            return $flights;

        } catch (SoapFault $e) {
            throw new WsdlStorageException($e->getMessage(), 0, $e);
        }
    }

    /**
     * @param object $result
     * @param string $ak
     * @return Flight[]
     * @throws \Exception
     */
    public function parseOptimalFaresIntoFlights(object $result, string $ak): array
    {
        $currency = Currency::currencyFactory($result->currency);
        /** @var Flight[] $flights */
        $flights = [];
        if (!empty($result->offers->GetOptimalFaresOffer)) {
            foreach ($result->offers->GetOptimalFaresOffer as $offer) {
                if ($offer->ak == $ak) {
                    $flight = FlightFactory::createFromWsdlStorageOffer($offer, $currency);
                    $flights[] = $flight;
                }
            }
        }
        return $flights;
    }
}