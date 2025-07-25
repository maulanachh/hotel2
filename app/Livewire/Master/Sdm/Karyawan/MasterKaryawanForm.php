<?php

namespace App\Livewire\Master\Sdm\Karyawan;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use App\Models\master\jenisKelamin;
use App\Models\master\pendidikan;
use App\Models\master\masterKaryawan;
use App\Models\master\MasterPekerjaan;
use Illuminate\Support\Carbon;

class MasterKaryawanForm extends Component
{
    #[Layout('components.layouts.app')]
    public $karyawan_id;
    public $pekerjaan_id;
    public $jenkel_id;
    public $pendidikan_id;
    public $karyawan_name;
    public $tempat_lahir;
    public $tgl_lahir;
    public $phone;
    public $alamat;
    public $jenis_pekerjaan = [];
    public $jenis_kelamin = [];
    public $pendidikan = [];
    public function resetForm()
    {
        $this->karyawan_id = null;
        $this->reset();
        $this->selectJenisPekerjaan();
        $this->selectJenisKelamin();
        $this->selectPendidikan();
    }
    public function mount()
    {
        $this->loadKaryawan();
        $this->selectJenisPekerjaan();
        $this->selectJenisKelamin();
        $this->selectPendidikan();
    }
    public function selectJenisPekerjaan()
    {
        $this->jenis_pekerjaan = DB::table('ms_pekerjaan')
            ->where('deleted_at', null)->pluck('pekerjaan_name', 'pekerjaan_id');
    }
    public function selectJenisKelamin()
    {
        $this->jenis_kelamin = DB::table('ms_jenis_kelamin')->pluck('kelamin', 'jenkel_id');
    }
    public function selectPendidikan()
    {
        $this->pendidikan = DB::table('ms_pendidikan')->pluck('pendidikan_name', 'pendidikan_id');
    }
    public function createKaryawan()
    {
        $user = Auth::user();
        $rules = [
            'karyawan_name' => ['required'],
            'pekerjaan_id' => ['required'],
            'jenkel_id' => ['required'],
            'pendidikan_id' => ['required'],
            'tempat_lahir' => ['required'],
            'tgl_lahir' => ['required'],
            'phone' => ['required'],
            'alamat' => ['required'],
        ];
        $this->validate($rules);
        $date_tgl_lahir = Carbon::createFromFormat('d M, Y', $this->tgl_lahir)->format('Y-m-d');
        if (session('function') === null) {
            $karyawan_create = masterKaryawan::create([
                'karyawan_name' => $this->karyawan_name,
                'pekerjaan_id' => $this->pekerjaan_id,
                'jenkel_id' => $this->jenkel_id,
                'pendidikan_id' => $this->pendidikan_id,
                'tempat_lahir' => $this->tempat_lahir,
                'tgl_lahir' => $date_tgl_lahir,
                'phone' => $this->phone,
                'alamat' => $this->alamat,
                'created_by' => $user->user_id,
            ]);
            $this->dispatch('resetForm', [
                'type' => 'success', // atau 'error' sesuai kebutuhan
                'message' => "Karyawan {$this->karyawan_name} berhasil dibuat."
            ]);
            $this->resetForm();
        } else {
            $karyawan_update = masterKaryawan::where('karyawan_id', $this->karyawan_id)->update([
                'karyawan_name' => $this->karyawan_name,
                'pekerjaan_id' => $this->pekerjaan_id,
                'jenkel_id' => $this->jenkel_id,
                'pendidikan_id' => $this->pendidikan_id,
                'tempat_lahir' => $this->tempat_lahir,
                'tgl_lahir' => $date_tgl_lahir,
                'phone' => $this->phone,
                'alamat' => $this->alamat,
                'updated_by' => $user->user_id,
            ]);
            $this->dispatch('resetForm', [
                'type' => 'success', // atau 'error' sesuai kebutuhan
                'message' => "Karyawan {$this->karyawan_name} berhasil diupdate."
            ]);
            $this->resetForm();
        }
    }
    public function loadKaryawan()
    {
        $this->karyawan_id = session('karyawan_id');
        if ($this->karyawan_id) {
            $karyawan = masterKaryawan::find($this->karyawan_id);
            if ($karyawan) {
                $tgl_lahir = Carbon::parse($karyawan->tgl_lahir)->format('d M, Y');
                $this->karyawan_name = $karyawan->karyawan_name;
                $this->pekerjaan_id = $karyawan->pekerjaan_id;
                $this->jenkel_id = $karyawan->jenkel_id;
                $this->pendidikan_id = $karyawan->pendidikan_id;
                $this->tempat_lahir = $karyawan->tempat_lahir;
                $this->tgl_lahir = $tgl_lahir;
                $this->phone = $karyawan->phone;
                $this->alamat = $karyawan->alamat;
            } else {
                $this->resetForm();
            }
        } else {
            $this->resetForm();
        }
    }
    public function goBack()
    {
        session()->forget(['karyawan_id', 'function']);
        return redirect()->to('/master/sdm/masterkaryawan');
    }
    public function render()
    {
        return view('livewire.master.sdm.karyawan.master-karyawan-form');
    }
}
