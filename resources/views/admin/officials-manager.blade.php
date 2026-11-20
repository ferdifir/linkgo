<section class="card admin-page" id="officials-management" data-admin-page="officials" @if ($adminPage !== 'officials') hidden @endif>
    <div class="content-managers">
        <section class="content-manager village-head-manager" data-village-head-manager hidden>
            <div class="section-top">
                <div>
                    <h2>Kepala desa</h2>
                    <p class="muted">Nama kepala desa yang ditampilkan pada sambutan dan bagian perangkat desa.</p>
                    <p class="village-head-name" data-village-head-display></p>
                </div>
                <button class="btn light" type="button" data-village-head-edit>Ubah</button>
            </div>
            <dialog class="admin-dialog" data-village-head-dialog aria-labelledby="village-head-dialog-title">
                <div class="admin-dialog-head">
                    <h2 id="village-head-dialog-title">Ubah kepala desa</h2>
                    <button class="btn light" type="button" data-village-head-cancel aria-label="Tutup form">Tutup</button>
                </div>
                <form class="grid content-form" data-village-head-form>
                    <div class="field wide">
                        <label for="village-head-name">Nama kepala desa</label>
                        <input id="village-head-name" name="name" maxlength="180" required autocomplete="name">
                    </div>
                    <div class="row wide">
                        <button class="btn" type="submit">Simpan perubahan</button>
                        <button class="btn light" type="button" data-village-head-cancel>Batal</button>
                    </div>
                </form>
            </dialog>
            <p class="notice" data-village-head-notice role="status" aria-live="polite"></p>
        </section>

        <section class="content-manager" data-official-manager>
            <div class="section-top">
                <div>
                    <h2>Perangkat desa <span class="content-count" data-official-count>0</span></h2>
                    <p class="muted">Nama dan jabatan yang ditampilkan pada website desa.</p>
                </div>
                <button class="btn" type="button" data-official-add>Tambah perangkat</button>
            </div>
            <dialog class="admin-dialog" data-official-dialog>
                <div class="admin-dialog-head">
                    <h2 data-official-dialog-title>Tambah perangkat</h2>
                    <button class="btn light" type="button" data-official-cancel aria-label="Tutup form">Tutup</button>
                </div>
                <form class="grid content-form" data-official-form>
                    <input type="hidden" name="id">
                    <div class="field"><label for="official-name">Nama</label><input id="official-name" name="name" maxlength="180" required autocomplete="name"></div>
                    <div class="field"><label for="official-position">Jabatan</label><input id="official-position" name="position" maxlength="180" required></div>
                    <div class="field wide"><label for="official-image-url">URL foto <span class="optional">(opsional)</span></label><input id="official-image-url" name="imageUrl" type="url" placeholder="https://" autocomplete="url"></div>
                    <div class="field wide"><label for="official-image-picker">Atau pilih dari Media desa</label><select id="official-image-picker" data-official-image-picker><option value="">Pilih foto yang sudah diunggah</option></select></div>
                    <div class="field"><label for="official-sort-order">Urutan tampil</label><input id="official-sort-order" name="sortOrder" type="number" min="0" max="9999" value="0" inputmode="numeric"></div>
                    <label class="check"><input name="published" type="checkbox" checked> Tampilkan di website</label>
                    <p class="field-help wide">Centang “Tampilkan di website” agar perangkat ini muncul di daftar perangkat desa.</p>
                    <div class="row wide"><button class="btn" type="submit">Simpan perangkat</button><button class="btn light" type="button" data-official-cancel>Batal</button></div>
                </form>
            </dialog>
            <p class="notice" data-official-notice role="status" aria-live="polite"></p>
            <div class="list" data-official-list hidden></div>
        </section>
    </div>
</section>
<style>
    .village-head-manager .section-top { align-items: center; }
    .village-head-name { margin: 12px 0 0; color: var(--ink); font-size: 17px; font-weight: 700; }
    .village-head-manager .notice:empty { display: none; }
</style>
