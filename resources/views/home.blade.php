@include('header')
<?php 
$es = "";
?>
<nav class="navbar navbar-dark bg-black">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="navlogo.png" alt="" height="24" class="d-inline-block align-text-top">
            Klaim Waifu
        </a>
    </div>
</nav>
<!-- istri_revisi_fix_uw.png -->
<div class="container">
    <div class="jumbotron cover-start h-400">
        <div class="jumbotron-cover">
            <div class="jumbotron-text f-left">
                <h1>Klaim Waifumu sekarang juga!</h1>
                <p>Situs ini dibuat sebagai social experiment untuk mengetahui waifu (dan husbando) yang paling banyak di klaim</p>
                <a href="https://fb.com/groups/himputek"> <button class="btn btn-primary">Join ke grup Himputek di Facebook</button></a>
                <a href="https://t.me/himputek"> <button class="btn btn-info">Join ke grup chat Himputek di Telegram</button></a>

            </div>
        </div>
    </div>
    <hr>
    <h2>Klaim Waifu/Husbando</h2>

    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
    <ul> 
    @foreach ($errors->all() as $error)
         <li>{{($error == "validation.captcha" ? "Jawaban Soal Captcha salah. silahkan coba lagi" : $error)}}</li>
     @endforeach
</ul>
</div>

 @endif
  @if ($nusantara)
    @if (!session('sudahklaim', false) )
    <form action="/klaim" method="POST">
        @csrf
        <div class="row">
            <div class="form-group col-12 col-md-3">
                <label for="staticEmail" class="form-label">Nama Karakter</label>
                <input maxlength="64" type="text" placeholder="{{$randomWaifu->nama ?? ''}}" class="form-control" name="nama" id="namaKarakter">

            </div>


            <div class="form-group col-12 col-md-4">
                <label for="staticEmail" class="form-label">Anime/Game Karakter</label>
                <input maxlength="64" name="sumber"  type="text" placeholder="{{$randomWaifu->sumber ?? ''}}" class="form-control" id="sumberKarakter">

            </div>

            <div class="form-group col-12 col-md-3">
                <label for="staticEmail"  class="form-label">Soal  {!!captcha_img();!!}</label>
            
                <input type="text" name="captcha" placeholder="Masukan Jawaban Diatas" class="form-control" id="captcha">

            </div>
            <div class="form-group col-12 col-md-2">
                <hr class="d-block d-sm-none">
                <br class="d-none d-sm-block">
                <button class="btn btn-lg btn-success w-100">Klaim</button>
            </div>

        </div>
    </form>
    <p class="text-muted">Kamu hanya bisa mengklaim waifu 1 kali saja. Klaimlah waifu yang paling wangy wangy</p>
    @else
    <div class="alert alert-info" role="alert">
  Kamu sudah melakukan klaim waifu. 1 orang hanya diberi 1 kesempatan klaim waifu
@if($pekalongan) 
<br>
<b>Kami mendeteksi adanya upaya kecurangan klaim waifu. Pekalongan lu!</b>
@endif
</div>
    @endif
    @else 
    <div class="alert alert-warning" role="alert">
  Mohon maaf untuk sementara Klaim waifu hanya tersedia di indonesia. Dari indonesia? PEKALONGAN LO GAK USAH PAKE VPN! 
</div>
    @endif

    <hr>
   <ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active " id="topglobalnav" onclick="topglobal()">Top Global</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-white" id="latestnav" onclick="latest()">Terakhir diklaim</a>
  </li>

</ul>

    <div class="p-3" id="topglobal">
    <!-- 
        Kalian Developer ingin parsing data dari sini
        silahkan gunakan api nya. udah format json . datanya sama persis kaya dibawah
        https://himputek.id/api/waifu
     
        kalau gak bisa berarti udah saya matiin karena bikin overload server mungkin ?
    -->
    <div class="row" >
        @foreach ($waifulist as $waifu)
        <div class="col-12 card text-white bg-black mb-3 p-0 karakterimg" style='background: url(" {{$waifu->gambar ?? $es }} ") ' >
            <div class="card-body karakterimgu" >
                <div class="row">
                    <div class="col-12 col-md-4">
                        <p class="card-title"><b>{{$waifu->nama ?? "N/A"}}</b><br> ({{$waifu->sumber ?? "N/A"}})</p>
                    </div>
                    <div class="col-12 col-md-4">
                        <h5 class="card-title"><span class="d-none d-sm-block">Jumlah Klaim:</span> <span class=" "><i class="   far fa-check-circle"></i> <b class=" d-sm-none">Jumlah Klaim: </b>{{number_format($waifu->jumlah ?? 0)}}</span></h5>
                    </div>
                    <div class="col-12 col-md-4">
                        <h5 class="card-title"><span class="d-none d-sm-block">Terakhir Diklaim:</span> <span class=""><i class="  far fa-clock"></i>  {{wib($waifu->updated_at) ?? "Tidak Pernah"}} WIB</span></h5>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    </div>


    <div class="p-3" id="latest" style="display:none">
    <!-- 
        Kalian Developer ingin parsing data dari sini
        silahkan gunakan api nya. udah format json . datanya sama persis kaya dibawah
        https://himputek.id/api/waifu
     
        kalau gak bisa berarti udah saya matiin karena bikin overload server mungkin ?
    -->
    <div class="row" >
        @foreach ($waifulistlatest as $waifu)
        <div class="col-12 card text-white bg-black mb-3 p-0 karakterimg" style='background: url(" {{$waifu->gambar ?? $es }} ") ' >
            <div class="card-body karakterimgu" >
                <div class="row">
                    <div class="col-12 col-md-4">
                        <p class="card-title"><b>{{$waifu->nama ?? "N/A"}}</b><br> ({{$waifu->sumber ?? "N/A"}})</p>
                    </div>
                    <div class="col-12 col-md-4">
                        <h5 class="card-title"><span class="d-none d-sm-block">Jumlah Klaim:</span> <span class=" "><i class="   far fa-check-circle"></i> <b class=" d-sm-none">Jumlah Klaim: </b>{{number_format($waifu->jumlah ?? 0)}}</span></h5>
                    </div>
                    <div class="col-12 col-md-4">
                        <h5 class="card-title"><span class="d-none d-sm-block">Terakhir Diklaim:</span> <span class=""><i class="  far fa-clock"></i>  {{wib($waifu->updated_at) ?? "Tidak Pernah"}} WIB</span></h5>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    </div>

   

    Copyright {{date("Y")}} himputek.id
    <br>
</div>
<br>

<script>
    function topglobal() {
        $("#topglobalnav").addClass("active");
        $("#topglobalnav").removeClass("text-white");
        $("#latestnav").removeClass("active");
        $("#latestnav").addClass("text-white");
        $("#latest").hide();
        $("#topglobal").show();
        
        
    }
    function latest() {
        $("#topglobalnav").removeClass("active");
        $("#topglobalnav").addClass("text-white");
        $("#latestnav").addClass("active");
        $("#latestnav").removeClass("text-white");
        $("#topglobal").hide();
        $("#latest").show();
        
    }

    $( document ).ready(function() {
   @if (session("fromKlaim",false))
   latest();     
   @endif
});
    </script>

@include('footer')