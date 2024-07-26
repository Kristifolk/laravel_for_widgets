<?php

namespace App\Services;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Otis22\VetmanagerRestApi\Headers;
use Otis22\VetmanagerRestApi\Headers\Auth\ApiKey;
use Otis22\VetmanagerRestApi\Query\Filter\EqualTo;
use Otis22\VetmanagerRestApi\Query\Filter\Value\StringValue;
use Otis22\VetmanagerRestApi\Query\Filters;
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
    private function authHeaders(): Headers\WithAuth
    {
        return new Headers\WithAuth(
            new Headers\Auth\ByApiKey(
                new ApiKey($this->key)
            )
        );
    }

    private function response($url, $nameModal)
    {
        $response = $this->client->request(
            'GET',
            $url,
            [
                'headers' => $this->authHeaders()->asKeyValue(),
//                'query' => $pagedQuery->asKeyValue()
            ]
        );

        $array = json_decode($response->getBody(), true);

        return $array['data'][$nameModal];
    }

    public function getAll(string $nameModal, string $url = '/rest/api/')
    {
        $url = $url . $nameModal;
        return $this->response($url, $nameModal);
    }

    /**
     *Вывод 1 клиента
     */
    public function getClient(int $id){
        $url = "/rest/api/client/$id";
        return $this->response($url, 'client');
    }

//    public function getClient(int $id)
//    {
//        $response = $this->client->request(
//            'GET',
//            "/rest/api/client/$id",
//            [
//                'headers' => $this->authHeaders()->asKeyValue(),
//            ]
//        );
//
//        $array = json_decode($response->getBody(), true);
//
//        return $array['data']['client'];
//    }

    public function deleteClient(int $id)
    {

    }

//TODO поиск по полному ФИО
    /**
     *Поиск по Фамилии по всем клиентам Ветменеджер, не только для первых 50 шт
     */
    public function searchClients($lastname)
    {
        $foundClients['data']['client'] = [];

        if(!empty($lastname)) {
            $filters = new Filters(new EqualTo(new Property('last_name'), new StringValue($lastname)));

            $response = $this->client->request(
                'GET',
                '/rest/api/client',
                [
                    'headers' => $this->authHeaders()->asKeyValue(),
                    'query' => $filters->asKeyValue()
                ]
            );

            $foundClients = json_decode($response->getBody(), true);
        }

        return $foundClients['data']['client'];
    }

    public function getAllPetsClient($ownerId)
    {
        $url = "/rest/api/pet/?filter=[{'property':'owner_id', 'value':'$ownerId'},{'property':'status', 'value':'deleted', 'operator':'!='}]";
        return $this->response($url, 'pet');
    }

    public function getPet(int $id)
    {
        $url = "/rest/api/pet/$id";
        return $this->response($url, 'pet');
    }

    public function deletePet(int $ownerId)
    {

    }

    public function createInVetmanager($nameModal, $data)
    {
        $response = $this->client->request(
            'POST',
            "/rest/api/$nameModal",
            [
                'headers' => $this->authHeaders()->asKeyValue(),
                'json' => $data,
            ]
        );
        $decodeBody = json_decode((string)$response->getBody(), true);
//        dd($decodeBody);
//        dd($decodeBody['message']);
        if(!$decodeBody['success'] || $decodeBody['success'] !== true) {
            throw new \Exception($decodeBody['message']);
        }
    }
}
