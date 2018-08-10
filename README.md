# IEXTrading

[![Latest Stable Version](https://poser.pugx.org/michaeldrennen/iex-trading/v/stable)](https://packagist.org/packages/michaeldrennen/iex-trading) [![Total Downloads](https://poser.pugx.org/michaeldrennen/iex-trading/downloads)](https://packagist.org/packages/michaeldrennen/iex-trading) [![Latest Unstable Version](https://poser.pugx.org/michaeldrennen/iex-trading/v/unstable)](https://packagist.org/packages/michaeldrennen/iex-trading) [![License](https://poser.pugx.org/michaeldrennen/iex-trading/license)](https://packagist.org/packages/michaeldrennen/iex-trading)

PHP library that provides access to the iextrading.com API.

A fork from my original library.

## Usage

### Quote
```php
// https://iextrading.com/developer/docs/#quote 
$stockQuote = IEXTrading::stockQuote( 'aapl' );
echo $stockQuote->companyName; // Apple Inc.
```

### Key Stats
```php
// https://iextrading.com/developer/docs/#key-stats
$stockStats = IEXTrading::stockStats( 'aapl' );
echo $stockStats->marketcap; // 760334287200
```