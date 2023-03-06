<?php

namespace App\Imports;

use App\Models\Classification\Classifier;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ClassifierCodesImport extends Import implements ToCollection {
    public Classifier $classifier;

    public function __construct(Classifier $classifier) {
        $this->classifier = $classifier;
    }

    public function collection(Collection $collection) {
        $collection->each(function($row) {
            list($name, $title) = $row;
            if (($name = trim($name)) && ($title = trim($title))) {
                $this->classifier->codes()->firstOrCreate(['name' => $name])->update(['title' => $title]);
            }
        });
    }
}
