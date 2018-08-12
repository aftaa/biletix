<?php
/**
 * Created by PhpStorm.
 * User: Maxim Gabidullin <after@ya.ru>
 * Date: 09.08.2018
 * Time: 2:15
 */

namespace app\models;


class Ticket
{
    /** @var string Номер рейса */
    private $flightNumber;

    /** @var string продолжительность перелета ЧЧ:ММ */
    private $duration;

    /** @var \DateTime День и время вылета */
    private $departureAt;

    /** @var string Аэропорт вылета */
    private $departureFrom;

    /** @var \DateTime День и время прилета */
    private $arrivalAt;

    /** @var string Аэропорт прилета */
    private $arrivalTo;

    /** @var string Авиакомпания */
    private $ak;

    /**
     * Ticket constructor.
     * @param array $config
     * @throws \InvalidArgumentException
     */
    public function __construct(array $config = [])
    {
        foreach ($config as $key => $value) {
            $method = "set$key";
            if (!method_exists($this, $method)) {
                throw new \InvalidArgumentException("Property $key not found in class " . static::class);
            }
            $this->$method($value);
        }
    }

    /**
     * @return string
     */
    public function getFlightNumber(): ?string
    {
        return $this->flightNumber;
    }

    /**
     * @param string $flightNumber
     */
    public function setFlightNumber(string $flightNumber): void
    {
        $this->flightNumber = $flightNumber;
    }

    /**
     * @return string
     */
    public function getDuration(): string
    {
        return $this->duration;
    }

    /**
     * @param int
     */
    public function setDuration(int $duration): void
    {
        $duration = date('H:i', $duration);
        $this->duration = $duration;
    }

    /**
     * @return \DateTime
     */
    public function getDepartureAt(): \DateTime
    {
        return $this->departureAt;
    }

    /**
     * @param \DateTime $departureAt
     */
    public function setDepartureAt(\DateTime $departureAt): void
    {
        $this->departureAt = $departureAt;
    }

    /**
     * @return string
     */
    public function getDepartureFrom(): string
    {
        return $this->departureFrom;
    }

    /**
     * @param string $departureFrom
     */
    public function setDepartureFrom(string $departureFrom): void
    {
        $this->departureFrom = $departureFrom;
    }

    /**
     * @return \DateTime
     */
    public function getArrivalAt(): \DateTime
    {
        return $this->arrivalAt;
    }

    /**
     * @param \DateTime $arrivalAt
     */
    public function setArrivalAt(\DateTime $arrivalAt): void
    {
        $this->arrivalAt = $arrivalAt;
    }

    /**
     * @return string
     */
    public function getArrivalTo(): string
    {
        return $this->arrivalTo;
    }

    /**
     * @param string $arrivalTo
     */
    public function setArrivalTo(string $arrivalTo): void
    {
        $this->arrivalTo = $arrivalTo;
    }

    /**
     * @return string
     */
    public function getAk(): string
    {
        return $this->ak;
    }

    /**
     * @param string $ak
     */
    public function setAk(string $ak): void
    {
        $this->ak = $ak;
    }
}
