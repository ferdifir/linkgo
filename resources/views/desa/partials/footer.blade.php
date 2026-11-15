<style>
    svg.inline-icon{display:inline-block!important;width:14px;height:14px;flex:none;vertical-align:-2px}
    .portal-footer{padding:52px max(28px,calc((100vw - 1280px)/2)) 18px;background:var(--portal-footer-bg,#25870d);color:#fff;font:400 14px/1.6 var(--font-sans,ui-sans-serif,system-ui,sans-serif)}
    .portal-footer--curahsawo{--portal-footer-bg:#294c35}.portal-footer--pajurangan{--portal-footer-bg:#17352d}.portal-footer--gending{--portal-footer-bg:#1d3729}.portal-footer--randupitu{--portal-footer-bg:#79291f}.portal-footer--bulang{--portal-footer-bg:#103a86}.portal-footer--klaseman{--portal-footer-bg:#8d3529}.portal-footer--jatiadi{--portal-footer-bg:#164b38}
    .portal-footer__grid{display:grid;grid-template-columns:1.45fr 1fr 1fr .8fr;gap:38px;max-width:1280px;margin-inline:auto}
    .portal-village-logo{display:grid;width:46px;height:46px;flex:none;place-items:center;overflow:hidden;border:1px solid currentColor;border-radius:31%;background:#f7fcff}.portal-village-logo img{display:block;width:100%;height:100%;object-fit:contain}.portal-footer__identity{display:grid;grid-template-columns:70px minmax(0,1fr);align-content:start;gap:18px}.portal-footer__seal{display:block;width:64px;height:64px;overflow:hidden;border:2px solid rgb(255 255 255/.82);border-radius:31%;background:#f7fcff}.portal-footer__seal img{display:block;width:100%;height:100%;object-fit:contain}
    .portal-footer__section h2,.portal-footer__identity h2{margin:0 0 14px;color:#fff;font-size:20px;font-weight:750;line-height:1.25}.portal-footer__identity p,.portal-footer__section p{margin:0 0 5px}
    .portal-footer__contact{display:flex;align-items:flex-start;gap:11px;margin:0 0 14px!important}.portal-footer__contact svg{width:19px;height:19px;flex:none;margin-top:2px;fill:none;stroke:currentColor;stroke-linecap:round;stroke-linejoin:round;stroke-width:1.8}.portal-footer__social{margin-top:19px!important;color:rgb(255 255 255/.85)}
    .portal-footer__links{display:flex;flex-direction:column;align-items:flex-start;gap:5px}.portal-footer__links h2{margin-bottom:9px}.portal-footer a{color:#fff;text-decoration:underline;text-underline-offset:3px}
    .portal-footer__bottom{margin:48px auto 0;color:rgb(255 255 255/.88);text-align:center}.portal-footer__bottom a{font-weight:800}
    @media(max-width:900px){.portal-footer__grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:32px 28px}}
    @media(max-width:560px){.portal-footer{padding:38px 20px 16px;font-size:14px}.portal-footer__grid{grid-template-columns:minmax(0,1fr);gap:28px}.portal-footer__identity{grid-template-columns:54px minmax(0,1fr);gap:14px}.portal-footer__seal{width:52px;height:52px}.portal-footer__section h2,.portal-footer__identity h2{font-size:18px}.portal-footer__bottom{margin-top:35px}}
</style>
<footer class="portal-footer portal-footer--{{ $theme }}">
    <div class="portal-footer__grid">
        <section class="portal-footer__identity" aria-label="Identitas pemerintah desa">
            <span class="portal-footer__seal" aria-hidden="true"><img src="{{ asset('images/portal-logo.png') }}" alt=""></span>
            <div>
                <h2>Pemerintah Desa {{ $villageName }}</h2>
                <p>Alamat kantor belum tersedia.</p>
                <p>Desa {{ $villageName }}, Kecamatan Gending, Kabupaten Probolinggo, Jawa Timur.</p>
                <p><strong>Kode wilayah:</strong> belum tersedia</p>
            </div>
        </section>

        <section class="portal-footer__section">
            <h2>Hubungi Kami</h2>
            <p class="portal-footer__contact"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 4h4l2 5-3 2c1.5 3 3 4.5 6 6l2-3 5 2v4c0 1-1 2-2 2C9 21 3 15 3 6c0-1 1-2 2-2Z"/></svg><span>Telepon belum tersedia</span></p>
            <p class="portal-footer__contact"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/></svg><span>Email belum tersedia</span></p>
            <p class="portal-footer__social">Kanal media sosial belum tersedia</p>
        </section>

        <section class="portal-footer__section">
            <h2>Nomor Telepon Penting</h2>
            <p class="portal-footer__contact"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s7-4.5 7-11a7 7 0 1 0-14 0c0 6.5 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/></svg><span>Nomor layanan penting belum tersedia</span></p>
        </section>

        <nav class="portal-footer__section portal-footer__links" aria-label="Jelajahi situs">
            <h2>Jelajahi</h2>
            @foreach ($links as $link)
                <a href="{{ $link['href'] }}">{{ $link['label'] }}</a>
            @endforeach
        </nav>
    </div>


    <div class="portal-footer__bottom">© {{ date('Y') }} LinkGo · Powered by <a href="https://wa.me/6285239110184" target="_blank" rel="noopener noreferrer">@ferdifir</a></div>
</footer>
