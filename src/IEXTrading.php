<?php

namespace MichaelDrennen\IEXTrading;

use MichaelDrennen\IEXTrading\Exceptions\InvalidStockChartOption;
use MichaelDrennen\IEXTrading\Exceptions\ItemCountPassedToStockNewsOutOfRange;
use MichaelDrennen\IEXTrading\Exceptions\UnknownSymbol;
use MichaelDrennen\IEXTrading\Responses\StockChart;
use MichaelDrennen\IEXTrading\Responses\StockCompany;
use MichaelDrennen\IEXTrading\Responses\StockFinancials;
use MichaelDrennen\IEXTrading\Responses\StockLogo;
use MichaelDrennen\IEXTrading\Responses\StockNews;
use MichaelDrennen\IEXTrading\Responses\StockPeers;
use MichaelDrennen\IEXTrading\Responses\StockPrice;
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
     *
     * @return \MichaelDrennen\IEXTrading\Responses\StockNews
     * @throws \MichaelDrennen\IEXTrading\Exceptions\ItemCountPassedToStockNewsOutOfRange
     * @throws \MichaelDrennen\IEXTrading\Exceptions\UnknownSymbol
     * @throws \Exception
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
     *
     * @return StockChart
     * @throws \MichaelDrennen\IEXTrading\Exceptions\InvalidStockChartOption
     * @throws \Exception
     */
    public static function stockChart( string $ticker, string $option, string $date = NULL ): StockChart {
        $uri = 'stock/' . $ticker . '/chart/' . $option;

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
                $uri      .= '/' . $date;
                $response = IEXTrading::makeRequest( 'GET', $uri );
                break;
            default:
                throw new InvalidStockChartOption( "When calling stockChart() you passed in [" . $option . "] as an option. Valid values are 5y, 2y, 1y, ytd, 6m, 3m, 1m, 1d, date, and dynamic." );

        endswitch;

        return new StockChart( $response, $option, $date );
    }

    /**
     * @param string $ticker
     * @return \MichaelDrennen\IEXTrading\Responses\StockFinancials
     * @throws \MichaelDrennen\IEXTrading\Exceptions\UnknownSymbol
     * @throws \Exception
     */
    public static function stockFinancials( string $ticker ): StockFinancials {
        $uri      = 'stock/' . $ticker . '/financials';
        $response = IEXTrading::makeRequest( 'GET', $uri );

        return new StockFinancials( $response );
    }

    /**
     * @param string $ticker
     * @return \MichaelDrennen\IEXTrading\Responses\StockLogo
     * @throws \MichaelDrennen\IEXTrading\Exceptions\UnknownSymbol
     * @throws \Exception
     */
    public static function stockLogo( string $ticker ): StockLogo {
        $uri      = 'stock/' . $ticker . '/logo';
        $response = IEXTrading::makeRequest( 'GET', $uri );

        return new StockLogo( $response );
    }

    /**
     * @param string $ticker
     * @return float
     * @throws \Exception
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
     * @throws \Exception
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