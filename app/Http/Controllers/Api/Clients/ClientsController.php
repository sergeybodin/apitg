<?php

namespace App\Http\Controllers\Api\Clients;

use App\Http\Controllers\Controller;
use App\Models\Clients\Client;
use App\Models\Clients\ClientType;
use App\Models\Movies\Movie;
use App\Transformers\Clients\ClientTransformer;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    protected $model;

    public function __construct(Client $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        $query = $this->model->query()->orderByDesc('id');
        //$filters = collect(is_array($request->get('filters')) ? $request->get('filters') : json_decode($request->get('filters'), true) ?? []);
        //$query = Movie::applyFilters($query, $filters);
        $paginator = $query->paginate(config('app.pagination_limit'));
        return fractal($paginator, new ClientTransformer())->respond();
    }

    public function show($id)
    {
        $model = $this->model->byUuid($id)->firstOrFail();
        return fractal($model, new ClientTransformer())->respond();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
            'telegram_chat_id' => 'required',
        ]);
        $model = $this->model->query()->create($request->all());
        return fractal($model, new ClientTransformer())->respond(201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'type' => 'required',
            'telegram_chat_id' => 'required',
        ]);
        $model = $this->model->where('id', $id)->firstOrFail();
        $model->update($request->all());
        return fractal($model->fresh(), new ClientTransformer())->respond();
    }

    public function destroy(Request $request, $uuid)
    {
        $model = $this->model->byUuid($uuid)->firstOrFail();
        $model->delete();
        return response()->json(null, 204);
    }

    public function filters()
    {
        $clientTypes = ClientType::get();
        $data = [
            'data' => [
                'name' => 'filter-session',
                'title' => '???????????? ??????????????????',
                'groups' => [
                    'data' => [
                        [
                            'name' => 'common',
                            'title' => '?????????? ??????????????????',
                            'fields' => [
                                'data' => [
                                    [
                                        'name' => 'commission',
                                        'title' => '?????????????????????? ?????????????????? ????????????????',
                                        'type' => 'relation',
                                        'params' => [
                                            'appearance' => 'radio'
                                        ],
                                        'value' => 'all',
                                        'represented' => [
                                            'data' => [
                                                [
                                                    'id' => 'all',
                                                    'title' => '???????????????????? ??????'
                                                ], [
                                                    'id' => 'coming',
                                                    'title' => '???????????????????? ???????????? ??????????????????????'
                                                ], [
                                                    'id' => 'archive',
                                                    'title' => '???????????????????? ???????????? ??????????????????????'
                                                ], [
                                                    'id' => 'authorized',
                                                    'title' => '???????????????????? ???????????? ??????????????????????'
                                                ], [
                                                    'id' => 'unauthorized',
                                                    'title' => '???????????????????? ???????????? ??????????????????????????'
                                                ],
                                            ]
                                        ]
                                    ],
                                    [
                                        'type' => 'date',
                                        'name' => 'date',
                                        'title' => '???????? ??????????????????',
                                    ],
                                    [
                                        'type' => 'string',
                                        'name' => 'location',
                                        'title' => '?????????? ???????????????????? ??????????????????',
                                        'value' => ''
                                    ],
                                    [
                                        'type' => 'relation',
                                        'name' => 'form',
                                        'title' => '?????????? ????????????????????',
                                        'params' => [
                                            'appearance' => 'select'
                                        ],
                                        'represented' => [
                                            'data' => [
                                                [
                                                    'id' => 'fulltime',
                                                    'title' => '??????????'
                                                ], [
                                                    'id' => 'correspondence',
                                                    'title' => '??????????????'
                                                ],
                                            ]
                                        ]
                                    ],
                                    [
                                        'type' => 'relation',
                                        'name' => 'members',
                                        'title' => '??????????????????',
                                        'multiple' => true,
                                        'items' => fractal($clientTypes, new ClientTransformer())
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        return response()->json($data, 200);
    }
}
