@include('header')

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
  
    @if (!session('sudahklaim', false) )
    <form action="/klaim" method="POST">
        @csrf
        <div class="row">
            <div class="form-group col-12 col-md-3">
                <label for="staticEmail" class="form-label">Nama Karakter</label>
                <input maxlength="64" type="text" placeholder="Lumine" class="form-control" name="nama" id="namaKarakter">

            </div>


            <div class="form-group col-12 col-md-4">
                <label for="staticEmail" class="form-label">Anime/Game Karakter</label>
                <input maxlength="64" name="sumber" type="text" placeholder="Genshin Impact" class="form-control" id="sumberKarakter">

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
    <hr>
    <h2>Top Global Waifu : All Time</h2>
    <!-- 
        Kalian Developer ingin parsing data dari sini
        silahkan gunakan api nya. udah format json . datanya sama persis kaya dibawah
        https://himputek.id/api/waifu
     
        kalau gak bisa berarti udah saya matiin karena bikin overload server mungkin ?
    -->
    <div class="p-3">
    <div class="row p-3 d-none d-sm-block">
        <div class="col-12 card text-white bg-dark mb-3" >
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <h4 class="card-title">Karakter</h4>
                    </div>
                    <div class="col-12 col-md-4">
                        <h4 class="card-title">Jumlah Klaim</h4>
                    </div>
                    <div class="col-12 col-md-4">
                        <h4 class="card-title">Terakhir diklaim</h4>
                    </div>
                </div>

           
            </div>
        </div>

    </div>

   
    <div class="row" >
        @foreach ($waifulist as $waifu)
        <div class="col-12 card text-black bg-light mb-3" >
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <p class="card-title"><b>{{$waifu->nama ?? "N/A"}}</b> ({{$waifu->sumber ?? "N/A"}})</p>
                    </div>
                    <div class="col-12 col-md-4">
                        <h5 class="card-title"><span class="d-block d-sm-none"><b>Jumlah Klaim:</b></span>{{number_format($waifu->jumlah ?? 0)}}</h5>
                    </div>
                    <div class="col-12 col-md-4">
                        <h5 class="card-title"><span class="d-block d-sm-none"><b>Terakhir Diklaim:</b></span> {{$waifu->updated_at ?? "Tidak Pernah"}}</h5>
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


@include('footer')