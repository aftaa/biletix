<?php
/**
 * Created by PhpStorm.
 * User: Maxim Gabidullin <after@ya.ru>
 * Date: 09.08.2018
 * Time: 2:25
 */

namespace app\models;


use \Exception;

abstract class Currency
{
    /**
     * @return string
     */
    abstract public function getSign(): string;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getSign();
    }

    /**
     * @param string $currency
     * @return Currency
     * @throws Exception
     */
    public static function currencyFactory($currency): Currency
    {
        switch ($currency) {
            case 'RUR':
                return new CurrencyRub;
            default:
                throw new Exception("Валюта $currency не поддерживается");
        }
    }
}