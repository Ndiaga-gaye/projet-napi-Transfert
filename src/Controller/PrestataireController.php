<?php

namespace App\Controller;

use App\Entity\Prestataire;
use App\Form\PrestataireType;
use App\Repository\PrestataireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\CreationCompte;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

//use App\Controller\EntityManagerInterface;
  use Doctrine\ORM\EntityManagerInterface;
/**
 * @Route("/prestataire")
 */
class PrestataireController extends AbstractController
{
    /**
     * @Route("/", name="prestataire_index", methods={"GET"})
     */
    public function index(PrestataireRepository $prestataireRepository): Response
    {
        return $this->render('prestataire/index.html.twig', [
            'prestataires' => $prestataireRepository->findAll(),
        ]);
    }

     /**
     * 
     * @Route Rest\post("/prestataire", name="prestataire_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator ): Response
    {
        

  $values = json_decode($request->getContent());
  $random = random_int(10000000, 99999999);
  $prestataire = new Prestataire();
  $prestataire->setNom($values->nom);
  $prestataire->setNinea($values->ninea);                                                                                                                                                                                                                      
  $prestataire->setRaisonSocial($values->raisonsocial);
  $prestataire->setAdresse($values->adresse);
  $prestataire->setIsActive($values->isActive);
 

  $user = new User();
 
  $user->setPrestataire($prestataire);
  $user->setUsername($values->username);
  $user->setRoles($user->getRoles(["ROLE_ADMIN_SYSTEME"]));
  $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
  $user->setNomComplet($values->nomComplet);
  $user->setAdresse($values->adresse);
  $user->setNumeroIdentité($values->numeroIdentité);
  $user->setTelephone($values->telephone);
  $user->setStatut($values->statut);
  
  $creationCompte = new CreationCompte();
  
  $creationCompte->setNumeroCompte($random);
  $creationCompte->setSolde($values->solde);
  $creationCompte->setCompteprestataire($prestataire);

  $errors = $validator->validate($user);
  if(count($errors)) {
      $errors = $serializer->serialize($errors, 'json');
      return new Response($errors, 500, [
          'Content-Type' => 'application/json'
      ]);
     }
     
     $errors = $validator->validate($prestataire);
     if(count($errors)) {
         $errors = $serializer->serialize($errors, 'json');
         return new Response($errors, 500, [
             'Content-Type' => 'application/json'
         ]);
        }   
  
  $entityManager->persist($prestataire);
  $entityManager->persist($user);
  $entityManager->persist($creationCompte);
  $entityManager->flush();
 }

    /**
     * @Route("/{id}", name="prestataire_show", methods={"GET"})
     */
    public function show(Prestataire $prestataire): Response
    {
        return $this->render('prestataire/show.html.twig', [
            'prestataire' => $prestataire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="prestataire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Prestataire $prestataire): Response
    {
        $form = $this->createForm(PrestataireType::class, $prestataire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('prestataire_index');
        }

        return $this->render('prestataire/edit.html.twig', [
            'prestataire' => $prestataire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="prestataire_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Prestataire $prestataire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$prestataire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($prestataire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('prestataire_index');
    }
}
