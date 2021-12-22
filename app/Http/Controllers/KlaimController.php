<?php

namespace App\Http\Controllers;
use App\Models\Waifu;
use Illuminate\Http\Request;

class KlaimController extends Controller
{
    public function home() {
        $waifu = Waifu::orderBy('jumlah', 'desc')->take(50)->get();
        return view('home',[
            "waifulist" => $waifu,
        ]);
    }
    public function getWaifu() {
        $waifu = Waifu::orderBy('jumlah', 'desc')->take(50)->get();
        return response()->json($waifu);
    }

    public function klaim(Request $request) {
        $this->validate($request, [
            'nama' => 'required|string',
            'sumber' => 'required|string',
            'captcha' => 'required|captcha',
            ]);
       
        $nama = $this->filterString($request->nama);
        $sumber = $this->filterString($request->sumber);
        $cekWaifu = Waifu::where(["nama" => $nama , "sumber" => $sumber])->first();
        if ($cekWaifu) {
            $cekWaifu->jumlah = $cekWaifu->jumlah + 1;
            $cekWaifu->save();
        } else {
            $waifu = Waifu::create([
                'nama' => $nama,
                'sumber' => $sumber,
                'jumlah' => 1,
                
            ]);
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
}
