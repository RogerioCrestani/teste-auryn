<?php

namespace App\Controller;

use App\Entity\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/users", methods={"GET"})
     */
    public function getUsers()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        $serializer = $this->get('serializer');
        $data = $serializer->serialize($users, 'json');

        return new Response($data, 200, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * @Route("/users", methods={"POST"})
     */
    public function postUsers(Request $request): Response
    {
        $user = new User();

        $user->setName($request->get('name'));
        $user->setPhone($request->get('phone'));
        $user->setEmail($request->get('mail'));
        $user->setBirthDate(new \DateTime($request->get('birth')));
        $user->setPassword(password_hash($request->get('password'), PASSWORD_DEFAULT));
        $user->setCpf($request->get('cpf'));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return new Response('snjkhabanjdkas', 200, ['Access-Control-Allow-Origin' => '*']);
    }
}
