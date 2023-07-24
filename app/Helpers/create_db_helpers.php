<?php

namespace App\Helpers;

class CreateDBHelper
{

    public static function createDb($cpanel_theme, $cPanelUser, $cPanelPass, $dbName)
    {
        $buildRequest = "/frontend/" . $cpanel_theme . "/sql/addb.html?db=" . $dbName;

        $openSocket = fsockopen('localhost', 2082);
        if (!$openSocket) {
            return "Socket error";
            exit();
        }

        $authString = $cPanelUser . ":" . $cPanelPass;
        $authPass = base64_encode($authString);
        $buildHeaders = "GET " . $buildRequest . "\r\n";
        $buildHeaders .= "HTTP/1.0\r\n";
        $buildHeaders .= "Host:localhost\r\n";
        $buildHeaders .= "Authorization: Basic " . $authPass . "\r\n";
        $buildHeaders .= "\r\n";

        fputs($openSocket, $buildHeaders);
        while (!feof($openSocket)) {
            fgets($openSocket, 128);
        }
        fclose($openSocket);
    }

    public static function createUser($cpanel_theme, $cPanelUser, $cPanelPass, $userName, $userPass)
    {
        $buildRequest = "/frontend/" . $cpanel_theme . "/sql/adduser.html?user=" . $userName . "&pass=" . $userPass;

        $openSocket = fsockopen('localhost', 2082);
        if (!$openSocket) {
            return "Socket error";
            exit();
        }

        $authString = $cPanelUser . ":" . $cPanelPass;
        $authPass = base64_encode($authString);
        $buildHeaders = "GET " . $buildRequest . "\r\n";
        $buildHeaders .= "HTTP/1.0\r\n";
        $buildHeaders .= "Host:localhost\r\n";
        $buildHeaders .= "Authorization: Basic " . $authPass . "\r\n";
        $buildHeaders .= "\r\n";

        fputs($openSocket, $buildHeaders);
        while (!feof($openSocket)) {
            fgets($openSocket, 128);
        }
        fclose($openSocket);
    }

    public static function addUserToDb($cpanel_theme, $cPanelUser, $cPanelPass, $userName, $dbName, $privileges)
    {
        // $buildRequest = "/frontend/" . $cpanel_theme . "/sql/addusertodb.html?user=" . $userName . "&db=" . $cPanelUser . "_" . $dbName . "&privileges=" . $privileges;
        $buildRequest = "/frontend/" . $cpanel_theme . "/sql/addusertodb.html?user=" . $cPanelUser . "_" . $userName . "&db=" . $cPanelUser . "_" . $dbName . "&privileges=" . $privileges;

        $openSocket = fsockopen('localhost', 2082);
        if (!$openSocket) {
            return "Socket error";
            exit();
        }

        $authString = $cPanelUser . ":" . $cPanelPass;
        $authPass = base64_encode($authString);
        $buildHeaders = "GET " . $buildRequest . "\r\n";
        $buildHeaders .= "HTTP/1.0\r\n";
        $buildHeaders .= "Host:localhost\r\n";
        $buildHeaders .= "Authorization: Basic " . $authPass . "\r\n";
        $buildHeaders .= "\r\n";

        fputs($openSocket, $buildHeaders);
        while (!feof($openSocket)) {
            fgets($openSocket, 128);
        }
        fclose($openSocket);
    }

    public static function create_db_process($database_name,$database_user)
    {
        $cpanel_username = "c2marketplace";
        $cpanel_pass = "[k&PDIDk7X4]";
        $cpanel_theme = "paper_lantern";
        self::createDb($cpanel_theme, $cpanel_username, $cpanel_pass, $database_name);
        // self::addUserToDb($cpanel_theme, $cpanel_username, $cpanel_pass, $database_user, $database_name, 'ALL PRIVILEGES');
        self::addUserToDb($cpanel_theme, $cpanel_username, $cpanel_pass, 'asset_lv', $database_name, 'ALL PRIVILEGES');
    }
    
    public static function deleteDb($dbName)
    {
        $cPanelUser = "c2marketplace";
        $cPanelPass = "[k&PDIDk7X4]";
        $cpanel_theme = "paper_lantern";
        $buildRequest = "/frontend/" . $cpanel_theme . "/sql/deldb.html?db=" . $cPanelUser . '_' . $dbName;

        $openSocket = fsockopen('localhost', 2082);
        if (!$openSocket) {
            return "Socket error";
            exit();
        }

        $authString = $cPanelUser . ":" . $cPanelPass;
        $authPass = base64_encode($authString);
        $buildHeaders = "GET " . $buildRequest . "\r\n";
        $buildHeaders .= "HTTP/1.0\r\n";
        $buildHeaders .= "Host:localhost\r\n";
        $buildHeaders .= "Authorization: Basic " . $authPass . "\r\n";
        $buildHeaders .= "\r\n";

        fputs($openSocket, $buildHeaders);
        while (!feof($openSocket)) {
            fgets($openSocket, 128);
        }
        fclose($openSocket);
    }

}
