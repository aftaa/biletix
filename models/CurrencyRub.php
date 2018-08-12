<?php
/**
 * Created by PhpStorm.
 * User: Maxim Gabidullin <after@ya.ru>
 * Date: 09.08.2018
 * Time: 2:31
 */

namespace app\models;


class CurrencyRub extends Currency
{
    public function getSign(): string
    {
        return '₽';
    }

}