// script.js

// 1. Data (Database Lokal)
let items = [
    { id: 1, nim: "672023001", nama: "Budi", email: "672023001@student.uksw.edu" },
    { id: 2, nim: "672023002", nama: "Sinta", email: "672023002@student.uksw.edu" },
    { id: 3, nim: "672023003", nama: "Joko", email: "672023003@student.uksw.edu" }
];

let isAscending = true; 

// 2. DOM Selections
const daftarItemsUL = document.getElementById('daftarItems');
const nimInputField = document.getElementById('nimInput');
const namaInputField = document.getElementById('namaInput');
const emailInputField = document.getElementById('emailInput');
const cariInputField = document.getElementById('cariInput');
const tombolSortir = document.getElementById('tombolSortir');
const tombolTambah = document.getElementById('tombolTambah'); // Ambil tombol
const editItemIdField = document.getElementById('editItemId'); // Ambil hidden field

// --- FUNGSI UTAMA: MENGELOLA SUBMISI FORM (CREATE atau UPDATE) ---
function handleFormSubmission() {
    const editId = editItemIdField.value;

    if (editId) {
        // Jika editItemIdField terisi, jalankan UPDATE
        updateItem(parseInt(editId));
    } else {
        // Jika editItemIdField kosong, jalankan CREATE
        createItem();
    }
}


// --- FUNGSI C (CREATE) ---
function createItem() {
    const nimBaru = nimInputField.value.trim();
    const namaBaru = namaInputField.value.trim();
    const emailBaru = emailInputField.value.trim();

    if (nimBaru === "" || namaBaru === "" || emailBaru === "") {
        alert("NIM, Nama, dan Email tidak boleh kosong!");
        return;
    }

    // Validasi Duplikat NIM
    const isDuplicate = items.some(item => item.nim === nimBaru);
    if (isDuplicate) {
        alert(`NIM "${nimBaru}" sudah terdaftar!`);
        return;
    }

    const newId = items.length > 0 ? Math.max(...items.map(item => item.id)) + 1 : 1;
    
    items.push({ id: newId, nim: nimBaru, nama: namaBaru, email: emailBaru });
    
    // Reset form
    resetForm();
    alert(`Mahasiswa ${namaBaru} berhasil ditambahkan.`);
    tampilkanItems();
}


// --- FUNGSI U (UPDATE) ---
function updateItem(itemId) {
    const item = items.find(i => i.id === itemId);
    const nimBaru = nimInputField.value.trim();
    const namaBaru = namaInputField.value.trim();
    const emailBaru = emailInputField.value.trim();

    if (!item) return;

    // Validasi Duplikat NIM saat Edit (kecuali NIM-nya sendiri)
    const isNIMDuplicate = items.some(i => i.nim === nimBaru && i.id !== itemId);
    if (isNIMDuplicate) {
        alert(`Gagal Edit: NIM "${nimBaru}" sudah terdaftar pada mahasiswa lain!`);
        return;
    }

    // Lakukan pembaruan
    item.nim = nimBaru;
    item.nama = namaBaru;
    item.email = emailBaru;
    
    // Reset form ke mode 'Tambah'
    resetForm();
    alert(`Data mahasiswa ${item.nama} berhasil diperbarui!`);
    tampilkanItems();
}


// --- FUNGSI BARU: MEMUAT DATA KE FORM UNTUK EDIT ---
function setItemForEdit(itemId) {
    const item = items.find(i => i.id === itemId);

    if (item) {
        // 1. Isi input field dengan data item
        nimInputField.value = item.nim;
        namaInputField.value = item.nama;
        emailInputField.value = item.email;
        
        // 2. Simpan ID item yang sedang diedit
        editItemIdField.value = item.id;
        
        // 3. Ubah teks tombol menjadi 'Update'
        tombolTambah.textContent = 'Update';
        tombolTambah.style.backgroundColor = '#ff9800'; // Ubah warna
        
        // Scroll ke atas form
        window.scrollTo(0, 0); 

        console.log(`Mode Edit: Data ID ${itemId} dimuat ke form.`);
    }
}

// --- FUNGSI BARU: MERESET FORM SETELAH CREATE/UPDATE ---
function resetForm() {
    nimInputField.value = '';
    namaInputField.value = '';
    emailInputField.value = '';
    editItemIdField.value = ''; // Hapus ID item yang diedit

    tombolTambah.textContent = 'Tambah'; // Kembalikan teks tombol
    tombolTambah.style.backgroundColor = '#1565c0'; // Kembalikan warna
}


// --- FUNGSI D (DELETE) tetap sama ---
function hapusItem(itemId) {
    const item = items.find(i => i.id === itemId);
    const konfirmasi = confirm(`Yakin ingin menghapus data ${item.nama} (${item.nim})?`);
    
    if (konfirmasi) {
        items = items.filter(item => item.id !== itemId);
        
        // Pastikan keluar dari mode edit jika item yang sedang diedit dihapus
        if (editItemIdField.value == itemId) {
            resetForm();
        }
        
        tampilkanItems();
    }
}


// --- FUNGSI SORTING, FILTERING, dan READ diperbarui pada bagian tombol Edit ---
function sortirItem() {
    items.sort((a, b) => {
        const namaA = a.nama.toUpperCase();
        const namaB = b.nama.toUpperCase();
        
        if (namaA < namaB) return isAscending ? -1 : 1;
        if (namaA > namaB) return isAscending ? 1 : -1;
        return 0;
    });

    isAscending = !isAscending;
    tombolSortir.textContent = isAscending ? 'Sortir Nama A-Z' : 'Sortir Nama Z-A';

    tampilkanItems(); 
}

function cariItem() {
    const kataKunci = cariInputField.value.toLowerCase().trim();
    
    const filteredItems = items.filter(item => {
        return item.nim.includes(kataKunci) ||
               item.nama.toLowerCase().includes(kataKunci) ||
               item.email.toLowerCase().includes(kataKunci);
    });
    
    tampilkanItems(filteredItems);
}

function tampilkanItems(arrayToDisplay = items) {
    daftarItemsUL.innerHTML = ''; 
    
    if (arrayToDisplay.length === 0) {
        daftarItemsUL.innerHTML = '<li class="list-item" style="grid-template-columns: 1fr;"><span>Tidak ada data ditemukan.</span></li>';
        return;
    }

    arrayToDisplay.forEach(item => {
        const li = document.createElement('li');
        li.className = 'list-item';
        
        li.innerHTML = `
            <span>${item.nim}</span>
            <span>${item.nama}</span>
            <span>${item.email}</span>
            <div>
                <button class="action-btn edit-btn" onclick="setItemForEdit(${item.id})">Edit</button>
                <button class="action-btn delete-btn" onclick="hapusItem(${item.id})">Hapus</button>
            </div>
        `;
        
        daftarItemsUL.appendChild(li);
    });
}

// 5. Inisialisasi
tampilkanItems();