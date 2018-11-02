<?php

namespace MichaelDrennen\IEXTrading;

use Carbon\Carbon;
use MichaelDrennen\IEXTrading\Exceptions\InvalidStockChartOption;
use MichaelDrennen\IEXTrading\Exceptions\ItemCountPassedToStockNewsOutOfRange;
use MichaelDrennen\IEXTrading\Exceptions\UnknownSymbol;
use MichaelDrennen\IEXTrading\Responses\StockChart;
use MichaelDrennen\IEXTrading\Responses\StockChartDay;
use MichaelDrennen\IEXTrading\Responses\StockCompany;
use MichaelDrennen\IEXTrading\Responses\StockFinancials;
use MichaelDrennen\IEXTrading\Responses\StockLogo;
use MichaelDrennen\IEXTrading\Responses\StockNews;
use MichaelDrennen\IEXTrading\Responses\StockPeers;
use MichaelDrennen\IEXTrading\Responses\StockQuote;
use MichaelDrennen\IEXTrading\Responses\StockRelevant;
use MichaelDrennen\IEXTrading\Responses\StockStats;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;

class IEXTrading {

    const URL = 'https://api.iextrading.com/1.0/';

    /**
     * @param string $ticker Use market to get market-wide news
     * @param int    $items  How many news items do you want? Number between 1 and 50. Default is 10
     * @return \MichaelDrennen\IEXTrading\Responses\StockNews
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \MichaelDrennen\IEXTrading\Exceptions\ItemCountPassedToStockNewsOutOfRange
     * @throws \MichaelDrennen\IEXTrading\Exceptions\UnknownSymbol
     */
    public static function stockNews( string $ticker = 'market', int $items = NULL ): StockNews {
        if ( isset( $items ) && ( $items < 1 || $items > 50 ) ):
            throw new ItemCountPassedToStockNewsOutOfRange( "If you pass in a date it needs to be a number between 1 and 50. You passed in " . $items );
        endif;

        if ( isset( $items ) ):
            $uri = 'stock/' . $ticker . '/news/last/' . $items;
        else:
            $uri = 'stock/' . $ticker . '/news';
        endif;
        $response = IEXTrading::makeRequest( 'GET', $uri );

        return new StockNews( $response );
    }

    /**
     * @param string $ticker
     * @return \MichaelDrennen\IEXTrading\Responses\StockStats
     * @throws \Exception
     * @throws \MichaelDrennen\IEXTrading\Exceptions\UnknownSymbol
     */
    public static function stockStats( string $ticker ): StockStats {
        $uri      = 'stock/' . $ticker . '/stats';
        $response = IEXTrading::makeRequest( 'GET', $uri );

        return new StockStats( $response );
    }

    /**
     * @param string $ticker
     *
     * @return \MichaelDrennen\IEXTrading\Responses\StockQuote
     * @throws \MichaelDrennen\IEXTrading\Exceptions\UnknownSymbol
     * @throws \Exception
     */
    public static function stockQuote( string $ticker ): StockQuote {
        $uri      = 'stock/' . $ticker . '/quote';
        $response = IEXTrading::makeRequest( 'GET', $uri );

        return new StockQuote( $response );
    }

    /**
     * @param string $ticker
     * @return \MichaelDrennen\IEXTrading\Responses\StockCompany
     * @throws \Exception
     * @throws \MichaelDrennen\IEXTrading\Exceptions\UnknownSymbol
     */
    public static function stockCompany( string $ticker ): StockCompany {
        $uri      = 'stock/' . $ticker . '/company';
        $response = IEXTrading::makeRequest( 'GET', $uri );

        return new StockCompany( $response );
    }

    /**
     * @param string $ticker
     * @return \MichaelDrennen\IEXTrading\Responses\StockPeers
     * @throws \MichaelDrennen\IEXTrading\Exceptions\UnknownSymbol
     * @throws \Exception
     */
    public static function stockPeers( string $ticker ): StockPeers {
        $uri      = 'stock/' . $ticker . '/peers';
        $response = IEXTrading::makeRequest( 'GET', $uri );

        return new StockPeers( $response );
    }

