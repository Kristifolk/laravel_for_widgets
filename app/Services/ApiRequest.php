<?php

namespace App\Services;

use App\Models\UserSettingApi;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
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


    /**
     * @throws Exception
     */
    public function __construct()
    {
        $userApiSettings = UserSettingApi::userApiSettings();

        $this->key = $userApiSettings->api_key;
        $this->client = new Client([
            'base_uri' => $userApiSettings->url,
        ]);
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
     * @throws Exception
     */
    private function response(string $method, string $url, array $parameters = null)
    {
        $options = [
            'headers' => $this->authHeaders()->asKeyValue(),
        ];

        if ($parameters !== null){
            if ($method === 'GET') {
                $options['query'] = $parameters;
            } else {
                $options['json'] = $parameters;
            }
        }

        try {
            $response = $this->client->request($method, $url, $options);
//            dd($response);

//            if (!isset($response['success']) || $response['success'] === false) {
//                throw new Exception($response['message']);
//            }
           return json_decode($response->getBody(), true);
//            return $this->handleResponse($response);

        } catch (GuzzleException $exception) {
            throw new Exception('Проверьте свои настройки: url клиники и API ключ. Произошла ошибка при выполнении запроса к API: ' . $exception->getMessage());
        } catch (Exception $exception) {
            throw new Exception('Проверьте свои настройки: url клиники и API ключ. Произошла ошибка при выполнении запроса к API: '. $exception->getMessage());
        }
//        } catch (GuzzleException|Exception $exception) {
//            return $this->handleException($exception);
//        }
    }
//        private function handleException(Exception $exception)
//        {
//            dd($exception->getMessage());
//            return [
//                'success' => false,
//                'message' => 'Проверьте свои настройки: url клиники и API ключ. Произошла ошибка при выполнении запроса к API: ' . $exception->getMessage(),
//            ];
//        }


//    private function handleResponse($response)
//    {
////        $data = json_decode($response->getBody(), true);
////
////        if (!isset($data['success']) || $data['success'] === false) {
////            throw new Exception($data['message']);
////        }
//
//        try {
//        $data = json_decode($response->getBody(), true);
//                return $data;
//
//
//        } catch (\Exception $exception) {
//            return redirect('/settingsApi')->withErrors($exception->getMessage());
//        }
//
////    return $data;
//    }

    /**
     *Вывод всех клиентов Ветменеджера
     */
    public function allClients()
    {
        $url = "/rest/api/client/?filter=[{'property':'status', 'value':'ACTIVE'}]";
        $array = $this->response('GET', $url);
        return $array['data']['client'];
    }

    /**
     *Вывод 1 клиента или 1 питомца, в зависимости от переданного значения имени модели $nameModal
     */
    public function one(string $nameModal, int $id)
    {
        $url = "/rest/api/$nameModal/$id";
        $array = $this->response('GET', $url);
        return $array['data'][$nameModal];
    }

//    public function one(string $nameModal, int $id)
//    {
//        $url = "/rest/api/$nameModal/$id";
//        $array = $this->response('GET', $url);
//        if (!$array['success']) {
//            return redirect('/settingsApi')->withErrors($array['message']);
//        }
//        return $array['data'][$nameModal];
//
//    }
    /**
     *Вывод всех питомцев (без удаленных) одного клиента
     */
    public function allPetsClient(string $ownerId)
    {
        $filters = [
          [
              'property' => 'owner_id',
              'value' => $ownerId,
          ],
          [
              'property' => 'status',
                'value' => 'deleted',
                'operator' => '!=',
          ]
        ];

        $query = ['filter' => json_encode($filters)];
        $url = "/rest/api/pet";
        $array = $this->response('GET', $url, $query);

        if (isset($array['data']['pet'])) {
            return $array['data']['pet'];
        } else {
            return [];
        }
    }

//TODO поиск по полному ФИО
    /**
     *Поиск по Фамилии по всем клиентам Ветменеджер, не только для первых 50 шт
     */
    public function searchClients(string $lastname)
    {
        $array['data']['client'] = [];

        if(!empty($lastname)) {
            $filters = new Filters(new EqualTo(new Property('last_name'), new StringValue($lastname)));
            $url = "/rest/api/client";
            $query = $filters->asKeyValue();
            $array = $this->response('GET', $url, $query);
        }

        return $array['data']['client'];
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
        $url = "/rest/api/$nameModal/$id";
        $array = $this->response('DELETE', $url);

        if (!isset($array['success']) || $array['success'] === false) {
            throw new Exception($array['message']);
        }
    }

    /**
     *Создание клиента или питомца, в зависимости от переданного значения имени модели $nameModal
     */
    public function createInVetmanager(string $nameModal, array $data)
    {
        $url = "/rest/api/$nameModal";
        $json = $data;
        $array = $this->response('POST', $url, $json);

        if(!$array['success'] || $array['success'] !== true) {
            throw new \Exception($array['message']);
        }

        return $array;
    }

    /**
     *Редактирование клиента или питомца, в зависимости от переданного значения имени модели $nameModal
     */
    public function edit(string $nameModal, array $data, int $id)
    {
        $url = "/rest/api/$nameModal/$id";
        $json = $data;
        $array = $this->response('PUT', $url, $json);

        if(!$array['success'] || $array['success'] !== true) {
            throw new \Exception($array['message']);
        }
    }

    /**
     *Для fetch petTypesForSelectOption чтобы избежать блокировки политики CORS
     */
    public  function petType()
    {
        $url = "/rest/api/PetType";
        return $this->response('GET', $url);
    }

    /**
     *Для fetch breedByTypeForSelectOption чтобы избежать блокировки политики CORS
     *Не удалять неиспользуемый аргумент $client, тк breedByType будет неправильно отрабатывать: вместо id типа питомца будет подставлять id клиента
     */
      public  function breedByType(int $client, string $selectedTypeId)
    {
        $filters = new Filters(new EqualTo(new Property('pet_type_id'), new StringValue($selectedTypeId)));
        $query = $filters->asKeyValue();
        $url = "/rest/api/breed";

        return $this->response('GET', $url, $query);
    }
}
