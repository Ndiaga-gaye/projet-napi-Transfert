<?php
namespace App\Controller;
use App\Entity\User;
use App\Entity\Partenaire;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
/**
     * @Route("/api", name="register")
     */
class UserController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     * @IsGranted("ROLE_ADMIN_SYSTEME")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder,EntityManagerInterface $entityManager)
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        $data=$request->request->all();
        $form->submit($data);  
        $file=$request->files->all()['imageName'];
        
        if ($form->isSubmitted() ) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setImageFile($file);
            //recuperation id partenaire
            $repository = $this->getDoctrine()->getRepository(Partenaire::class);
            $parte= $repository->findAll();
            $user->setPartenaire($parte[0]);
            $user->setStatut("actif");
            $profil= $data["profil"];
            $user->setProfil($profil);
            $roles=[];
            if($profil=="admin"){
                $roles=["ROLE_ADMIN_PRESTATAIRE"];
            }
            elseif ($profil=="user") {
                $roles=["ROLE_USER"];
            }
            elseif ($profil=="prestataire" || $profil=="adminPrestataire") {
                $roles=["ROLE_ADMINPRESTATAIRE"];
            }
            $user->setRoles($roles);
           
            $entityManager = $this->getDoctrine()->getManager();
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
            'message' => 'Renseigner tout les champs'
        ];
        return new JsonResponse($data, 500);     
    }
    /**
     * @Route("/login_check", name="login", methods={"POST"})
     */
    public function login(Request $request)
    {
        $user = $this->getUser();
        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles()
        ]);
    }
}