    /**
     * @param string $ticker
     * @return \MichaelDrennen\IEXTrading\Responses\StockRelevant
     * @throws \MichaelDrennen\IEXTrading\Exceptions\UnknownSymbol
     * @throws \Exception
     */
    public static function stockRelevant( string $ticker ): StockRelevant {
        $uri      = 'stock/' . $ticker . '/relevant';
        $response = IEXTrading::makeRequest( 'GET', $uri );

        return new StockRelevant( $response );
    }


    /**
     * @param string $ticker A valid stock ticker Ex: AAPL for Apple
     * @param string $option Valid values: 5y, 2y, 1y, ytd, 6m, 3m, 1m, 1d, date, and dynamic
     * @param string $date   Only used with the 'date' $option passed in. Expected format: yyyymmdd
     * @return \MichaelDrennen\IEXTrading\Responses\StockChart
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \MichaelDrennen\IEXTrading\Exceptions\InvalidRangeReturnedInDynamicChart
     * @throws \MichaelDrennen\IEXTrading\Exceptions\InvalidStockChartOption
     * @throws \MichaelDrennen\IEXTrading\Exceptions\UnknownSymbol
     */
    public static function stockChart( string $ticker, string $option, string $date = NULL ): StockChart {
        $uri              = 'stock/' . $ticker . '/chart/' . $option;

        switch ( $option ):
            case '5y':
            case '2y':
            case '1y':
            case 'ytd':
            case '6m':
            case '3m':
            case '1m':
            case '1d':
            case 'dynamic':
                $response = IEXTrading::makeRequest( 'GET', $uri );
                break;
            case 'date':
                $uri .= '/' . $date;
                $response = IEXTrading::makeRequest( 'GET', $uri );
                break;
            default:
                throw new InvalidStockChartOption( "When calling stockChart() you passed in [" . $option . "] as an option. Valid values are 5y, 2y, 1y, ytd, 6m, 3m, 1m, 1d, date, and dynamic." );

        endswitch;

        return new StockChart( $response, $option, $date );
    }


    // TODO Keep working on this. It will speed up a lot of what I do.
    public static function stockCharts( array $tickers, string $option, string $date ): array {
        $csvTickers = implode( ',', $tickers );
        $uri        = 'stock/market/batch?symbols=' . $csvTickers . '&types=chart&range=' . $option;

    }


    /**
     * @param string $ticker
     * @return \MichaelDrennen\IEXTrading\Responses\StockFinancials
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \MichaelDrennen\IEXTrading\Exceptions\UnknownSymbol
     */
    public static function stockFinancials( string $ticker ): StockFinancials {
        $uri      = 'stock/' . $ticker . '/financials';
        $response = IEXTrading::makeRequest( 'GET', $uri );

        return new StockFinancials( $response );
    }

    /**
     * @param string $ticker
     * @return \MichaelDrennen\IEXTrading\Responses\StockLogo
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \MichaelDrennen\IEXTrading\Exceptions\UnknownSymbol
     */
    public static function stockLogo( string $ticker ): StockLogo {
        $uri      = 'stock/' . $ticker . '/logo';
        $response = IEXTrading::makeRequest( 'GET', $uri );

        return new StockLogo( $response );
    }

    /**
     * @param string $ticker
     * @return float
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \MichaelDrennen\IEXTrading\Exceptions\UnknownSymbol
     */
    public static function stockPrice( string $ticker ): float {
        $uri        = 'stock/' . $ticker . '/price';
        $response   = IEXTrading::makeRequest( 'GET', $uri );
        $jsonString = (string)$response->getBody();
        $price      = \GuzzleHttp\json_decode( $jsonString, TRUE );

        return (float)$price;
    }

    /**
     * Given a ticker and a date, this method will return the closing price.
     * TODO Add code that determines how far back date is, and select a better date option for the stockChart method.
     * No need to pull 5 years of pricing data if I don't have to.
     * @param string         $ticker
     * @param \Carbon\Carbon $date
     * @return float
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \MichaelDrennen\IEXTrading\Exceptions\InvalidRangeReturnedInDynamicChart
     * @throws \MichaelDrennen\IEXTrading\Exceptions\InvalidStockChartOption
     * @throws \MichaelDrennen\IEXTrading\Exceptions\UnknownSymbol
     */
    public static function getClosingPriceByDate( string $ticker, Carbon $date ): float {
        $stockChart = self::stockChart( $ticker, '5y', $date->toDateString() );
        if ( empty( $stockChart->data ) ):
            throw new \Exception( "IEXTrading couldn't find 5y stockChart data for " . $ticker );
        endif;
        $stockChartCollection = collect( $stockChart->data );
        $dateString           = $date->toDateString();
        $day                  = $stockChartCollection->filter( function ( $dayOfData ) use ( $dateString ) {
            return $dateString == $dayOfData->date;
        } );
        if ( $day->isEmpty() ):
            throw new \Exception( "Could not find a price on " . $dateString . " for " . $ticker );
        endif;

        return (float)$day->first()->close;
    }

