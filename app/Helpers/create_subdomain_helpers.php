<?php

namespace App\Helpers;

class CreateSubdomainHelper
{
    
    public static function createSudomain($subDomainName, $cPanelUser, $cPanelPass)
    {
        // $domainName = env('ROOT_DOMAIN');
        $domainName = 'c2marketplace.com';
        // $cPanelUser = env('CPANEL_USER');
        // $cPanelPass = env('CPANEL_PASS');
        // $subDomainName =  'demo';
        $subDomain = $subDomainName;

        $rootDomain = $domainName;

        $buildRequest = "/frontend/paper_lantern/subdomain/doadddomain.html?rootdomain=" . $rootDomain . "&domain=" . $subDomain . "&dir=$subDomain" . "." . $domainName;

        $openSocket = fsockopen('localhost', 2082);
        if (!$openSocket) {
            return "Socket error";
            exit();
        }

        $authString = $cPanelUser . ":" . $cPanelPass;
        $authPass = base64_encode($authString);
        $buildHeaders  = "GET " . $buildRequest . "\r\n";
        $buildHeaders .= "HTTP/1.0\r\n";
        $buildHeaders .= "Host:localhost\r\n";
        $buildHeaders .= "Authorization: Basic " . $authPass . "\r\n";
        $buildHeaders .= "\r\n";

        fputs($openSocket, $buildHeaders);
        while (!feof($openSocket)) {
            fgets($openSocket, 128);
        }
        fclose($openSocket);

        // echo $newDomain = "http://" . $subDomain . "." . $rootDomain . "/";
        $newDomain = $subDomain . "." . $rootDomain . "/";
        return $newDomain;
        // $this->unzip($newDomain);

    }
}