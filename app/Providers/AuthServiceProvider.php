<?php

namespace App\Providers;

use App\Models\Berkunjung;
use App\Models\LaporanDinas;
use App\Models\PencatatanSurat;
use App\Models\User;
use App\Policies\BerkunjungPolicy;
use App\Policies\LaporanDinasPolicy;
use App\Policies\PencatatanSuratPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        PencatatanSurat::class => PencatatanSuratPolicy::class,
        LaporanDinas::class => LaporanDinasPolicy::class,
        Berkunjung::class => BerkunjungPolicy::class,
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
