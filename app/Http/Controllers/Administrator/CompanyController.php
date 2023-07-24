<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
// use App\Models\Module;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
// use File;
// use ZipArchive;
use Illuminate\Support\Facades\Session;


class CompanyController extends Controller
{
    public function companies()
    {
        $companies = Company::all();
        // $companies = DB::table('companies')
        // ->join('subscription_master', 'companies.id', '=', 'subscription_master.company_id')
        // ->join('orders', 'users.id', '=', 'orders.user_id')
        // ->select('users.*', 'contacts.phone', 'orders.price')
        // ->get();
        $title = 'AssetCOD | Company';
        return view('Administrator.Companies.index',compact('companies','title'));
    }


    public function statusUpdate(Request $request)
    {
        $company = Company::find($request->company_id);
        // echo $company;
        if (!empty($company)) {
            $company->status = $request->status;
            $company->save();
            Self::offCompanyStatus($company->slug);
            return response()->json(['success' => 'Status Updated Successfully']);
        } else {
            return response()->json(['error' => 'Oops! something unexpected happened!']);
        }
    }

    public function create_company(){
        $title = 'AssetCOD | Create Company';
        $subscriptions = DB::select('SELECT sm.*,sc.* FROM `subscription_master` sm inner join
        subscription_charges sc on sm.id=sc.subscription_id inner join
        (select `subscription_id`,max(`created_at`) as created from subscription_charges group by `subscription_id`) A
        on sm.id=A.subscription_id and sc.created_at=A.created');
        return view('Administrator.Companies.create_new_company',compact('title','subscriptions'));
    }
    
    
    public function offCompanyStatus($subdomain=""){
        $buildRequest = "https://aditya-birla-group.c2marketplace.com/logout";

        $openSocket = fsockopen('localhost', 2082);
        if (!$openSocket) {
            return "Socket error";
            exit();
        }

        // $authString = $cPanelUser . ":" . $cPanelPass;
        // $authPass = base64_encode($authString);
        $buildHeaders = "GET " . $buildRequest . "\r\n";
        $buildHeaders .= "HTTP/1.0\r\n";
        $buildHeaders .= "Host:localhost\r\n";
        // $buildHeaders .= "Authorization: Basic " . $authPass . "\r\n";
        $buildHeaders .= "\r\n";

        fputs($openSocket, $buildHeaders);
        while (!feof($openSocket)) {
            fgets($openSocket, 128);
        }
        fclose($openSocket);
    }
    
    
    // public function offCompanyStatus($subdomain=""){
    //     // dd($_SERVER['HTTP_USER_AGENT']);
    //     $url = "https://aditya-birla-group.c2marketplace.com/logout";
    //     // $url = "https://".$subdomain.'.'.env('ROOT_DOMAIN').'/api/off-status';
    //     $headers = array(
    //         // "accept: application/json",
    //         // "Authorization: Bearer ".$accesstoken,
    //         // "User-Agent: <product> / <product-version> <comment>"
    //         "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36"
    //         // "user-agent: ".$_SERVER['HTTP_USER_AGENT']
    //         // "User-Agent: ".$_SERVER['HTTP_USER_AGENT']
    //         // "User-Agent: Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0"
    //     );
    //     // dd($headers);

        
    //     $curl = curl_init($url);
    //     curl_setopt($curl, CURLOPT_URL, $url);
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
    //     curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    //     // curl_setopt($curl, CURLOPT_REFERER, 'https://www.c2marketplace.com/');
    //     // curl_setopt( $curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
    //     // curl_setopt( $curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; U; Android 2.2; en-us; DROID2 Build/VZW) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1 854X480 motorola DROID2" );

    //     curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //     //for debug only!
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    //     $response = curl_exec($curl);
    //     // var_dump($response);
    //     dd($response);
    // }

}
