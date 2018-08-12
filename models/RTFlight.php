<?php
/**
 * Created by PhpStorm.
 * User: Maxim Gabidullin <after@ya.ru>
 * Date: 10.08.2018
 * Time: 3:25
 */

namespace app\models;


class RTFlight
{
    /** @var TicketTo[] */
    private $ticketsTo = [];

    /** @var TicketBack[] */
    private $ticketsBack = [];

    /** @var Cost */
    private $price;

    /** @var string */
    private $ak;

    /** @var RTFlightStrategy */
    private $flightStrategy;

    /**
     * RTFlight constructor.
     *
     * @param Cost             $price
     * @param string           $ak
     * @param RTFlightStrategy $flightStrategy
     */
    public function __construct(Cost $price, string $ak, RTFlightStrategy $flightStrategy)
    {
        $this->price = $price;
        $this->ak = $ak;
        $this->flightStrategy = $flightStrategy;
    }

    /**
     * @param Ticket $ticket
     */
    public function addTicket(Ticket $ticket): void
    {
        if ($this->flightStrategy->ticketCorrect($this, $ticket)) {
            if ($ticket instanceof TicketBack) {
                $this->ticketsBack[] = $ticket;
            } else {
                $this->ticketsTo[] = $ticket;
            }
        }
    }

    /**
     * @return TicketTo[]
     */
    public function getTicketsTo(): array
    {
        return $this->ticketsTo;
    }

    /**
     * @return TicketBack[]
     */
    public function getTicketsBack(): array
    {
        return $this->ticketsBack;
    }

    /**
     * @return bool
     */
    public function hasTickets(): bool
    {
        return count($this->ticketsTo) && count($this->ticketsBack);
    }

    /**
     * @return Cost
     */
    public function getPrice(): Cost
    {
        return $this->price;
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