<?php
ini_set('display_errors', 'On');
require_once($_SERVER['DOCUMENT_ROOT'].'/../../lib/bootstrap.php');

$sourceUrls = array(
    'http://www.sequence.co.uk/en/Blog.aspx?tag=d8f96632-9678-4eb2-bcb9-b6a4a6537ab9',
    'http://en.wikipedia.org/wiki/Main_Page',
    'http://www.google.co.uk',
    'http://news.bbc.co.uk/',
    'http://reddit.com',
    'http://www.microsoft.com/en-us/default.aspx',
    'http://www.stackoverflow.com/'
);

foreach ($sourceUrls as $sourceUrl) {
    echo "Finding link URLs in ".$sourceUrl."\n";

    $finder = new \webignition\WebDocumentLinkUrlFinder\WebDocumentLinkUrlFinder();
    $finder->setSourceUrl($sourceUrl);
    $finder->setRequestOptions(array(
        'proxyhost' => 'localhost',
        'proxyport' => 3128,
        'proxytype' => HTTP_PROXY_HTTP
    ));

    $urls = $finder->urls();
   
    echo "Found ".count($urls)." urls\n";
    
    if (isset($_GET['verbose'])) {
        foreach ($urls as $url) {
            echo $url . "\n";
        }
    }
    
    echo "\n";
}