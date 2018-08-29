<?php

namespace MichaelDrennen\IEXTrading\Responses;


abstract class StockChartData {

    public $high;
    public $low;
    public $volume;
    public $label;
    public $changeOverTime;

    /**
     * StockQuote constructor.
     *
     * @param array $dataPoint
     */
    public function __construct( $dataPoint ) {
        $this->high           = $dataPoint[ 'high' ] ?? NULL;
        $this->low            = $dataPoint[ 'low' ] ?? NULL;
        $this->volume         = $dataPoint[ 'volume' ] ?? NULL;
        $this->changeOverTime = $dataPoint[ 'changeOverTime' ] ?? NULL;
    }

}