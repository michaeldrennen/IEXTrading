<?php

namespace MichaelDrennen\IEXTrading\Responses;

class StockLogo extends IEXTradingResponse {

    public $url;

    public function __construct( $response ) {
        $jsonString = (string)$response->getBody();
        $a          = \GuzzleHttp\json_decode( $jsonString, TRUE );
        $this->url  = $a[ 'url' ] ?? NULL;
    }

}