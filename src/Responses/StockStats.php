<?php

namespace MichaelDrennen\IEXTrading\Responses;

class StockStats extends IEXTradingResponse {
    public $companyName;
    public $marketcap;
    public $beta;
    public $week52high;
    public $week52low;
    public $week52change;
    public $shortInterest;
    public $shortDate;
    public $dividendRate;
    public $dividendYield;
    public $exDividendDate;
    public $latestEPS;
    public $latestEPSDate;
    public $sharesOutstanding;
    public $float;
    public $returnOnEquity;
    public $consensusEPS;
    public $numberOfEstimates;
    public $symbol;
    public $EBITDA;
    public $revenue;
    public $grossProfit;
    public $cash;
    public $debt;
    public $ttmEPS;
    public $revenuePerShare;
    public $revenuePerEmployee;
    public $peRatioHigh;
    public $peRatioLow;
    public $EPSSurpriseDollar;
    public $EPSSurprisePercent;
    public $returnOnAssets;
    public $returnOnCapital;
    public $profitMargin;
    public $priceToSales;
    public $priceToBook;
    public $day200MovingAvg;
    public $day50MovingAvg;
    public $institutionPercent;
    public $insiderPercent;
    public $shortRatio;
    public $year5ChangePercent;
    public $year2ChangePercent;
    public $year1ChangePercent;
    public $ytdChangePercent;
    public $month6ChangePercent;
    public $month3ChangePercent;
    public $month1ChangePercent;
    public $day5ChangePercent;


    /**
     * StockStats constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct( $response ) {
        $jsonString                = (string)$response->getBody();
        $a                         = \GuzzleHttp\json_decode( $jsonString, TRUE );
        $this->companyName         = $a[ 'companyName' ] ?? NULL;
        $this->marketcap           = $a[ 'marketcap' ] ?? NULL;
        $this->beta                = $a[ 'beta' ] ?? NULL;
        $this->week52high          = $a[ 'week52high' ] ?? NULL;
        $this->week52low           = $a[ 'week52low' ] ?? NULL;
        $this->week52change        = $a[ 'week52change' ] ?? NULL;
        $this->shortInterest       = $a[ 'shortInterest' ] ?? NULL;
        $this->shortDate           = $a[ 'shortDate' ] ?? NULL;
        $this->dividendRate        = $a[ 'dividendRate' ] ?? NULL;
        $this->dividendYield       = $a[ 'dividendYield' ] ?? NULL;
        $this->exDividendDate      = $a[ 'exDividendDate' ] ?? NULL;
        $this->latestEPS           = $a[ 'latestEPS' ] ?? NULL;
        $this->latestEPSDate       = $a[ 'latestEPSDate' ] ?? NULL;
        $this->sharesOutstanding   = $a[ 'sharesOutstanding' ] ?? NULL;
        $this->float               = $a[ 'float' ] ?? NULL;
        $this->returnOnEquity      = $a[ 'returnOnEquity' ] ?? NULL;
        $this->consensusEPS        = $a[ 'consensusEPS' ] ?? NULL;
        $this->numberOfEstimates   = $a[ 'numberOfEstimates' ] ?? NULL;
        $this->symbol              = $a[ 'symbol' ] ?? NULL;
        $this->EBITDA              = $a[ 'EBITDA' ] ?? NULL;
        $this->revenue             = $a[ 'revenue' ] ?? NULL;
        $this->grossProfit         = $a[ 'grossProfit' ] ?? NULL;
        $this->cash                = $a[ 'cash' ] ?? NULL;
        $this->debt                = $a[ 'debt' ] ?? NULL;
        $this->ttmEPS              = $a[ 'ttmEPS' ] ?? NULL;
        $this->revenuePerShare     = $a[ 'revenuePerShare' ] ?? NULL;
        $this->revenuePerEmployee  = $a[ 'revenuePerEmployee' ] ?? NULL;
        $this->peRatioHigh         = $a[ 'peRatioHigh' ] ?? NULL;
        $this->peRatioLow          = $a[ 'peRatioLow' ] ?? NULL;
        $this->EPSSurpriseDollar   = $a[ 'EPSSurpriseDollar' ] ?? NULL;
        $this->EPSSurprisePercent  = $a[ 'EPSSurprisePercent' ] ?? NULL;
        $this->returnOnAssets      = $a[ 'returnOnAssets' ] ?? NULL;
        $this->returnOnCapital     = $a[ 'returnOnCapital' ] ?? NULL;
        $this->profitMargin        = $a[ 'profitMargin' ] ?? NULL;
        $this->priceToSales        = $a[ 'priceToSales' ] ?? NULL;
        $this->priceToBook         = $a[ 'priceToBook' ] ?? NULL;
        $this->day200MovingAvg     = $a[ 'day200MovingAvg' ] ?? NULL;
        $this->day50MovingAvg      = $a[ 'day50MovingAvg' ] ?? NULL;
        $this->institutionPercent  = $a[ 'institutionPercent' ] ?? NULL;
        $this->insiderPercent      = $a[ 'insiderPercent' ] ?? NULL;
        $this->shortRatio          = $a[ 'shortRatio' ] ?? NULL;
        $this->year5ChangePercent  = $a[ 'year5ChangePercent' ] ?? NULL;
        $this->year2ChangePercent  = $a[ 'year2ChangePercent' ] ?? NULL;
        $this->year1ChangePercent  = $a[ 'year1ChangePercent' ] ?? NULL;
        $this->ytdChangePercent    = $a[ 'ytdChangePercent' ] ?? NULL;
        $this->month6ChangePercent = $a[ 'month6ChangePercent' ] ?? NULL;
        $this->month3ChangePercent = $a[ 'month3ChangePercent' ] ?? NULL;
        $this->month1ChangePercent = $a[ 'month1ChangePercent' ] ?? NULL;
        $this->day5ChangePercent   = $a[ 'day5ChangePercent' ] ?? NULL;
    }

}