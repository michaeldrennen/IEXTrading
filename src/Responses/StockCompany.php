<?php

namespace MichaelDrennen\IEXTrading\Responses;

class StockCompany extends IEXTradingResponse {

    public $symbol;
    public $companyName;
    public $exchange;
    public $industry;
    public $website;
    public $description;
    public $CEO;
    public $issueType;
    public $sector;

    // (blank) = Not Available, i.e., Warrant, Note, or (non-filing) Closed Ended Funds
    public $issueTypes = [
        'ad' => "American Depository Receipt (ADR’s)",
        're' => "Real Estate Investment Trust (REIT’s)",
        'ce' => "Closed end fund (Stock and Bond Fund)",
        'si' => "Secondary Issue",
        'lp' => "Limited Partnerships",
        'cs' => "Common Stock",
        'et' => "Exchange Traded Fund (ETF)",
    ];

    /**
     * StockCompany constructor.
     *
     * @param $response
     */
    public function __construct( $response ) {
        $jsonString        = (string)$response->getBody();
        $a                 = \GuzzleHttp\json_decode( $jsonString, TRUE );
        $this->symbol      = $a[ 'symbol' ] ?? NULL;
        $this->companyName = $a[ 'companyName' ] ?? NULL;
        $this->exchange    = $a[ 'exchange' ] ?? NULL;
        $this->industry    = $a[ 'industry' ] ?? NULL;
        $this->website     = $a[ 'website' ] ?? NULL;
        $this->description = $a[ 'description' ] ?? NULL;
        $this->CEO         = $a[ 'CEO' ] ?? NULL;
        $this->issueType   = $a[ 'issueType' ] ?? NULL;
        $this->sector      = $a[ 'sector' ] ?? NULL;
    }

}