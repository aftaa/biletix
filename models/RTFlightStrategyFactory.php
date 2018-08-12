<?php
/**
 * Created by PhpStorm.
 * User: Maxim Gabidullin <after@ya.ru>
 * Date: 13.08.2018
 * Time: 1:49
 */

namespace app\models;


class RTFlightStrategyFactory
{
    /**
     * @param bool $backTheSameCompany
     *
     * @return RTFlightStrategy
     * @throws \Exception
     */
    public function create(bool $backTheSameCompany): RTFlightStrategy
    {
        switch ($backTheSameCompany) {
            case true:
                return new RTFlightStrategyOneAk;
            case false:
                return new RTFlightStrategyAnyAk;
            default:
                throw new \Exception("Wrong value of param 'backTheSameCompany''");
        }
    }
}