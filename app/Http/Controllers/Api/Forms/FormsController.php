<?php

namespace App\Http\Controllers\Api\Forms;

use App\Http\Controllers\Controller;
use App\Models\Clients\Client;
use App\Models\Clients\ClientType;
use App\Models\Movies\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormsController extends Controller {

    protected array $availableForms = [
        'movie', 'clients'
    ];

    public function new(Request $request, $type): JsonResponse {
        return $this->_getData($type);
    }

    public function edit(Request $request, $type, $uuid): JsonResponse {
        return $this->_getData($type, $uuid);
    }

    private function _getData($type, $uuid = ''): JsonResponse {
        $data = [];
        if (in_array($type, $this->availableForms) && method_exists($this, $type)) {
            $data = $this->$type($uuid);
        }
        return response()->json($data);
    }

    private function _getRelationItems($items): array  {
        $result = [];
        foreach ($items as $id => $title) {
            $result['data'][] = [
                'id' => $id,
                'title' => $title
            ];
        }
        return $result;
    }

    public function movie($id = '') {

        $movie = null;

        if (!empty($id)) {
            $movie = Movie::where('id', $id)->firstOrFail();
        }

        $data = [
            'movie' => $movie,
            'data' => [
                [
                    'name' => 'common',
                    'title' => 'Общие сведения',
                    'fields' => [
                        'data' => [
                            [
                                'name' => 'name_ru',
                                'title' => 'Название на русском',
                                'type' => 'string',
                                'required' => true,
                                'value' => [
                                    'data' => is_null($movie) ? '' : $movie->name_ru
                                ]
                            ],
                            [
                                'name' => 'name_en',
                                'title' => 'Название на английском',
                                'type' => 'string',
                                'required' => true,
                                'value' => [
                                    'data' => is_null($movie) ? '' : $movie->name_en
                                ]
                            ],
                            [
                                'name' => 'quality',
                                'title' => 'Качество',
                                'type' => 'string',
                                'required' => true,
                                'value' => [
                                    'data' => is_null($movie) ? '' : $movie->quality
                                ]
                            ],
                            [
                                'name' => 'year',
                                'title' => 'Год выпуска',
                                'type' => 'string',
                                'required' => true,
                                'value' => [
                                    'data' => is_null($movie) ? '' : $movie->year
                                ]
                            ],
                            [
                                'name' => 'imdb_rating',
                                'title' => 'Рейтинг IMDb',
                                'type' => 'string',
                                'required' => true,
                                'value' => [
                                    'data' => is_null($movie) ? '' : $movie->imdb_rating
                                ]
                            ],
                            [
                                'name' => 'views',
                                'title' => 'Просмотров',
                                'type' => 'string',
                                'required' => true,
                                'value' => [
                                    'data' => is_null($movie) ? '' : $movie->views
                                ]
                            ],
                            [
                                'name' => 'country',
                                'title' => 'Страна',
                                'type' => 'string',
                                'required' => true,
                                'value' => [
                                    'data' => is_null($movie) ? '' : $movie->country
                                ]
                            ],
                            [
                                'name' => 'description',
                                'title' => 'Описание',
                                'type' => 'text',
                                'required' => true,
                                'value' => [
                                    'data' => is_null($movie) ? '' : $movie->description
                                ]
                            ],
                            [
                                'name' => 'poster',
                                'title' => 'Ссылка на постер',
                                'type' => 'string',
                                'required' => true,
                                'value' => [
                                    'data' => is_null($movie) ? '' : $movie->poster
                                ]
                            ],
                            [
                                'name' => 'trailer',
                                'title' => 'Ссылка на трейлер',
                                'type' => 'string',
                                'required' => true,
                                'value' => [
                                    'data' => is_null($movie) ? '' : $movie->trailer
                                ]
                            ],
                            [
                                'name' => 'movie',
                                'title' => 'Ссылка на фильм',
                                'type' => 'string',
                                'required' => true,
                                'value' => [
                                    'data' => is_null($movie) ? '' : $movie->movie
                                ]
                            ],
                        ]
                    ],
                ]
            ]
        ];
        return $data;
    }

    public function clients($id = '') {

        $client = null;

        if (!empty($id)) {
            $client = Client::where('id', $id)->firstOrFail();
        }

        $data = [
            'client' => $client,
            'data' => [
                [
                    'name' => 'common',
                    'title' => 'Общие сведения',
                    'fields' => [
                        'data' => [
                            [
                                'name' => 'telegram_chat_id',
                                'title' => 'Номер чата',
                                'type' => 'string',
                                'required' => true,
                                'disabled' => !is_null($client),
                                'value' => [
                                    'data' => $client->telegram_chat_id ?? null
                                ]
                            ],
                            [
                                'name' => 'type',
                                'title' => 'Тип',
                                'type' => 'relation',
                                'required' => true,
                                'value' => [
                                    'data' => [
                                        [
                                            'id' => $client->type ?? null
                                        ]
                                    ]
                                ],
                                'options' => $this->_getRelationItems(ClientType::TITLES)
                            ],
                        ]
                    ],
                ],
            ]
        ];
        return $data;
    }

//    public function member($uuid = '') {
//        $member = null;
//        if (!empty($uuid)) {
//            $member = CompanyMember::byUuid($uuid)->firstOrFail();
//        }
//
//        $data = [
//            'data' => [
//                [
//                    'name' => 'common',
//                    'title' => 'Общие сведения',
//                    'fields' => [
//                        'data' => [
//                            [
//                                'name' => 'email',
//                                'title' => 'Email',
//                                'type' => 'string',
//                                'required' => true,
//                                'readonly' => !is_null($member),
//                                'value' => [
//                                    'data' => is_null($member) ? '' : $member->user->email
//                                ]
//                            ],
//                            [
//                                'name' => 'name',
//                                'title' => 'Фамилия, имя, отчество',
//                                'type' => 'string',
//                                'required' => true,
//                                'value' => [
//                                    'data' => is_null($member) ? '' : $member->user->name
//                                ]
//                            ],
//                            [
//                                'name' => 'position',
//                                'title' => 'Должность',
//                                'type' => 'string',
//                                'required' => true,
//                                'value' => [
//                                    'data' => is_null($member) ? '' : $member->position
//                                ]
//                            ],
//                            [
//                                'name' => 'phone',
//                                'title' => 'Телефон',
//                                'type' => 'text',
//                                'required' => false,
//                                'value' => [
//                                    'data' => is_null($member) ? '' : $member->user->phone
//                                ]
//                            ],
//                            [
//                                'name' => 'representative',
//                                'title' => 'Назначить уполномоченным представителем',
//                                'type' => 'switch',
//                                'required' => false,
//                                'value' => [
//                                    'data' => is_null($member) ? '' : $member->representative
//                                ]
//                            ],
//                        ]
//                    ],
//                ]
//            ]
//        ];
//        return $data;
//    }
//
//    public function advisories($uuid = '') {
//        $advisoryMember = null;
//        if (!empty($uuid)) {
//            $advisoryMember = AdvisoryMember::byUuid($uuid)->first();
//            $users = User::query()->get();
//        } else {
//            $users = User::query()->where(function ($query) {
//                $userIds = CompanyMember::where(function ($query) {
//                    $memberIds = AdvisoryMember::query()->pluck('company_member_id');
//                    $query->whereIn('id', $memberIds);
//                })->pluck('user_id');
//                $query->whereNotIn('id', $userIds);
//            })->get();
//        }
//
//        $data = [
//            'data' => [
//                [
//                    'name' => 'common',
//                    'title' => 'Общие сведения',
//                    'fields' => [
//                        'data' => [
//                            [
//                                'name' => 'user',
//                                'title' => 'Фамилия, имя, отчество',
//                                'type' => 'relation',
//                                'required' => true,
//                                'readonly' => !empty($uuid),
//                                'value' => [
//                                    'data' => [
//                                        [
//                                            'id' => empty($uuid) ? '' : $advisoryMember->companyMember->user->uuid
//                                        ]
//                                    ]
//                                ],
//                                'options' => fractal($users, UserTransformer::class)
//                            ],
//                            [
//                                'name' => 'rank',
//                                'title' => 'Роль',
//                                'type' => 'relation',
//                                'required' => true,
//                                'value' => [
//                                    'data' => [
//                                        [
//                                            'id' => empty($uuid) ? '' : $advisoryMember->rank
//                                        ]
//                                    ]
//                                ],
//                                'options' => $this->_getRelationItems(AdvisoryMemberRank::TITLES)
//                            ],
//                        ]
//                    ],
//                ]
//            ]
//        ];
//        return $data;
//    }
//
//    public function session($uuid = '') {
//
//        if (empty($uuid)) {
//            $advisorySession = null;
//            $members = [];
//        } else {
//            $advisorySession = AdvisorySession::byUuid($uuid)->first();
//            $members = [];
//            $invitations = $advisorySession->invitations;
//            foreach($invitations as $invitation) {
//                $members[] = [
//                    'id' => $invitation->companyMember->id,
//                    'name' => $invitation->companyMember->user->name,
//                ];
//            }
//        }
//
//        $companyMembers = CompanyMember::query()->get();
//
//        $questionItems = [
//            $this->getQuestion(),
//        ];
//
//        $data = [
//            'data' => [
//                [
//                    'hidden' => false,
//                    'name' => 'common',
//                    'title' => 'Общие сведения',
//                    'fields' => [
//                        'data' => [
//                            [
//                                'name' => 'name',
//                                'title' => 'Наименование Заседания',
//                                'type' => 'text',
//                                'required' => true,
//                                'value' => [
//                                    'data' => is_null($advisorySession) ? '' : $advisorySession->name
//                                ]
//                            ],
//                            [
//                                'name' => 'date',
//                                'title' => 'Дата Заседания',
//                                'type' => 'date',
//                                'required' => true,
//                                'value' => [
//                                    'data' =>  is_null($advisorySession) ? '' : date('Y-m-d', strtotime($advisorySession->date))
//                                ]
//                            ],
//                            [
//                                'name' => 'time',
//                                'title' => 'Время проведения Заседания',
//                                'type' => 'time',
//                                'required' => true,
//                                'value' => [
//                                    'data' =>  is_null($advisorySession) ? '' : date('H:i', strtotime($advisorySession->time))
//                                ]
//                            ],
//                            [
//                                'name' => 'location',
//                                'title' => 'Место проведения Заседания',
//                                'type' => 'string',
//                                'required' => false,
//                                'value' => [
//                                    'data' =>  is_null($advisorySession) ? '' : $advisorySession->location
//                                ],
//                            ],
//                            [
//                                'name' => 'form',
//                                'title' => 'Форма проведения',
//                                'type' => 'relation',
//                                'multiple' => false,
//                                'required' => false,
//                                'value' => [
//                                    'data' => [
//                                        [
//                                            'id' =>  is_null($advisorySession) ? '' : $advisorySession->form
//                                        ]
//                                    ]
//                                ],
//                                'options' => $this->_getRelationItems(AdvisorySessionForm::TITLES),
//                            ],
//                        ]
//                    ],
//                ],
//                [
//                    'hidden' => true,
//                    'name' => 'members',
//                    'title' => 'Приглашенные участники',
//                    'fields' => [
//                        'data' => [
//                            [
//                                'name' => 'members',
//                                'title' => 'ФИО и должность участника',
//                                'type' => 'relation',
//                                'multiple' => true,
//                                'required' => false,
//                                'items' => fractal($companyMembers, CompanyMemberTransformer::class),
//                                'value' => [
//                                    'data' => $members
//                                ]
//                            ],
//                        ]
//                    ],
//                ],
//                [
//                    'hidden' => true,
//                    'name' => 'agenda',
//                    'title' => 'Повестка',
//                    'fields' => [
//                        'data' => [
//                            [
//                                'type' => 'question',
//                                'items' => $questionItems
//                            ]
//                        ]
//                    ],
//                ],
//                [
//                    'hidden' => true,
//                    'name' => 'key',
//                    'title' => 'Цифровой ключ',
//                    'fields' => [
//                        'data' => [
//                            [
//                                'name' => 'key',
//                                'title' => 'Код-пароль с вашего устройства генератора паролей*',
//                                'type' => 'string',
//                                'required' => false,
//                                'value' => [
//                                    'data' => ''
//                                ],
//                                'options' => $this->_getRelationItems([1=>'Очная', 2=>'Заочная']),
//                            ],
//                        ]
//                    ],
//                ]
//            ]
//        ];
//        return $data;
//    }
//
//    public function getQuestion() {
//        $users = User::query()->get();
//        return [
//            [
//                'title' => 'Формулировка',
//                'type' => 'text',
//                'filterable' => false,
//                'multiple' => false,
//                'name' => 'text',
//                'related' => null,
//                'required' => true,
//                'value' => [
//                    'data' => 'Заседание 1'
//                ]
//            ],
//            [
//                'title' => 'ФИО и должность докладчика',
//                'type' => 'relation',
//                'name' => 'member',
//                'multiple' => false,
//                'required' => false,
//                'items' => fractal($users, UserTransformer::class),
//                'value' => [
//                    'data' => [
//
//                    ]
//                ],
//            ],
//            [
//                'title' => '',
//                'filterable' => false,
//                'multiple' => true,
//                'name' => 'assets',
//                'related' => null,
//                'required' => true,
//                'type' => 'document',
//                'value' => [
//                    'data' => [
//
//                    ]
//                ]
//            ]
//        ];
//    }
}
