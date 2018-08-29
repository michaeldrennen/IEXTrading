<?php

namespace MichaelDrennen\IEXTrading\Responses;

use Carbon\Carbon;

class StockChartIntraDay extends StockChartData {

    public $minute;
    public $average;
    public $notional;
    public $numberOfTrades;
    public $date;
    public $high;
    public $low;
    public $volume;
    public $marketHigh;
    public $marketLow;
    public $marketAverage;
    public $marketVolume;
    public $marketNotional;
    public $marketNumberOfTrades;
    public $marketChangeOverTime;

    // Carbon dates
    public $carbonDate;


    public function __construct( array $dataPoint ) {
        parent::__construct( $dataPoint );
        $this->minute               = $dataPoint[ 'minute' ] ?? NULL;
        $this->average              = $dataPoint[ 'average' ] ?? NULL;
        $this->notional             = $dataPoint[ 'notional' ] ?? NULL;
        $this->numberOfTrades       = $dataPoint[ 'numberOfTrades' ] ?? NULL;
        $this->date                 = $dataPoint[ 'date' ] ?? NULL;
        $this->high                 = $dataPoint[ 'high' ] ?? NULL;
        $this->low                  = $dataPoint[ 'low' ] ?? NULL;
        $this->volume               = $dataPoint[ 'volume' ] ?? NULL;
        $this->marketHigh           = $dataPoint[ 'marketHigh' ] ?? NULL;
        $this->marketLow            = $dataPoint[ 'marketLow' ] ?? NULL;
        $this->marketAverage        = $dataPoint[ 'marketAverage' ] ?? NULL;
        $this->marketVolume         = $dataPoint[ 'marketVolume' ] ?? NULL;
        $this->marketNotional       = $dataPoint[ 'marketNotional' ] ?? NULL;
        $this->marketNumberOfTrades = $dataPoint[ 'marketNumberOfTrades' ] ?? NULL;
        $this->marketChangeOverTime = $dataPoint[ 'marketChangeOverTime' ] ?? NULL;
        // TODO Check the code for the below property. Add defaults, and it doesn't smell right.
        $this->carbonDate = Carbon::createFromFormat( 'Ymd H:i', $dataPoint[ 'date' ] . ' ' . $dataPoint[ 'minute' ], 'EST' );
    }
}