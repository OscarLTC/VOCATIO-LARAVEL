<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SurveyEnterprisePersonsExport implements FromCollection, WithHeadings
{
    protected $surveyEnterprisePersons;
    protected $domain;

    public function __construct($surveyEnterprisePersons, $domain = null)
    {
        $this->surveyEnterprisePersons = $surveyEnterprisePersons;
        $this->domain = $domain ?? '';
    }

    public function collection()
    {
        return $this->surveyEnterprisePersons->map(function ($person) {
            return [
                'Nombre y Apellido' => $person->person->name . ' ' . $person->person->lastName,
                'Links' => url($this->domain . '/encuestas/person/' . $person->id)
            ];
        });
    }

    public function headings(): array
    {
        return ['Nombre y Apellido', 'Links'];
    }
}
