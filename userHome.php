<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Western Restaurant — Landing</title>

  <!-- Hubungkan CSS -->
  <link rel="stylesheet" href="coret.css" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
</head>

<body>

  <!-- NAV -->
        <nav class="nav">
        <div class="brand">Westo</div>
        <div class="menu-links">
            <a href="#menu">Menu</a>
            <a href="#orders">Orders</a>
            <a href="#testi">Testi</a>
        </div>
        <div class="right-action">
            <button class="btn-book">Booking Delivery</button>
            <img src="gambar_makanan/cart.png" class="cart-icon" href="#">
            <img src="gambar_makanan/profil.png" class="profil-icon" href="#">
            
        </div>
        </nav>

  <!-- HERO -->
  <header class="hero" id="top">
    <div class="hero-left">
      <div class="pretitle">All Delicious</div>
      <h1>Western <strong>Restaurant</strong></h1>
      <p class="lead">Quality you can taste. Service you can trust.</p>
      <button class="btn-find">Find for more</button>
    </div>

    <div class="hero-right">
      <div class="hero-card">
        <!-- Ganti gambar sesuai kebutuhan -->
        <img src="gambar_makanan/pizza2.jpg" alt="Pizza" />
      </div>
    </div>
  </header>

  <!-- SECTION SALAD -->
  <section class="section alt">
    <div class="media">
      <img src="gambar_makanan/spageti.jpg" alt="Spageti">
    </div>
    <div class="content">
      <h2>Our <span class="accent">Western</span> Restaurant Expert Chef</h2>
      <p>
        Food consisting essentially of protein, carbohydrate, fat, and other nutrients...
      </p>
      <a class="find-more" href="#">Find More</a>
    </div>
  </section>

  <!-- SECTION CHEF -->
  <section class="chef">
    <div class="content">
      <h2>Our <span class="accent">Western</span> Restaurant Expert Chef</h2>
      <p>
        Food consisting essentially of protein, carbohydrate, fat, and other nutrients...
      </p>
    </div>

    <div class="chef-photo">
      <img src="gambar_makanan/chef.jpg" alt="Chef">
    </div>
  </section>

  <!-- TESTIMONIALS -->
  <section class="testi-wrap" id="testi">
    <h3>Our Western Restaurant<br>Happy Customers</h3>
    <p class="testi-desc">
      A customer is a person or business that buys goods or services...
    </p>

    <div class="testi-grid">

      <div class="testi">
        <div class="avatar"><img src="gambar_makanan/chef.jpg" /></div>
        <div class="space"></div>
        <p>A customer is a person or business that buys goods…</p>
        <b>Abdullah Iqbal</b>
      </div>

      <div class="testi">
        <div class="avatar"><img src="gambar_makanan/chef.jpg" /></div>
        <div class="space"></div>
        <p>A customer is a person or business that buys goods…</p>
        <b>Henry John</b>
      </div>

    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    <div class="footer-wrap">
      <div class="footer-col">
        <h4>Western Restaurant</h4>
        <p>Managing restaurant menus and other information including location…</p>
      </div>
      
      <div class="cols">
        <div>
          <h4>Navigation</h4>
          <p>Menu<br>Products<br>About Us</p>
        </div>

        <div>
          <h4>Genres</h4>
          <p>Salad<br>Spicy<br>Bowl</p>
        </div>
      </div>
    </div>
  </footer>

  <!-- Smooth Scroll -->
  <script>
    document.querySelectorAll('a[href^=\"#\"]').forEach(a=>{
      a.addEventListener('click',e=>{
        e.preventDefault();
        const t=document.querySelector(a.getAttribute('href'));
        if(t) t.scrollIntoView({behavior:'smooth'});
      })
    })

    const navbar = document.querySelector('.nav');
    let lastScrollY = window.scrollY; // Simpan posisi guliran terakhir

    window.addEventListener('scroll', () => {
        // Jika posisi guliran saat ini (window.scrollY) lebih besar dari posisi guliran terakhir (lastScrollY), 
        // artinya pengguna sedang menggulir ke BAWAH.
        if (window.scrollY > lastScrollY) {
            navbar.classList.add('hidden'); // Sembunyikan navbar
        } 
        // Jika posisi guliran saat ini lebih kecil, atau jika guliran kembali ke atas,
        // artinya pengguna sedang menggulir ke ATAS.
        else {
            navbar.classList.remove('hidden'); // Tampilkan navbar
        }

        // Perbarui posisi guliran terakhir untuk perbandingan di iterasi berikutnya
        lastScrollY = window.scrollY;
    });
  </script>

</body>
</html>
