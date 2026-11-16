<section class="card admin-page" id="content-management" data-admin-page="content" @if ($adminPage !== 'content') hidden @endif>
    <p id="content-empty-state" class="content-empty-state" hidden>Belum ada konten website. Mulai dengan menambahkan berita, layanan, atau profil desa.</p>
    <div class="content-managers">
        <section class="content-manager" data-content-manager="news">
            <div class="section-top"><div><h2>Berita dan pengumuman <span class="content-count" data-content-count>0</span></h2><p class="muted">Kabar, agenda, dan informasi warga.</p></div><button class="btn" type="button" data-content-add>Tambah berita</button></div>
            <form hidden class="grid content-form">
                <input type="hidden" name="id">
                <div class="field"><label>Judul</label><input name="title" maxlength="180" required></div>
                <div class="field"><label>Kategori</label><input name="category" maxlength="80" placeholder="Berita, Pengumuman, Kegiatan"></div>
                <div class="field wide"><label>Ringkasan</label><input name="summary" maxlength="300"></div>
                <div class="field wide"><label>Isi</label><textarea name="body" maxlength="5000" required></textarea></div>
                <div class="field"><label>Tanggal publikasi</label><input name="publishedAt" type="date"></div>
                <div class="field"><label>Tautan sumber <span class="optional">(opsional)</span></label><input name="link" type="url" placeholder="https://"></div>
                <div class="field wide"><label>URL gambar dari media desa <span class="optional">(opsional)</span></label><input name="imageUrl" type="url" placeholder="Unggah gambar di bagian Media desa, lalu pilih Gunakan"></div>
                <div class="field"><label>Urutan</label><input name="sortOrder" type="number" min="0" max="9999" value="0"></div>
                <label class="check"><input name="published" type="checkbox" checked> Tampilkan di website</label>
                <div class="row wide"><button class="btn" type="submit">Simpan berita</button><button class="btn light" type="button" data-content-cancel>Batal</button><span class="notice" role="status"></span></div>
            </form>
            <div class="list" data-content-list hidden></div>
        </section>

        <section class="content-manager" data-content-manager="service">
            <div class="section-top"><div><h2>Layanan warga <span class="content-count" data-content-count>0</span></h2><p class="muted">Persyaratan, alur, jadwal, atau informasi layanan.</p></div><button class="btn" type="button" data-content-add>Tambah layanan</button></div>
            <form hidden class="grid content-form">
                <input type="hidden" name="id">
                <div class="field"><label>Nama layanan</label><input name="title" maxlength="180" required></div>
                <div class="field"><label>Urutan tampil</label><input name="sortOrder" type="number" min="0" max="9999" value="0"></div>
                <div class="field wide"><label>Ringkasan</label><input name="summary" maxlength="300"></div>
                <div class="field wide"><label>Persyaratan dan alur</label><textarea name="body" maxlength="5000" required></textarea></div>
                <div class="field wide"><label>Tautan informasi <span class="optional">(opsional)</span></label><input name="link" type="url" placeholder="https://"></div>
                <div class="field wide"><label>URL gambar dari media desa <span class="optional">(opsional)</span></label><input name="imageUrl" type="url" placeholder="Unggah gambar di bagian Media desa, lalu pilih Gunakan"></div>
                <label class="check"><input name="published" type="checkbox" checked> Tampilkan di website</label>
                <div class="row wide"><button class="btn" type="submit">Simpan layanan</button><button class="btn light" type="button" data-content-cancel>Batal</button><span class="notice" role="status"></span></div>
            </form>
            <div class="list" data-content-list hidden></div>
        </section>

        <section class="content-manager" data-content-manager="profile">
            <div class="section-top"><div><h2>Profil dan potensi desa <span class="content-count" data-content-count>0</span></h2><p class="muted">Ringkasan profil dan potensi yang ingin ditampilkan.</p></div><button class="btn" type="button" data-content-add>Tambah profil</button></div>
            <form hidden class="grid content-form">
                <input type="hidden" name="id">
                <div class="field wide"><label>Judul</label><input name="title" maxlength="180" required></div>
                <div class="field wide"><label>Ringkasan</label><input name="summary" maxlength="300"></div>
                <div class="field wide"><label>Gambaran desa dan potensi utama</label><textarea name="body" maxlength="5000" required></textarea></div>
                <div class="field wide"><label>Tautan pendukung <span class="optional">(opsional)</span></label><input name="link" type="url" placeholder="https://"></div>
                <div class="field wide"><label>URL gambar dari media desa <span class="optional">(opsional)</span></label><input name="imageUrl" type="url" placeholder="Unggah gambar di bagian Media desa, lalu pilih Gunakan"></div>
                <div class="field wide"><strong>Informasi pemerintahan</strong></div>
                <div class="field"><label>Nama kepala desa</label><input data-profile-field="headName" maxlength="180"></div>
                <div class="field"><label>Alamat kantor</label><input data-profile-field="address" maxlength="255"></div>
                <div class="field"><label>Telepon</label><input data-profile-field="phone" maxlength="40"></div>
                <div class="field"><label>Email</label><input data-profile-field="email" type="email" maxlength="180"></div>
                <div class="field wide"><label>Jam pelayanan</label><input data-profile-field="officeHours" maxlength="160" placeholder="Hari dan jam pelayanan"></div>
                <div class="field"><label>Jumlah dusun</label><input data-profile-field="hamlets" type="number" min="0" max="10000"></div>
                <div class="field"><label>Jumlah RW</label><input data-profile-field="rw" type="number" min="0" max="10000"></div>
                <div class="field"><label>Jumlah RT</label><input data-profile-field="rt" type="number" min="0" max="10000"></div>
                <div class="field wide"><strong>Data Indeks Desa terbaru</strong><span class="optional">Masukkan angka sesuai hasil resmi. Ini berbeda dari seri IDM.</span></div>
                <div class="field"><label>Tahun pengukuran</label><input data-profile-field="indexYear" type="number" min="2025" max="2100"></div>
                <div class="field"><label>Nilai Indeks Desa (0–100)</label><input data-profile-field="indexScore" type="number" min="0" max="100" step="0.01"></div>
                <div class="field"><label>Status desa</label><select data-profile-field="indexStatus"><option value="">Pilih status</option><option>Mandiri</option><option>Maju</option><option>Berkembang</option><option>Tertinggal</option><option>Sangat Tertinggal</option></select></div>
                <div class="field"><label>Tanggal verifikasi</label><input data-profile-field="indexVerifiedAt" type="date"></div>
                <div class="field wide"><label>Sumber data resmi</label><input data-profile-field="indexSource" type="url" placeholder="https://"></div>
                <div class="field"><label>Layanan dasar</label><input data-profile-field="indexBasicServices" type="number" min="0" max="100" step="0.01"></div>
                <div class="field"><label>Sosial</label><input data-profile-field="indexSocial" type="number" min="0" max="100" step="0.01"></div>
                <div class="field"><label>Ekonomi</label><input data-profile-field="indexEconomic" type="number" min="0" max="100" step="0.01"></div>
                <div class="field"><label>Lingkungan</label><input data-profile-field="indexEnvironment" type="number" min="0" max="100" step="0.01"></div>
                <div class="field"><label>Aksesibilitas</label><input data-profile-field="indexAccessibility" type="number" min="0" max="100" step="0.01"></div>
                <div class="field"><label>Tata kelola pemerintahan</label><input data-profile-field="indexGovernance" type="number" min="0" max="100" step="0.01"></div>
                <label class="check"><input name="published" type="checkbox" checked> Tampilkan di website</label>
                <div class="row wide"><button class="btn" type="submit">Simpan profil</button><button class="btn light" type="button" data-content-cancel>Batal</button><span class="notice" role="status"></span></div>
            </form>
            <div class="list" data-content-list hidden></div>
        </section>
    </div>
