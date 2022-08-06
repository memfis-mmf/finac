<?php

namespace memfisfa\Finac;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;
use memfisfa\Finac\Commands\Install;

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
        $this->loadViewsFrom(__DIR__.'/views/invoice/item-list', 'invoice-itemlistview');
        $this->loadViewsFrom(__DIR__.'/views/invoice/additional-info', 'invoice-additionalview');
        $this->loadViewsFrom(__DIR__.'/views/invoice/account-profit-center', 'invoice-apcview');
        $this->loadViewsFrom(__DIR__.'/views/invoice/invoice-sales/', 'invoice-salesview');
        $this->loadViewsFrom(__DIR__.'/views/invoice/invoice-sales/account-profit-center', 'invoice-sales-apcview');
        $this->loadViewsFrom(__DIR__.'/views/invoice/invoice-sales/additional-info', 'invoice-sales-additionalview');
        $this->loadViewsFrom(__DIR__.'/views/invoice/invoice-sales/item-list', 'invoice-sales-itemlistview');
        $this->loadViewsFrom(__DIR__.'/views/invoice/invoice-workshop/', 'invoice-workshopview');
        $this->loadViewsFrom(__DIR__.'/views/invoice/invoice-workshop/account-profit-center', 'invoice-workshop-apcview');
        $this->loadViewsFrom(__DIR__.'/views/invoice/invoice-workshop/additional-info', 'invoice-workshop-additionalview');
        $this->loadViewsFrom(__DIR__.'/views/invoice/invoice-workshop/service-detail', 'invoice-workshop-servicedetailview');
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
        $this->loadViewsFrom(__DIR__.'/views/account-receivable', 'accountreceivableview');
        $this->loadViewsFrom(__DIR__.'/views/trial-balance', 'trialbalanceview');
        $this->loadViewsFrom(__DIR__.'/views/profit-loss', 'profitlossview');
        $this->loadViewsFrom(__DIR__.'/views/general-ledger', 'generalledgerview');
        $this->loadViewsFrom(__DIR__.'/views/balance-sheet', 'balancesheetview');
        $this->loadViewsFrom(__DIR__.'/views/master-asset', 'masterassetview');
        $this->loadViewsFrom(__DIR__.'/views/bond', 'bondview');
        $this->loadViewsFrom(__DIR__.'/views/cashbook-new', 'cashbooknewview');
        $this->loadViewsFrom(__DIR__.'/views/asset-category', 'assetcategoryview');
        $this->loadViewsFrom(__DIR__.'/views/ar-report', 'arreportview');
        $this->loadViewsFrom(__DIR__.'/views/ar-report/account-receivables', 'arreport-accountrhview');
        $this->loadViewsFrom(__DIR__.'/views/ap-report/account-payable', 'apreport-accountrhview');
        $this->loadViewsFrom(__DIR__.'/views/ar-report/aging-receivables-detail', 'arreport-agingview');
        $this->loadViewsFrom(__DIR__.'/views/ar-report/aging-payables-detail', 'apreport-agingview');
        $this->loadViewsFrom(__DIR__.'/views/ar-report/customer-tb', 'arreport-customertbview');
        $this->loadViewsFrom(__DIR__.'/views/ar-report/supplier-tb', 'arreport-suppliertbview');
        $this->loadViewsFrom(__DIR__.'/views/ar-report/invoice-paid', 'invoicepview');
        $this->loadViewsFrom(__DIR__.'/views/ar-report/outstanding', 'arreport-outstandingview');
        $this->loadViewsFrom(__DIR__.'/views/ar-report/cash-statement', 'arreport-cashstatementview');
        $this->loadViewsFrom(__DIR__.'/views/ar-report/bank-statement', 'arreport-bankstatementview');
        $this->loadViewsFrom(__DIR__.'/views/fixed-asset-disposition', 'fixassetdispositionview');
        $this->loadViewsFrom(__DIR__.'/views/master-coa', 'mastercoaview');
        $this->loadViewsFrom(__DIR__.'/views/project-report', 'projectreportview');
        $this->loadViewsFrom(__DIR__.'/views/project-report/profit-loss', 'projectreport-profitlossview');
        $this->loadViewsFrom(__DIR__.'/views/project-report/project-list', 'projectreport-projectlistview');
        $this->loadViewsFrom(__DIR__.'/views/benefit-coa-master', 'benefit-coa-master');
        //$this->loadViewsFrom(__DIR__.'/views/dll', 'dll'); 
    }
}
