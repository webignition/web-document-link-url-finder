<?php

namespace webignition\WebDocumentLinkUrlFinder;

/**
 * Extends vanilla HtmlDocumentLinkUrlFinder, only gets URLs for HTTP requests
 * that respond with a crawlable response code
 * 
 * @package webignition\HtmlDocumentLinkUrlFinder
 *
 */
class WebDocumentLinkUrlFinder extends \webignition\HtmlDocumentLinkUrlFinder\HtmlDocumentLinkUrlFinder {
    
    /**
     *
     * @var \webignition\Http\Client\CachingClient 
     */
    private $httpClient = null;    
    
    
    /**
     *
     * @return array
     */
    public function urls() {        
        if (!$this->hasUrls()) {
            $request = new \HttpRequest($this->getSourceUrl());           
            $response = $this->httpClient()->getResponse($request);
            
            if ($this->isCrawlableResponse($response)) {
                $this->setSourceContent($response->getBody());                
            } else {
                $this->clearUrls();
            }            
        }
        
        return parent::urls();
    }
    
    
    /**
     *
     * @param \HttpMessage $response
     * @return type 
     */
    private function isCrawlableResponse(\HttpMessage $response) {
        return $response->getResponseCode() == 200;
    }
    
    
    /**
     *
     * @return webignition\Http\Client\Client
     */
    private function httpClient() {
        if (is_null($this->httpClient)) {
            $this->httpClient = new \webignition\Http\Client\CachingClient();
            $this->httpClient->redirectHandler()->enable();
        }
        
        return $this->httpClient;
    }    

}