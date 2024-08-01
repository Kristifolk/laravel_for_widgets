<?php

namespace App\Services;

use App\Models\UserSettingApi;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Auth;
use Otis22\VetmanagerRestApi\Headers;
use Otis22\VetmanagerRestApi\Headers\Auth\ApiKey;
use Otis22\VetmanagerRestApi\Query\Filter\EqualTo;
use Otis22\VetmanagerRestApi\Query\Filter\Value\StringValue;
use Otis22\VetmanagerRestApi\Query\Filters;
use Otis22\VetmanagerRestApi\Model\Property;

class ApiRequest
{
    private Client $client;
    private $key;

    public function __construct()
    {
        $this->key = $this->userSettings()->api_key;
        $this->client = new Client([
            'base_uri' => $this->userSettings()->url,
        ]);
    }

    private function userSettings()
    {
        return UserSettingApi::where('user_id', Auth::user()->id)->first();
    }

    private function authHeaders(): Headers\WithAuth
    {
        return new Headers\WithAuth(
            new Headers\Auth\ByApiKey(
                new ApiKey($this->key)
            )
        );
    }

    /**
     * @throws GuzzleException
     */
    private function response(string $url, string $nameModal)
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

    /**
     *Вывод всех клиентов Ветменеджера
     */
    public function allClients()
    {
        $url = "/rest/api/client/?filter=[{'property':'status', 'value':'ACTIVE'}]";
        return $this->response($url, 'client');
    }

    /**
     *Вывод 1 клиента или 1 питомца, в зависимости от переданного значения имени модели $nameModal
     */
    public function one(string $nameModal, int $id){
        $url = "/rest/api/$nameModal/$id";
        return $this->response($url, $nameModal);
    }

    /**
     *Вывод всех питомцев одного клиента
     */
    public function allPetsClient(string $ownerId)
    {
        $url = "/rest/api/pet/?filter=[{'property':'owner_id', 'value':'$ownerId'},{'property':'status', 'value':'deleted', 'operator':'!='}]";
        return $this->response($url, 'pet');
    }

//TODO поиск по полному ФИО
    /**
     *Поиск по Фамилии по всем клиентам Ветменеджер, не только для первых 50 шт
     */
    public function searchClients(string $lastname)
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

    /**
     * @throws GuzzleException
     * @throws Exception
     *
     * Удаление клиента или питомца, в зависимости от переданного значения имени модели $nameModal
     *
     */
    public function delete(string $nameModal, int $id)
    {
        $response = $this->client->request(
            'DELETE',
            "/rest/api/$nameModal/$id",
            [
                'headers' => $this->authHeaders()->asKeyValue(),
            ]
        );

        $array = json_decode($response->getBody(), true);

        if (!isset($array['success']) || $array['success'] === false) {
            throw new Exception($array['message']);
        }
    }

    /**
     *Создание клиента или питомца, в зависимости от переданного значения имени модели $nameModal
     */
    public function createInVetmanager(string $nameModal, array $data)
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

        if(!$decodeBody['success'] || $decodeBody['success'] !== true) {
            throw new \Exception($decodeBody['message']);
        }
        return $decodeBody;
    }

    /**
     *Редактирование клиента или питомца, в зависимости от переданного значения имени модели $nameModal
     */
    public function edit(string $nameModal, array $data, int $id)
    {
        $response = $this->client->request(
            'PUT',
            "/rest/api/$nameModal/$id",
            [
                'headers' => $this->authHeaders()->asKeyValue(),
                'json' => $data,
            ]
        );

        $decodeBody = json_decode((string)$response->getBody(), true);
        if(!$decodeBody['success'] || $decodeBody['success'] !== true) {
            throw new \Exception($decodeBody['message']);
        }
    }

    /**
     *Для fetch petTypesForSelectOption чтобы избежать блокировки политики CORS
     */
    public  function petType()
    {
        $response = $this->client->request(
            'GET',
            "/rest/api/PetType",
            [
                'headers' => $this->authHeaders()->asKeyValue(),
            ]
        );
        return json_decode($response->getBody(), true);
    }

    /**
     *Для fetch breedByTypeForSelectOption чтобы избежать блокировки политики CORS
     */
      public  function breedByType(int $client, string $selectedTypeId)
    {
        $filters = new Filters(new EqualTo(new Property('pet_type_id'), new StringValue($selectedTypeId)));

        $response = $this->client->request(
            'GET',
//            "/rest/api/breed/?filter=[{'property':'pet_type_id', 'value':'$selectedTypeId'}]",
            "/rest/api/breed",
            [
                'headers' => $this->authHeaders()->asKeyValue(),
                'query' => $filters->asKeyValue(),
            ]
        );
        return json_decode($response->getBody(), true);
    }

}
