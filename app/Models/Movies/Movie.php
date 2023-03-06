<?php

namespace App\Models\Movies;

use App\Models\Tasks\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        //'uuid',
        'name_ru',
        'name_en',
        'quality',
        'year',
        'imdb_rating',
        'views',
        'country',
        'description',
        'poster',
        'trailer',
        'movie',
    ];

    protected $hidden = [
        'id'
    ];

    public function tasks(): HasMany {
        return $this->hasMany(Task::class, 'movie_id');
    }
}
