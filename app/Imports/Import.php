<?php

namespace App\Imports;

use Illuminate\Support\Str;

class Import {
    public array $mapper = [];

    public function mapData($row) {
        $result = [];
        foreach ($this->mapper as $int => $data) {
            if (!empty($data['prop']) && !empty($row[$data['prop']])) $result[$int] = trim(Str::replace(' ', '', $row[$data['prop']]));
            if (!empty($data['required']) && empty($result[$int])) return false;
        }
        return $result;
    }
}
