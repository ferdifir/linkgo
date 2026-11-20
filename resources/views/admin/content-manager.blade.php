<section class="card admin-page" id="news-management" data-admin-page="news" @if ($adminPage !== 'news') hidden @endif>
    <section class="content-manager" data-content-manager="news">
            <div class="section-top"><div><h2>Berita dan pengumuman <span class="content-count" data-content-count>0</span></h2><p class="muted">Kabar dan pengumuman warga.</p></div><button class="btn" type="button" data-content-add>Tambah berita</button></div>
            <dialog class="admin-dialog content-dialog"><div class="admin-dialog-head"><h2 data-content-dialog-title>Tambah berita</h2><button class="btn light" type="button" data-content-cancel aria-label="Tutup form">Tutup</button></div><form class="grid content-form">
                <input type="hidden" name="id">
                <section class="news-ai-composer wide" data-news-composer aria-labelledby="news-source-label">
                    <div><h3 id="news-source-label">Mulai dari bahan berita</h3><p class="field-help">Tempel catatan atau informasi resmi. AI akan menyusunnya menjadi draf; nama, tanggal, dan angka tidak akan ditambahkan sendiri.</p></div>
                    <div class="field"><label for="news-source">Bahan berita</label><textarea id="news-source" data-news-source maxlength="3000" rows="5" aria-describedby="news-source-help"></textarea><span id="news-source-help" class="field-help">Jangan masukkan data pribadi warga. Bahan dikirim ke TokenHarbor saat Anda memilih Buat draf.</span></div>
                    <p class="news-ai-status" data-news-ai-status role="status" aria-live="polite"></p>
                    <div class="news-ai-actions"><button class="btn" type="button" data-news-generate>Buat draf dengan AI</button><button class="btn light" type="button" data-news-manual>Tulis sendiri</button></div>
                </section>
                <div class="news-editor wide" data-news-editor hidden>
                    <p class="news-draft-note" data-news-draft-note role="status" aria-live="polite" tabindex="-1">Periksa dan sunting draf sebelum menyimpannya. Draf belum tayang di website.</p>
                    <div class="grid">
                        <div class="field"><label for="news-title">Judul</label><input id="news-title" name="title" maxlength="180" required autocomplete="off"></div>
                        <div class="field"><label for="news-category">Kategori</label><select id="news-category" name="category"><option value="Berita">Berita</option><option value="Pengumuman">Pengumuman</option></select></div>
                        <div class="field wide"><label for="news-summary">Ringkasan <span class="optional">(opsional)</span></label><textarea id="news-summary" name="summary" maxlength="300" rows="2"></textarea></div>
                        <div class="field wide"><label for="news-body">Isi berita</label><textarea id="news-body" name="body" maxlength="5000" required aria-describedby="news-body-help"></textarea><span id="news-body-help" class="field-help">Maksimal 5.000 karakter.</span></div>
                    </div>
                    <details class="news-extra">
                        <summary>Pengaturan tambahan</summary>
                        <div class="grid">
                            <div class="field"><label for="news-published-at">Tanggal publikasi <span class="optional">(opsional)</span></label><input id="news-published-at" name="publishedAt" type="date"></div>
                            <div class="field"><label for="news-link">Tautan informasi <span class="optional">(opsional)</span></label><input id="news-link" name="link" type="url" placeholder="https://" autocomplete="url"></div>
                            <div class="field wide"><label for="news-image-picker">Gambar dari Media desa <span class="optional">(opsional)</span></label><select id="news-image-picker" data-content-image-picker><option value="">Pilih gambar yang sudah diunggah</option></select><input type="hidden" name="imageUrl"><span class="optional">Unggah gambar lewat menu Media desa.</span></div>
                            <div class="field"><label for="news-sort-order">Urutan tampil</label><input id="news-sort-order" name="sortOrder" type="number" min="0" max="9999" value="0" inputmode="numeric"></div>
                            <label class="check"><input name="published" type="checkbox"> Tayangkan setelah disimpan</label>
                        </div>
                    </details>
                    <div class="row wide"><button class="btn light" type="button" data-news-redraft>Buat ulang dengan AI</button><button class="btn" type="submit">Simpan berita</button><button class="btn light" type="button" data-content-cancel>Batal</button></div>
                </div>
            </form></dialog>
            <p class="notice" data-content-notice role="status" aria-live="polite"></p>
            <div class="empty" data-content-empty hidden>Belum ada berita. Tambahkan berita untuk ditampilkan di website desa.</div>
            <div class="list" data-content-list hidden></div>
    </section>
