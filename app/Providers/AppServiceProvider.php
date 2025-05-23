<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Patient;
use App\Models\Calendar;
use App\Models\Doctor;

use App\Policies\DoctorPolicy;
use App\Policies\PatientPolicy;
use App\Policies\CalendarPolicy;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Calendar::class => CalendarPolicy::class,
        Patient::class => PatientPolicy::class,
        Doctor::class => DoctorPolicy::class
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        App::setLocale(Session::get('locale', config('app.locale')));
    }
}
