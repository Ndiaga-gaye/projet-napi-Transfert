<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PrestataireControllerTest extends WebTestCase
{
    public function testpostnew()
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/prestataire',[],[],
        ['CONTENT_TYPE'=>"application/json"],
        '{ "nom": "Multi Service",
            "raisonsocial": "Entreprise Services",
            "ninea": "FN12365498",
            "Adresse": "Dakar pikine",
            "isActive": 1,
            "username": "fall",
            "roles": "ROLE_ADMIN_USER",
            "password": "F2190",
            "nomComplet": "Modou Fall",
            "adresse": "Dakar",
            "numeroIdentité": 123654892,
            "telephone": 771123658,
            "statut":"actif",
            "solde": 800000}');
        $rep=$client->getResponse();
        $this->assertSame(201,$client->getResponse()->getStatusCode());
    }
}
