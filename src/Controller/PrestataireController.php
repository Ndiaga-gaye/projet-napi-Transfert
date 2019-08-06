<?php

namespace App\Controller;
use App\Controller\Response;
use App\Entity\Prestataire;
use App\Form\PrestataireType;
use App\Repository\PrestataireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
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
 * @Route("/api")
 */
class PrestataireController extends AbstractController
{
    /**
     * @Route("/", name="prestataire_index", methods={"GET"})
     */
    public function index(PrestataireRepository $prestataireRepository)
    {
        return $this->render('prestataire/index.html.twig', [
            'prestataires' => $prestataireRepository->findAll(),
        ]);
    }

     /**
     * 
     * @Route("/prestataire", name="prestataire_new", methods={"GET","POST"})
     */
    public function postnew(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator ): Response
    {
        

  $values = json_decode($request->getContent());
  $random = random_int(10000000, 99999999);
  $prestataire = new Prestataire();
  $prestataire->setNom($values->nom);
  $prestataire->setNinea($values->ninea);                                                                                                                                                                                                                      
  $prestataire->setRaisonSocial($values->raisonsocial);
  $prestataire->setAdresse($values->adresse);
  $prestataire->setIsActive($values->isActive);
 

  $admin = new User();
  $form = $this->createForm(UserFormType::class, $admin);
  $form->handleRequest($request);
  $data=$request->request->all();
  $form->submit($data);  
  $file=$request->files->all()['imageName'];
  $admin->setImageFile($file);
  $admin->setPrestataire($prestataire);
  $admin->setUsername($values->username);
  $admin->setPassword($passwordEncoder->encodePassword($admin, $values->password));
  $admin->setNomComplet($values->nomComplet);
  $admin->setAdresse($values->adresse);
  $admin->setNumeroIdentité($values->numeroIdentité);
  $admin->setTelephone($values->telephone);
  $admin->setStatut($values->statut);
  

  $creationCompte = new CreationCompte();
  
  $creationCompte->setNumeroCompte($random);
  $creationCompte->setSolde($values->solde);
  $creationCompte->setCompteprestataire($prestataire);

  $errors = $validator->validate($admin);
  if(count($errors)) {
      $errors = $serializer->serialize($errors, 'json');
      return new Response($errors, 500, [
          'Content-Type' => 'application/json'
      ]);
     }
     
     $errors = $validator->validate($prestataire);
     if(count($errors)) {
         $errors = $serializer->serialize($errors, 'json');
         return new Response ($errors, 500, [
             'Content-Type' => 'application/json'
         ]);
        }   
  
  $entityManager->persist($prestataire);
  $entityManager->persist($admin);
  $entityManager->persist($creationCompte);
  $entityManager->flush();
 }
  
 
 

    /**
     * @Route("/register", name="register", methods={"POST"})
     */
  /*  public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $values = json_decode($request->getContent());
        if(isset($values->username,$values->password)) {
            $user = new User();
            $user->setUsername($values->username);
            $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
            $user->setRoles($user->getRoles());
            $entityManager->persist($user);
            $entityManager->flush();

            $data = [
                'status' => 201,
                'message' => 'L\'utilisateur a été créé'
            ];

            return new JsonResponse($data, 201);
        }
        $data = [
            'status' => 500,
            'message' => 'Vous devez renseigner les clés username et password'
        ];
        return new JsonResponse($data, 500);
    }


    /**
     * @Route("/{id}", name="prestataire_show", methods={"GET"})
     */

    public function show(Prestataire $prestataire)
    {
        return $this->render('prestataire/show.html.twig', [
            'prestataire' => $prestataire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="prestataire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Prestataire $prestataire)
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
    public function delete(Request $request, Prestataire $prestataire)
    {
        if ($this->isCsrfTokenValid('delete'.$prestataire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($prestataire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('prestataire_index');
    }
}
