//carousel banner, preview foto, dan interaksi antarmuka sederhana

// app.js bisa menangani:
// - Banner edukasi, testimoni, dan deskripsi yang bergantian.
// - Preview foto sebelum penjual mengunggahnya.
// - Tombol untuk melihat foto produk lainnya.
// - Interaksi menu pada layar ponsel.
// - Validasi sederhana pada antarmuka.
// Carousel banner, preview foto, dan interaksi antarmuka sederhana
//
// app.js menangani:
// - Banner edukasi, testimoni, dan deskripsi yang bergantian.
// - Preview foto sebelum penjual mengunggahnya.
// - Tombol untuk melihat foto produk lainnya.
// - Interaksi menu pada layar ponsel.
// - Validasi sederhana pada antarmuka.

// ---------- Banner bergantian (homepage) ----------
document.querySelectorAll('[data-hero]').forEach((hero) => {
  const slides = hero.querySelectorAll('.aw-hero__slide');
  const dotsBox = hero.querySelector('.aw-hero__dots');
  if (slides.length < 2 || !dotsBox) return;

  let current = 0;
  let timer;

  const go = (i) => {
    current = (i + slides.length) % slides.length;
    slides.forEach((s, k) => s.classList.toggle('is-active', k === current));
    dots.forEach((d, k) => d.classList.toggle('is-active', k === current));
  };
  const restart = () => {
    clearInterval(timer);
    timer = setInterval(() => go(current + 1), 5000);
  };

  const dots = [...slides].map((_, i) => {
    const b = document.createElement('button');
    b.type = 'button';
    b.setAttribute('aria-label', `Slide ${i + 1}`);
    b.addEventListener('click', () => { go(i); restart(); });
    dotsBox.appendChild(b);
    return b;
  });

  go(0);
  restart();
  hero.addEventListener('mouseenter', () => clearInterval(timer));
  hero.addEventListener('mouseleave', restart);
});

// Galeri foto/video di halaman detail produk
document.querySelectorAll('[data-gallery]').forEach((box) => {
  const main = box.querySelector('[data-gallery-main]');
  const thumbs = box.querySelectorAll('.aw-thumb');
  if (!main || !thumbs.length) return;

  thumbs.forEach((t) => {
    t.addEventListener('click', () => {
      thumbs.forEach((x) => x.classList.toggle('is-active', x === t));
      main.innerHTML = '';
      const isVideo = t.dataset.type === 'video';
      const el = document.createElement(isVideo ? 'video' : 'img');
      el.src = t.dataset.src;
      if (isVideo) { el.controls = true; } else { el.alt = t.dataset.alt || ''; }
      main.appendChild(el);
    });
  });
});