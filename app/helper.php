<?php 
use Carbon\Carbon;
use App\Models\Waifu;
use App\Models\KataTerlarang;
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

function filterkatakasar() {
      //filteredString 
      $waifus = Waifu::get();
      foreach ($waifus as $waifu) {
          $string = $waifu->nama . " " . $waifu->sumber;
      $filteredString = " " .strtolower($string) . " ";
      $filteredString = str_replace("1","i",$filteredString);
      $filteredString = str_replace("0","o",$filteredString);

      $kataterlarangs = KataTerlarang::get();
      foreach ($kataterlarangs as $kataterlarang) {
          if (strpos($filteredString, strtolower($kataterlarang->kata)) !== false) {
            fwrite(STDOUT, $waifu->nama . "(" . $waifu->sumber.")". "\n"); 
            $waifu->delete();
          }
      }
    }
}

if (!function_exists("ip_info")) {

    function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), "", strtolower(trim($purpose)));
        $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city"           => @$ipdat->geoplugin_city,
                            "state"          => @$ipdat->geoplugin_regionName,
                            "country"        => @$ipdat->geoplugin_countryName,
                            "country_code"   => @$ipdat->geoplugin_countryCode,
                            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }
        return $output;
    }
    
    }
    
?>
