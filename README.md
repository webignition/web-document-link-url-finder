Web Document Link URL Finder
============================

Get a collection of full absolute URLs for all links found at a given URL.

Building
--------

This project has external dependencies managed with [composer][1]. Get and install this first.

    # Make a suitable project directory
    mkdir ~/html-document-link-url-finder && cd ~/html-document-link-url-finder

    # Clone repository
    git clone git@github.com:webignition/html-document-link-url-finder.git .

    # Retrieve/update dependencies
    composer.phar update

Usage
-----

### The "Hello World" example

```php
<?php
$sourceUrl = 'http://www.google.co.uk/search?q=Hello+World';

echo "Finding link URLs in ".$sourceUrl."\n";

$finder = new \webignition\WebDocumentLinkUrlFinder\WebDocumentLinkUrlFinder();
$finder->setSourceUrl($sourceUrl);

$urls = $finder->urls();

echo "Found ".count($urls)." urls\n";

if (isset($_GET['verbose'])) {
    foreach ($urls as $url) {
        echo $url . "\n";
    }
}

echo "\n";
```

[1]: http://getcomposer.org/