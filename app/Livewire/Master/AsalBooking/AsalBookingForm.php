<?php

namespace App\Livewire\Master\AsalBooking;

use App\Models\master\asalBooking;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use App\Models\master\fnb;
use App\Models\master\jenisFnb;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AsalBookingForm extends Component
{
    #[Layout('components.layouts.app')]
    public $aslbooking_id;
    public $aslbooking_name;
    public $keterangan;

    public function resetForm()
    {
        $this->aslbooking_id = null;
        $this->reset();
    }
    public function mount()
    {
        $this->loadData();
    }
    public function create()
    {
        $user = Auth::user();
        $rules = [
            'aslbooking_name' => [
                'required',
                Rule::unique('ms_stts_asalbooking')->ignore($this->aslbooking_id, 'aslbooking_id')->where(function ($query) {
                    return $query->where('deleted_at', null);
                }),
            ],
        ];
        $this->validate($rules);
        if (session('function') === null) {
            $create = asalBooking::create([
                'aslbooking_name' => $this->aslbooking_name,
                'keterangan' => $this->keterangan,
                'created_by' => $user->user_id,
            ]);
            $this->dispatch('resetForm', [
                'type' => 'success', // atau 'error' sesuai kebutuhan
                'message' => "item {$this->aslbooking_name} berhasil dibuat."
            ]);
            $this->resetForm();
        } else {
            $update = asalBooking::where('aslbooking_id', $this->aslbooking_id)->update([
                'aslbooking_name' => $this->aslbooking_name,
                'keterangan' => $this->keterangan,
                'updated_by' => $user->user_id,
            ]);
            $this->dispatch('resetForm', [
                'type' => 'success', // atau 'error' sesuai kebutuhan
                'message' => "item {$this->aslbooking_name} berhasil dibuat."
            ]);
            $this->resetForm();
        }
    }
    public function loadData()
    {
        $this->aslbooking_id = session('aslbooking_id');
        if ($this->aslbooking_id) {
            $data = asalBooking::find($this->aslbooking_id);
            if ($data) {
                $this->aslbooking_name = $data->aslbooking_name;
                $this->keterangan = $data->keterangan;
            } else {
                $this->resetForm();
            }
        } else {
            $this->resetForm();
        }
    }
    public function goBack()
    {
        session()->forget(['aslbooking_id', 'function']);
        return redirect()->to('/master/asalbooking/index');
    }
    public function render()
    {
        return view('livewire.master.asal-booking.asal-booking-form');
    }
}
