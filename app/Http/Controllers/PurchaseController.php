<?php

namespace App\Http\Controllers;

use App\Helpers\CreateDBHelper;
use App\Helpers\CreateSubdomainHelper;
use App\Helpers\CreateTableHelper;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use ZipArchive;
use Mail;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|unique:companies,name|max:255',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:companies',
            'phone' => 'required|numeric',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'subscription_id'=>'required'
        ]);
 
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $data = [
            'subscription_id' => $request->subscription_id,
            'company_name' => $request->company_name,
            'email' => $request->email,
            'code' => substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, 6),
            'slug' => Str::slug($request->company_name),
            'first_name' => $request->first_name,
            'last_name'=> $request->last_name,
            'password' => substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, 8),
            'country'=>$request->country,
            'state'=>$request->state,
            'city'=>$request->city,
            'currency'=>$request->currency
        ];
        // dd('hi');
        $info['name']=$data['first_name']." ".$data['last_name'];
        $info['email']=$data['email'];
        $info['accessCode']=$data['code'];
        $info['password']=$data['password'];

        $subscription_data = DB::select('SELECT sm.id,sm.title,sc.tenure FROM `subscription_master` sm inner join
        subscription_charges sc
        on sm.id=sc.subscription_id inner join
        (select `subscription_id`,max(`created_at`) as created from subscription_charges group by `subscription_id`) A
        on sm.id=A.subscription_id and sc.created_at=A.created WHERE sm.id=' . $data['subscription_id']);

        $current = Carbon::now();
        $tenure_to = $current->addDays(floor(365 * $subscription_data[0]->tenure));

        $modules = DB::select('SELECT m.title,smp.* FROM `modules` m join subscription_module_permissions smp on m.id=smp.module_id WHERE smp.subscription_id=' . $data['subscription_id']);
        foreach ($modules as $item) {
            $module_arr[] = [
                'name' => $item->title,
                'view' => ($item->view == 0) ? -1 : 1,
                'add' => ($item->add == 0) ? -1 : 1,
                'edit' => ($item->edit == 0) ? -1 : 1,
                'delete' => ($item->delete == 0) ? -1 : 1,
                'created_at' => date('Y-m-d H:i:s')
            ];
        }


        try{
            $newCompany = new Company();
            $newCompany->subscription_id = $data['subscription_id'];
            $newCompany->name = $data['company_name'];
            $newCompany->first_name = $data['first_name'];
            $newCompany->last_name = $data['last_name'];
            $newCompany->country = $data['country'];
            $newCompany->state = $data['state'];
            $newCompany->city = $data['city'];
            $newCompany->email = $data['email'];
            $newCompany->code = $data['code'];
            $newCompany->slug = $data['slug'];
            $newCompany->start_date = date('Y-m-d H:i:s');
            $newCompany->end_date = $tenure_to;

            $newCompany->save();
        }catch (\Throwable $th){
            return redirect()->back()->with('error', 'The company is already registered');
            // return $th;
        }
        

        CreateDBHelper::create_db_process($newCompany->slug, env('DB_USERNAME'));
        $subdomain = CreateSubdomainHelper::createSudomain($newCompany->slug, 'c2marketplace', "[k&PDIDk7X4]");
        self::unzip($subdomain);
        $info['subdomain']=$subdomain;

        DB::statement('use `c2marketplace_' . $newCompany->slug . '`');

        try {
            DB::unprepared(CreateTableHelper::create_table());

            DB::table('subscriptions')->insert(['title' => $subscription_data[0]->title, 'tenure_from' => date('Y-m-d H:i:s'), 'tenure_to' => $tenure_to, 'created_at' => date('Y-m-d H:i:s')]);
            DB::table('modules')->insert($module_arr);
            $role_id = DB::table('roles')->insertGetId(['name' => 'Admin', 'created_at' => date('Y-m-d H:i:s')]);
            DB::table('users')->insert(['first_name' => $data['first_name'],'last_name'=>$data['last_name'], 'email' => $data['email'], 'country'=> $data['country'],'state'=>$data['state'], 'city'=>$data['city'], 'password' => Hash::make($data['password']), 'role_id' => $role_id, 'created_at' => date('Y-m-d H:i:s')]);
            $new_modules = DB::table('modules')->get();
            foreach ($new_modules as $item) {
                $permission_array[] = [
                    'role_id' => $role_id,
                    'module_id' => $item->id,
                    'view' => $item->view,
                    'add' => $item->add,
                    'edit' => $item->edit,
                    'delete' => $item->delete,
                    'created_at' => date('Y-m-d H:i:s')
                ];
            }
            DB::table('role_module_permissions')->insert($permission_array);
            DB::table('settings')->insert([
                ['group' => 'general', 'name' => 'company_logo', 'locked' => 0, 'payload' => "\"\""],
                ['group' => 'general', 'name' => 'timezone', 'locked' => 0, 'payload' => "\"America/New_York\""],
                ['group' => 'general', 'name' => 'currency', 'locked' => 0, 'payload' => "\"".$data["currency"]."\""]
            ]);
            self::sendEmail($info);
            return redirect()->back()->with('success', 'Purchase has been successfully accomplished');
        } catch (\Throwable $th) {
            throw $th;
            CreateDBHelper::deleteDb($newCompany->slug);
            DB::statement('use ' . env('DB_DATABASE'));
            Company::destroy($newCompany->id);
        }
    }


    public function unzip($subdomain)
    {
        $file = public_path('company.zip');
        $zip = new ZipArchive;
        $res = $zip->open($file);
        $path = '/home2/c2marketplace/' . $subdomain . '/';
        $zip->extractTo($path);
        $zip->close();
    }


    public function local(Request $request)
    {
        $data = [
            'subscription_id' => 41,
            'company_name' => 'Aditya Birla Group',
            'email' => 'tipu@abg.com',
            'code' => substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, 6),
            'slug' => Str::slug('Aditya Birla Group'),
            'name' => 'ABG Admin',
            'password' => 'password'
        ];

        $subscription_data = DB::select('SELECT sm.id,sm.title,sc.tenure FROM `subscription_master` sm inner join
        subscription_charges sc
        on sm.id=sc.subscription_id inner join
        (select `subscription_id`,max(`created_at`) as created from subscription_charges group by `subscription_id`) A
        on sm.id=A.subscription_id and sc.created_at=A.created WHERE sm.id=' . $data['subscription_id']);

        $current = Carbon::now();
        $tenure_to = $current->addDays(floor(365 * $subscription_data[0]->tenure));

        $modules = DB::select('SELECT m.title,smp.* FROM `modules` m join subscription_module_permissions smp on m.id=smp.module_id WHERE smp.subscription_id=' . $data['subscription_id']);
        foreach ($modules as $item) {
            $module_arr[] = [
                'name' => $item->title,
                'view' => ($item->view == 0) ? -1 : 1,
                'add' => ($item->add == 0) ? -1 : 1,
                'edit' => ($item->edit == 0) ? -1 : 1,
                'delete' => ($item->delete == 0) ? -1 : 1,
                'created_at' => date('Y-m-d H:i:s')
            ];
        }


        $newCompany = new Company();
        $newCompany->name = $data['company_name'];
        $newCompany->email = $data['email'];
        $newCompany->code = $data['code'];
        $newCompany->slug = $data['slug'];
        $newCompany->save();

        DB::statement('CREATE DATABASE `' . $newCompany->slug . '`');
        DB::statement('use `' . $newCompany->slug . '`');

        try {
            DB::beginTransaction();
            DB::unprepared(CreateTableHelper::create_table());

            DB::table('subscriptions')->insert(['title' => $subscription_data[0]->title, 'tenure_from' => date('Y-m-d H:i:s'), 'tenure_to' => $tenure_to, 'created_at' => date('Y-m-d H:i:s')]);
            DB::table('modules')->insert($module_arr);
            $role_id = DB::table('roles')->insertGetId(['name' => 'Admin', 'created_at' => date('Y-m-d H:i:s')]);
            DB::table('users')->insert(['name' => $data['name'], 'email' => $data['email'], 'password' => Hash::make($data['password']), 'role_id' => $role_id, 'created_at' => date('Y-m-d H:i:s')]);
            $new_modules = DB::table('modules')->get();
            foreach ($new_modules as $item) {
                $permission_array[] = [
                    'role_id' => $role_id,
                    'module_id' => $item->id,
                    'view' => $item->view,
                    'add' => $item->add,
                    'edit' => $item->edit,
                    'delete' => $item->delete,
                    'created_at' => date('Y-m-d H:i:s')
                ];
            }
            DB::table('role_module_permissions')->insert($permission_array);
            DB::table('settings')->insert(['group' => 'general', 'name' => 'company_logo', 'locked' => 0, 'payload' => ""]);
            DB::commit();
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollback();
            DB::statement('DROP DATABASE `' . $newCompany->slug . '`');
            DB::statement('use ' . env('DB_DATABASE'));
            Company::destroy($newCompany->id);
        }
    }
    
    public function sendEmail($info){
        Mail::send('mail', $info, function ($message) use ($info)
        {
            // $message->to('surajit@pixelconsultancy.in', $info['name'])
            $message->to($info['email'], $info['name'])
                ->subject('Confirmation of company registration');
            $message->from('admin@c2marketplace.com', 'c2marketplace');
        });
        // echo "Successfully sent the email";
    }
}
