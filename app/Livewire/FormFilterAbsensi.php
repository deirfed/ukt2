<?php

namespace App\Livewire;

use App\Models\Pulau;
use App\Models\Seksi;
use App\Models\User;
use Livewire\Component;

class FormFilterAbsensi extends Component
{
    public $seksi_id = null;
    public $pulau_id = null;
    public $user_id = null;
    public $user_required = null;

    public function mount($seksi_id = null, $pulau_id = null, $user_id = null, $user_required = null)
    {
        $this->seksi_id = $seksi_id;
        $this->pulau_id = $pulau_id;
        $this->user_id = $user_id;
        $this->user_required = $user_required;
    }

    public function updatedSeksiId()
    {
        $this->pulau_id = null;
        $this->user_id = null;
    }

    public function updatedPulauId()
    {
        $this->user_id = null;
    }

    public function render()
    {
        $seksi = Seksi::orderBy('name', 'ASC')->get();
        $pulau = collect();
        $user = collect();

        if ($this->seksi_id) {
            $pulau = Pulau::orderBy('name', 'ASC')->get();
            $user = User::whereRelation('struktur.seksi', 'id', '=', $this->seksi_id)
                ->where('employee_type_id', 3) //PJLP Only
                ->orderBy('name', 'ASC')
                ->get();
        }

        if ($this->seksi_id && $this->pulau_id) {
            $user = User::whereRelation('area.pulau', 'id', '=', $this->pulau_id)
                ->whereRelation('struktur.seksi', 'id', '=', $this->seksi_id)
                ->where('employee_type_id', 3) //PJLP Only
                ->orderBy('name', 'ASC')
                ->get();
        }

        return view('livewire.form-filter-absensi', [
            'seksi' => $seksi,
            'pulau' => $pulau,
            'user' => $user,
            'seksi_id' => $this->seksi_id,
            'pulau_id' => $this->pulau_id,
            'user_id' => $this->user_id,
            'user_required' => $this->user_required,
        ]);
    }
}
