<?php

namespace Database\Seeders;

use App\Models\Movies\Movie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovieSeeder extends Seeder
{
    private $_items = [
        [
            'name_ru' => 'Топ Ган: Мэверик',
            'name_en' => 'Top Gun: Maverick',
            'quality' => 'UHD 4K HD + AC3',
            'year' => 2022,
            'imdb_rating' => 8.5,
            'views' => 320415,
            'country' => 'США',
            'description' => 'Пит Митчелл по прозвищу Мэверик более 30 лет остается одним из лучших пилотов ВМФ: бесстрашный летчик-испытатель, он расширяет границы возможного и старательно избегает повышения в звании, которое заставило бы его приземлиться навсегда. Приступив к подготовке отряда выпускников «Топ Ган» для специальной миссии, подобной которой никогда не было, Мэверик встречает лейтенанта Брэдли Брэдшоу, сына своего покойного друга, лейтенанта Ника Брэдшоу.',
            //'poster' => '/public/films/posters/image_2022_08_31T16_18_47_820Z.png',
            'poster' => 'https://upload.wikimedia.org/wikipedia/ru/7/7d/Top_Gun-_Maverick.jpg',
            'trailer' => 'https://clck.ru/weUjo',
            'movie' => 'https://clck.ru/weVCU',
        ],
        [
            'name_ru' => 'Миньоны: Грювитация',
            'name_en' => 'Minions: The Rise of Gru',
            'quality' => 'UHD 4K HD + AC3',
            'year' => 2022,
            'imdb_rating' => 6.6,
            'views' => 46677,
            'country' => 'США',
            'description' => 'Миллион лет миньоны искали самого великого и ужасного предводителя, пока не встретили ЕГО. Знакомьтесь — Грю. Пусть он еще очень молод, но у него в планах по-настоящему гадкие дела, которые заставят планету содрогнуться.',
            //'poster' => '/public/films/posters/image_2022_08_31T16_21_48_964Z.png',
            'poster' => 'https://upload.wikimedia.org/wikipedia/ru/a/a7/Minions_-_The_Rise_of_Gru_%28poster%29.jpg',
            'trailer' => 'https://clck.ru/weWZA',
            'movie' => 'https://clck.ru/weX6E',
        ],
        [
            'name_ru' => 'Добыча',
            'name_en' => 'Prey',
            'quality' => 'UHD 4K HD + AC3',
            'year' => 2022,
            'imdb_rating' => 7.2,
            'views' => 135305,
            'country' => 'США',
            'description' => 'Основано на франшизе «Хищник» Джима Томаса и Джона Томаса. Это пятая часть франшизы и приквел к первым четырём фильмам. Женщина-воин Нару пытается защитить своё племя от одного из первых высокоразвитых Хищников, высадившихся на Земле.',
            //'poster' => '/public/films/posters/image_2022_08_31T16_28_28_218Z.png',
            'poster' => 'https://upload.wikimedia.org/wikipedia/ru/3/3a/Prey_%282022_film%29.jpg',
            'trailer' => 'https://clck.ru/wec8n',
            'movie' => 'https://clck.ru/wecWc',
        ],
        [
            'name_ru' => 'Удача',
            'name_en' => 'Luck',
            'quality' => 'UHD 4K HD + AC3',
            'year' => 2022,
            'imdb_rating' => 6.3,
            'views' => 11762,
            'country' => 'США, Испания',
            'description' => 'Сэм Гринфилд — самая невезучая девочка в мире! Внезапно оказавшись в невиданной Стране Удачи, она объединяется с населяющими её волшебными существами, чтобы вернуть своё везение.',
//            'poster' => '/public/films/posters/image_2022_08_31T16_31_27_546Z.png',
            'poster' => 'https://upload.wikimedia.org/wikipedia/ru/f/f8/Удача_%28мультфильм%2C_2022%29.jpg',
            'trailer' => 'https://clck.ru/wec8n',
            'movie' => 'https://clck.ru/weecR',
        ],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->_items as $item) {
            Movie::create($item);
        }
    }
}
