<?php

namespace App\Livewire\Pelanggan;

use App\Models\Pelanggan;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;
    public $search = '';

    public function render()
    {
        return view('livewire.pelanggan.index' ,  [
            'pelanggans' => Pelanggan::search($this->search)->paginate($this->perPage),
        ]);
    }
}
