<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\FormFieldOptionController;
use App\Http\Controllers\BasicDetailsController;
use App\Http\Controllers\FormFieldDependentController;
use App\Http\Controllers\AdminQualificationController;
use App\Http\Controllers\NoteFormFieldController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\AdminPaidController;
use App\Http\Controllers\AdminUnPaidController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [App\Http\Controllers\HomeController::class, 'Welcome'])->name('welcome');
Auth::routes();
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/send-otp', [OTPController::class, 'sendOTP']);
Route::post('/send-email-otp', [OTPController::class, 'sendEmailOTP']);
Route::post('/verify-otp', [OTPController::class, 'verifyOTP']);
Route::post('/verify-email-otp', [OTPController::class, 'EmailverifyOTP']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'user-access:candidate'])->group(function () {
  
    Route::get('/candidate/home', [CandidateController::class, 'index'])->name('candidate.home');
    Route::post('/candidate/data', [CandidateController::class, 'getDependentFieldData'])->name('candidate.data');
    Route::post('/application-form-submit', [CandidateController::class, 'submitFormOne'])->name('application.form.submit');
    Route::get('/candidate/registration', [CandidateController::class, 'Registration'])->name('candidate.registration');
    Route::get('/candidate/basic-details', [CandidateController::class, 'BasicDetails'])->name('candidate.basic.detail');
    Route::post('/candidate/basic-details-data', [CandidateController::class, 'BasicDetailsData'])->name('candidate.basic.details.data');
    Route::post('/candidate/basic-details', [CandidateController::class, 'BasicDetailsSave'])->name('candidate.basic.detail.save');
    Route::get('/candidate/educational-qualifications', [CandidateController::class, 'EducationalQualifications'])->name('candidate.educational.qualifications');
    Route::get('/get-qualifications', [CandidateController::class, 'GetQualifications'])->name('get.qualifications');
    Route::post('/education-document-upload', [CandidateController::class, 'EducationDocumentUpload'])->name('education.document.upload');
    Route::post('/educational-qualifications-submit', [CandidateController::class, 'EducationalQualificationSubmit'])->name('educational.qualifications.submit');
    //ex
    Route::get('/candidate/experience-details', [CandidateController::class, 'ExperienceDetails'])->name('candidate.experience.details');
    Route::get('/get-experience-details', [CandidateController::class, 'GetExperienceDetails'])->name('get.experience.details');
    Route::delete('/get-experience-details-delete/{id}', [CandidateController::class, 'GetExperienceDetailsDelete'])->name('get.experience.details.delete');
    Route::get('/get-experience-details/{id}', [CandidateController::class, 'GetExperienceDetailsGet'])->name('get.experience.details.delete.data');
    Route::post('/experience-details-submit', [CandidateController::class, 'ExperienceDetailsSubmit'])->name('experience.details.submit');
    Route::post('/experience-submit', [CandidateController::class, 'ExperienceSubmit'])->name('experience.submit');
    //doc
    Route::get('/candidate/documents-upload', [CandidateController::class, 'DocumentsUpload'])->name('candidate.documents.upload');
    Route::post('/candidate/each-document-upload', [CandidateController::class, 'EachDocumentUpload'])->name('candidate.each.document.upload');
    Route::post('/candidate/documents-upload-success', [CandidateController::class, 'DocumentsUploadSuccess'])->name('candidate.documents.upload.success');
    Route::get('candidate/payment',[CandidateController::class,'showPaymentForm'])->name('payment.form');
    Route::post('/create-payment', [CandidateController::class, 'createPayment'])->name('payment.process');
    // Route::post('/payment-callback', [CandidateController::class, 'paymentCallback'])->name('payment.success');
    Route::post('/payment-done', [CandidateController::class, 'PaymentDone'])->name('payment.done');
    Route::get('/successfully-registered', [CandidateController::class, 'SuccessfullyRegistered'])->name('successfully.registered');
    Route::get('/form-preview', [CandidateController::class, 'FormPreview'])->name('form.preview');

});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    //home
    Route::get('/admin/home-content', [HomeController::class, 'HomeContent'])->name('admin.home.content');
    Route::get('/admin/home-content-create', [HomeController::class, 'HomeContentCreate'])->name('admin.home.content.create');
    Route::post('/admin/home-content-save', [HomeController::class, 'HomeContentSave'])->name('admin.home.content.save');
    Route::get('/admin/home-content/{id}/edit', [HomeController::class, 'HomeContentEdit'])->name('admin.home.content.edit');
    Route::post('/admin/home-content-edit-save', [HomeController::class, 'HomeContenteEditSave'])->name('admin.home.content.edit.save');
    Route::post('/admin/home-content-delete', [HomeController::class, 'HomeContenteDelete'])->name('admin.home.content.delete');
    Route::post('/admin/home-content-toggle', [HomeController::class, 'HomeContenteToggle'])->name('admin.home.content.toggle');
    //
    Route::get('/admin/home-data', [HomeController::class, 'HomeData'])->name('admin.home.data');
    Route::get('/admin/home-data-create', [HomeController::class, 'HomeDatatCreate'])->name('admin.home.data.create');
    Route::post('/admin/home-data-save', [HomeController::class, 'HomeDataSave'])->name('admin.home.data.save');
    Route::get('/admin/home-data/{id}/edit', [HomeController::class, 'HomeDataEdit'])->name('admin.home.data.edit');
    Route::post('/admin/home-data-edit-save', [HomeController::class, 'HomeDataEditSave'])->name('admin.home.data.edit.save');
    Route::post('/admin/home-data-delete', [HomeController::class, 'HomeDataDelete'])->name('admin.home.data.delete');
    Route::post('/admin/home-data-toggle', [HomeController::class, 'HomeDataToggle'])->name('admin.home.data.toggle');
  //
    Route::get('/admin/home', [AdminController::class, 'index'])->name('admin.home');
    Route::get('/admin/candidate-status', [AdminController::class, 'candidateStatus'])->name('admin.candidate.status');
    Route::get('/admin/form-field', [AdminController::class, 'create'])->name('admin.form.field');
    Route::post('/admin/form-field-submit', [AdminController::class, 'FormField'])->name('admin.form.field.submit');
    Route::get('/admin/form-field-show', [AdminController::class, 'FormFieldShow'])->name('admin.form.field.show');
    Route::get('/admin/form-field-show/{id}/edit', [AdminController::class, 'FormFieldEdit'])->name('admin.form.field.edit');
    Route::put('/admin/form-field-update/{id}', [AdminController::class, 'FormFieldUpdate'])->name('admin.form.field.update');
    //formfieldoprtion
    Route::get('/admin/form-field-options', [FormFieldOptionController::class, 'FormFieldOptions'])->name('admin.form.field.options');
    Route::get('/admin/form-field-options-create', [FormFieldOptionController::class, 'FormFieldOptionsCreate'])->name('admin.form.field.options.create');
    Route::post('/admin/form-field-options-save', [FormFieldOptionController::class, 'FormFieldOptionsSave'])->name('admin.form.field.options.save');
    Route::get('/admin/form-field-options/{id}/edit', [FormFieldOptionController::class, 'FormFieldOptionsEdit'])->name('admin.form.field.options.edit');
    Route::post('/admin/form-field-options-update', [FormFieldOptionController::class, 'FormFieldOptionsUpdate'])->name('admin.form.field.options.update');
    //dependent
    Route::get('/admin/form-field-dependent', [FormFieldDependentController::class, 'FormFieldDependent'])->name('admin.form.field.dependent');
    Route::get('/admin/form-field-dependent-create', [FormFieldDependentController::class, 'FormFieldDependentCreate'])->name('admin.form.field.dependent.create');
    Route::post('/admin/form-field-dependent-save', [FormFieldDependentController::class, 'FormFieldDependentSave'])->name('admin.form.field.dependent.save');
    Route::get('/admin/form-field-dependent/{id}/edit', [FormFieldDependentController::class, 'FormFieldDependentEdit'])->name('admin.form.field.dependent.edit');
    Route::post('/admin/form-field-dependent-edit-save', [FormFieldDependentController::class, 'FormFieldDependentEditSave'])->name('admin.form.field.dependent.edit.save');
    Route::post('/admin/form-field-dependent-delete', [FormFieldDependentController::class, 'FormFieldDependentDelete'])->name('admin.form.field.dependent.delete');
    Route::post('/admin/form-field-dependent-toggle', [FormFieldDependentController::class, 'FormFieldDependentToggle'])->name('admin.form.field.dependent.toggle');
    //basic
    Route::get('/admin/basic-details-form-field-show', [BasicDetailsController::class, 'basicDetailsFormFieldShow'])->name('admin.basic.details.form.field.show');
    Route::get('/admin/basic-details-form-field-show/{id}/edit', [BasicDetailsController::class, 'BasicDetailsFormFieldEdit'])->name('admin.basic.details.form.field.edit');
    Route::get('/admin/basic-details-form-field-create', [BasicDetailsController::class, 'create'])->name('basic.details.admin.form.field');
    Route::post('/admin/basic-details-form-field-submit', [BasicDetailsController::class, 'BasicDetailsFormField'])->name('admin.basic.details.form.field.submit');
    Route::put('/admin/basic-details-form-field-update/{id}', [BasicDetailsController::class, 'BasicDetailsFormFieldUpdate'])->name('admin.basic.details.form.field.update');
    Route::post('/admin/basic-details-form-field-delete', [BasicDetailsController::class, 'BasicDetailsFormFieldDelete'])->name('admin.basic.details.form.field.delete');
    //formfieldoprtion
    Route::get('/admin/basic-details-form-field-options', [BasicDetailsController::class, 'BasicDetailsFormFieldOptions'])->name('admin.basic.details.form.field.options');
    Route::get('/admin/basic-details-form-field-options-create', [BasicDetailsController::class, 'BasicDetailsFormFieldOptionsCreate'])->name('admin.basic.details.form.field.options.create');
    Route::post('/admin/basic-details-form-field-options-save', [BasicDetailsController::class, 'BasicDetailsFormFieldOptionsSave'])->name('admin.basic.details.form.field.options.save');
    Route::get('/admin/basic-details-form-field-options/{id}/edit', [BasicDetailsController::class, 'BasicDetailsFormFieldOptionsEdit'])->name('admin.basic.details.form.field.options.edit');
    Route::post('/admin/basic-details-form-field-options-update', [BasicDetailsController::class, 'BasicDetailsFormFieldOptionsUpdate'])->name('admin.basic.details.form.field.options.update');
    //dependent
    Route::get('/admin/basic-details-form-field-dependent', [BasicDetailsController::class, 'BasicDetailsFormFieldDependent'])->name('admin.basic.details.form.field.dependent');
    Route::get('/admin/basic-details-form-field-dependent-create', [BasicDetailsController::class, 'BasicDetailsFormFieldDependentCreate'])->name('admin.basic.details.form.field.dependent.create');
    Route::post('/admin/basic-details-form-field-dependent-save', [BasicDetailsController::class, 'BasicDetailsFormFieldDependentSave'])->name('admin.basic.details.form.field.dependent.save');

    Route::get('/admin/basic-details=form-field-dependent/{id}/edit', [BasicDetailsController::class, 'BasicDetailsFormFieldDependentEdit'])->name('admin.basic.details.form.field.dependent.edit');
    Route::post('/admin/basic-details-form-field-dependent-edit-save', [BasicDetailsController::class, 'BasicDetailsFormFieldDependentEditSave'])->name('admin.basic.details.form.field.dependent.edit.save');
    Route::post('/admin/basic-details-form-field-dependent-delete', [BasicDetailsController::class, 'BasicDetailsFormFieldDependentDelete'])->name('admin.basic.details.form.field.dependent.delete');
    Route::post('/admin/basic-details-form-field-dependent-toggle', [BasicDetailsController::class, 'BasicDetailsFormFieldDependentToggle'])->name('admin.basic.details.form.field.dependent.toggle');
    //basic end
    //note
    Route::get('/admin/form-field-note', [NoteFormFieldController::class, 'FormFieldDependentNote'])->name('admin.form.field.note');
    Route::get('/admin/form-field-note-create', [NoteFormFieldController::class, 'FormFieldNoteCreate'])->name('admin.form.field.note.create');
    Route::post('/admin/form-field-note-delete', [NoteFormFieldController::class, 'FormFieldNoteDelete'])->name('admin.form.field.note.delete');
    Route::post('/admin/form-field-note-save', [NoteFormFieldController::class, 'FormFieldNoteSave'])->name('admin.form.field.note.save');
    Route::get('/admin/form-field-note/{id}/edit', [NoteFormFieldController::class, 'FormFieldNoteEdit'])->name('admin.form.field.note.edit');
    Route::post('/admin/form-field-note-edit-save', [NoteFormFieldController::class, 'FormFieldNoteEditSave'])->name('admin.form.field.note.edit.save');
    
    //Qualification
    Route::get('/admin/qualification', [AdminQualificationController::class, 'Qualification'])->name('admin.qualification');
    Route::get('/admin/qualification-create', [AdminQualificationController::class, 'QualificationCreate'])->name('admin.qualification.add');
    Route::post('/admin/qualification-create-save', [AdminQualificationController::class, 'QualificationSave'])->name('admin.qualification.save');
    Route::get('/admin/qualification/{id}/edit', [AdminQualificationController::class, 'QualificationEdit'])->name('admin.qualification.edit');
    Route::post('/admin/qualification-edit-save', [AdminQualificationController::class, 'qualificationEditSave'])->name('admin.qualification.edit.save');

    Route::get('/admin/qualification-options', [AdminQualificationController::class, 'QualificationOptions'])->name('admin.qualification.options');
    Route::get('/admin/qualification-options-create', [AdminQualificationController::class, 'QualificationOptionsCreate'])->name('admin.qualification.options.create');
    Route::post('/admin/qualification-options-save', [AdminQualificationController::class, 'qualificationOptionsSave'])->name('admin.qualification.options.save');
    Route::get('/admin/qualification-options/{id}/edit', [AdminQualificationController::class, 'QualificationOptionsEdit'])->name('admin.qualification.options.edit');
    Route::post('/admin/qualification-options-update', [AdminQualificationController::class, 'QualificationOptionsUpdate'])->name('admin.qualification.options.update');

    //paid unpaid
    Route::get('/admin/paid-candidate/{post}', [AdminPaidController::class, 'AdminPaidData'])->name('admin.paid.data');
    Route::get('/admin/unpaid-candidate/{post}', [AdminUnPaidController::class, 'AdminUnPaidData'])->name('admin.unpaid.data');
    Route::get('/admin/candidate/{id}', [AdminUnPaidController::class, 'CandidateData'])->name('admin.candidate.data');
});
