<?php

namespace App\Services;

use App\Exceptions\InvalidOrderException;
use App\Models\UserSettingApi;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Otis22\VetmanagerRestApi\Headers;
use Otis22\VetmanagerRestApi\Headers\Auth\ApiKey;
use Otis22\VetmanagerRestApi\Query\Builder;
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
            $data = json_decode($response->getBody(), true);
        } catch (\Throwable $exception) {
            throw new InvalidOrderException($exception->getMessage());
        }


        if (!isset($data['success']) || $data['success'] === false) {
            throw new Exception($data['message'] ?? 'Ошибка при формировании response');
        }

       return $data;
    }

    /**
     *Вывод 50 клиентов Ветменеджера
     * @throws Exception
     */
    public function fiftyClients(int $currentPage)
    {
//        try {
            $filters = [
                [
                    'property' => 'status',
                    'value' => 'ACTIVE',
                    ],
            ];

            $url = "/rest/api/client";
            $page = ($currentPage - 1);
            $paginate = (new Builder())->paginate(50, $page);
            $query = array_merge(['filter' => json_encode($filters)], $paginate->asKeyValue());
            $array = $this->response('GET', $url, $query);

            if (isset($array['data']['client'])) {
                return $array['data'];
            } else {
                throw new Exception('Ошибка при получении данных клиентов.');
            }
//        } catch (Exception $exception) {
////            dd($exception->getMessage());//попадаю сюда,при dd вижу сообщение, но не отрабатывает redirect и нет красивого отображения сообщения
////        } catch (Exception $exception) {
////            return redirect('/settingsApi')->withErrors($exception->getMessage());
////        }
//
//          session()->flash('error',//TOdo Этот flash('error', надо? удалить везде
//              "Проверьте свои настройки: url клиники и API ключ.
//              Произошла ошибка при выполнении запроса к API: " . $exception->getMessage());
//          return [
//              "totalCount" => 0,
//              "client" => [],
//          ];
//        } catch (InvalidOrderException $exception) {
//
//        }
    }

    /**
     *Вывод 1 клиента или 1 питомца, в зависимости от переданного значения имени модели $nameModal
     */
    public function one(string $nameModal, int $id)
    {
        try {
            $url = "/rest/api/$nameModal/$id";
            $array = $this->response('GET', $url);
            return $array['data'][$nameModal];
        }
        catch (Exception $exception) {
            return redirect('/settingsApi')->withErrors($exception->getMessage());
        }
    }

    /**
     *Вывод всех питомцев (без удаленных) одного клиента
     */
    public function allPetsClient(string $ownerId)
    {
        try {
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
        } catch (Exception $exception) {
            session()->flash('error',
                "Проверьте свои настройки: url клиники и API ключ.
                Произошла ошибка при выполнении запроса к API: " . $exception->getMessage());
            return [];
        }
    }

//TODO поиск по полному ФИО
    /**
     *Поиск по Фамилии по всем клиентам Ветменеджер, не только для первых 50 шт
     */
    public function searchClients(string $lastname)
    {
        try {
            $array['data']['client'] = [];

            if (!empty($lastname)) {
                $filters = new Filters(new EqualTo(new Property('last_name'), new StringValue($lastname)));
                $url = "/rest/api/client";
                $query = $filters->asKeyValue();
                $array = $this->response('GET', $url, $query);
            }

            return $array['data']['client'];
        } catch (Exception $exception) {
            session()->flash('error',
                "Проверьте свои настройки: url клиники и API ключ.
                Произошла ошибка при выполнении запроса к API: " . $exception->getMessage());
            return [];
        }
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
        try {
            $url = "/rest/api/$nameModal/$id";
            $array = $this->response('DELETE', $url);

            if (!isset($array['success']) || $array['success'] === false) {
                throw new Exception($array['message']);
            }
        } catch (Exception $exception) {
            session()->flash('error',
                "Проверьте свои настройки: url клиники и API ключ.
                Произошла ошибка при выполнении запроса к API: " . $exception->getMessage());
            return [];
        }
    }

    /**
     *Создание клиента или питомца, в зависимости от переданного значения имени модели $nameModal
     */
    public function createInVetmanager(string $nameModal, array $data)
    {
        try {
            $url = "/rest/api/$nameModal";
            $json = $data;
            $array = $this->response('POST', $url, $json);

            if (!$array['success'] || $array['success'] !== true) {
                throw new \Exception($array['message']);
            }

            return $array;
        } catch (Exception $exception) {
            return redirect('/settingsApi')->withErrors($exception->getMessage());
        }
    }

    /**
     *Редактирование клиента или питомца, в зависимости от переданного значения имени модели $nameModal
     */
    public function edit(string $nameModal, array $data, int $id)
    {
        try {
            $url = "/rest/api/$nameModal/$id";
            $json = $data;
            $array = $this->response('PUT', $url, $json);

            if (!$array['success'] || $array['success'] !== true) {
                throw new \Exception($array['message']);
            }
        } catch (Exception $exception) {
            return redirect('/settingsApi')->withErrors($exception->getMessage());
        }
    }

    /**
     *Для fetch petTypesForSelectOption чтобы избежать блокировки политики CORS
     */
    public  function petType()
    {
        try {
            $url = "/rest/api/PetType";
            return $this->response('GET', $url);
        } catch (Exception $exception) {
            return redirect('/settingsApi')->withErrors($exception->getMessage());
        }
    }

    /**
     *Для fetch breedByTypeForSelectOption чтобы избежать блокировки политики CORS
     *Не удалять неиспользуемый аргумент $client, тк breedByType будет неправильно отрабатывать: вместо id типа питомца будет подставлять id клиента
     */
      public  function breedByType(int $client, string $selectedTypeId)
    {
        try {
            $filters = new Filters(new EqualTo(new Property('pet_type_id'), new StringValue($selectedTypeId)));
            $query = $filters->asKeyValue();
            $url = "/rest/api/breed";

            return $this->response('GET', $url, $query);
        } catch (Exception $exception) {
            return redirect('/settingsApi')->withErrors($exception->getMessage());
        }
    }
}
