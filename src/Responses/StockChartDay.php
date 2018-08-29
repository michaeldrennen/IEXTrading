<?php

namespace MichaelDrennen\IEXTrading\Responses;

class StockChartDay extends StockChartData {

    public $date;
    public $open;
    public $close;
    public $unadjustedVolume;
    public $change;
    public $changePercent;
    public $vwap;

    public $high;
    public $low;
    public $volume;
    public $label;
    public $changeOverTime;


    public function __construct( array $dataPoint ) {
        parent::__construct( $dataPoint );
        $this->date             = $dataPoint[ 'date' ] ?? NULL;
        $this->open             = $dataPoint[ 'open' ] ?? NULL;
        $this->close            = $dataPoint[ 'close' ] ?? NULL;
        $this->unadjustedVolume = $dataPoint[ 'unadjustedVolume' ] ?? NULL;
        $this->change           = $dataPoint[ 'change' ] ?? NULL;
        $this->changePercent    = $dataPoint[ 'changePercent' ] ?? NULL;
        $this->vwap             = $dataPoint[ 'vwap' ] ?? NULL;
        $this->high             = $dataPoint[ 'high' ] ?? NULL;
        $this->low              = $dataPoint[ 'low' ] ?? NULL;
        $this->volume           = $dataPoint[ 'volume' ] ?? NULL;
        $this->label            = $dataPoint[ 'label' ] ?? NULL;
        $this->changeOverTime   = $dataPoint[ 'changeOverTime' ] ?? NULL;
    }
}