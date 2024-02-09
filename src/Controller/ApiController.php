<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// le but de cette classe est de faire apparaitre les résultats de l'API

class ApiController extends AbstractController
{

    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/api', name: 'app_api')]
    public function getDatas(): Response
    {

        $response = $this->client->request('GET', 'https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/evenements-publics-openagenda/records?select=uid%2C%20title_fr%2C%20description_fr%2C%20image%2C%20firstdate_begin%2C%20firstdate_end%2C%20lastdate_begin%2C%20lastdate_end%2C%20location_coordinates%2C%20location_name%2C%20location_address%2C%20daterange_fr%2C%20longdescription_fr&limit=-1&refine=updatedat%3A%222024%22');

        $statusCode = $response->getStatusCode();
        // $statusCode = 200

        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'

        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'

        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        // Récupérer les résultats de la réponse
        $results = $content['results'];

        $completeData = [];

        foreach ($results as $result) {
            
            $data = [
                'title_fr' => $result['title_fr'],
            ];

            $completeData[] = $data;
        }
        
        // $jsonContent = json_encode($content, JSON_PRETTY_PRINT);

        // // Décoder le JSON pour obtenir un tableau associatif
        // $decodedContent = json_decode($jsonContent, true);

        // // Si le décodage réussit, ré-encoder avec l'option JSON_UNESCAPED_UNICODE pour afficher les caractères unicode non échappés
        // if ($decodedContent !== null) {
        //     $jsonContent = json_encode($decodedContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        // }

        return $this->render('api/api.html.twig', [
            'controller_name' => 'ApiController',
            // 'data' => $jsonContent,
            'data' => $completeData,
        ]);
    }
}
