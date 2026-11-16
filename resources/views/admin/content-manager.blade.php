<section class="card admin-page" id="content-management" data-admin-page="content" @if ($adminPage !== 'content') hidden @endif>
    <p id="content-empty-state" class="content-empty-state" hidden>Belum ada konten website. Tambahkan berita, kegiatan, layanan, atau profil desa.</p>
    <div class="content-managers">
        <section class="content-manager" data-content-manager="news">
            <div class="section-top"><div><h2>Berita dan pengumuman <span class="content-count" data-content-count>0</span></h2><p class="muted">Kabar, agenda, dan informasi warga.</p></div><button class="btn" type="button" data-content-add>Tambah berita</button></div>
            <dialog class="admin-dialog content-dialog"><div class="admin-dialog-head"><h2 data-content-dialog-title>Tambah berita</h2><button class="btn light" type="button" data-content-cancel aria-label="Tutup form">Tutup</button></div><form class="grid content-form">
                <input type="hidden" name="id">
                <div class="field"><label for="news-title">Judul</label><input id="news-title" name="title" maxlength="180" required autocomplete="off"></div>
                <div class="field"><label for="news-category">Kategori</label><select id="news-category" name="category"><option value="Berita">Berita</option><option value="Pengumuman">Pengumuman</option><option value="Agenda">Agenda</option></select></div>
                <div class="field wide"><label for="news-summary">Ringkasan <span class="optional">(opsional, maks. 300 karakter)</span></label><input id="news-summary" name="summary" maxlength="300"></div>
                <div class="field wide"><label for="news-body">Isi kabar</label><textarea id="news-body" name="body" maxlength="5000" required aria-describedby="news-body-help"></textarea><span id="news-body-help" class="field-help">Gunakan paragraf singkat. Maksimal 5.000 karakter.</span></div>
                <div class="field"><label for="news-published-at">Tanggal publikasi <span class="optional">(opsional)</span></label><input id="news-published-at" name="publishedAt" type="date"></div>
                <div class="field"><label for="news-link">Tautan informasi <span class="optional">(opsional)</span></label><input id="news-link" name="link" type="url" placeholder="https://" autocomplete="url"></div>
                <div class="field wide"><label for="news-image-url">Gambar <span class="optional">(opsional)</span></label><input id="news-image-url" name="imageUrl" type="url" placeholder="Gunakan gambar dari Media desa" autocomplete="url"></div>
                <div class="field"><label for="news-sort-order">Urutan tampil</label><input id="news-sort-order" name="sortOrder" type="number" min="0" max="9999" value="0" inputmode="numeric"></div>
                <label class="check"><input name="published" type="checkbox" checked> Terbitkan di website</label>
                <div class="row wide"><button class="btn" type="submit">Simpan berita</button><button class="btn light" type="button" data-content-cancel>Batal</button></div>
            </form></dialog>
            <p class="notice" data-content-notice role="status" aria-live="polite"></p>
            <div class="list" data-content-list hidden></div>
        </section>

        <section class="content-manager" data-content-manager="activity">
            <div class="section-top"><div><h2>Kegiatan desa <span class="content-count" data-content-count>0</span></h2><p class="muted">Agenda, kegiatan warga, dan catatan pelaksanaannya.</p></div><button class="btn" type="button" data-content-add>Tambah kegiatan</button></div>
            <dialog class="admin-dialog content-dialog"><div class="admin-dialog-head"><h2 data-content-dialog-title>Tambah kegiatan</h2><button class="btn light" type="button" data-content-cancel aria-label="Tutup form">Tutup</button></div><form class="grid content-form">
                <input type="hidden" name="id">
                <div class="field"><label for="activity-title">Nama kegiatan</label><input id="activity-title" name="title" maxlength="180" required autocomplete="off"></div>
                <div class="field"><label for="activity-category">Jenis kegiatan</label><select id="activity-category" name="category"><option value="Agenda">Agenda</option><option value="Kegiatan warga">Kegiatan warga</option><option value="Pelayanan">Pelayanan</option><option value="Lainnya">Lainnya</option></select></div>
                <div class="field wide"><label for="activity-summary">Ringkasan <span class="optional">(opsional, maks. 300 karakter)</span></label><input id="activity-summary" name="summary" maxlength="300"></div>
                <div class="field wide"><label for="activity-body">Rincian kegiatan</label><textarea id="activity-body" name="body" maxlength="5000" required aria-describedby="activity-body-help"></textarea><span id="activity-body-help" class="field-help">Jelaskan jadwal, lokasi, atau hasil kegiatan yang sudah berlangsung.</span></div>
                <div class="field"><label for="activity-published-at">Tanggal kegiatan</label><input id="activity-published-at" name="publishedAt" type="date"></div>
                <div class="field"><label for="activity-link">Tautan informasi <span class="optional">(opsional)</span></label><input id="activity-link" name="link" type="url" placeholder="https://" autocomplete="url"></div>
                <div class="field wide"><label for="activity-image-url">Gambar <span class="optional">(opsional)</span></label><input id="activity-image-url" name="imageUrl" type="url" placeholder="Gunakan gambar dari Media desa" autocomplete="url"></div>
                <div class="field"><label for="activity-sort-order">Urutan tampil</label><input id="activity-sort-order" name="sortOrder" type="number" min="0" max="9999" value="0" inputmode="numeric"></div>
                <label class="check"><input name="published" type="checkbox" checked> Terbitkan di website</label>
                <div class="row wide"><button class="btn" type="submit">Simpan kegiatan</button><button class="btn light" type="button" data-content-cancel>Batal</button></div>
            </form></dialog>
            <p class="notice" data-content-notice role="status" aria-live="polite"></p>
            <div class="list" data-content-list hidden></div>
        </section>

        <section class="content-manager" data-content-manager="service">
            <div class="section-top"><div><h2>Layanan warga <span class="content-count" data-content-count>0</span></h2><p class="muted">Persyaratan, alur, jadwal, atau informasi layanan.</p></div><button class="btn" type="button" data-content-add>Tambah layanan</button></div>
            <dialog class="admin-dialog content-dialog"><div class="admin-dialog-head"><h2 data-content-dialog-title>Tambah layanan</h2><button class="btn light" type="button" data-content-cancel aria-label="Tutup form">Tutup</button></div><form class="grid content-form">
                <input type="hidden" name="id">
                <div class="field"><label for="service-title">Nama layanan</label><input id="service-title" name="title" maxlength="180" required></div>
                <div class="field"><label for="service-sort-order">Urutan tampil</label><input id="service-sort-order" name="sortOrder" type="number" min="0" max="9999" value="0"></div>
                <div class="field wide"><label for="service-summary">Ringkasan</label><input id="service-summary" name="summary" maxlength="300"></div>
                <div class="field wide"><label for="service-body">Persyaratan dan alur</label><textarea id="service-body" name="body" maxlength="5000" required></textarea></div>
                <div class="field wide"><label for="service-link">Tautan informasi <span class="optional">(opsional)</span></label><input id="service-link" name="link" type="url" placeholder="https://"></div>
                <div class="field wide"><label for="service-image-url">URL gambar dari media desa <span class="optional">(opsional)</span></label><input id="service-image-url" name="imageUrl" type="url" placeholder="Unggah gambar di bagian Media desa, lalu pilih Gunakan"></div>
                <label class="check"><input name="published" type="checkbox" checked> Tampilkan di website</label>
                <div class="row wide"><button class="btn" type="submit">Simpan layanan</button><button class="btn light" type="button" data-content-cancel>Batal</button></div>
            </form></dialog>
            <p class="notice" data-content-notice role="status" aria-live="polite"></p>
            <div class="list" data-content-list hidden></div>
        </section>

        <section class="content-manager" data-content-manager="profile">
            <div class="section-top"><div><h2>Profil dan potensi desa <span class="content-count" data-content-count>0</span></h2><p class="muted">Ringkasan profil dan potensi yang ingin ditampilkan.</p></div><button class="btn" type="button" data-content-add>Tambah profil</button></div>
            <dialog class="admin-dialog content-dialog"><div class="admin-dialog-head"><h2 data-content-dialog-title>Tambah profil</h2><button class="btn light" type="button" data-content-cancel aria-label="Tutup form">Tutup</button></div><form class="grid content-form">
                <input type="hidden" name="id">
                <div class="field wide"><label for="profile-title">Judul</label><input id="profile-title" name="title" maxlength="180" required></div>
                <div class="field wide"><label for="profile-summary">Ringkasan</label><input id="profile-summary" name="summary" maxlength="300"></div>
                <div class="field wide"><label for="profile-body">Gambaran desa dan potensi utama</label><textarea id="profile-body" name="body" maxlength="5000" required></textarea></div>
                <div class="field wide"><label for="profile-link">Tautan pendukung <span class="optional">(opsional)</span></label><input id="profile-link" name="link" type="url" placeholder="https://"></div>
                <div class="field wide"><label for="profile-image-url">URL gambar dari media desa <span class="optional">(opsional)</span></label><input id="profile-image-url" name="imageUrl" type="url" placeholder="Unggah gambar di bagian Media desa, lalu pilih Gunakan"></div>
                <div class="field wide"><strong>Informasi pemerintahan</strong></div>
                <div class="field"><label for="profile-headName">Nama kepala desa</label><input id="profile-headName" data-profile-field="headName" maxlength="180"></div>
                <div class="field"><label for="profile-address">Alamat kantor</label><input id="profile-address" data-profile-field="address" maxlength="255"></div>
                <div class="field"><label for="profile-phone">Telepon</label><input id="profile-phone" data-profile-field="phone" maxlength="40"></div>
                <div class="field"><label for="profile-email">Email</label><input id="profile-email" data-profile-field="email" type="email" maxlength="180"></div>
                <div class="field wide"><label for="profile-officeHours">Jam pelayanan</label><input id="profile-officeHours" data-profile-field="officeHours" maxlength="160" placeholder="Hari dan jam pelayanan"></div>
                <div class="field"><label for="profile-hamlets">Jumlah dusun</label><input id="profile-hamlets" data-profile-field="hamlets" type="number" min="0" max="10000"></div>
                <div class="field"><label for="profile-rw">Jumlah RW</label><input id="profile-rw" data-profile-field="rw" type="number" min="0" max="10000"></div>
                <div class="field"><label for="profile-rt">Jumlah RT</label><input id="profile-rt" data-profile-field="rt" type="number" min="0" max="10000"></div>
                <label class="check"><input name="published" type="checkbox" checked> Tampilkan di website</label>
                <div class="row wide"><button class="btn" type="submit">Simpan profil</button><button class="btn light" type="button" data-content-cancel>Batal</button></div>
            </form></dialog>
            <p class="notice" data-content-notice role="status" aria-live="polite"></p>
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
    .field-help { color: var(--muted); font-size: 12px; line-height: 1.45; }
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
