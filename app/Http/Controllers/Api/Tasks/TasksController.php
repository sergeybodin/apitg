<?php

namespace App\Http\Controllers\Api\Tasks;

use App\Http\Controllers\Controller;
use App\Models\Movies\Movie;
use App\Models\Tasks\Task;
use App\Transformers\Tasks\TaskTransformer;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    protected $model;

    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        $query = $this->model->query()->orderByDesc('id');
        //$filters = collect(is_array($request->get('filters')) ? $request->get('filters') : json_decode($request->get('filters'), true) ?? []);
        //$query = Movie::applyFilters($query, $filters);
        $paginator = $query->paginate(config('app.pagination_limit'));
        return fractal($paginator, new TaskTransformer())->respond();
    }

    public function show($id)
    {
        $model = $this->model->byUuid($id)->firstOrFail();
        return fractal($model, new TaskTransformer())->respond();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'movie_id' => 'required',
            'type' => 'required',
        ]);
        $data = [
            'movie_id' => $request->get('movie_id'),
            'type' => $request->get('type')
        ];
        if ($request->has('data')) {
            $data['data'] = json_encode($request->get('data'));
        }

        //$modal = $this->modal->query()->where($data)->first();

        $model = $this->model->query()->create($data);

        return fractal($model, new TaskTransformer())->respond(201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'type' => 'required',
            'status' => 'required',
        ]);
        $model = $this->model->where('id', $id)->firstOrFail();
        $data = $request->all();
        $model->update($data);
        return fractal($model->fresh(), new TaskTransformer())->respond();
    }

    public function destroy(Request $request, $uuid)
    {
        $model = $this->model->byUuid($uuid)->firstOrFail();
        $model->delete();
        return response()->json(null, 204);
    }

    public function filters()
    {
        $companyMembers = Movie::get();
        $data = [
            'data' => [
                'name' => 'filter-session',
                'title' => 'Фильтр заседания',
                'groups' => [
                    'data' => [
                        [
                            'name' => 'common',
                            'title' => 'Общие параметры',
                            'fields' => [
                                'data' => [
                                    [
                                        'name' => 'commission',
                                        'title' => 'Отображение Заседаний Комиссии',
                                        'type' => 'relation',
                                        'params' => [
                                            'appearance' => 'radio'
                                        ],
                                        'value' => 'all',
                                        'represented' => [
                                            'data' => [
                                                [
                                                    'id' => 'all',
                                                    'title' => 'Показывать все'
                                                ], [
                                                    'id' => 'coming',
                                                    'title' => 'Показывать только предстоящие'
                                                ], [
                                                    'id' => 'archive',
                                                    'title' => 'Показывать только проведенные'
                                                ], [
                                                    'id' => 'authorized',
                                                    'title' => 'Показывать только правомочные'
                                                ], [
                                                    'id' => 'unauthorized',
                                                    'title' => 'Показывать только неправомочные'
                                                ],
                                            ]
                                        ]
                                    ],
                                    [
                                        'type' => 'date',
                                        'name' => 'date',
                                        'title' => 'Дата Заседания',
                                    ],
                                    [
                                        'type' => 'string',
                                        'name' => 'location',
                                        'title' => 'Место проведения Заседания',
                                        'value' => ''
                                    ],
                                    [
                                        'type' => 'relation',
                                        'name' => 'form',
                                        'title' => 'Форма проведения',
                                        'params' => [
                                            'appearance' => 'select'
                                        ],
                                        'represented' => [
                                            'data' => [
                                                [
                                                    'id' => 'fulltime',
                                                    'title' => 'очная'
                                                ], [
                                                    'id' => 'correspondence',
                                                    'title' => 'заочная'
                                                ],
                                            ]
                                        ]
                                    ],
                                    [
                                        'type' => 'relation',
                                        'name' => 'members',
                                        'title' => 'Участники',
                                        'multiple' => true,
                                        'items' => fractal($companyMembers, new CompanyMemberTransformer())
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
