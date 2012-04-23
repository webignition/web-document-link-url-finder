<?php
ini_set('display_errors', 'On');
require_once($_SERVER['DOCUMENT_ROOT'].'/../../lib/bootstrap.php');

$sourceUrls = array(
    'http://www.sequence.co.uk/en/Blog.aspx?tag=d8f96632-9678-4eb2-bcb9-b6a4a6537ab9',
    'http://en.wikipedia.org/wiki/Main_Page',
    'http://www.google.co.uk',
    'http://news.ycombinator.com',
    'http://news.bbc.co.uk/',
    'http://reddit.com',
    'http://news.ycombinator.com/item?id=3720332',
    'http://www.microsoft.com/en-us/default.aspx',
    'http://www.stackoverflow.com/'
);

foreach ($sourceUrls as $sourceUrl) {
    echo "Finding link URLs in ".$sourceUrl."\n";

    $finder = new \webignition\WebDocumentLinkUrlFinder\WebDocumentLinkUrlFinder();
    $finder->setSourceUrl($sourceUrl);

    $urls = $finder->urls();
   
    echo "Found ".count($urls)." urls\n";
    
    if (isset($_GET['verbose'])) {
        foreach ($urls as $url) {
            //echo $url . "\n";
            var_dump($url);
        }
    }
    
    echo "\n";
}