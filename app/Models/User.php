<?php

namespace App\Models;

use App\Models\Companies\Company;
use App\Models\Companies\CompanyMember;
use App\Support\HasRolesUuid;
use App\Support\HasSocialLogin;
use App\Support\RelationValuesTrait;
use App\Support\UuidScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {
    use Notifiable, UuidScopeTrait, HasFactory, HasApiTokens, HasRoles, SoftDeletes, HasSocialLogin, RelationValuesTrait, HasRolesUuid {
        HasRolesUuid::getStoredRole insteadof HasRoles;
    }

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'name',
        'phone',
        'uuid',
        'email',
        'password'
    ];

    protected $hidden = [
        'id',
        'password',
        'remember_token',
    ];



    public function socialProviders(): HasMany {
        return $this->hasMany(SocialProvider::class);
    }

	public function avatar(): BelongsTo {
    	return $this->belongsTo(Asset::class);
	}

    public function companies(): BelongsToMany {
        return $this->belongsToMany(Company::class, 'company_members');
    }

    public function membership(): HasMany {
        return $this->hasMany(CompanyMember::class);
    }

    public function key(): HasOne {
        return $this->hasOne(UserKey::class);
    }



    public function getSelectedMemberAttribute(): ?Model {
        return $this->membership()->orderBy('selected', 'desc')->first();
    }

    public function getHasKeyAttribute(): bool {
        return $this->key && $this->key->isActive;
    }

    public function getParsedAbbreviationNameAttribute(): string {
        $result = '';
        $names = explode(' ', $this->name);
        if (count($names)==1) {
            $result = mb_substr($names[0], 0, 1);
        } else if (count($names)>1) {
            $result = mb_substr($names[0], 0, 1).mb_substr($names[1], 0, 1);
        }
        return mb_strtoupper($result);
    }



    public function isCompanyMember(Company $company): bool {
        return $this->membership()->where('company_id', $company->id)->exists();
    }

    public function isMyMember(CompanyMember $member): bool {
        return $member->user->id === $this->id;
    }

    public function isAdmin(): bool {
        return $this->hasRole('Administrator');
    }

    public function checkKey($code): bool {
        return $this->key ? $this->key->check($code) : false;
    }

    public function setTemporaryKey(): Model {
        return $this->setKey("TMP000{$this->id}", md5(now()));
    }

    public function setKey($number, $secret): Model {
        $key = $this->key()->firstOrCreate();
        $key->update(['number' => $number, 'secret' => $secret, 'counter' => 0, 'active_since' => now(),
            'active_till' => now()->addYear()->subDay(), 'is_revoked' => 0]);
        return $key;
    }



    public static function getByData($data) {
        $result = false;
        if (!empty($data['email'])) {
            $result = self::query()->where(['email' => $data['email']])->first() ?? self::create(['email' => $data['email'], 'password' => $data['password'] ?? 'Qwerty1!']);
            if (!empty($data['name'])) $result->update(['name' => $data['name']]);
        }
        return $result;
    }

    public static function create(array $attributes = []) {
        if (array_key_exists('password', $attributes)) {
            $attributes['password'] = Hash::make($attributes['password']);
        }
        return static::query()->create($attributes);
    }
}
