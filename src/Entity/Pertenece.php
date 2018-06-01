<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PerteneceRepository")
 */
class Pertenece
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
    private $idUsuario;

    /**
     * @ORM\Column(type="integer")
     */
    private $idEvento;

    /**
     * @ORM\Column(type="string", length=655, nullable=true)
     */
    private $mensaje;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $deletParticipante;

    /**
     * @return mixed
     */
    public function getDeletParticipante()
    {
        return $this->deletParticipante;
    }

    /**
     * @param mixed $deletParticipante
     */
    public function setDeletParticipante($deletParticipante)
    {
        $this->deletParticipante = $deletParticipante;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdUsuario(): ?int
    {
        return $this->idUsuario;
    }

    public function setIdUsuario(int $idUsuario): self
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    public function getIdEvento(): ?int
    {
        return $this->idEvento;
    }

    public function setIdEvento(int $idEvento): self
    {
        $this->idEvento = $idEvento;

        return $this;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }

    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    }
}
