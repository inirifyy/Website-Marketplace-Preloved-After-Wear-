@extends('layouts.app')
@section('title', 'Mengapa Membeli Pakaian Preloved — After Wear')
@section('content')
<div class="wrap" style="padding-top:20px">
  <a class="small mute" href="{{ url('/education') }}">← Kembali ke Edukasi</a>
  <article class="art">
    <h1>Mengapa Membeli Pakaian Preloved Adalah Langkah Nyata Menyelamatkan Bumi</h1>
    <div class="meta"><span>Tim Riset After Wear</span><span>18 Oktober 2024</span><span>5 Menit Baca</span><span>Dampak: 2.700L Air Terhemat</span></div>
    <div class="cover"><img src="{{ asset('images/education-cover.png') }}" alt="Kain vintage tertata rapi di meja kayu"></div>

    <div class="stats">
      <div class="card"><span class="small mute">Konservasi Air</span><h3>2.700 Liter</h3><span class="small mute">Tiap 1 kaos preloved yang diadopsi</span></div>
      <div class="card"><span class="small mute">Reduksi Emisi</span><h3>-82% Karbon</h3><span class="small mute">Dibanding produksi ritel cepat baru</span></div>
      <div class="card"><span class="small mute">Dukungan Lokal</span><h3>100% UMKM</h3><span class="small mute">Memperkuat kurator thrift mandiri</span></div>
    </div>

    <p>Di tengah gempuran tren mikro yang berganti setiap pekan, lemari pakaian modern kita tanpa disadari menjadi tempat singgah bagi garmen yang usianya kian pendek. Industri mode konvensional kini memproduksi lebih dari seratus miliar pakaian setiap tahun, dan sebagian besar berakhir di tempat pembuangan atau insinerator hanya beberapa bulan setelah dibeli.</p>
    <p>Kenyataan ini mendorong pergeseran paradigma: fesyen sirkular bukan lagi sekadar gaya hidup pencinta barang antik, melainkan strategi terukur untuk menekan krisis iklim. Memilih pakaian preloved berkualitas berarti memperpanjang umur material yang sudah ada.</p>

    <h2>Krisis Tersembunyi di Balik Lemari Pakaian Kita</h2>
    <p>Menurut data konsorsium lingkungan global, sektor tekstil menyumbang sekitar 10 persen emisi gas rumah kaca dunia, melampaui gabungan penerbangan komersial dan pelayaran. Masalah ini diperparah serat sintetis berbahan poliester yang butuh ratusan tahun untuk terurai.</p>
    <p>Di Indonesia, puluhan ton limbah tekstil pascakonsumen mencemari sungai dan pesisir setiap hari. Pakaian yang dibuang terlalu cepat melepaskan mikroplastik ke rantai makanan laut dan gas metana saat terkubur di tempat pemrosesan akhir terbuka.</p>

    <h2>Menghitung Jejak Karbon dari Produksi Sehelai Katun</h2>
    <p>Satu kaus katun biasa membutuhkan rata-rata 2.700 liter air bersih, setara kebutuhan minum seorang dewasa selama 900 hari. Saat kita membeli garmen preloved yang masih prima, kebutuhan air produksi baru itu hilang sepenuhnya: tidak ada pestisida baru, tidak ada pewarna sintetis yang dibuang ke saluran air, dan tidak ada bahan bakar fosil tambahan.</p>
    <blockquote>“Membeli barang preloved bukan sekadar penghematan biaya, melainkan deklarasi kesadaran terhadap masa depan lingkungan kita.”<div class="small mute" style="font:12px 'Plus Jakarta Sans';margin-top:8px">Manifesto Fashion Berkelanjutan After Wear 2024</div></blockquote>

    <h2>Solusi Sirkular UMKM Indonesia</h2>
    <p>Ekosistem preloved di Indonesia adalah urat nadi ekonomi sirkular yang digerakkan ratusan ribu pedagang UMKM. Para kurator memilah dengan cermat, memperbaiki jahitan, membersihkan menyeluruh, hingga menata gayanya. Melalui After Wear, kondisi setiap produk dinilai dari ketahanan kain, keutuhan jahitan, dan keaslian merek, sehingga pembeli mendapat kepastian nilai.</p>

    <div class="steps">
      <h3 style="font-size:22px;margin-bottom:12px">Panduan Merawat Pakaian agar Bertahan Dekade Berikutnya</h3>
      <ol>
        <li><b>Cuci menggunakan air dingin.</b> Air panas merusak elastisitas serat dan melepas lebih banyak mikroplastik.</li>
        <li><b>Hindari pengering berpanas tinggi.</b> Jemur di tempat teduh berangin agar benang katun dan wol tidak melemah.</li>
        <li><b>Gunakan gantungan kayu atau busa tebal.</b> Gantungan kawat tipis meregangkan bahu kemeja dan jaket secara permanen.</li>
        <li><b>Pelajari visible mending.</b> Robekan kecil atau kancing lepas bukan alasan membuang pakaian.</li>
      </ol>
    </div>
    <p style="margin-top:24px">Menyelamatkan bumi tidak selalu butuh tindakan megah. Langkahnya bisa dimulai dari keputusan sederhana saat membuka ponsel: memilih pakaian yang sudah punya cerita, merawatnya dengan baik, dan membiarkannya terus berputar.</p>
    <p class="small mute">#SlowFashion #FashionSirkular #UMKMThrift #JejakKarbon</p>

    <div class="card" style="display:flex;gap:16px;align-items:center;margin-top:32px">
      <div><b>Tim Kurasi &amp; Keberlanjutan After Wear</b><p class="small mute">Kami mengkaji siklus hidup tekstil lokal, mendukung pedagang thrift vintage di seluruh Indonesia, dan merumuskan standar kurasi yang transparan.</p></div>
    </div>
  </article>

  <section class="sec"><div style="display:flex;justify-content:space-between;align-items:baseline"><h2>Artikel Terkait</h2><a href="{{ url('/education') }}"><b>Lihat Semua Artikel Edukasi</b></a></div>
    <div class="grid g3">
      @foreach($related ?? [] as $a)
        <a class="pcard" href="{{ url('/education/'.$a->slug) }}"><div class="bd"><span class="small mute">{{ $a->category }} • {{ $a->read_minutes }} Menit</span><h3 style="font-size:20px;margin:6px 0">{{ $a->title }}</h3><p class="small mute">{{ $a->excerpt }}</p><b class="small">Baca Selengkapnya</b></div></a>
      @endforeach
    </div>
  </section>

  <div class="cta"><div><h2 style="font-size:30px">Dukung gerakan slow fashion bersama kami.</h2><p>Temukan ribuan pilihan pakaian preloved yang lolos uji keaslian, sanitasi higienis, dan kurasi teliti.</p></div>
    <div style="display:flex;gap:8px"><a class="btn" style="background:#fff;color:#000" href="{{ url('/products') }}">Jelajahi Katalog</a><a class="btn dark" href="{{ url('/seller/submissions/create') }}">Jual Pakaian Anda</a></div></div>
</div>
@endsection