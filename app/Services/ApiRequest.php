<?php

namespace App\Services;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Otis22\VetmanagerRestApi\Headers;
use Otis22\VetmanagerRestApi\Headers\Auth\ApiKey;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use Otis22\VetmanagerRestApi\Query\Sort\AscBy;
use Otis22\VetmanagerRestApi\Query\Sorts;
use Otis22\VetmanagerRestApi\Model\Property;
use Otis22\VetmanagerRestApi\Query\Query;



class ApiRequest
{
    private Client $client;
    private $key;
//    public function __construct(User $user, $model)
    public function __construct()
    {
        $this->key = '437a544156c310367211f9faa2f4a276';
        $this->client = new Client(['base_uri' => 'https://testdevkris.vetmanager.ru']);
//        $this->key = $user->userSettingApi->key;
//        $this->client = new Client(['base_uri' => $user->userSettingApi->url]);
    }
//    public function request($method, $url, $data)
//    {
//
//    }

    /**
     *Вывод по 50 клиентов
     */
    public function getAllClients()
    {
        $authHeaders = new Headers\WithAuth(
            new Headers\Auth\ByApiKey(
                new ApiKey($this->key)
            )
        );

        $sorts = new Sorts(
            new AscBy(
                new Property('id')
            )
        );

        $pagedQuery = PagedQuery::forGettingTop(
            new Query(
                $sorts
            ),
            50
        );

        $response = $this->client->request(
            'GET',
            '/rest/api/client',
            [
                'headers' => $authHeaders->asKeyValue(),
                'query' => $pagedQuery->asKeyValue()
            ]
        );

        return json_decode($response->getBody(), true);
    }
    /**
     *Вывод 1 клиента
     */
    public function getClient(int $id)
    {

    }

    public function deleteClient(int $id)
    {

    }

    public function searchClient(Request $request)
    {

    }

    public function getAllPetsClient($id_client)
    {

    }

    public function getPet(int $id_client)
    {

    }
    public function deletePet(int $id_client)
    {

    }
}
