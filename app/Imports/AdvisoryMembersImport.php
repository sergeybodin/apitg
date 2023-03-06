<?php

namespace App\Imports;

use App\Models\Advisories\Advisory;
use App\Models\Advisories\AdvisoryMemberRank;
use App\Models\Companies\Company;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AdvisoryMembersImport extends Import implements ToCollection, WithHeadingRow {
    public Advisory $advisory;

    public array $mapper = [
        'name' => ['prop' => 'fio', 'required' => true],
        'email' => ['prop' => 'email', 'required' => true],
        'inn' => ['prop' => 'inn_organizacii', 'required' => true],
        'position' => ['prop' => 'dolznost', 'required' => true],
        'rank' => ['prop' => 'polozenie']
    ];


    public function __construct(Advisory $advisory) {
        $this->advisory = $advisory;
    }

    public function collection(Collection $collection) {
        $collection->each(function($row) {
            if ($row = $this->mapData($row)) $this->importRow($row);
        });
    }

    public function importRow($row) {
        $company = Company::getByData(['inn' => $row['inn']]);
        $user = User::getByData($row);
        $companyMember = $company->members()->firstOrCreate(['user_id' => $user->id, 'position' => $row['position']]);
        $advisoryMember = $this->advisory->members()->firstOrCreate(['company_member_id' => $companyMember->id]);
        $advisoryMember->update(['rank' => $this->translateRole($row['rank'] ?? null)]);
    }

    public function translateRole($rank) {
        $aRoles = [
            'председатель' => AdvisoryMemberRank::CHAIRMAN,
            'заместитель председателя' => AdvisoryMemberRank::VICE_CHAIRMAN,
            'секретарь' => AdvisoryMemberRank::SECRETARY
        ];
        return $aRoles[Str::lower(trim($rank))] ?? AdvisoryMemberRank::ORDINARY;
    }

}