    /**
     * @param string         $ticker
     * @param \Carbon\Carbon $date
     * @return float
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \MichaelDrennen\IEXTrading\Exceptions\InvalidRangeReturnedInDynamicChart
     * @throws \MichaelDrennen\IEXTrading\Exceptions\InvalidStockChartOption
     * @throws \MichaelDrennen\IEXTrading\Exceptions\UnknownSymbol
     * @todo SEE ABOVE SISTER FUNCTION FOR TODO'S
     */
    public static function getOpeningPriceByDate( string $ticker, Carbon $date ): float {
        $stockChart = self::stockChart( $ticker, '5y', $date->toDateString() );
        if ( empty( $stockChart->data ) ):
            throw new \Exception( "IEXTrading couldn't find 5y stockChart data for " . $ticker );
        endif;
        $stockChartCollection = collect( $stockChart->data );
        $dateString           = $date->toDateString();
        $day                  = $stockChartCollection->filter( function ( $dayOfData ) use ( $dateString ) {
            return $dateString == $dayOfData->date;
        } );
        if ( $day->isEmpty() ):
            throw new \Exception( "Could not find a price on " . $dateString . " for " . $ticker );
        endif;

        return (float)$day->first()->open;
    }


    /**
     * @param string         $ticker
     * @param \Carbon\Carbon $date
     * @return \MichaelDrennen\IEXTrading\Responses\StockChartDay
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \MichaelDrennen\IEXTrading\Exceptions\InvalidRangeReturnedInDynamicChart
     * @throws \MichaelDrennen\IEXTrading\Exceptions\InvalidStockChartOption
     * @throws \MichaelDrennen\IEXTrading\Exceptions\UnknownSymbol
     * @todo SEE ABOVE SISTER FUNCTIONS FOR TODO'S
     */
    public static function getStockChartDayByDate( string $ticker, Carbon $date ): StockChartDay {
        $stockChart = self::stockChart( $ticker, '5y', $date->toDateString() );
        if ( empty( $stockChart->data ) ):
            throw new \Exception( "IEXTrading couldn't find 5y stockChart data for " . $ticker );
        endif;
        $stockChartCollection = collect( $stockChart->data );
        $dateString           = $date->toDateString();
        $day                  = $stockChartCollection->filter( function ( $dayOfData ) use ( $dateString ) {
            return $dateString == $dayOfData->date;
        } );
        if ( $day->isEmpty() ):
            throw new \Exception( "Could not find a price on " . $dateString . " for " . $ticker );
        endif;

        return $day->first();
    }




    /**
     * Set up and return a GuzzleHttp Client with some default settings.
     * @return \GuzzleHttp\Client
     */
    protected static function getClient(): Client {
        return new Client( [
                               'verify'   => FALSE,
                               'base_uri' => IEXTrading::URL,
                           ] );
    }

    /**
     * Makes the request and handles any exceptions that the IEXTrading.com system might return.
     * @param string $method
     * @param string $uri
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \MichaelDrennen\IEXTrading\Exceptions\UnknownSymbol
     */
    protected static function makeRequest( string $method, string $uri ): ResponseInterface {
        $client = IEXTrading::getClient();
        try {
            return $client->request( $method, $uri );
        } catch ( ClientException $clientException ) {
            if ( 'Unknown symbol' == $clientException->getResponse()->getBody() ):
                throw new UnknownSymbol( "IEXTrading.com replied with: " . $clientException->getResponse()->getBody() );
            endif;
            throw $clientException;
        } catch ( \Exception $exception ) {
            throw $exception;
        }
    }

}