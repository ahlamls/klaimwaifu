<?php

namespace App\Http\Controllers;
use App\Models\Waifu;
use App\Models\Sadap;
use Illuminate\Http\Request;

class KlaimController extends Controller
{
    public function home() {
       //double klaim protection
       $uip = $this->get_client_ip();
       $uua =  $_SERVER['HTTP_USER_AGENT'];
       $pekalongan = false;
        $waifu = Waifu::orderBy('jumlah', 'desc')->take(50)->get();
        
        if (!session('sadap', false)) {
            $cekSadap = Sadap::where(["ip"=> $uip , "ua" => $uua])->where("waifu_id","!=",null)->first();
          
            if ($cekSadap) {
             session(['sudahklaim' => 'true']);
             $pekalongan = true;
            } else {
            
                try {
                    $sadap = Sadap::create([
                    'ip' => $uip,
                    'ua' => $uua,
                ]);
                session(['sadap' => 'true']);
                session(['sadap_id' => $sadap->id]);
                } catch (\Throwable $e) {

                }
            }
        } 
       
        return view('home',[
            "waifulist" => $waifu,
            "pekalongan" => $pekalongan,
        ]);
    }
    public function getWaifu() {
        $waifu = Waifu::orderBy('jumlah', 'desc')->take(50)->get();
        return response()->json($waifu);
    }

    public function klaim(Request $request) {
        if (session('sudahklaim', false)) {
            die("Hanya boleh klaim sekali");
        } 
        $this->validate($request, [
            'nama' => 'required|string|regex:/^[a-zA-Z0-9\s]+$/',
            'sumber' => 'required|string|regex:/^[a-zA-Z0-9\s]+$/',
            'captcha' => 'required|captcha',
            ]);
       
        $nama = $this->filterString($request->nama);
        $sumber = $this->filterString($request->sumber);
        $cekWaifu = Waifu::where(["nama" => $nama , "sumber" => $sumber])->first();
        $waifu_id = 0;
        if ($cekWaifu) {
            $cekWaifu->jumlah = $cekWaifu->jumlah + 1;
            $waifu_id = $cekWaifu->id;
            $cekWaifu->save();
        } else {
            $waifu = Waifu::create([
                'nama' => $nama,
                'sumber' => $sumber,
                'jumlah' => 1,
                
            ]);
            $waifu_id = $waifu->id;
        }

        $sadap_id = session('sadap_id', false);
        if ($sadap_id) {
            $sadap = Sadap::where("id",$sadap_id)->first();
            if ($sadap) {
                $sadap->waifu_id = $waifu->id ;
                $sadap->save();
            }
        }
       
        session(['sudahklaim' => 'true']);
        return redirect("/");
    }

    public function filterString($string) {
        $hekel = false;
        if ($string == "'") {
            $hekel = true;
        } elseif (strpos($string, "<script>") !== false) {
            $hekel = true;
        } 

        if ($hekel) {
            die("Mau ngehek ya dek?");
        }

        return substr(strip_tags($string),0,64);
        
    }
    public function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}
