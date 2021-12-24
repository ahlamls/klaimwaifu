<?php 
use Carbon\Carbon;
use App\Models\Waifu;
if (!function_exists("wib")) {
    function wib($time ) {
        $korban = new Carbon($time);
        $korban = $korban->addHour(7);
        $enggress = $korban->format('l j \ F Y H:i:s ');
        $replaces = [
            ["Monday","Senin"],
            ["Tuesday","Selasa"],
            ["Wednesday","Rabu"],
            ["Thursday","Kamis"],
            ["Friday","Jumat"],
            ["Saturday","Sabtu"],
            ["Sunday","Minggu"],

            ["January","Januari"],
            ["February","Februari"],
            ["March","Maret"],
            ["April","April"],
            ["May","Mei"],
            ["June","Juni"],
            ["July","Juli"],
            ["September","September"],
            ["October","Oktober"],
            ["November","Nopember"],
            ["December","Desember"],
        ];

        foreach ($replaces as $replace) {
            $enggress = str_replace($replace[0],$replace[1],$enggress);
        }
        return $enggress;
    }
}

if (!function_exists("waifuimg")) {
    function waifuimg($name,$source ) {
        try {
            $search_keyword = "$name ($source)";
            $search_keyword=str_replace(' ','+',$search_keyword);
            $newhtml = file_get_html("https://www.google.com/search?q=".$search_keyword."&tbm=isch");
            $result_image_source = $newhtml->find('img', 1)->src;
            return $result_image_source ?? '';
        } catch (\Throwable $e) {
            return "";
        }
    }
}

function googleimagewaifu() {
    //laravel jobs gak work queue work malah stuck. helper jadiin jobs
    $waifus = Waifu::get();
    foreach ($waifus as $waifu) {
   
    if ($waifu->gambar == null OR $waifu->gambar == "") {
        fwrite(STDOUT, $waifu->nama . "(" . $waifu->sumber.")". "\n");
        $waifu->gambar = waifuimg($waifu->nama,$waifu->sumber);
        $waifu->save();
    
    }
    }
}

?>