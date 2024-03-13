<?php

namespace App\Service;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NewApiService
{
    
    private const API_URL = 'https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/evenements-publics-openagenda/records?select=uid%2C%20title_fr%2C%20description_fr%2C%20image%2C%20firstdate_begin%2C%20firstdate_end%2C%20lastdate_begin%2C%20lastdate_end%2C%20location_coordinates%2C%20location_name%2C%20location_address%2C%20daterange_fr%2C%20longdescription_fr&limit=-1&refine=updatedat%3A%222024%22&refine=location_city%3A%22Paris%22&';

    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getDataById(string $eventUid): array {

        $response = $this->client->request('GET', self::API_URL . $eventUid);

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            return null;
        }

        $results = $response->toArray();

        dump($results);

        foreach ($results['results'] as $result) {
            if ($result['uid'] === $eventUid) {
                $imageUrl = !empty($result['image']) ? $result['image'] : '/assets/img/nopicture.jpg';
                $data = [
                    'title' => $result['title_fr'],
                    'description' => $result['description_fr'],
                    'image' => $imageUrl,
                    'address' => $result['location_address'],
                    'eventUid' => $result['uid'], 
                    'date' => $result['daterange_fr'], 
                    'orga' => $result['location_name'], 
                    'eventUid' => $result['uid'],
                    'location_coordinates' => [
                        'long' => $result['location_coordinates']['lon'],
                        'lat' => $result['location_coordinates']['lat']
                    ],
                    'tags' => null,     
                    'categories' => null,
                    'firstCategory' => null, 
                ];

                $assertedData = $this->assertCategory($result);
                $data['tags'] = $assertedData['tags'];
                $data['categories'] = $assertedData['categories'];
                $data['firstCategory'] = $assertedData['firstCategory'];
    
                return $data;
            }
        }
        return null;
    
    }

    public function getDatas(): array // Renvoie les reservations pour l'utilisateur loggué
    {
        // Get reponse de l'API, statuscode & contentype
        $response = $this->client->request('GET', self::API_URL);  
        $content = $response->toArray();
        $results = $content['results'];

        $completeData = [];
        $data = [
            'eventId' => '1', 
            'title' => 'Simple', 
            'start' => date('Y-m-d', strtotime('-6 week')),
            'end' => date('Y-m-d', strtotime('+1 week')),  
            'adultes'=> '2',
            'enfants'=>'4',        
        ];
        $completeData[] = $data;
        $data = [
            'eventId' => '2', 
            'title' => 'Exclusive', 
            'start' => date('Y-m-d', strtotime('+3 week')),
            'end' => date('Y-m-d', strtotime('+4 week')),  
            'adultes'=> '4',
            'enfants'=>'1',             
        ];
        $completeData[] = $data;
        $data = [
            'eventId' => '3', 
            'title' => 'Piscine ouverte', 
            'start' => date('Y-m-d', strtotime('-3 week')),
            'end' => date('Y-m-d', strtotime('+6 week')),  
           'adultes'=> '4',
            'enfants'=>'1',             
       ];
        $completeData[] = $data;
        $data = [
            'eventId' => '4', 
            'title' => 'Piscine fermée', 
            'start' => date('Y-m-d', strtotime('-6 week')),
            'end' => date('Y-m-d', strtotime('-3 week')),  
           'adultes'=> '4',
            'enfants'=>'1',             
       ];
        $completeData[] = $data;
      
        return $completeData;
      
    }
}