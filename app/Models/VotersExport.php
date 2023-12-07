<?php
namespace App\Models;

use App\Models\Voter;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class VotersExport implements FromCollection, WithHeadings
{
    protected $district;
    protected $state;

    public function __construct($district, $state)
    {
        $this->district = $district;
        $this->state = $state;
    }

    public function collection()
    {
        $query = Voter::join('states', 'voters.state_id', '=', 'states.id')
                ->join('districts', 'voters.district_id', '=', 'districts.id')
                ->orderBy('voters.created_at', 'DESC');

        if ($this->district) {
            $query->where('voters.district_id', 'like', '%' . $this->district . '%');
        }

        if ($this->state) {
            $query->where('voters.state_id', 'like', '%' . $this->state . '%');
        }


        $voters = $query->get([
            'voter_identification_number',
            'first_name',
            'last_name',
            'email',
            'mobile',
            'dob',
            'address',
            'taluk',
            'district_name',
            'state_name',
            'gender',
            'voters.created_at',
        ]);


        $voters->transform(function ($voter) {
            $voter->dob = Carbon::parse($voter->dob)->format('d/m/Y');

            if ($voter->gender == 1) {
                $voter->gender = 'Male';
            } elseif ($voter->gender == 2) {
                $voter->gender = 'Female';
            } else {
                $voter->gender = 'Other';
            }
            return $voter;
        });

        return $voters;
    }

    public function headings(): array
    {
        return [
            'Voter Identity No',
            'First Name',
            'Last Name',
            'Email',
            'Mobile',
            'Dob',
            'Address',
            'Taluk',
            'District',
            'State',
            'Gender',
            'created_at',
        ];
    }
}
