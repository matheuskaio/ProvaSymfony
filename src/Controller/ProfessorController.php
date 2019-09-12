<?php
  namespace App\Controller;
  use App\Entity\Professor;
  
  use Doctrine\ORM\EntityManagerInterface;
  use Symfony\Component\HttpFoundation\JsonResponse;
  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  use Symfony\Component\HttpFoundation\Request; 
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\Routing\Annotation\Route;

  class ProfessorController extends AbstractController{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
      $this -> entityManager = $entityManager;
    } 
    /**
     * @Route("/professor", methods={"POST"})
     */
    public function create(Request $request): Response{
      $content = json_decode($request->getContent());
      $professor = new Professor();
      $professor->nome = $content->nome;
      $professor->matricula = $content->matricula;
      $this->entityManager->persist($professor);
      $this->entityManager->flush();
      return new JsonResponse($professor);
    } 

  }