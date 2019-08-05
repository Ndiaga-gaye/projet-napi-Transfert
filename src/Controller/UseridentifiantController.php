<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Useridentifiant;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authorization\UseridentifiantCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Symfony\Component\Routing\Annotation\Route;

class UseridentifiantController extends AbstractController
{
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();

        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $roles = $request->request->get('roles');

        if (!$roles) {
            $roles = json_encode([]);
        }

        $useridentifiant = new Useridentifiant($username);
        $useridentifiant->setPassword($encoder->encodePassword($username, $password));
        $useridentifiant->setRoles(($roles));
        $em->persist($useridentifiant);
        $em->flush();

        return new Response(sprintf('User %s successfully created', $useridentifiant->getUsername()));
    }
}
