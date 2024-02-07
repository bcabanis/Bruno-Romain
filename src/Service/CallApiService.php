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
// https://public.opendatasoft.com/explore/dataset/evenements-publics-openagenda/api/?flg=fr-fr&disjunctive.keywords_fr&disjunctive.location_city&disjunctive.location_department&disjunctive.location_region&disjunctive.location_countrycode
        return $response->toArray();
    }

}



