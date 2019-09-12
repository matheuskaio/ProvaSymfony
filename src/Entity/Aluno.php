<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AlunoRepository")
 */
class Aluno
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
     * @ORM\Column(type="string", length=255)
     */
    public $matricula;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Projeto")
     * @ORM\JoinColumn(nullable=true)
     */
    
    public $projeto;
    
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

    public function getMatricula(): ?string
    {
        return $this->matricula;
    }

    public function setMatricula(string $matricula): self
    {
        $this->matricula = $matricula;

        return $this;
    }

    public function getProjeto(): ?Projeto
    {
        return $this->projeto;
    }

    public function setProjeto(?Projeto $projeto): self
    {
        $this->projeto = $projeto;

        return $this;
    }
}
