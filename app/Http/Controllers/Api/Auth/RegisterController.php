<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Models\Companies\Company;
use App\Models\Companies\CompanyMember;
use App\Models\User;
use App\Transformers\Users\UserTransformer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function checkEmail(Request $request) {
    	$this->validate($request, [
    		'email' => 'required|email|unique:users,email'
		]);
		return response()->json(null, 200);
	}

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);
        $user = $this->model->create($request->all());
        $user->assignRole('User');
        event(new Registered($user));

        return fractal($user, new UserTransformer())->respond(201);
    }

	public function storeWithCompany(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required|email|unique:users,email',
			'company.name' => 'required',
			'company.full_name' => 'required',
			'company.inn' => 'required|unique:companies,inn',
			'company.kpp' => 'required',
			'company.ogrn' => 'required'
		]);
		$password = Str::random(8);
		$user = $this->model->create($request->all() + ['password' => $password]);
		$user->assignRole('User');

		$company = Company::create($request->get('company'));
		$company->createRelatedModels();
		$company->requestDadata();
		$company->syncRoles(['applicant']);
		$member = $user->membership()->firstOrCreate([
			'company_id' => $company->id,
			'role' => CompanyMember::$ROLE_ROOT,
			'position' => 'Генеральный директор'
		]);
		$member->select();
		$member->director();
		$member->defaultResponsible();
		$member->setTemporaryKey();

		event(new UserRegistered($user, $password));

		return fractal($user, new UserTransformer())->respond(201);
	}
}
