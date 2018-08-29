<?php

namespace MichaelDrennen\IEXTrading\Responses;

use Carbon\Carbon;

class StockFinancialReport {


    public $reportDate;
    public $grossProfit;
    public $costOfRevenue;
    public $operatingRevenue;
    public $totalRevenue;
    public $operatingIncome;
    public $netIncome;
    public $researchAndDevelopment;
    public $operatingExpense;
    public $currentAssets;
    public $totalAssets;
    public $totalLiabilities;
    public $currentCash;
    public $currentDebt;
    public $totalCash;
    public $totalDebt;
    public $shareholderEquity;
    public $cashChange;
    public $cashFlow;
    public $operatingGainsLosses;
    public $carbonReportDate;


    public function __construct( $data ) {
        $this->reportDate             = $data[ 'reportDate' ] ?? NULL;
        $this->grossProfit            = $data[ 'grossProfit' ] ?? NULL;
        $this->costOfRevenue          = $data[ 'costOfRevenue' ] ?? NULL;
        $this->operatingRevenue       = $data[ 'operatingRevenue' ] ?? NULL;
        $this->totalRevenue           = $data[ 'totalRevenue' ] ?? NULL;
        $this->operatingIncome        = $data[ 'operatingIncome' ] ?? NULL;
        $this->netIncome              = $data[ 'netIncome' ] ?? NULL;
        $this->researchAndDevelopment = $data[ 'researchAndDevelopment' ] ?? NULL;
        $this->operatingExpense       = $data[ 'operatingExpense' ] ?? NULL;
        $this->currentAssets          = $data[ 'currentAssets' ] ?? NULL;
        $this->totalAssets            = $data[ 'totalAssets' ] ?? NULL;
        $this->totalLiabilities       = $data[ 'totalLiabilities' ] ?? NULL;
        $this->currentCash            = $data[ 'currentCash' ] ?? NULL;
        $this->currentDebt            = $data[ 'currentDebt' ] ?? NULL;
        $this->totalCash              = $data[ 'totalCash' ] ?? NULL;
        $this->totalDebt              = $data[ 'totalDebt' ] ?? NULL;
        $this->shareholderEquity      = $data[ 'shareholderEquity' ] ?? NULL;
        $this->cashChange             = $data[ 'cashChange' ] ?? NULL;
        $this->cashFlow               = $data[ 'cashFlow' ] ?? NULL;
        $this->operatingGainsLosses   = $data[ 'operatingGainsLosses' ] ?? NULL;

        $this->carbonReportDate = Carbon::createFromFormat( 'Y-m-d', $this->reportDate, 'EST' )->setTime( 0, 0, 0 );
    }

}