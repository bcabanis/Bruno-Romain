<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NewApiService
{
    
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getDatas(): array
    {

        $response = $this->client->request('GET', 'https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/evenements-publics-openagenda/records?select=uid%2C%20title_fr%2C%20description_fr%2C%20image%2C%20firstdate_begin%2C%20firstdate_end%2C%20lastdate_begin%2C%20lastdate_end%2C%20location_coordinates%2C%20location_name%2C%20location_address%2C%20daterange_fr%2C%20longdescription_fr&limit=-1&refine=updatedat%3A%222024%22&refine=location_city%3A%22Paris%22');

        $statusCode = $response->getStatusCode();
        $contentType = $response->getHeaders()['content-type'][0];
        
        $content = $response->getContent();
        $content = $response->toArray();

        // Récupérer les résultats de la réponse
        $results = $content['results'];

        $completeData = [];

        foreach ($results as $result) {
            
            $imageUrl = !empty($result['image']) ? $result['image'] : '/assets/img/nopicture.jpg';
            
            $data = [
                'title' => $result['title_fr'], // ok
                'description' => $result['description_fr'], // ok
                'image_url' => $imageUrl, // ok
                'address' => $result['location_address'], // ok
                'eventId' => $result['uid'], // ok
                'orga' => $result['location_name'], //ok
                'date' => $result['daterange_fr'], // ok
                'location_coordinates' => [
                    'long' => $result['location_coordinates']['lon'],
                    'lat' => $result['location_coordinates']['lat']
                ], // ok
                'longdescription' => strip_tags($result['longdescription_fr']), 

                'start' => $result['firstdate_begin'],
                'end' => $result['firstdate_end'],
                'last_start' => $result['lastdate_begin'],
                'last_end' => $result['lastdate_end'],              
            ];

            $tagCategories = [
                "Comedy",
                "Sculpture",
                "Design",
                "Bijoux",
                "Ballet",
                "Chorales",
                "Comédies Musicales",
                "Danse",
                "Littérature",
                "Orchestres",
                "Peinture",
                "ONG",
                "Start Ups",
                "Associations",
                "Carrières",
                "Investissement",
                "Immobilier",
                "Marketing",
                "Medias",
                "Petites entreprises",
                "Apéro",
                "Bière",
                "Brunch",
                "Culinaire",
                "Restaurants",
                "Spiritueux",
                "Actions Locales",
                "Bénévolat",
                "Cours particuliers",
                "Histoire",
                "Langues",
                "Nationalité",
                "Parrainages",
                "Participatif",
                "Anime",
                "Adult",
                "Ciné-débat",
                "Comédie",
                "Comics",
                "Film",
                "Gaming",
                "Alternatif",
                "Blues",
                "Classique",
                "Dj/Dance",
                "Concert",
                "Electro",
                "Festival",
                "Folk",
                "Hip Hop/Rap",
                "Jazz",
                "Jam",
                "Techno",
                "Reggae",
                "Live Music",
                "Accesoires",
                "Beauté",
                "Vide-grenier",
                "Maquillage",
                "Arts Martiaux",
                "Basket",
                "Cyclisme",
                "Football",
                "Golf",
                "Hockey sur Gazon",
                "Marche",
                "Moto",
                "Tennis",
                "Yoga",
                "Bien-être",
                "Hypnose",
                "Méditation",
                "Santé mentale",
                "Spa"
            ];

            foreach ($tagCategories as $tagCategory) {
                if (stripos($result['title_fr'], $tagCategory) !== false) {
                    $data['tagCategory'] = $category;
                    break;
                }
            }

            $completeData[] = $data;
        }
        
        return $completeData;
    }

}