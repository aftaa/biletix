<?php
/**
 * Created by PhpStorm.
 * User: Maxim Gabidullin <after@ya.ru>
 * Date: 11.08.2018
 * Time: 6:24
 */

namespace app\models;


use DateTime;
use yii\base\Model;

class MockForm extends Model
{
    public $owrt = 'RT';
    public $adult_count = 1;
    public $departure_point = 'MOW';
    public $arrival_point = 'LED';
    public $ak = 'S7';
    /** @var DateTime */
    public $return_date;
    /** @var DateTime */
    public $outbound_date;

    /**
     * Form constructor.
     */
    public function __construct()
    {
        parent::__construct([]);
        $date = new Datetime('now + 1day');
        $date = $date->format('d.m.Y');
        $this->return_date = $date;
        $this->outbound_date = $date;
    }
}