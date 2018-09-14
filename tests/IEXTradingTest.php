<?php

use MichaelDrennen\IEXTrading\IEXTrading;
use PHPUnit\Framework\TestCase;

class IEXTradingTest extends TestCase {

    public function testStockPrice() {
        $price = IEXTrading::stockPrice( 'aapl' );
        $this->assertTrue( is_float( $price ) );
    }

    public function testStockFinancials() {
        /**
         * @var \MichaelDrennen\IEXTrading\Responses\StockFinancials $stockFinancials
         */
        $stockFinancials = IEXTrading::stockFinancials( 'aapl' );
        $this->assertEquals( 'AAPL', $stockFinancials->symbol );
    }

    public function testStockLogo() {
        /**
         * @var \MichaelDrennen\IEXTrading\Responses\StockLogo $stockLogo
         */
        $stockLogo = IEXTrading::stockLogo( 'aapl' );
        $this->assertEquals( 'https://storage.googleapis.com/iex/api/logos/AAPL.png', $stockLogo->url );
    }

    /**
     * @throws \MichaelDrennen\IEXTrading\Exceptions\ItemCountPassedToStockNewsOutOfRange
     * @throws \MichaelDrennen\IEXTrading\Exceptions\UnknownSymbol
     * @throws \Exception
     */
    public function testStockNews() {
        /**
         * @var \MichaelDrennen\IEXTrading\Responses\StockNews $stockNews
         */
        $stockNews = IEXTrading::stockNews( 'aapl', 1 );

        $this->assertCount( 1, $stockNews->items );
    }

    /**
     * FIXED https://github.com/iexg/IEX-API/issues/185
     * @throws \MichaelDrennen\IEXTrading\Exceptions\ItemCountPassedToStockNewsOutOfRange
     * @throws \MichaelDrennen\IEXTrading\Exceptions\UnknownSymbol
     * @throws \Exception
     */
    public function testStockNewsWithNoParametersShouldReturnTenMarketNewsItems() {
        /**
         * @var \MichaelDrennen\IEXTrading\Responses\StockNews $stockNews
         */
        $stockNews = IEXTrading::stockNews();
        $this->assertCount( 10, $stockNews->items );

    }

    public function testStockNewsWithTooManyItemsShouldThrowException() {
        $this->expectException( \MichaelDrennen\IEXTrading\Exceptions\ItemCountPassedToStockNewsOutOfRange::class );
        /**
         * @var \MichaelDrennen\IEXTrading\Responses\StockNews $stockNews
         */
        IEXTrading::stockNews( 'aapl', 51 );
    }

    public function testStockNewsWithTooFewItemsShouldThrowException() {
        $this->expectException( \MichaelDrennen\IEXTrading\Exceptions\ItemCountPassedToStockNewsOutOfRange::class );
        /**
         * @var \MichaelDrennen\IEXTrading\Responses\StockNews $stockNews
         */
        IEXTrading::stockNews( 'aapl', -1 );
    }

    public function testStockStatsWithInvalidTicker() {
        $this->expectException( \MichaelDrennen\IEXTrading\Exceptions\UnknownSymbol::class );
        IEXTrading::stockStats( 'thisisafaketicker' );
    }

    public function testStockStats() {
        /**
         * @var \MichaelDrennen\IEXTrading\Responses\StockStats $stockStats
         */
        $stockStats = IEXTrading::stockStats( 'aapl' );
        $this->assertEquals( 'Apple Inc.', $stockStats->companyName );
    }

    public function testStockQuote() {
        /**
         * @var \MichaelDrennen\IEXTrading\Responses\StockQuote $stockQuote
         */
        $stockQuote = IEXTrading::stockQuote( 'aapl' );
        $this->assertEquals( 'Apple Inc.', $stockQuote->companyName );
    }

    public function testStockCompany() {
        /**
         * @var \MichaelDrennen\IEXTrading\Responses\StockCompany $stockCompany
         */
        $stockCompany = IEXTrading::stockCompany( 'aapl' );
        $this->assertEquals( 'http://www.apple.com', $stockCompany->website );
    }

    public function testStockPeers() {
        /**
         * @var \MichaelDrennen\IEXTrading\Responses\StockPeers $stockPeers
         */
        $stockPeers = IEXTrading::stockPeers( 'aapl' );
        $this->assertTrue( in_array( 'MSFT', $stockPeers->symbols ) );
    }

    public function testStockRelevant() {
        /**
         * @var \MichaelDrennen\IEXTrading\Responses\StockRelevant $stockRelevant
         */
        $stockRelevant = IEXTrading::stockRelevant( 'aapl' );
        $this->assertTrue( in_array( 'MSFT', $stockRelevant->symbols ) );
        $this->assertTrue( $stockRelevant->peers );
    }


    /**
     * TODO Add code to determine WHEN this unit test is run. If you run it outside of MARKET HOURS, the data you get back will be different.
     * @test
     * @group chart
     */
    public function testStockChartDynamic() {
        /**
         * @var \MichaelDrennen\IEXTrading\Responses\StockChart $stockChart
         */
        $stockChart = IEXTrading::stockChart( 'aapl', \MichaelDrennen\IEXTrading\Responses\StockChart::OPTION_DYNAMIC );
        $this->assertInstanceOf( \MichaelDrennen\IEXTrading\Responses\StockChart::class, $stockChart );
    }

    public function testStockChartDate() {
        /**
         * @var \MichaelDrennen\IEXTrading\Responses\StockChart $stockChart
         */
        $stockChart = IEXTrading::stockChart( 'aapl', \MichaelDrennen\IEXTrading\Responses\StockChart::OPTION_DATE,
                                              '20180103' );
        $this->assertInstanceOf( \MichaelDrennen\IEXTrading\Responses\StockChart::class, $stockChart );
    }

    public function testStockChartOneMonth() {
        /**
         * @var \MichaelDrennen\IEXTrading\Responses\StockChart $stockChart
         */
        $stockChart = IEXTrading::stockChart( 'aapl', \MichaelDrennen\IEXTrading\Responses\StockChart::OPTION_1M );
        $this->assertInstanceOf( \MichaelDrennen\IEXTrading\Responses\StockChart::class, $stockChart );
    }

    public function testStockChartWithInvalidOptionShouldThrowException() {
        $this->expectException( Exception::class );
        IEXTrading::stockChart( 'aapl', 'notValidOption' );
    }

    /**
     * @test
     * @group price
     */
    public function testGetClosingPriceByDateWithTooEarlyDateShouldThrowException() {
        $this->expectException( Exception::class );
        $ticker       = 'AAPL';
        $date         = \Carbon\Carbon::parse( '2001-10-01' );
        IEXTrading::getClosingPriceByDate( $ticker, $date );
    }


    /**
     * TODO Add code that will intelligently pick the date to run this test on. (A business day) Because 5 years from
     * now this test won't work. (IEXTrading doesn't return data points older than that.)
     * @test
     * @group price
     */
    public function testGetClosingPriceByDateWithValidDateShouldReturnPrice() {
        $ticker       = 'AAPL';
        $date         = \Carbon\Carbon::parse( '2018-09-13' );
        $closingPrice = IEXTrading::getClosingPriceByDate( $ticker, $date );
        $this->assertEquals( 226.41, $closingPrice );
    }


}