<?php

use App\Http\Controllers\api\costumerController;
use App\Livewire\AuthLogin;
use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;
use App\Livewire\Setting\Role\RoleGroupForm;
use App\Livewire\Setting\Role\RoleIndex;
use App\Livewire\Setting\SettingIndex;
use App\Livewire\Setting\Developer\FeatureIndex;
use App\Livewire\Setting\Developer\FeatureForm;
use App\Livewire\Setting\RoleFeature\RoleFeatureIndex;
use App\Livewire\Master\MasterIndex;
use App\Livewire\Master\Msops\FasilitasKamar\FasilitaskamarForm;
use App\Livewire\Master\Msops\FasilitasKamar\FasilitasKamarIndex;
use App\Livewire\Master\Msops\JenisKamar\JenisKamarIndex;
use App\Livewire\Master\Msops\KelasKamar\KelasKamarForm;
use App\Livewire\Master\Msops\KelasKamar\KelasKamarIndex;
use App\Livewire\Master\Msops\JenisKamar\JenisKamarForm;
use App\Livewire\Master\Msops\NamaKamar\NamaKamarForm;
use App\Livewire\Master\Msops\NamaKamar\NamaKamarIndex;
//api
use App\Http\Controllers\api\searchFeatureController;
use App\Http\Controllers\transaksi\invoiceController;
use App\Livewire\Master\AsalBooking\AsalBookingForm;
use App\Livewire\Master\AsalBooking\AsalBookingIndex;
use App\Livewire\Master\Customers\CustomerForm;
use App\Livewire\Master\Customers\CustomerIndex;
use App\Livewire\Master\FNB\FnbForm;
use App\Livewire\Master\FNB\FnbIndex;
use App\Livewire\Master\Msops\ExtraCharge\ExtraChargeForm;
use App\Livewire\Master\Msops\ExtraCharge\ExtraChargeIndex;
use App\Livewire\Master\Pajak\PajakForm;
use App\Livewire\Master\Pajak\PajakIndex;
use App\Livewire\Master\Rekanan\RekananForm;
use App\Livewire\Master\Rekanan\RekananIndex;
use App\Livewire\Master\Rekening\RekeningForm;
use App\Livewire\Master\Rekening\RekeningIndex;
use App\Livewire\Master\Sdm\Karyawan\MasterKaryawanForm;
use App\Livewire\Master\Sdm\Karyawan\MasterKaryawanIndex;
use App\Livewire\Master\Sdm\MasterPekerjaanForm;
use App\Livewire\Master\Sdm\MasterPekerjaanIndex;
use App\Livewire\Master\TarifLayanan\TarifKamarHarian\TarifHarianForm;
use App\Livewire\Master\TarifLayanan\TarifKamarHarian\TarifHarianIndex;
use App\Livewire\Master\TarifLayanan\TarifKhusus\TarifKhususForm;
use App\Livewire\Master\TarifLayanan\TarifKhusus\TarifKhususindex;
use App\Livewire\Report\Hunian\TingkatHunianIndex;
use App\Livewire\Setting\RoleFeature\RoleFeatureForm;
use App\Livewire\Setting\User\UserForm;
use App\Livewire\Setting\User\UserIndex;
use App\Livewire\Transaksi\Booking\BookingForm;
use App\Livewire\Transaksi\Booking\BookingIndex;
use App\Livewire\Transaksi\RsvLangsung\RsvLangsungCheckoutIndex;
use App\Livewire\Transaksi\RsvLangsung\RsvLangsungForm;
use App\Livewire\Transaksi\RsvLangsung\RsvLangsungIndex;
use App\Livewire\Transaksi\TransaksiIndex;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/admin', AuthLogin::class, function () {
    return view('livewire.auth-login');
})->name('login')->withoutMiddleware([Authenticate::class]);
Route::group(['middleware' => Authenticate::class], function () {
    //start view per component
    //dashboard
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    //setting
    Route::get('/setting', SettingIndex::class)->name('setting');
    //setting fitur
    Route::get('/setting/developer/masterfitur', FeatureIndex::class)->name('featureIndex');
    Route::get('/setting/developer/masterfitur/create', FeatureForm::class)->name('featureIndexCreate');
    Route::get('/setting/developer/masterfitur/loadfeature', FeatureForm::class)->name('featureLoadData');
    Route::get('/setting/developer/masterfitur/feature-locations', [SearchFeatureController::class, 'searchLocation']);
    Route::get('/setting/developer/masterfitur/parentfeaturesidebar', [SearchFeatureController::class, 'searchFeatureParentSidebar']);
    Route::get('/setting/developer/masterfitur/parentfeature', [SearchFeatureController::class, 'searchFeatureParent']);
    Route::get('/setting/developer/masterfitur/levelfeature', [SearchFeatureController::class, 'searchFeatureLevel']);

    //setting role
    Route::get('/setting/masteruser/rolegroup', RoleIndex::class)->name('roleindex');
    Route::any('/setting/masteruser/rolegroup/create', RoleGroupForm::class)->name('roleIndexCreate');
    Route::any('/setting/masteruser/rolegroup/loadrolegroup', RoleGroupForm::class)->name('loadrolegrupdata');
    Route::any('/setting/masteruser/rolegroup/deleterolegroup', [RoleGroupForm::class, 'deleteRoleGroup'])->name('deleteRoleGroup');

    //setting role feature
    Route::get('/setting/masteruser/rolefeature', RoleFeatureIndex::class)->name('roleFeatureIndex');
    Route::get('/setting/masteruser/rolefeature/create', RoleFeatureForm::class)->name('roleFeaturecreate');

    Route::get('/setting/masteruser/users', UserIndex::class)->name('userIndex');
    Route::get('/setting/masteruser/users/create', UserForm::class)->name('userIndexCreate');

    //master-master
    Route::get('/master', MasterIndex::class)->name('masterindex');
    Route::get('/master/ops/fasilitaskamar', FasilitasKamarIndex::class)->name('fasilitaskamarindex');
    Route::get('/master/ops/fasilitaskamar/create', FasilitaskamarForm::class)->name('fasilitaskamarform');
    Route::get('/master/ops/fasilitaskamar/loadfasilitas', FasilitaskamarForm::class)->name('fasilitaskamarLoadData');
    Route::any('/master/ops/kelaskamar', KelasKamarIndex::class)->name('kelaskamarindex');
    Route::get('/master/ops/kelaskamar/create', KelasKamarForm::class)->name('kelaskamarform');
    Route::get('/master/ops/jeniskamar', JenisKamarIndex::class)->name('jeniskamarindex');
    Route::get('/master/ops/jeniskamar/create', JenisKamarForm::class)->name('jeniskamarform');
    Route::get('/master/ops/namakamar', NamaKamarIndex::class)->name('namakamarindex');
    Route::get('/master/ops/namakamar/create', NamaKamarForm::class)->name('namakamarform');

    Route::get('/master/ops/extracharge', ExtraChargeIndex::class)->name('extrachargeindex');
    Route::get('/master/ops/extracharge/create', ExtraChargeForm::class)->name('extrachargeform');

    Route::get('/master/tariflayanan/tarifharian', TarifHarianIndex::class)->name('tarifharianindex');
    Route::get('/master/tariflayanan/tarifharian/create', TarifHarianForm::class)->name('tarifhariancreate');
    Route::get('/master/tariflayanan/tarifkhusus', TarifKhususindex::class)->name('tarifkhususindex');
    Route::get('/master/tariflayanan/tarifkhusus/create', TarifKhususForm::class)->name('tarifkhususcreate');

    Route::get('/master/tariflayanan/masterrekanan', RekananIndex::class)->name('masterrekananindex');
    Route::get('/master/tariflayanan/masterrekanan/create', RekananForm::class)->name('masterrekananform');

    Route::get('/master/customer/mastercustomer', CustomerIndex::class)->name('customerindex');
    Route::get('/master/customer/mastercustomer/create', CustomerForm::class)->name('customercreate');

    Route::get('/master/rekening/masterbank', RekeningIndex::class)->name('bankindex');
    Route::get('/master/rekening/masterbank/create', RekeningForm::class)->name('bankcreate');

    Route::get('/master/fnb/fnbindex', FnbIndex::class)->name('fnbindex');
    Route::get('/master/fnb/create', FnbForm::class)->name('fnbcreate');

    Route::get('/master/pajak/pajakindex', PajakIndex::class)->name('pajakindex');
    Route::get('/master/pajak/create', PajakForm::class)->name('pajakcreate');

    Route::get('/master/sdm/masterpekerjaan', MasterPekerjaanIndex::class)->name('masterpekerjaanindex');
    Route::get('/master/sdm/masterpekerjaan/create', MasterPekerjaanForm::class)->name('masterpekerjaanform');

    Route::get('/master/sdm/masterkaryawan', MasterKaryawanIndex::class)->name('masterkaryawanindex');
    Route::get('/master/sdm/masterkaryawan/create', MasterKaryawanForm::class)->name('masterkaryawanform');

    Route::get('/master/asalbooking/index', AsalBookingIndex::class)->name('asalbookingindex');
    Route::get('/master/asalbooking/create', AsalBookingForm::class)->name('asalbookingform');

    Route::get('/transaksi', TransaksiIndex::class)->name('transaksiindex');
    Route::get('/transaksi/reservasi/direct', RsvLangsungIndex::class)->name('directrsvindex');
    Route::get('/transaksi/reservasi/direct/create', RsvLangsungForm::class)->name('directrsvcreate');
    Route::get('/transaksi/reservasi/direct/invoice/{id}', [invoiceController::class, 'printInvoice'])->name('invoice');
    Route::get('/transaksi/reservasi/direct/invoice/dp/{id}', [invoiceController::class, 'printInvoiceDP'])->name('invoice');
    Route::get('/transaksi/reservasi/direct/invoicedasar/{id}', [invoiceController::class, 'printInvoiceDasar'])->name('invoice');
    Route::get('/transaksi/reservasi/direct/invoiceextra/{id}', [invoiceController::class, 'printInvoiceExtra'])->name('invoice');

    Route::get('/transaksi/reservasi/booking', BookingIndex::class)->name('bookingindex');
    Route::get('/transaksi/reservasi/booking/create', BookingForm::class)->name('bookingcreate');
    Route::get('/transaksi/reservasi/booking/datacustomer', [costumerController::class, 'searchCustomer']);

    Route::get('/transaksi/reservasi/checkout', RsvLangsungCheckoutIndex::class)->name('checkoutindex');

    Route::get('/report/hunian/tingkathunian', TingkatHunianIndex::class)->name('hunianindex');
    //end view per component


});
