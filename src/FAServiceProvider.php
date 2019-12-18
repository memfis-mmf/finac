<?php

namespace Directoryxx\Finac;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Directoryxx\Finac\Commands\Install;

class FAServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes.php';
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        //$this->loadViewsFrom(__DIR__.'/views/coa', 'coaViews');
        //$this->loadViewsFrom(__DIR__.'/views/dll', 'dll');
        /*
        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/fa'),
        ],'views');
        */
        $this->publishes([
            __DIR__.'/assets' => public_path('vendor/courier'),
        ],'assetsfa');
        if ($this->app->runningInConsole()) {
            $this->commands([
                Install::class,
            ]);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewsFrom(__DIR__.'/views/form', 'formview');
        $this->loadViewsFrom(__DIR__.'/views/coa', 'coaview');
        $this->loadViewsFrom(__DIR__.'/views/cashbook', 'cashbookview');
        $this->loadViewsFrom(__DIR__.'/views/invoice', 'invoiceview');
        $this->loadViewsFrom(__DIR__.'/views/ar', 'arview');
        $this->loadViewsFrom(__DIR__.'/views/frontend', 'frontend');
        $this->loadViewsFrom(__DIR__.'/views/frontend/common/label', 'label');
        $this->loadViewsFrom(__DIR__.'/views/frontend/common/input', 'input');
        $this->loadViewsFrom(__DIR__.'/views/frontend/common/buttons', 'buttons');
        $this->loadViewsFrom(__DIR__.'/views/include', 'include');
        $this->loadViewsFrom(__DIR__.'/views/journal', 'journalview');
        $this->loadViewsFrom(__DIR__.'/views/supplier-invoice', 'supplierinvoiceview');
        $this->loadViewsFrom(__DIR__.'/views/supplier-invoice/grn', 'supplierinvoicegrnview');
        $this->loadViewsFrom(__DIR__.'/views/supplier-invoice/general', 'supplierinvoicegeneralview');
        $this->loadViewsFrom(__DIR__.'/views/account-payable', 'accountpayableview');
        $this->loadViewsFrom(__DIR__.'/views/trial-balance', 'trialbalanceview');
        $this->loadViewsFrom(__DIR__.'/views/profit-loss', 'profitlossview');
        $this->loadViewsFrom(__DIR__.'/views/general-ledger', 'generalledgerview');
        $this->loadViewsFrom(__DIR__.'/views/balance-sheet', 'balancesheetview');
        $this->loadViewsFrom(__DIR__.'/views/master-asset', 'masterassetview');
        $this->loadViewsFrom(__DIR__.'/views/bond', 'bondview');
        //$this->loadViewsFrom(__DIR__.'/views/dll', 'dll');
    }
}