</section>
<section class="card admin-page" id="activity-management" data-admin-page="activities" @if ($adminPage !== 'activities') hidden @endif>
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
                <div class="field wide"><label for="activity-image-picker">Gambar dari Media desa <span class="optional">(opsional)</span></label><select id="activity-image-picker" data-content-image-picker><option value="">Pilih gambar yang sudah diunggah</option></select><input type="hidden" name="imageUrl"><span class="optional">Unggah gambar lewat menu Media desa.</span></div>
                <div class="field"><label for="activity-sort-order">Urutan tampil</label><input id="activity-sort-order" name="sortOrder" type="number" min="0" max="9999" value="0" inputmode="numeric"></div>
                <label class="check"><input name="published" type="checkbox" checked> Terbitkan di website</label>
                <div class="row wide"><button class="btn" type="submit">Simpan kegiatan</button><button class="btn light" type="button" data-content-cancel>Batal</button></div>
            </form></dialog>
            <p class="notice" data-content-notice role="status" aria-live="polite"></p>
            <div class="empty" data-content-empty hidden>Belum ada kegiatan. Tambahkan kegiatan untuk ditampilkan di website desa.</div>
            <div class="list" data-content-list hidden></div>
    </section>
</section>
<section class="card admin-page" id="service-management" data-admin-page="services" @if ($adminPage !== 'services') hidden @endif>
    <section class="content-manager" data-content-manager="service">
            <div class="section-top"><div><h2>Layanan warga <span class="content-count" data-content-count>0</span></h2><p class="muted">Persyaratan, alur, jadwal, atau informasi layanan.</p></div><button class="btn" type="button" data-content-add>Tambah layanan</button></div>
            <dialog class="admin-dialog content-dialog"><div class="admin-dialog-head"><h2 data-content-dialog-title>Tambah layanan</h2><button class="btn light" type="button" data-content-cancel aria-label="Tutup form">Tutup</button></div><form class="grid content-form">
                <input type="hidden" name="id">
                <div class="field"><label for="service-title">Nama layanan</label><input id="service-title" name="title" maxlength="180" required></div>
                <div class="field"><label for="service-sort-order">Urutan tampil</label><input id="service-sort-order" name="sortOrder" type="number" min="0" max="9999" value="0"></div>
                <div class="field wide"><label for="service-summary">Ringkasan</label><input id="service-summary" name="summary" maxlength="300"></div>
                <div class="field wide"><label for="service-body">Persyaratan dan alur</label><textarea id="service-body" name="body" maxlength="5000" required></textarea></div>
                <div class="field wide"><label for="service-link">Tautan informasi <span class="optional">(opsional)</span></label><input id="service-link" name="link" type="url" placeholder="https://"></div>
                <div class="field wide"><label for="service-image-picker">Gambar dari Media desa <span class="optional">(opsional)</span></label><select id="service-image-picker" data-content-image-picker><option value="">Pilih gambar yang sudah diunggah</option></select><input type="hidden" name="imageUrl"><span class="optional">Unggah gambar lewat menu Media desa.</span></div>
                <label class="check"><input name="published" type="checkbox" checked> Tampilkan di website</label>
                <div class="row wide"><button class="btn" type="submit">Simpan layanan</button><button class="btn light" type="button" data-content-cancel>Batal</button></div>
            </form></dialog>
            <p class="notice" data-content-notice role="status" aria-live="polite"></p>
            <div class="empty" data-content-empty hidden>Belum ada layanan. Tambahkan informasi layanan untuk warga.</div>
            <div class="list" data-content-list hidden></div>
    </section>
