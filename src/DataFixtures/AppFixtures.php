<?php

namespace App\DataFixtures;
use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
//use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class AppFixtures extends Fixture
{

    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $admin1 = new Admin("admin");
     $admin1->setUsername('admine');
     $password = $this->encoder->encodePassword($admin1 ,'admin');
     $admin1->setpassword($password);
            $admin1->setUsername('Cheikh');
            $admin1->setRoles(["ROLE_ADMIN_SYSTEME"]);
            $admin1->setAdresse('Dakar');
            $admin1->setNomComplet('cheikh Bamba Fall');
            $admin1->setNumeroIdentite(1254783692);
            
            $manager->persist($admin1);

          $admin2 = new Admin("Caissier");
          $password = $this->encoder->encodePassword($admin2 ,'admin');
          $admin2->setpassword($password);
                $admin2->setUsername('Maimouna');
                $admin2->setRoles(["ROLE_CASSIER_SYSTEME"]);
                $admin2->setAdresse('dakar rufisque');
                $admin2->setNomComplet('Maimouna Gaye');
                $admin2->setNumeroIdentite(1842369254);
                    $manager->persist($admin2);
                    $manager->flush()
                    ;
    
        $manager->flush();
    }
}
