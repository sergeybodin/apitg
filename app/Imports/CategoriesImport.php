<?php

namespace App\Imports;

use App\Models\Catalog\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CategoriesImport extends Import implements ToCollection {
    public function collection(Collection $collection) {
        $collection->each(function($row) {
            list($number, $name) = $row;
            if (($number = trim($number, ' ')) && ($name = trim($name))) {
                $parent = $this->getParent($number);
                Category::query()->firstOrCreate(['number' => $number, 'parent_id' => $parent ? $parent->id : 0])->update(['name' => $name]);
            }
        });
    }

    public function getParent($number) {
        $result = false;
        $digits = explode('.', $number);
        if (count($digits) === 3) {
            $digits = array_reverse($digits);
            foreach ($digits as $k => $digit) {
                if ($digit !== '00') {
                    $digits[$k] = '00';
                    break;
                }
            }
            $parentNumber = implode('.', array_reverse($digits));
            if ($parentNumber !== '00.00.00') {
                $result = Category::firstOrCreate(['number' => $parentNumber]);
            }
        }
        return $result;
    }
}
