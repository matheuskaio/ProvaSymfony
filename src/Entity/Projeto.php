<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjetoRepository")
 */
class Projeto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $nome;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Professor")
     * @ORM\JoinColumn(nullable=false)
     */
    public $professor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $statusProjeto;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getProfessor(): ?Professor
    {
        return $this->professor;
    }

    public function setProfessor(?Professor $professor): self
    {
        $this->professor = $professor;

        return $this;
    }

    public function getStatusProjeto(): ?string
    {
        return $this->statusProjeto;
    }

    public function setStatusProjeto(string $statusProjeto): self
    {
        $this->statusProjeto = $statusProjeto;

        return $this;
    }

}
