<?php

namespace App\Livewire;

use App\Models\Kategori;
use App\Models\Pulau;
use App\Models\Seksi;
use App\Models\User;
use Livewire\Component;

class FormFilterKinerja extends Component
{
    public $seksi_id = null;
    public $pulau_id = null;
    public $user_id = null;
    public $kategori_id = null;
    public $user_required = null;
    public $kategori_required = null;

    public function mount($seksi_id = null, $pulau_id = null, $user_id = null, $kategori_id = null, $user_required = null, $kategori_required = null)
    {
        $this->seksi_id = $seksi_id;
        $this->pulau_id = $pulau_id;
        $this->user_id = $user_id;
        $this->kategori_id = $kategori_id;
    }

    public function updatedSeksiId()
    {
        $this->pulau_id = null;
        $this->user_id = null;
        $this->kategori_id = null;
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
        $kategori = collect();

        if ($this->seksi_id) {
            $pulau = Pulau::orderBy('name', 'ASC')->get();
            $user = User::whereRelation('struktur.seksi', 'id', '=', $this->seksi_id)
                ->where('employee_type_id', 3) //PJLP Only
                ->orderBy('name', 'ASC')
                ->get();
            $kategori = Kategori::where('seksi_id', $this->seksi_id)
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

        return view('livewire.form-filter-kinerja', [
            'seksi' => $seksi,
            'pulau' => $pulau,
            'user' => $user,
            'kategori' => $kategori,
            'seksi_id' => $this->seksi_id,
            'pulau_id' => $this->pulau_id,
            'user_id' => $this->user_id,
            'kategori_id' => $this->kategori_id,
            'user_required' => $this->user_required,
            'kategori_required' => $this->kategori_required,
        ]);
    }
}
