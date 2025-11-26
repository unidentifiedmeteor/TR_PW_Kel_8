// Data Awal
let items = [
  { id: 1, nama: "Laptop", stok: 15 },
  { id: 2, nama: "Monitor 24 Inci", stok: 25 },
  { id: 3, nama: "Keyboard Mekanik", stok: 50 }
];

// Elemen DOM
const daftarItemsUL = document.getElementById('daftarBarang');
const namaBarangInput = document.getElementById('namaBarang');
const stokBarangInput = document.getElementById('stokBarang');
const totalStokText = document.getElementById('totalStok');

// Tampilkan daftar barang
function tampilkanItems() {
  daftarItemsUL.innerHTML = '';

  items.forEach((item, index) => {
    const li = document.createElement('li');
    li.className = 'list-item';
    li.innerHTML = `
      <span class="item-nama">${item.nama}</span>
      <div class="item-stok">
        <button class="stok-btn" onclick="ubahStok(${index}, -1)">−</button>
        <span>${item.stok}</span>
        <button class="stok-btn" onclick="ubahStok(${index}, 1)">+</button>
      </div>
      <button class="delete-btn" onclick="hapusItem(${index})">Hapus</button>
    `;
    daftarItemsUL.appendChild(li);
  });

  hitungTotalStok();
}

// Tambah barang baru
function tambahItem() {
  const nama = namaBarangInput.value.trim();
  const stok = parseInt(stokBarangInput.value);

  if (nama === '' || isNaN(stok) || stok < 0) {
    alert('Masukkan nama barang dan stok yang valid!');
    return;
  }

  const isDuplicate = items.some(i => i.nama.toLowerCase() === nama.toLowerCase());
  if (isDuplicate) {
    alert(`Barang "${nama}" sudah ada di daftar!`);
    return;
  }

  const newId = items.length > 0 ? Math.max(...items.map(i => i.id)) + 1 : 1;
  items.push({ id: newId, nama: nama, stok: stok });

  namaBarangInput.value = '';
  stokBarangInput.value = '';
  tampilkanItems();
}

// Ubah stok (tambah/kurang)
function ubahStok(index, perubahan) {
  items[index].stok += perubahan;
  if (items[index].stok < 0) items[index].stok = 0;
  tampilkanItems();
}

// Hapus barang
function hapusItem(index) {
  const nama = items[index].nama;
  if (confirm(`Yakin ingin menghapus "${nama}"?`)) {
    items.splice(index, 1);
    tampilkanItems();
  }
}

// Hitung total stok
function hitungTotalStok() {
  const total = items.reduce((sum, item) => sum + item.stok, 0);
  totalStokText.textContent = `Total Stok: ${total} unit`;
}

// Inisialisasi
tampilkanItems();
