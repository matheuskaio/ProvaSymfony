<?php
namespace App\Controller;
use App\Entity\Aluno;
use App\Entity\Projeto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlunoController extends AbstractController{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this -> entityManager = $entityManager;
    }
    /**
     * @Route("/aluno", methods={"POST"})
     */
    public function create(Request $request): Response{
        $content = json_decode($request->getContent());
        $aluno = new Aluno();
        $aluno->nome = $content->nome;
        $aluno->matricula = $content->matricula;
        $this->entityManager->persist($aluno);
        $this->entityManager->flush();
        return new JsonResponse($aluno);
    }

    /**
     * @Route("/alunoParticipar/{idAluno}", methods={"PUT"})
     */
    public function participarProjeto(int $idAluno, Request $request): Response{
        $content = json_decode($request->getContent());

        $idAluno = $request->get("idAluno");

        $repository = $this->getDoctrine()->getRepository(Projeto::class);
        $projeto = $repository->find($content->projeto);

        // $alunoUpdate = new Aluno();
        // $alunoUpdate->setProjeto($projeto);

        $repository = $this->getDoctrine()->getRepository(Aluno::class);
        $aluno = $repository->find($idAluno);


        if(is_null($aluno)){
            return new Response("Aluno não Encontrado", Response::HTTP_NOT_FOUND);
        }
        if($aluno->getProjeto()){
            return new Response("Aluno já estar em um projeto", Response::HTTP_NOT_FOUND);
        }

        $aluno->setProjeto($projeto);
        $this->entityManager->persist($aluno);
        $this->entityManager->flush();
        // return new JsonResponse($aluno);
        return new JsonResponse("Deu bom", Response::HTTP_OK);
    }

    /**
     * @Route("/aluno/{id}", methods={"GET"})
     */
    public function alunoPorProjeto(int $id, Request $request): Response{
        $id = $request->get("id");
        $repository = $this->getDoctrine()->getRepository(Aluno::class);
        $aluno = $repository->find($id);
        $status = is_null($aluno) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;
        return new JsonResponse($aluno, $status);
    }
    /**
     * @Route("/alunoEncerrarParticipacao/{id}", methods={"PUT"})
     */
    public function alunoEncerrarParticipacao(int $id, Request $request): Response{
        $id = $request->get("id");
        $repository = $this->getDoctrine()->getRepository(Aluno::class);
        $aluno = $repository->find($id);
        if(is_null($aluno)){
            return new Response("", Response::HTTP_NOT_FOUND);
        }
        $aluno->setProjeto(null);
        $this->entityManager->persist($aluno);
        $this->entityManager->flush();
        return new JsonResponse($aluno);
    }
}