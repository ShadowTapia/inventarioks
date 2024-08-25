<?php

namespace App\Livewire;

use App\Models\company;
use Illuminate\Auth\Access\Gate;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;


class DelCompany extends ModalComponent
{
    public company $company;

    public function render()
    {
        return view('livewire.del-company');
    }
}
