<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventosRepository")
 */
class Eventos
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $IdAdmin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombreEvento;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $EventImage;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $totalPrice;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $deleteEvent;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $totalMemebers;

    /**
     * @return mixed
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * @param mixed $totalPrice
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }

    /**
     * @param mixed $EventImage
     */
    public function setEventImage($EventImage)
    {
        $this->EventImage = $EventImage;
    }


    /**
     * @return mixed
     */
    public function getDescrripcion()
    {
        return $this->descrripcion;
    }

    /**
     * @param mixed $descrripcion
     */
    public function setDescrripcion($descrripcion)
    {
        $this->descrripcion = $descrripcion;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @ORM\Column(type="string", length=600)
     */
    private $descrripcion;

    /**
     * @ORM\Column(type="string", length=600, nullable=true)
     */

    private $message;

    /**
     * @ORM\Column(type="datetime", length=600)
     */
    private $date;

    public function getId()
    {
        return $this->id;
    }

    public function getIdAdmin(): ?int
    {
        return $this->IdAdmin;
    }

    public function setIdAdmin(int $IdAdmin): self
    {
        $this->IdAdmin = $IdAdmin;

        return $this;
    }

    public function getNombreEvento(): ?string
    {
        return $this->nombreEvento;
    }

    public function setNombreEvento(string $nombreEvento): self
    {
        $this->nombreEvento = $nombreEvento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeleteEvent()
    {
        return $this->deleteEvent;
    }

    /**
     * @param mixed $deleteEvent
     */
    public function setDeleteEvent($deleteEvent)
    {
        $this->deleteEvent = $deleteEvent;
    }

    /**
     * @return mixed
     */
    public function getEventImage()
    {
        return $this->EventImage;
    }

    /**
     * @return mixed
     */
    public function getTotalMemebers()
    {
        return $this->totalMemebers;
    }

    /**
     * @param mixed $totalMemebers
     */
    public function setTotalMemebers($totalMemebers)
    {
        $this->totalMemebers = $totalMemebers;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }


}
