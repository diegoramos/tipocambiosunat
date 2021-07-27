<?php

namespace Bitzua;

class cURL {
    private $refer;
    private $url;
    private $agents;
    private $ch;
    private $cReferer;
    private $cUrl;
    private $ccTime;
    private $cAgents;
    private $errorCurl;
    private $cHttp;
    private $cTime;
    private $cLocation;
    private $cRetTrans;
    private $cHttpVer;
    private $cIpResol;
    private $cSslvHost;
    private $cSslvPeer;
    private $data;

    /**
     * cURL constructor.
     *
     * @param string $refer
     * @param string $url
     * @param null   $browsers
     */
    public function __construct($refer, $url, $browsers = null)
    {
        $this->refer    = $refer;
        $this->url 		= $url;
        $this->agents   = 'Mozilla/5.0 (X11; U; Linux i686; en-US) AppleWebKit/534.16 (KHTML, like Gecko) Chrome/10.0.648.204 Safari/534.16';
        if ($browsers !== '') {
            $this->agents = $browsers;
        }
    }

	/**
	* Curl send get request, support HTTPS protocol
	* @param string $url The request url
	* @param string $refer The request refer
	* @param int $timeout The timeout seconds
	* @return mixed
	*/
	function getRequest()
	{
        $ssl = stripos($this->url,'https://') === 0 ? true : false;

        $this->ch        = curl_init();
        $this->cUrl      = curl_setopt($this->ch, CURLOPT_URL, urldecode($this->url));
        $this->ccTime    = curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 10);
        $this->cAgents   = curl_setopt($this->ch, CURLOPT_USERAGENT, $this->agents);
        $this->cHttp     = curl_setopt($this->ch, CURLOPT_HTTPHEADER, ['Accept-Language: es-es,en']);
        $this->cTime     = curl_setopt($this->ch, CURLOPT_TIMEOUT, 10);
        $this->cLocation = curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
        $this->caReferer = curl_setopt($this->ch, CURLOPT_AUTOREFERER, 1);
        $this->cRetTrans = curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        $this->cBinary   = curl_setopt($this->ch, CURLOPT_BINARYTRANSFER, 1);
        $this->cHttpVer  = curl_setopt($this->ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        $this->cIpResol  = curl_setopt($this->ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $this->data      = curl_exec($this->ch);
        $this->errorCurl = curl_error($this->ch);

	    if ($this->refer) {
	        $this->refer  = curl_setopt($this->ch, CURLOPT_REFERER, $this->refer);
	    }
	    if ($ssl) {
	        //support https
	        $this->cSslvHost = curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, false);
	        $this->cSslvPeer = curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
	    }

	    if ($errno = curl_errno($this->ch)) {
	        //error message
		    $error_message = curl_strerror($errno);
		    echo "cURL error ({$errno}):\n {$error_message}";
	    }
	    curl_close($this->ch);

	    return $this->data;
	}

}

?>