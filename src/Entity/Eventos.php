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
}
