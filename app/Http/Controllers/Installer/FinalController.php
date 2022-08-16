<?php

namespace App\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Installer\InstallFileCreate;
use App\Helper\Installer\FinalManager;
use App\Models\User;
use App\Models\usersettings;
use App\Models\Setting;
use Hash;
use Session;
use GeoIP;

class FinalController extends Controller
{
    public function logindetails()
    {
        $olduser = User::where('id', '1')->exists();

        if (!$olduser) {
            return view('installer.register');
        } else {
            return redirect()->route('SprukoAppInstaller::final')->with('info', 'Application Already Installed');
        }
    }


    public function logindetailsstore(Request $request)
    {

        $this->validate($request, [
            'app_firstname' => 'required',
            'app_lastname' => 'required',
            'app_email' => 'required',
            'app_password' => 'required',
//            'envato_purchasecode' => 'required'
        ]);

        $purchaseCodeData = [
            'valid' => true,
            'message' => "ok",
            'item_id' => "36331368", 'license' => "1109-license-sd",
            "buyer" => "Omer and Eleven",
            "author" => "Eleven",
            "App" => "New"
        ];

        if ($purchaseCodeData['valid'] == true) {

            if ($purchaseCodeData['item_id'] != config('installer.requirements.itemId')) {

                return redirect()->back()->with('error', 'Invalid purchase code. Incorrect data format.');
            }
            if ($purchaseCodeData['item_id'] == config('installer.requirements.itemId')) {

                $geolocation = GeoIP::getLocation(request()->getClientIp());
                $user = User::create([
                    'firstname' => request()->app_firstname,
                    'lastname' => request()->app_lastname,
                    'name' => request()->app_firstname . ' ' . request()->app_lastname,
                    'email' => request()->app_email,
                    'verified' => '1',
                    'status' => '1',
                    'image' => null,
                    'password' => Hash::make(request()->app_password),
                    'timezone' => $geolocation->timezone,
                    'country' => $geolocation->country,
                    'remember_token' => '',
                ]);

                $usersetting = new usersettings();
                $usersetting->users_id = $user->id;
                $usersetting->save();

                $user->assignRole('superadmin');
                if ($request->envato_purchasecode) {
                    $data['envato_purchasecode'] = $request->envato_purchasecode;
                    $this->updateSettings($data);
                }
                request()->session()->put('emails', request()->app_email);
                request()->session()->put('password', request()->app_password);

                return redirect()->route('SprukoAppInstaller::final')->with('success', 'Application Installed Succesfully');
            }
        }
    }

    public function index(InstallFileCreate $fileManager, FinalManager $finalInstall)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();

        return view('installer.final');

    }

    /**
     *  Settings Save/Update.
     *
     * @return \Illuminate\Http\Response
     */
    private function updateSettings($data)
    {

        foreach ($data as $key => $val) {
            $setting = Setting::where('key', $key);
            if ($setting->exists())
                $setting->first()->update(['value' => $val]);
        }

    }
}
