<?php
/**
 * Created by PhpStorm.
 * User: Maxim Gabidullin <after@ya.ru>
 * Date: 09.08.2018
 * Time: 2:33
 */

namespace app\models;


class Cost
{
    /** @var mixed Цена */
    private $cost;
    /** @var Currency */
    private $currency;

    /**
     * Cost constructor.
     * @param mixed $cost
     * @param Currency $currency
     */
    public function __construct($cost, Currency $currency)
    {
        $this->cost = $cost;
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getCost(): string
    {
        $cost = number_format($this->cost, 0, ',', ' ');
        return $cost;
    }

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        $s = $this->getCost();
        $s .= " $this->currency";
        return $s;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}