<?php

namespace App\Livewire\Master\AsalBooking;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AsalBookingIndex extends Component
{
    #[Layout('components.layouts.app')]
    public $username;
    public $isTableLoaded = false;
    public function loadTable()
    {
        $this->isTableLoaded = true;
    }
    public function mount()
    {
        if (Auth::check()) {
            $this->username = Auth::user()->user_name;
        } else {
            return redirect()->route('login');
        }
    }
    public function create()
    {
        session()->forget(['aslbooking_id', 'function']);

        $this->redirect('/master/asalbooking/create');
    }
    public function render()
    {
        return view('livewire.master.asal-booking.asal-booking-index');
    }
}
