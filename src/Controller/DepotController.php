<?php

namespace App\Controller;

use App\Entity\Depot;
use App\Entity\CreationCompte;
use App\Form\DepotType;
use App\Repository\DepotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
/**
 * @Route("/depot")
 */
class DepotController extends AbstractController
{
    /**
     * @Route("/", name="depot_index", methods={"GET"})
     */
    public function index(DepotRepository $depotRepository): Response
    {
        return $this->render('depot/index.html.twig', [
            'depots' => $depotRepository->findAll(),
        ]);
    }

    /**
     * @Route Rest\post("/depot", name="depot_new", methods={"GET","POST"})
     */
    public function depot ( Request $request,EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator)
    {
      
        $values = json_decode($request->getContent());
       // $creationCompte = new CreationCompte();

                    $depot = new Depot();
    
       $repo = $this->getDoctrine()->getRepository(CreationCompte::class);
       $creation=$repo->find($values->creationcompte);
          $depot->setCreationcompte($creation);
                    $depot->setNumeroCompte($values->numerocompte);
                    $depot->setMontantDepot($values->montantdepot);
                    $depot->setDate($values->date);
                   
  $errors = $validator->validate($depot);
  if(count($errors)) {
      $errors = $serializer->serialize($errors, 'json');
      return new Response($errors, 500, [
          'Content-Type' => 'application/json'
      ]);
     }
     
     $errors = $validator->validate($depot);
     if(count($errors)) {
         $errors = $serializer->serialize($errors, 'json');
         return new Response($errors, 500, [
             'Content-Type' => 'application/json'
         ]);
        }   
                    $entityManager->persist($depot);
                    $entityManager->flush();
                }
    /**
     * @Route("/{id}", name="depot_show", methods={"GET"})
     */
    public function show(Depot $depot): Response
    {
        return $this->render('depot/show.html.twig', [
            'depot' => $depot,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="depot_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Depot $depot): Response
    {
        $form = $this->createForm(DepotType::class, $depot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('depot_index');
        }

        return $this->render('depot/edit.html.twig', [
            'depot' => $depot,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="depot_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Depot $depot): Response
    {
        if ($this->isCsrfTokenValid('delete'.$depot->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($depot);
            $entityManager->flush();
        }

        return $this->redirectToRoute('depot_index');
    }
}
