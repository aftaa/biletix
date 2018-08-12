<?php
/**
 * Created by PhpStorm.
 * User: Maxim Gabidullin <after@ya.ru>
 * Date: 10.08.2018
 * Time: 3:25
 */

namespace app\models;


class Flight
{
    /** @var TicketTo[] */
    private $ticketsTo = [];

    /** @var TicketBack[] */
    private $ticketsBack = [];

    /** @var Cost */
    private $price;

    /**
     * Flight constructor.
     * @param Cost|null $price
     */
    public function __construct(?Cost $price)
    {
        $this->price = $price;
    }

    /**
     * @param Ticket $ticket
     */
    public function addTicket(Ticket $ticket): void
    {
        $ticket->setPrice($this->price);

        if ($ticket instanceof TicketBack) {
            $this->ticketsBack[] = $ticket;
        } else {
            $this->ticketsTo[] = $ticket;
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
     * @return Cost
     */
    public function getPrice(): Cost
    {
        return $this->price;
    }
}