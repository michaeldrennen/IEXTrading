<?php

namespace MichaelDrennen\IEXTrading\Responses;

class StockNewsItem {

    public $datetime;
    public $headline;
    public $source;
    public $url;
    public $summary;
    public $related;


    public function __construct( $a ) {
        $this->datetime = $a[ 'datetime' ] ?? NULL;
        $this->headline = $a[ 'headline' ] ?? NULL;
        $this->source   = $a[ 'source' ] ?? NULL;
        $this->url      = $a[ 'url' ] ?? NULL;
        $this->summary  = $a[ 'summary' ] ?? NULL;
        $this->related  = $a[ 'related' ] ?? NULL;

    }

}