</section>
<section class="card admin-page" id="analytics-management" data-admin-page="analytics" @if ($adminPage !== 'analytics') hidden @endif>
    <div class="section-top"><div><h2>Penggunaan website</h2><p class="muted">Jumlah tampilan halaman publik 30 hari terakhir. Satu halaman yang dibuka ulang dihitung lagi; ini bukan jumlah pengunjung unik.</p></div><span class="status" id="analytics-period">Memuat…</span></div>
    <div class="stats"><div class="metric"><strong id="analytics-total">0</strong><span>Tampilan 30 hari</span></div><div class="metric"><strong id="analytics-today">0</strong><span>Tampilan hari ini</span></div></div>
    <div class="table-wrap"><table><thead><tr><th>Tanggal</th><th>Tampilan halaman</th></tr></thead><tbody id="analytics-daily"></tbody></table></div>
</section>
<style>
    .field-help { color: var(--muted); font-size: 12px; line-height: 1.45; }
    .content-manager h2 { margin: 0; font-size: 17px; }
    .content-manager .muted { margin: 5px 0 10px; font-size: 14px; }
    .content-count { display: inline-grid; min-width: 25px; height: 25px; place-items: center; margin-left: 5px; padding: 0 7px; border-radius: 20px; background: #edf2e9; color: #405846; font-size: 12px; vertical-align: 2px; }
    .content-manager .list[hidden] { display: none !important; }
    .content-form { padding: 16px; margin-top: 12px; border: 1px solid var(--line); border-radius: 10px; background: #fbfcfa; }
    .content-form[hidden] { display: none !important; }
    .news-ai-composer, .news-editor { grid-column: 1 / -1; }
    .news-ai-composer { display: grid; gap: 14px; padding: 16px; border: 1px solid #d5e1d0; border-radius: 10px; background: #f5f8f2; }
    .news-ai-composer[hidden], .news-editor[hidden] { display: none !important; }
    .news-ai-composer h3 { margin: 0 0 5px; font-size: 17px; }
    .news-ai-composer p { margin: 0; }
    .news-ai-composer .field-help { font-size: 14px; line-height: 1.45; }
    .news-ai-actions { display: flex; align-items: center; gap: 9px; flex-wrap: wrap; }
    .news-ai-status { min-height: 0; color: var(--muted); font-size: 14px; }
    .news-ai-status:empty { display: none; }
    .news-ai-status.error { color: #a3342a; }
    .news-ai-status.ok { color: #2f6138; }
    .news-editor { display: grid; gap: 14px; }
    .news-editor > .grid { gap: 12px; }
    .news-editor textarea { min-height: 128px; }
    .news-editor #news-summary { min-height: 68px; }
    .news-draft-note { margin: 0; padding: 10px 12px; border-radius: 8px; background: #f5f8f2; color: #536158; font-size: 14px; }
    .news-extra { padding: 12px 14px; border: 1px solid var(--line); border-radius: 9px; background: #fff; }
    .news-extra summary { color: #405846; cursor: pointer; font-size: 14px; font-weight: 700; }
    .news-extra .grid { margin-top: 14px; }
    @media (min-width: 900px) { .content-form { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 650px) {
        .content-manager > .section-top { display: grid; grid-template-columns: minmax(0, 1fr); align-items: start; gap: 12px; }
        .content-manager > .section-top > div { min-width: 0; }
        .content-manager .section-top > .btn { justify-self: start; max-width: 100%; padding: 9px 11px; }
        .content-form { padding: 12px; }
        .news-ai-composer { padding: 13px; }
        .news-ai-actions > button { width: 100%; }
    }
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
