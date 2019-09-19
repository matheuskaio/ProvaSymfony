<?php

namespace App\Controller;
use App\Repository\UserRepository;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoginController extends AbstractController
{
    private $repository;
    private $encode;

    public function __construct(
        UserRepository $repository,
        UserPasswordEncoderInterface $encode)
    {
        $this->repository = $repository;
        $this->encode = $encode;
    }
    /**
     * @Route("/login", name="login")
     */
    public function index(Request $request)
    {
        $login = json_decode($request->getContent());
        
        if(!isset($login->usuario)|| !isset($login->senha)){
            return new JsonResponse(
                ['erro'=>'Favor Enviar usuário e senha'],
                Response::HTTP_BAD_REQUEST);
        }
        
        /** @var User $user */
        $user = $this->repository->findOneBy(['username'=>$login->usuario]);
        if(!$this->encode->isPasswordValid($user, $login->senha)){
            return new JsonResponse(
                ['erro' => 'Usuário ou senha inválido'],
                RESPONSE::HTTP_UNAUTHORIZED
            );
        }

        $token = JWT::encode(['username'=> $user->getUsername()], 'chave');
        return new JsonResponse(['acess_token' => $token]);
      
    }
}