</section>
<section class="card admin-page" id="analytics-management" data-admin-page="analytics" @if ($adminPage !== 'analytics') hidden @endif>
    <div class="section-top"><div><h2>Penggunaan website</h2><p class="muted">Jumlah tampilan halaman publik 30 hari terakhir. Satu halaman yang dibuka ulang dihitung lagi; ini bukan jumlah pengunjung unik.</p></div><span class="status" id="analytics-period">Memuat…</span></div>
    <div class="stats"><div class="metric"><strong id="analytics-total">0</strong><span>Tampilan 30 hari</span></div><div class="metric"><strong id="analytics-today">0</strong><span>Tampilan hari ini</span></div></div>
    <div class="table-wrap"><table><thead><tr><th>Tanggal</th><th>Tampilan halaman</th></tr></thead><tbody id="analytics-daily"></tbody></table></div>
</section>
<style>
    .content-empty-state { margin: 0 0 10px; padding: 12px 14px; border-radius: 9px; background: #f5f8f2; color: #536158; font-size: 14px; }
    .content-managers { display: grid; gap: 16px; }
    .content-manager { padding-top: 16px; border-top: 1px solid var(--line); }
    .content-manager:first-child { padding-top: 0; border-top: 0; }
    .content-manager h2 { margin: 0; font-size: 17px; }
    .content-manager .muted { margin: 5px 0 10px; font-size: 14px; }
    .content-count { display: inline-grid; min-width: 25px; height: 25px; place-items: center; margin-left: 5px; padding: 0 7px; border-radius: 20px; background: #edf2e9; color: #405846; font-size: 12px; vertical-align: 2px; }
    .content-manager .list[hidden] { display: none !important; }
    .content-form { padding: 16px; margin-top: 12px; border: 1px solid var(--line); border-radius: 10px; background: #fbfcfa; }
    .content-form[hidden] { display: none !important; }
    @media (min-width: 900px) { .content-form { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 650px) { .content-manager > .section-top { align-items: flex-start; } .content-manager .section-top > .btn { flex: 0 0 auto; padding: 9px 11px; } .content-form { padding: 12px; } }
    .request-item { padding: 16px; border: 1px solid #e0e7dd; border-radius: 10px; background: #fbfcfa; }
    .request-head { display: grid; grid-template-columns: 1fr auto; gap: 12px; }
    .request-head strong, .request-head small { display: block; }
    .request-head small { color: var(--muted); margin-top: 4px; }
    .request-item > p { margin: 14px 0; white-space: pre-line; }
    .request-controls { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; align-items: end; }
    .request-controls label { display: grid; gap: 5px; font-size: 13px; font-weight: 700; }
    .request-controls input, .request-controls select, .request-controls textarea { width: 100%; border: 1px solid #afbdad; border-radius: 8px; padding: 9px; background: #fff; }
    .request-controls textarea { min-height: 70px; }
    .request-controls .request-note { grid-column: 1 / -1; }
    .request-history { margin: 14px 0 0; padding: 12px 14px; border-radius: 8px; background: #f1f5ef; }
    .request-history summary { cursor: pointer; font-weight: 700; }
    .request-history ol { display: grid; gap: 6px; margin: 10px 0 0; padding-left: 20px; color: var(--muted); }
    .media-item { display: grid; grid-template-columns: 84px minmax(0, 1fr) auto; align-items: center; gap: 12px; }
    .media-item img { display: block; width: 84px; height: 68px; border-radius: 7px; object-fit: cover; }
    @media (max-width: 650px) { .request-head, .request-controls { grid-template-columns: 1fr; } .request-controls .request-note { grid-column: auto; } }
    @media (max-width: 650px) { .media-item { grid-template-columns: 64px minmax(0, 1fr); } .media-item img { width: 64px; height: 56px; } .media-item .actions { grid-column: 1 / -1; } }
</style>
<section class="card admin-page" id="media-management" data-admin-page="media" @if ($adminPage !== 'media') hidden @endif>
    <div class="section-top"><div><h2>Media desa</h2><p class="muted">Unggah gambar JPG, PNG, atau WebP sampai 5 MB. Isi teks alternatif agar gambar bisa dipahami pembaca layar.</p></div></div>
    <form id="media-upload-form" class="grid" enctype="multipart/form-data">
        <div class="field"><label for="media-file">Pilih gambar</label><input id="media-file" name="file" type="file" accept="image/jpeg,image/png,image/webp" required></div>
        <div class="field"><label for="media-alt">Teks alternatif</label><input id="media-alt" name="altText" maxlength="180" required></div>
        <div class="row wide"><button class="btn" type="submit">Unggah gambar</button><span id="media-upload-note" class="notice" role="status"></span></div>
    </form>
    <div class="list media-list" id="village-media"></div>
</section>
<section class="admin-page admin-section" id="user-management" data-admin-page="users" @if ($adminPage !== 'users' || ! $canManageUsers) hidden @endif>
    <section class="card account-panel">
        <div class="section-top"><div><h2>Buat akun pengelola</h2><p class="muted">Akun baru mendapat akses editor untuk website desa ini.</p></div></div>
        <form class="grid" id="admin-user-form">
            <div class="field"><label for="new-admin-name">Nama lengkap</label><input id="new-admin-name" name="name" maxlength="120" required></div>
            <div class="field"><label for="new-admin-username">Nama pengguna</label><input id="new-admin-username" name="username" minlength="3" maxlength="60" pattern="[A-Za-z0-9._-]+" required autocomplete="off"></div>
            <div class="field"><label for="new-admin-email">Email</label><input id="new-admin-email" name="email" type="email" maxlength="180" required autocomplete="email"></div>
            <div class="field"><label for="new-admin-password">Kata sandi sementara</label><input id="new-admin-password" name="password" type="password" minlength="12" required autocomplete="new-password"></div>
            <div class="field"><label for="new-admin-password-confirmation">Konfirmasi kata sandi</label><input id="new-admin-password-confirmation" name="password_confirmation" type="password" minlength="12" required autocomplete="new-password"></div>
            <div class="row wide"><button class="btn" type="submit">Buat akun editor</button><span class="notice" id="admin-user-note" role="status" aria-live="polite"></span></div>
        </form>
    </section>
    <section class="card account-panel">
        <div class="section-top"><div><h2>Akun yang sudah terdaftar</h2><p class="muted">Atur peran dan akses. Perubahan kata sandi tersedia di tiap akun.</p></div></div>
        <div class="list" id="admin-users"></div>
    </section>
</section>
<section class="card admin-page" id="request-management" data-admin-page="requests" @if ($adminPage !== 'requests') hidden @endif>
    <div class="section-top"><div><h2>Permintaan layanan dan pengaduan</h2><p class="muted">Catat tindak lanjut dan perkiraan waktu respons.</p></div><span class="status" id="request-count">0 permintaan</span></div>
    <div class="list" id="village-requests"></div>
</section>
