<?php

namespace MichaelDrennen\IEXTrading\Responses;

use Carbon\Carbon;

class StockQuote extends IEXTradingResponse {

    public $symbol;
    public $companyName;
    public $primaryExchange;
    public $sector;
    public $calculationPrice;
    public $open;
    public $openTime;
    public $close;
    public $closeTime;
    public $latestPrice;
    public $latestSource;
    public $latestTime;
    public $latestUpdate;
    public $latestVolume;
    public $iexRealtimePrice;
    public $iexRealtimeSize;
    public $iexLastUpdated;
    public $delayedPrice;
    public $delayedPriceTime;
    public $previousClose;
    public $change;
    public $changePercent;
    public $iexMarketPercent;
    public $iexVolume;
    public $avgTotalVolume;
    public $iexBidPrice;
    public $iexBidSize;
    public $iexAskPrice;
    public $iexAskSize;
    public $marketCap;
    public $peRatio;
    public $week52High;
    public $week52Low;
    public $ytdChange;

    // Carbon Dates
    public $carbonOpenTime;
    public $carbonCloseTime;
    public $carbonLatestUpdate;
    public $carbonIexLastUpdated;
    public $carbonDelayedPriceTime;


    /**
     * StockQuote constructor.
     *
     * @param $response
     */
    public function __construct( $response ) {
        $jsonString             = (string)$response->getBody();
        $a                      = \GuzzleHttp\json_decode( $jsonString, TRUE );
        $this->symbol           = $a[ 'symbol' ] ?? NULL;
        $this->companyName      = $a[ 'companyName' ] ?? NULL;
        $this->primaryExchange  = $a[ 'primaryExchange' ] ?? NULL;
        $this->sector           = $a[ 'sector' ] ?? NULL;
        $this->calculationPrice = $a[ 'calculationPrice' ] ?? NULL;
        $this->open             = $a[ 'open' ] ?? NULL;
        $this->openTime         = $a[ 'openTime' ] ?? NULL;
        $this->close            = $a[ 'close' ] ?? NULL;
        $this->closeTime        = $a[ 'closeTime' ] ?? NULL;
        $this->latestPrice      = $a[ 'latestPrice' ] ?? NULL;
        $this->latestSource     = $a[ 'latestSource' ] ?? NULL;
        $this->latestTime       = $a[ 'latestTime' ] ?? NULL;
        $this->latestUpdate     = $a[ 'latestUpdate' ] ?? NULL;
        $this->latestVolume     = $a[ 'latestVolume' ] ?? NULL;
        $this->iexRealtimePrice = $a[ 'iexRealtimePrice' ] ?? NULL;
        $this->iexRealtimeSize  = $a[ 'iexRealtimeSize' ] ?? NULL;
        $this->iexLastUpdated   = $a[ 'iexLastUpdated' ] ?? NULL;
        $this->delayedPrice     = $a[ 'delayedPrice' ] ?? NULL;
        $this->delayedPriceTime = $a[ 'delayedPriceTime' ] ?? NULL;
        $this->previousClose    = $a[ 'previousClose' ] ?? NULL;
        $this->change           = $a[ 'change' ] ?? NULL;
        $this->changePercent    = $a[ 'changePercent' ] ?? NULL;
        $this->iexMarketPercent = $a[ 'iexMarketPercent' ] ?? NULL;
        $this->iexVolume        = $a[ 'iexVolume' ] ?? NULL;
        $this->avgTotalVolume   = $a[ 'avgTotalVolume' ] ?? NULL;
        $this->iexBidPrice      = $a[ 'iexBidPrice' ] ?? NULL;
        $this->iexBidSize       = $a[ 'iexBidSize' ] ?? NULL;
        $this->iexAskPrice      = $a[ 'iexAskPrice' ] ?? NULL;
        $this->iexAskSize       = $a[ 'iexAskSize' ] ?? NULL;
        $this->marketCap        = $a[ 'marketCap' ] ?? NULL;
        $this->peRatio          = $a[ 'peRatio' ] ?? NULL;
        $this->week52High       = $a[ 'week52High' ] ?? NULL;
        $this->week52Low        = $a[ 'week52Low' ] ?? NULL;
        $this->ytdChange        = $a[ 'ytdChange' ] ?? NULL;

        $this->carbonOpenTime         = Carbon::createFromTimestampUTC( $this->openTime );
        $this->carbonCloseTime        = Carbon::createFromTimestampUTC( $this->closeTime );
        $this->carbonLatestUpdate     = Carbon::createFromTimestampUTC( $this->latestUpdate );
        $this->carbonIexLastUpdated   = Carbon::createFromTimestampUTC( $this->iexLastUpdated );
        $this->carbonDelayedPriceTime = Carbon::createFromTimestampUTC( $this->delayedPriceTime );
    }

}