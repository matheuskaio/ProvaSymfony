<?php
namespace App\Controller;
use App\Entity\Projeto;
use App\Entity\Professor;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Tests\Compiler\J;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjetoController extends AbstractController{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this -> entityManager = $entityManager;
    }
    /**
     * @Route("/projeto", methods={"POST"})
     */
    public function create(Request $request): Response{
        $content = json_decode($request->getContent());
        $professor = $this->getDoctrine()->getRepository(Professor::class);
        $professor = $professor->find($content->professor);

        $projeto = new Projeto();
        $projeto->setProfessor($professor);
        $projeto->nome = $content->nome;
        $projeto->setStatusProjeto("Ativo");
        $this->entityManager->persist($projeto);
        $this->entityManager->flush();
        return new JsonResponse($projeto);
    }

    /**
     * @Route("/projetoProfessor/{idProfessor}", methods={"GET"})
     */
    public function projetosProfessor(int $idProfessor, Request $request): Response{
        $idProfessor = $request->get("idProfessor");

        $repository = $this->getDoctrine()->getRepository(Professor::class);
        $professor = $repository->find($idProfessor);

        if(is_null($professor)){
            return new JsonResponse(["erro"=>"Professor não cadastrado"], Response::HTTP_BAD_REQUEST);
        }

        $repository = $this->getDoctrine()->getRepository(Projeto::class);
        $projetos = $repository->findByProfessor($idProfessor);
        if(is_null($projetos)){
            return new JsonResponse(["erro"=>"Professor não cadastrado"], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse($projetos);
    }


    /**
     * @Route("/projeto", methods={"GET"})
     */
    public function projetosAll(Request $request): Response{
        $repository = $this->getDoctrine()->getRepository(Projeto::class);
        $projetos = $repository->findAll();
        $status = is_null($projetos) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;
        return new JsonResponse($projetos, $status);
    }


    /**
     * @Route("/projetoStatus/{status}", methods={"GET"})
     */
    public function projetosStatus(string $status, Request $request): Response{
        $statusP = $request->get("status");
        $repository = $this->getDoctrine()->getRepository(Projeto::class);
        $projetos = $repository->findByStatusProjeto($statusP);
        $status = is_null($projetos) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;
        return new JsonResponse($projetos, $status);
    }

    /**
     * @Route("/projetoMudarStatus/{idProjeto}", methods={"PUT"})
     */
    public function projetosMudarStatus(string $idProjeto, Request $request): Response{
        $idProjeto = $request->get("idProjeto");
        $repository = $this->getDoctrine()->getRepository(Projeto::class);
        $projeto = $repository->find($idProjeto);
        if(is_null($projeto)){
            return new JsonResponse(["erro"=>"Projeto Não Encontrado"], Response::HTTP_NOT_FOUND);
        }
        $projeto->setStatusProjeto("Finalizado");
        $this->entityManager->persist($projeto);
        $this->entityManager->flush();
        return new JsonResponse(["msg"=>"Status alterado com sucesso"], Response::HTTP_OK);
    }

}