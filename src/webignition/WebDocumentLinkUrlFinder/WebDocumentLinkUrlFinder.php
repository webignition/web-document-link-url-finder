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
     * Options to use with the interal \HttpRequest
     * 
     * @var array
     */
    private $requestOptions = array();
    
    
    /**
     *
     * @var array
     */
    private $requestHeaders = array();
    
    
    /**
     *
     * @return array
     */
    public function urls() {        
        if (!$this->hasUrls()) {
            $request = new \HttpRequest($this->getSourceUrl());
            $request->setOptions($this->requestOptions);
            $request->addHeaders($this->requestHeaders);
            
            try {
                $response = $this->httpClient()->getResponse($request);
            } catch (\webignition\Http\Client\Exception $e) {
                if ($e->isDnsLookupFailureException()) {
                    return array();
                }
            }            
            
            if ($this->isCrawlableResponse($response)) {
                $this->setSourceContent($response->getBody());                
            } else {
                $this->clearUrls();
            }            
        }
        
        return parent::urls();
    }
    
    
    /**
     * Set options to use with the interal \HttpRequest
     *
     * @see http://php.net/manual/en/http.request.options.php
     * @param array $requestOptions 
     */
    public function setRequestOptions($requestOptions) {
        $this->requestOptions = $requestOptions;
    }
    
    
    /**
     * Set headers to send with HTTP request
     * 
     * @param array $requestHeaders 
     */
    public function setRequestHeaders($requestHeaders = array()) {
        if (!is_array($requestHeaders)) {
            $requestHeaders = array();
        }
        
        $this->requestHeaders = $requestHeaders;
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
            $this->httpClient = new \webignition\Http\Client\Client();
            $this->httpClient->redirectHandler()->enable();
        }
        
        return $this->httpClient;
    }    

}