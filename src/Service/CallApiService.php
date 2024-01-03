<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{

    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getDataByTags()
    {
        $response = $this->client->request(
            'GET',
            'https://public.opendatasoft.com/api/records/1.0/search/?dataset=evenements-publics-openagenda&q=&refine.updatedat=2023'
        );

        return $response->toArray();
    }

    // public function getDataByDate(string $year, string $month, string $day)
    // {
    //     $response = $this->client->request(
    //         'GET',
    //         'https://public.opendatasoft.com/api/records/1.0/search/?dataset=evenements-publics-openagenda&q=&refine.updatedat=' . $year . '%2F' . $month . '%2F' . $day . '&refine.location_city=Paris'
    //     );

    //     return $response->toArray();
    // }

}



