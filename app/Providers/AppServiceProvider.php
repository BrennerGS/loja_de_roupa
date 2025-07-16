<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Client;
use App\Models\Supplier;
use App\Models\Company;
use App\Models\SocialMediaPost;
use App\Observers\ProductObserver;
use App\Observers\SaleObserver;
use App\Observers\ClientObserver;
use App\Observers\SupplierObserver;
use App\Observers\CompanyObserver;
use App\Observers\SocialMediaPostObserver;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Trash;
use App\Policies\TrashPolicy;
use App\Models\ActivityLog;
use App\Policies\ActivityLogPolicy;

class AppServiceProvider extends ServiceProvider
{

    /**
     * As políticas de autorização do aplicativo.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'trash' => TrashPolicy::class,
        ActivityLog::class => ActivityLogPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Registrar o ActivityLogger como singleton
        $this->app->singleton(
            \App\Services\ActivityLogger::class,
            fn () => new \App\Services\ActivityLogger()
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
        Product::observe(ProductObserver::class);
        Sale::observe(SaleObserver::class);
        Client::observe(ClientObserver::class);
        Supplier::observe(SupplierObserver::class);
        Company::observe(CompanyObserver::class);
        SocialMediaPost::observe(SocialMediaPostObserver::class);
        $this->registerPolicies();
    }
}
