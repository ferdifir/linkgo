<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Panduan warga Desa Curahsawo, Kecamatan Gending, Kabupaten Probolinggo. Temukan informasi layanan balai desa, pembangunan, anggaran, dan kegiatan warga.">
  <meta name="theme-color" content="#f6f7f2">
  @include('desa.partials.open-graph', ['villageOpenGraph' => $villageOpenGraph, 'villageSlug' => $slug])
  <style>
@font-face{font-family:Instrument Serif;src:url("{{ asset('fonts/curahsawo-instrument-serif-regular.woff2') }}") format("woff2");font-display:swap}
@font-face{font-family:Instrument Serif;src:url("{{ asset('fonts/curahsawo-instrument-serif-italic.woff2') }}") format("woff2");font-style:italic;font-display:swap}
@font-face{font-family:DM Sans;src:url("{{ asset('fonts/curahsawo-dm-sans.woff2') }}") format("woff2");font-weight:100 1000;font-display:swap}
:root {
  --ink:#152f2a;
  --muted:#53655e;
  --green:#1a5344;
  --deep:#12392f;
  --lime:#e4f2a6;
  --bg:#f6f7f2;
  --line:#dce4d9;
  --serif:"Instrument Serif",Georgia,serif;
  --sans:"DM Sans",Arial,sans-serif;
}
*,*::before,*::after { box-sizing:border-box }
html { scroll-behavior:smooth }
body { margin:0;background:var(--bg);color:var(--ink);font:16px/1.55 var(--sans) }
h1,h2,h3,p,figure,dl,dd { margin:0 }
a { color:inherit;text-decoration:none }
button { color:inherit;font:inherit }
img { display:block;width:100%;object-fit:cover }
svg { width:20px;height:20px;flex:none;fill:none;stroke:currentColor;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round;vertical-align:middle }
.symbols { position:absolute;width:0;height:0;overflow:hidden }
:focus-visible { outline:2px solid #486d28;outline-offset:4px }
[id] { scroll-margin-top:104px }
.shell { width:min(100% - 88px,1260px);margin-inline:auto }
.skip { position:fixed;top:12px;left:12px;z-index:8;padding:9px 15px;background:white;border-radius:8px;transform:translateY(-180%) }
.skip:focus { transform:none }
.site-header { position:sticky;top:0;z-index:5;background:#fbfcf8;border-bottom:1px solid var(--line) }
.header-row { min-height:78px;display:flex;justify-content:space-between;align-items:center;gap:18px }
.brand { display:inline-flex;align-items:center;gap:11px;line-height:1.2;flex:none }
.brand-mark { display:grid;place-items:center;width:45px;height:45px;background:var(--deep);color:var(--lime);border-radius:13px }
.brand-mark svg { width:26px;height:26px;stroke-width:1.5 }
.brand strong,.brand small { display:block }
.brand strong { font-size:16px;font-weight:800;letter-spacing:-.025em }
.brand small { color:var(--muted);font-size:11px;margin-top:4px }
nav { display:flex;gap:clamp(13px,2vw,28px);align-items:center;font-size:14px;font-weight:700 }
nav>a { color:var(--muted);white-space:nowrap }
nav>a:hover,nav>a[aria-current] { color:var(--green) }
nav>a[aria-current]:not(.nav-action) { text-decoration:underline;text-underline-offset:7px }
nav .nav-action { display:inline-flex;gap:7px;align-items:center;justify-content:center;padding:10px 13px;border-radius:9px;background:#e8efe4;color:var(--deep) }
nav .nav-action:hover { background:#dbe9d7 }
.nav-action svg,.menu-toggle svg { width:17px;height:17px }
.menu-toggle { display:none }
.hero { padding-top:25px }
.hero-frame { min-height:514px;position:relative;overflow:hidden;isolation:isolate;background:#173c30;color:#fff;border-radius:23px;display:flex;align-items:center }
.hero-photo,.hero-frame::after { position:absolute;inset:0;width:100%;height:100%;z-index:-1 }
.hero-photo { object-position:50% 47% }
.hero-frame::after { content:"";background:linear-gradient(90deg,#102c26f5 0%,#102c26db 29%,#102c2680 54%,#102c2615 84%),linear-gradient(0deg,#102c2690,transparent 41%) }
.hero-body { padding:47px clamp(32px,5.2vw,78px) 64px }
.eyebrow { display:flex;align-items:center;gap:7px;color:#376654;font-size:11px;font-weight:800;line-height:1.4;letter-spacing:.16em;text-transform:uppercase }
.eyebrow svg { width:16px;height:16px }
.hero-body .eyebrow,.location .eyebrow { color:var(--lime) }
h1,h2 { font-family:var(--serif);font-weight:400;letter-spacing:-.03em;line-height:.94 }
h1 { font-size:clamp(86px,10vw,145px);max-width:7ch;margin:16px 0 18px }
h1 span { color:var(--lime) }
.hero-body>p:not(.eyebrow) { color:#f1f6e8;max-width:38ch;font-size:17px;line-height:1.52 }
.button { display:inline-flex;align-items:center;justify-content:center;gap:10px;width:fit-content;min-height:47px;padding:11px 16px;font-size:14px;font-weight:800;border-radius:9px }
.button svg,.text-link svg { width:17px;height:17px }
.lime { color:#15362c;background:var(--lime) }
.lime:hover { background:#f0fac1 }
.hero .button { margin-top:23px }
.hero :focus-visible,.location :focus-visible { outline-color:var(--lime) }
.hero-label { position:absolute;right:24px;bottom:23px;display:flex;align-items:center;gap:9px;padding:9px 12px;color:#fff;background:#142c26b8;border:1px solid #f7fff353;border-radius:11px;backdrop-filter:blur(10px) }
.hero-label:hover { background:#142c26 }
.hero-label strong,.hero-label small { display:block;line-height:1.25 }
.hero-label strong { font-size:13px }
.hero-label small { font-size:11px;color:#e3eddf;margin-top:3px }
.hero-label .label-arrow { width:15px;height:15px;margin-left:5px }
.quick { display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:11px;padding-top:12px }
.quick-card { display:grid;grid-template-columns:auto minmax(0,1fr) auto;align-items:center;gap:10px;background:#fff;border:1px solid var(--line);border-radius:13px;padding:13px 12px;min-height:81px;transition:border-color .18s,transform .18s,box-shadow .18s }
.quick-card:hover { border-color:#9aaf94;transform:translateY(-3px);box-shadow:0 6px 15px #16352912 }
.icon { width:43px;height:43px;display:grid;place-items:center;flex:none;border-radius:11px }
.icon svg { width:21px;height:21px }
.tone-green { background:#e7f0dc;color:#2e5b36 }
.tone-gold { background:#f6ecd5;color:#78572c }
.tone-blue { background:#e4eff0;color:#305d68 }
.tone-rose { background:#f5e8df;color:#814c39 }
.quick-card strong,.quick-card small,summary strong,summary small { display:block }
.quick-card strong { font-size:14px;line-height:1.25 }
.quick-card small { color:var(--muted);font-size:11px;margin-top:3px;line-height:1.3 }
.quick-arrow { width:15px;height:15px;color:var(--green) }
.section-space { padding-block:70px }
h2 { font-size:clamp(53px,5.5vw,78px);margin-top:9px }
.welcome-band { background:#eaf0e5;border-block:1px solid #dfe7da }
.welcome { display:grid;grid-template-columns:minmax(0,.9fr) minmax(0,1.1fr);gap:clamp(24px,5vw,70px);align-items:center;padding-block:52px }
.welcome-copy { position:relative;padding:clamp(22px,3vw,38px);overflow:hidden;border-radius:16px;background:var(--deep);color:#f6f8ef }
.welcome-copy::after { content:"“";position:absolute;top:-39px;right:17px;color:#ffffff0d;font:250px/.9 var(--serif);pointer-events:none }
.welcome-copy .eyebrow { color:#d9e5c9 }
.welcome-copy h2 { position:relative;z-index:1;max-width:12ch;font-size:clamp(40px,4.4vw,61px) }
.welcome-message { position:relative;z-index:1;margin-top:18px;color:#e8eee1;font-size:16px;line-height:1.65 }
.welcome-author { position:relative;z-index:1;display:flex;align-items:center;gap:11px;margin-top:22px;padding-top:17px;border-top:1px solid #ffffff30 }
.welcome-monogram { display:grid;place-items:center;width:43px;height:43px;flex:none;border-radius:50%;background:var(--lime);color:var(--deep);font-size:14px;font-weight:850 }
.welcome-author strong,.welcome-author small { display:block }
.welcome-author strong { font-size:14px }
.welcome-author small { margin-top:2px;color:#d3ddcf;font-size:12px }
.staff-heading { display:flex;justify-content:space-between;align-items:end;gap:10px;margin-bottom:13px }
.staff-heading h3 { font:400 clamp(31px,3.4vw,45px)/1 var(--serif);letter-spacing:-.025em }
.staff-heading p { max-width:22ch;color:var(--muted);font-size:12px;text-align:right }
.staff-list { display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px }
.staff-card { display:grid;grid-template-columns:39px minmax(0,1fr);align-items:center;gap:10px;min-height:68px;padding:10px;background:#fff;border:1px solid #d6e1d2;border-radius:11px }
.staff-mark { display:grid;place-items:center;width:39px;height:39px;border-radius:10px;background:#e7f0dc;color:#315b39;font-size:12px;font-weight:850 }
.staff-card strong,.staff-card small { display:block }
.staff-card strong { font-size:13px;line-height:1.25 }
.staff-card small { margin-top:3px;color:var(--muted);font-size:11px;line-height:1.3 }
.staff-card.is-placeholder { background:#f8faf6;border-style:dashed }
.staff-card.is-placeholder .staff-mark { background:#edf1e9;color:#879184 }
.staff-card.is-placeholder strong { color:#697369 }
.welcome-sources { display:flex;flex-wrap:wrap;gap:12px;margin-top:12px }
.welcome-sources a { color:var(--muted);font-size:11px;text-decoration:underline;text-underline-offset:2px }
.services { display:grid;grid-template-columns:minmax(0,.8fr) minmax(0,1.2fr);gap:clamp(25px,5.5vw,83px);align-items:start }
.section-side h2 { max-width:10ch }
.section-side>p:not(.eyebrow),.profile>div>p:not(.eyebrow) { color:var(--muted);margin:15px 0;max-width:42ch }
.text-link { display:inline-flex;width:fit-content;align-items:center;gap:6px;color:var(--green);font-size:14px;font-weight:800 }
.text-link:hover { text-decoration:underline;text-underline-offset:4px }
.service-list { display:grid;gap:9px }
details { background:#fff;border:1px solid var(--line);border-radius:13px }
details[open] { border-color:#a8bf9f }
summary { cursor:pointer;list-style:none;padding:13px 16px;display:grid;grid-template-columns:auto 1fr auto;align-items:center;gap:11px;border-radius:12px }
summary::-webkit-details-marker { display:none }
summary:hover { background:#f4f8ee }
summary small { font-size:12px;color:var(--muted);margin-top:2px }
.expand { width:30px;height:30px;display:grid;place-items:center;border:1px solid var(--line);border-radius:50% }
.expand svg { width:16px;height:16px;transition:transform .18s }
details[open] .expand { color:white;background:var(--green);border-color:var(--green) }
details[open] .expand svg { transform:rotate(180deg) }
.detail-body { padding:0 18px 15px 70px;color:var(--muted);font-size:14px }
.detail-body .text-link { margin-top:7px }
.verification-note,.budget-status { display:flex;align-items:flex-start;gap:7px;color:var(--muted);font-size:12px;line-height:1.5 }
.verification-note { padding:3px 1px }
.verification-note svg,.budget-status svg { width:16px;height:16px;margin-top:1px }
.civic-band { background:#eaf0e5;border-block:1px solid #dfe7da }
.civic-grid { display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:clamp(25px,5.5vw,82px) }
.civic-grid h2,.community h2 { font-size:clamp(46px,5vw,72px) }
.timeline { display:grid;margin:27px 0 0 5px;border-left:1px solid #b0c3ab;gap:21px }
.timeline article { position:relative;padding-left:21px }
.timeline article::before { position:absolute;content:"";top:7px;left:-5px;width:9px;height:9px;border-radius:50%;background:#58835a;box-shadow:0 0 0 3px #eaf0e5 }
.timeline time { font-size:12px;font-weight:750;color:var(--muted);margin-right:8px }
.status { display:inline-block;border-radius:20px;background:#f4e9ce;color:#735327;font-size:11px;font-weight:750;padding:2px 8px }
.status.green { background:#d8e7d4;color:#315836 }
.timeline h3,.community-card h3,.budget-head h3 { font-size:20px;line-height:1.2;letter-spacing:-.025em }
.timeline h3 { margin-top:8px }
.timeline p,.community-card p,.community-card li { color:var(--muted);font-size:14px }
.timeline p { margin:5px 0 }
.budget-card { margin-top:24px;background:#fff;border:1px solid #d4dfd0;border-radius:15px;padding:18px }
.budget-head { display:flex;align-items:center;gap:12px }
.budget-head .icon { background:var(--green);color:var(--lime) }
.budget-head p { color:var(--muted);font-size:12px;margin-top:4px }
.budget-card dl { margin-block:14px }
.budget-card dl div { border-top:1px solid var(--line);padding:8px 0 }
.budget-card dt { font-size:14px;font-weight:800 }
.budget-card dd { font-size:13px;color:var(--muted) }
.budget-status { background:#eef3e9;border-radius:7px;padding:8px;margin-bottom:10px }
.community-grid { display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:13px;margin-top:24px }
.community-card { background:#fff;border:1px solid var(--line);border-radius:15px;padding:19px }
.community-card h3 { margin:12px 0 8px }
.community-card .text-link { margin-top:8px }
.community-card.proposal { background:#f6f0e1;border-color:#e8ddc5 }
.proposal-form { margin-top:14px }
.proposal-form>p { color:var(--muted);font-size:14px }
.proposal-fields { display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:11px;margin-top:15px }
.proposal-fields label { display:grid;gap:5px;color:var(--ink);font-size:12px;font-weight:750 }
.proposal-fields label span { display:inline;color:var(--muted);font-weight:500 }
.proposal-fields input,.proposal-fields select,.proposal-fields textarea { width:100%;min-height:42px;border:1px solid #aabbaa;border-radius:8px;background:#fff;padding:9px 10px;color:var(--ink);font:500 14px var(--sans) }
.proposal-fields textarea { resize:vertical }
.proposal-fields input:focus,.proposal-fields select:focus,.proposal-fields textarea:focus { outline:3px solid #dbe7cf;border-color:#668461 }
.proposal-description { grid-column:1/-1 }
.proposal-trap { position:absolute;left:-10000px;width:1px;height:1px;overflow:hidden }
.proposal-submit { display:flex;align-items:center;gap:12px;margin-top:12px }
.proposal-submit p { margin:0;color:var(--green);font-size:13px }
.proposal-widget { position:fixed;right:24px;bottom:24px;z-index:12;display:grid;justify-items:end;gap:10px }
.proposal-chat-toggle { display:inline-flex;align-items:center;gap:9px;min-height:54px;padding:0 18px;border:0;border-radius:999px;background:var(--deep);color:#f8faee;font:750 14px var(--sans);box-shadow:0 10px 26px #102c2640;cursor:pointer }
.proposal-chat-toggle:hover { background:#205445;transform:translateY(-2px) }
.proposal-chat-toggle svg { color:var(--lime) }
.proposal-chat-panel { width:min(410px,calc(100vw - 32px));height:min(650px,calc(100dvh - 112px));min-height:min(430px,calc(100dvh - 112px));overflow:hidden;display:grid;grid-template-rows:auto auto minmax(0,1fr) auto auto;background:#fff;border:1px solid #d6e1d2;border-radius:17px;box-shadow:0 20px 60px #102c2630 }
.proposal-chat-panel[hidden] { display:none }
.proposal-chat-header { display:flex;align-items:center;justify-content:space-between;gap:12px;padding:14px 16px;background:var(--deep);color:#fff }
.proposal-chat-heading { display:flex;align-items:center;gap:10px }
.proposal-chat-avatar { display:grid;place-items:center;width:39px;height:39px;border-radius:50%;background:var(--lime);color:var(--deep) }
.proposal-chat-avatar svg { width:19px;height:19px }
.proposal-chat-heading strong,.proposal-chat-heading small { display:block }
.proposal-chat-heading strong { font-size:14px }
.proposal-chat-heading small { margin-top:2px;color:#d5e2d3;font-size:11px }
.proposal-chat-close { display:grid;place-items:center;width:36px;height:36px;border:1px solid #ffffff45;border-radius:50%;background:transparent;color:#fff;cursor:pointer }
.proposal-chat-close:hover { background:#ffffff18 }
.proposal-chat-progress { padding:8px 14px;background:#f5f8f2;border-bottom:1px solid var(--line);color:var(--muted);font-size:11px;font-weight:750 }
.proposal-chat-content { display:grid;grid-template-rows:auto minmax(0,1fr);min-height:0 }
.proposal-chat-log { display:flex;flex-direction:column;gap:10px;overflow-y:auto;padding:14px;background:#f7f9f5;overscroll-behavior:contain }
.proposal-chat-bubble { max-width:88%;padding:10px 12px;border-radius:13px;font-size:13px;line-height:1.5;overflow-wrap:anywhere;white-space:pre-wrap }
.proposal-chat-bubble.bot { align-self:start;background:#fff;border:1px solid #e1e8de;border-bottom-left-radius:4px;color:var(--ink) }
.proposal-chat-bubble.user { align-self:end;background:#dce9d4;border-bottom-right-radius:4px;color:#213a2b }
.proposal-chat-bubble.notice { align-self:center;background:#f5f0e3;color:#6f572d;font-size:12px;text-align:center }
.proposal-chat-choice-list { display:grid;gap:8px;margin-top:8px }
.proposal-chat-choice { min-height:46px;padding:10px 12px;border:1px solid #cbd8c7;border-radius:9px;background:#fff;color:var(--green);font:700 13px var(--sans);text-align:left;cursor:pointer }
.proposal-chat-choice:hover,.proposal-chat-choice:focus-visible { border-color:#668461;background:#f0f4ed }
.proposal-chat-summary { display:grid;gap:7px;margin-top:8px }
.proposal-chat-summary div { padding-top:6px;border-top:1px solid var(--line) }
.proposal-chat-summary strong,.proposal-chat-summary span { display:block }
.proposal-chat-summary strong { color:var(--muted);font-size:10px }
.proposal-chat-summary span { margin-top:2px;white-space:pre-wrap;overflow-wrap:anywhere }
.proposal-chat-form { padding:12px 14px 14px;border-top:1px solid var(--line);background:#fff }
.proposal-chat-field { display:grid;gap:6px }
.proposal-chat-field label { color:var(--ink);font-size:12px;font-weight:750 }
.proposal-chat-field input,.proposal-chat-field select,.proposal-chat-field textarea { width:100%;min-height:43px;border:1px solid #aabbaa;border-radius:9px;background:#fff;padding:10px 11px;color:var(--ink);font:500 14px var(--sans) }
.proposal-chat-field textarea { min-height:88px;resize:vertical }
.proposal-chat-field input:focus,.proposal-chat-field select:focus,.proposal-chat-field textarea:focus { outline:3px solid #dbe7cf;border-color:#668461 }
.proposal-chat-actions { display:grid;grid-template-columns:repeat(2,minmax(0,1fr));grid-template-areas:"send cancel" "extra extra";gap:7px;margin-top:10px }
.proposal-chat-actions .button,.proposal-chat-skip,.proposal-chat-edit,.proposal-chat-cancel { display:grid;place-items:center;width:100%;min-height:39px;padding:7px 10px;border:0;border-radius:8px;background:#e8f0e5;color:#315b39;font:700 12px var(--sans);cursor:pointer;box-shadow:none }
.proposal-chat-send { grid-area:send }
.proposal-chat-cancel { grid-area:cancel }
.proposal-chat-skip,.proposal-chat-edit { grid-area:extra }
.proposal-chat-actions .button:hover,.proposal-chat-skip:hover,.proposal-chat-edit:hover { background:#dce9d6 }
.proposal-chat-cancel { background:#f4eee3;color:#765a36 }
.proposal-chat-cancel:hover { background:#eee2ce }
.proposal-chat-restart { min-height:41px;padding:8px 11px;border:1px solid #cbd8c7;border-radius:9px;background:#fff;color:var(--green);font:700 12px var(--sans);cursor:pointer }
.proposal-chat-restart:hover { background:#f0f4ed }
.proposal-chat-send:disabled { opacity:.65;cursor:wait }
.proposal-chat-error { margin-top:8px;color:#9b342a;font-size:12px }
.proposal-chat-restart { display:none;margin:0 14px 12px }
.proposal ol { margin:0;padding-inline-start:20px }
.proposal li+li { margin-top:4px }
.location-panel { border-radius:18px;padding:28px;background:var(--deep);color:#f6f8ef;display:flex;gap:24px;justify-content:space-between;align-items:center }
.location-info { display:flex;align-items:center;gap:17px }
.location-info>.icon { background:#ffffff16;color:var(--lime);width:52px;height:52px }
.location h2 { font-size:clamp(38px,4vw,60px) }
.location-info p:not(.eyebrow) { color:#e0ebde;margin-top:7px;font-size:14px }
.location-actions { display:grid;gap:9px;justify-items:start }
.location .text-link { color:#eaf4d2 }
.location-map { margin-top:14px;overflow:hidden;border:1px solid var(--line);border-radius:18px;background:#eaf0e5 }
.location-map iframe { display:block;width:100%;height:clamp(320px,48vw,450px);border:0 }
.profile { display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:clamp(26px,5vw,75px);align-items:center }
.profile h2 { font-size:clamp(46px,5vw,72px) }
.profile-photo { position:relative;overflow:hidden;border-radius:15px }
.profile-photo img { aspect-ratio:1.85;height:auto }
.profile-photo figcaption { position:absolute;bottom:10px;left:10px;background:#1b2421e5;color:#fff;border-radius:7px;padding:6px 8px;font-size:12px }
.profile-photo svg { width:14px;height:14px }
.profile .text-link { display:flex;margin-top:7px }
.site-footer { border-top:1px solid var(--line);padding:24px 0 30px;background:#edf2e9 }
.footer-row { display:flex;align-items:center;justify-content:space-between;gap:15px }
.credits { margin-top:19px;font-size:12px;color:var(--muted) }
.credits a { text-decoration:underline;text-underline-offset:2px }
.powered-by { margin:18px 0 0;text-align:center;font-size:11px;color:var(--muted) }
.powered-by a { color:var(--green-800);font-weight:700;text-decoration:underline;text-underline-offset:2px }
@media(max-width:1000px) {
  .shell { width:min(100% - 48px,1260px) }
  .quick-card { grid-template-columns:auto 1fr;padding:10px;gap:8px }
  .quick-arrow { display:none }
  nav { gap:12px }
}
@media(max-width:820px) {
  [id] { scroll-margin-top:81px }
  .shell { width:calc(100% - 36px) }
  .header-row { min-height:65px;flex-wrap:nowrap;gap:4px }
  .brand { min-width:0;flex:1 1 auto;gap:6px }
  .brand>span:last-child { min-width:0 }
  .brand small { overflow:hidden;text-overflow:ellipsis;white-space:nowrap }
  .brand-mark { width:39px;height:39px }
  .js .menu-toggle { display:inline-flex;min-height:40px;flex:none;align-items:center;gap:4px;white-space:nowrap;background:#e8efe4;border:1px solid var(--line);border-radius:8px;padding:6px 7px;font-size:13px;font-weight:750 }
  nav { width:100%;flex-direction:column;align-items:stretch;gap:0;padding:7px 0 12px }
  .js nav { display:none }
  .js nav.is-open { display:flex }
  nav>a { padding:9px 0 }
  nav .nav-action { margin-top:4px;align-self:start }
  .hero { padding-top:13px }
  .hero-frame { min-height:456px;border-radius:17px }
  .hero-body { padding-bottom:73px }
  h1 { font-size:clamp(76px,13vw,112px) }
  .section-space { padding-block:49px }
  .services,.civic-grid { grid-template-columns:1fr;gap:24px }
  .section-side h2 { max-width:none }
  .welcome { grid-template-columns:1fr;gap:24px;padding-block:40px }
  .village-index { grid-template-columns:1fr;gap:22px }
  .village-index h2 { max-width:none }
}
@media(max-width:590px) {
  .hero-frame { min-height:490px;align-items:flex-start }
  .hero-frame::after { background:linear-gradient(90deg,#102c26ed,#102c2683 78%,#102c2652),linear-gradient(0deg,#102c26bf,transparent 42%) }
  .hero-photo { object-position:57% center }
  .hero-body { padding:32px 22px 75px }
  .hero-body>p:not(.eyebrow) { font-size:15px;max-width:30ch }
  .hero-label { right:11px;bottom:11px }
  .quick { grid-template-columns:repeat(2,minmax(0,1fr));gap:7px }
  .quick-card { min-height:69px;border-radius:10px;padding:8px;gap:7px }
  .quick-card .icon { width:34px;height:34px;border-radius:8px }
  .quick-card .icon svg { width:17px;height:17px }
  .quick-card strong { font-size:12px }
  .quick-card small { font-size:10px }
  .community-grid,.profile { grid-template-columns:1fr }
  .staff-list { grid-template-columns:1fr }
  .index-dimensions { grid-template-columns:1fr }
  .index-method { grid-column:auto }
  .proposal-fields { grid-template-columns:1fr }
  .proposal-description { grid-column:auto }
  .location-panel { flex-direction:column;align-items:flex-start;gap:15px;padding:19px }
  .proposal-widget { right:12px;bottom:max(12px,env(safe-area-inset-bottom));gap:8px }
  .proposal-chat-panel { width:min(410px,calc(100vw - 24px));height:min(620px,calc(100dvh - 92px));min-height:min(390px,calc(100dvh - 92px)) }
  .proposal-chat-toggle { min-height:49px;padding-inline:15px;font-size:13px }
  .location-info { align-items:flex-start;gap:10px }
  .location-info>.icon { width:34px;height:34px }
  .location-info>.icon svg { width:18px;height:18px }
  .profile-photo { grid-row:2 }
}
@media(max-width:360px) {
  .shell { width:calc(100% - 24px) }
  .hero-body { padding-inline:17px }
  h1 { font-size:67px }
  .quick-card .icon { width:29px;height:29px }
  .brand small,.footer-row>.text-link { font-size:10px }
}
@media(prefers-reduced-motion:reduce) {
  *,*::before,*::after { scroll-behavior:auto!important;transition:none!important }
}
  [hidden] { display:none!important }
.transparency-band { background:#eaf0e5;border-block:1px solid #dfe7da }
.village-index { display:grid;grid-template-columns:minmax(0,.78fr) minmax(0,1.22fr);gap:clamp(25px,5vw,72px);align-items:start }
.village-index h2 { max-width:9ch;font-size:clamp(46px,5vw,72px) }
.village-index-intro { max-width:40ch;margin-top:14px;color:var(--muted) }
.index-status { display:inline-flex;align-items:center;gap:8px;margin-top:20px;padding:8px 11px;border:1px solid #e5d7b7;border-radius:8px;background:#f6f0e1;color:#71562d;font-size:12px;font-weight:800 }
.index-status::before { content:"";width:7px;height:7px;border-radius:50%;background:#ba8d3c }\n.sample-label { display:inline-flex;align-items:center;width:max-content;margin-top:12px;padding:5px 8px;border-radius:999px;background:#eaf0e5;color:var(--green);font-size:11px;font-weight:800;line-height:1.2 }
.index-source { display:flex;flex-wrap:wrap;gap:14px;margin-top:12px }
.index-dimensions { display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:9px }
.index-dimension { min-width:0;padding:15px;background:#fff;border:1px solid var(--line);border-radius:12px }
.index-dimension-top { display:flex;justify-content:space-between;align-items:start;gap:10px }
.index-dimension h3 { max-width:20ch;font-size:15px;line-height:1.3 }
.index-dimension strong { flex:none;color:var(--green);font-size:14px }
.index-dimension p { margin-top:8px;color:var(--muted);font-size:12px;line-height:1.45 }
.index-weight { height:4px;margin-top:12px;overflow:hidden;border-radius:4px;background:#edf1e9 }
.index-weight span { display:block;height:100%;border-radius:inherit;background:#6c9061 }
.index-method { grid-column:1/-1;margin-top:2px;color:var(--muted);font-size:12px;line-height:1.5 }
.index-method strong { color:var(--ink) }
.transparency-heading,.board-heading { display:flex;align-items:end;justify-content:space-between;gap:16px }
.transparency-heading>p,.projects-intro { color:var(--muted);max-width:42ch }
.transparency-links { display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:24px }
.transparency-links a { display:grid;grid-template-columns:auto minmax(0,1fr) auto;align-items:center;gap:12px;background:var(--deep);color:#f8faee;border:1px solid var(--deep);padding:15px;border-radius:13px }
.transparency-links a:hover { background:#205445 }
.transparency-links a:focus-visible { outline-color:#436b39 }
.transparency-links a>svg { color:var(--lime) }
.transparency-links strong,.transparency-links small { display:block }
.transparency-links small { color:#e0ebde;margin-top:3px }
.budget-board { margin-top:22px;padding:clamp(16px,2.7vw,32px);background:#fff;border:1px solid #d6e1d2;border-radius:17px }
.board-heading h3 { margin:4px 0 0;font:400 clamp(41px,4.7vw,65px)/.98 var(--serif);letter-spacing:-.025em }
.board-heading>.text-link { margin-bottom:3px }
.select-control { display:grid;gap:4px;color:var(--ink);font-size:12px;font-weight:800 }
.select-control select,.clear-filters { min-height:43px;padding:8px 11px;background:white;border:1px solid #aabbaa;border-radius:8px;color:var(--ink);font:600 14px var(--sans) }
.select-control select { width:100%;cursor:pointer }
.budget-notice { display:flex;gap:8px;align-items:start;margin-top:18px;color:var(--muted);font-size:14px }
.budget-notice svg,.project-address svg { width:16px;height:16px;margin-top:2px }
.budget-metrics { display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-top:12px }
.budget-metrics div { background:#f1f5ee;border:1px solid #e2eade;border-radius:9px;padding:12px }
.budget-metrics dt,.project-details dt { color:var(--muted);font-size:12px }
.budget-metrics dd,.project-details dd { font-weight:750 }
.allocation { display:flex;align-items:center;justify-content:space-between;gap:16px;margin-top:15px;padding:15px;background:#e7f0e1;border-radius:11px }
.allocation h4 { margin:4px 0 1px;font-size:17px }
.allocation p:not(.eyebrow) { color:var(--muted);font-size:13px }
.allocation .text-link { margin-top:5px;font-size:13px }
.allocation strong { font-size:clamp(23px,4vw,40px);letter-spacing:-.04em;line-height:1.1;color:var(--green);white-space:nowrap }
.board-docs { margin-top:12px }
.board-docs dl { display:grid;gap:8px;margin-bottom:8px }
.board-docs dt { color:var(--ink);font-weight:800 }
.project-board { margin-top:42px }
.projects-intro { margin-top:8px;max-width:68ch }
.project-filters { display:grid;grid-template-columns:repeat(3,minmax(0,1fr)) auto;align-items:end;gap:10px;margin-top:19px;background:#f7faf5;border:1px solid #d6e1d2;border-radius:11px;padding:12px }
.clear-filters { cursor:pointer;color:var(--green);font-weight:750 }
.clear-filters:hover { background:#e6eee1 }
.project-count { margin-top:12px;color:var(--muted);font-size:13px }
.project-grid { display:grid;grid-template-columns:repeat(3,minmax(0,1fr));align-items:start;gap:12px;margin-top:10px }
.project-card { min-width:0;background:#fff;border:1px solid #d6e1d2;border-radius:14px;padding:15px }
.project-card:has(.project-details[open]) { position:relative;z-index:2 }
.project-top { display:flex;justify-content:space-between;align-items:center;gap:7px }
.project-top .status { line-height:1.35;text-align:center }
.project-card h4 { margin:12px 0 2px;font-size:20px;letter-spacing:-.02em;line-height:1.2 }
.project-address { display:flex;align-items:flex-start;gap:4px;font-size:13px;color:var(--muted) }
.project-summary { display:flex;flex-wrap:wrap;gap:5px 16px;margin:12px 0;padding:9px 0;border-block:1px solid var(--line);font-size:12px;color:var(--muted) }
.project-summary strong { margin-left:3px;color:var(--ink) }
.project-details { position:relative;border:0;background:#f0f4ed;border-radius:8px }
.project-details summary { grid-template-columns:1fr auto;padding:7px 9px;min-height:44px;font-size:13px;font-weight:800 }
.project-details-body { position:absolute;top:calc(100% + 6px);left:0;right:0;z-index:3;padding:10px 12px 12px;background:#fff;border:1px solid #cbd8c7;border-radius:10px;box-shadow:0 12px 28px #20352a2b;font-size:13px }
.project-details-body>p { margin-bottom:7px;color:var(--muted) }
.project-details dl { display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:7px 8px;margin-bottom:9px }
.project-details .text-link { flex-wrap:wrap;font-size:12px }
.empty-projects { margin-top:14px;padding:14px;background:#f7faf5;border:1px dashed #aabbaa;border-radius:9px;color:var(--muted) }
@media(max-width:930px) { .project-grid { grid-template-columns:repeat(2,minmax(0,1fr)) } }
@media(max-width:620px) {
  .transparency-heading,.allocation { flex-direction:column;align-items:start;gap:8px }
  .transparency-links { grid-template-columns:1fr;margin-top:16px;gap:7px }
  .board-heading { align-items:start;flex-direction:column;gap:11px }
  .budget-metrics div { padding:7px }
  .budget-metrics dd { font-size:12px }
  .project-filters { grid-template-columns:repeat(2,minmax(0,1fr));gap:8px }
  .project-grid { grid-template-columns:1fr;gap:9px }
}

  @media(max-width:820px){.village-index{grid-template-columns:1fr;gap:22px}.village-index h2{max-width:none}}
@media(max-width:590px){.index-dimensions{grid-template-columns:1fr}.index-method{grid-column:auto}.budget-metrics{grid-template-columns:1fr;gap:8px}.budget-metrics div{min-width:0;padding:10px}.budget-metrics dt{font-size:13px}.budget-metrics dd{font-size:13px;overflow-wrap:anywhere}.index-dimension p{font-size:14px}.project-details dt{font-size:13px}.project-details dd{font-size:13px}.proposal-chat-toggle{display:grid;width:50px;height:50px;min-height:50px;place-items:center;padding:0;border-radius:50%}.proposal-chat-toggle span{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap}}
        </style>
  <title>Desa Curahsawo | Portal Warga | LinkGo</title>
    @include('desa.partials.favicon')
  @include('desa.partials.village-logo-styles')
</head>
<body>
  <svg class="symbols" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <symbol id="logo" viewBox="0 0 32 32"><path d="M3 19 12 9l5 6 3-4 9 8M3 24c4 0 4-2 8-2s4 2 8 2 5-2 10-2M3 28c4 0 4-2 8-2s4 2 8 2 5-2 10-2"/><circle cx="23.5" cy="6.5" r="2.5"/></symbol>
    <symbol id="arrow" viewBox="0 0 24 24"><path d="M4 12h15m-6-6 6 6-6 6"/></symbol>
    <symbol id="out" viewBox="0 0 24 24"><path d="M6 18 18 6M8 6h10v10"/></symbol>
    <symbol id="pin" viewBox="0 0 24 24"><path d="M20 10c0 6-8 11-8 11s-8-5-8-11a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></symbol>
    <symbol id="document" viewBox="0 0 24 24"><path d="M14 3H6a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8Zm0 0v5h5M8 12h8m-8 4h6"/></symbol>
    <symbol id="message" viewBox="0 0 24 24"><path d="M21 11.5a7.5 7.5 0 0 1-7.5 7.5H7l-4 3V11.5A7.5 7.5 0 0 1 10.5 4h3a7.5 7.5 0 0 1 7.5 7.5ZM8 10h8m-8 4h5"/></symbol>
    <symbol id="leaf" viewBox="0 0 24 24"><path d="M5 14C2 5 15 6 20 3c.5 7-1 14-8 15-3 .5-5-.5-7-4Zm-1 7c3-5 6-8 11-11"/></symbol>
    <symbol id="water" viewBox="0 0 24 24"><path d="M2 10c3 0 3-2 6-2s3 2 6 2 3-2 8-2M2 16c3 0 3-2 6-2s3 2 6 2 3-2 8-2"/></symbol>
    <symbol id="menu" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></symbol>
    <symbol id="close" viewBox="0 0 24 24"><path d="m6 6 12 12M18 6 6 18"/></symbol>

    <symbol id="chart" viewBox="0 0 24 24"><path d="M4 4v16h16M8 15v2m4-7v7m4-11v11"/></symbol>
    <symbol id="id-card" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="9" cy="10" r="2"/><path d="M5.8 16c.7-2.8 5.7-2.8 6.4 0M15 10h3m-3 4h3"/></symbol>
    <symbol id="chevron" viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"/></symbol>
    <symbol id="info" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 11v5m0-8h.01"/></symbol>
  </svg>
<a class="skip" href="#konten">Langsung ke konten</a>
<header class="site-header">
  <div class="shell header-row">
    <a class="brand" href="#beranda" aria-label="Desa Curahsawo, beranda">
      <span class="portal-village-logo" aria-hidden="true"><img src="{{ asset('images/portal-logo.webp') }}" alt="" width="44" height="44"></span>
      <span><strong>Desa Curahsawo</strong><small>Kec. Gending · Probolinggo</small></span>
    </a>
    <button class="menu-toggle" type="button" aria-controls="navigasi" aria-expanded="false"><svg><use href="#menu"/></svg><span>Menu</span></button>
    <nav id="navigasi" aria-label="Navigasi utama">
      <a href="#beranda" aria-current="location">Beranda</a>
      <a href="#sambutan">Sambutan</a>
      <a href="#layanan">Layanan</a>
      <a href="#transparansi">Transparansi</a>
      <a href="#indeks-desa">Indeks Desa</a>
      <a href="#kegiatan">Kegiatan</a>
      <a class="nav-action" href="#lokasi"><svg><use href="#pin"/></svg> Balai Desa</a>
    </nav>
  </div>
</header>
<main id="konten">
  <section class="shell hero" id="beranda" aria-labelledby="judul">
    <div class="hero-frame">
      <picture>
        <source media="(max-width: 600px)" srcset="{{ asset('images/curahsawo-hero-mobile.webp') }}" type="image/webp" width="900" height="1246">
        <img class="hero-photo" src="{{ asset('images/curahsawo-hero.webp') }}" alt="Pesisir Curahsawo dilihat dari Bukit Bentar" width="1920" height="1440" fetchpriority="high">
      </picture>
      <div class="hero-body">
        <p class="eyebrow"><svg><use href="#pin"/></svg> Gending, Kabupaten Probolinggo</p>
        <h1 id="judul">Desa Curahsawo<span>.</span></h1>
        <p>Informasi layanan desa, pembangunan, dan kegiatan warga dalam satu tempat.</p>
        <a class="button lime" href="#layanan">Lihat layanan desa <svg><use href="#arrow"/></svg></a>
      </div>
      <a class="hero-label" href="#profil"><svg><use href="#pin"/></svg><span><strong>Bukit Bentar</strong><small>Curahsawo, Jawa Timur</small></span><svg class="label-arrow"><use href="#out"/></svg></a>
    </div>
    <div class="quick" aria-label="Akses cepat">
      <a class="quick-card" href="#layanan"><span class="icon tone-green"><svg><use href="#document"/></svg></span><span><strong>Layanan balai desa</strong><small>Surat dan administrasi</small></span><svg class="quick-arrow"><use href="#arrow"/></svg></a>
      <a class="quick-card" href="#pembangunan"><span class="icon tone-gold"><svg><use href="#pin"/></svg></span><span><strong>Cek proyek dusun</strong><small>Papan proyek desa</small></span><svg class="quick-arrow"><use href="#arrow"/></svg></a>
      <a class="quick-card" href="#anggaran"><span class="icon tone-blue"><svg><use href="#chart"/></svg></span><span><strong>Lihat Anggaran</strong><small>Alokasi transfer desa</small></span><svg class="quick-arrow"><use href="#arrow"/></svg></a>
      <a class="quick-card" href="#lokasi"><span class="icon tone-rose"><svg><use href="#pin"/></svg></span><span><strong>Lokasi balai desa</strong><small>Alamat dan petunjuk arah</small></span><svg class="quick-arrow"><use href="#arrow"/></svg></a>
    </div>
  </section>

  <div class="welcome-band">
    <section class="shell welcome" id="sambutan" aria-labelledby="sambutan-judul">
      <div class="welcome-copy">
        <p class="eyebrow">Pemerintah Desa Curahsawo</p>
        <h2 id="sambutan-judul">Sambutan Kepala Desa</h2>
        <p class="welcome-message">Mari membangun Curahsawo melalui kolaborasi pemerintah desa dan masyarakat, dengan semangat persaudaraan, gotong royong, dan akhlak mulia untuk mewujudkan desa yang maju, mandiri, dan berbudaya.</p>
        <div class="welcome-author"><span class="welcome-monogram" aria-hidden="true">NI</span><span><strong>Hj. Nikmatul Iza, S.Pd.</strong><small>Kepala Desa Curahsawo</small></span></div>
      </div>
      <div class="staff-panel">
        <div class="staff-heading"><h3>Perangkat desa</h3><p>Melayani warga Curahsawo</p></div>
        <div class="staff-list" aria-label="Kepala desa dan perangkat desa">
          <article class="staff-card"><span class="staff-mark" aria-hidden="true">NI</span><span><strong>Hj. Nikmatul Iza, S.Pd.</strong><small>Kepala Desa</small></span></article>
          <article class="staff-card"><span class="staff-mark" aria-hidden="true">S</span><span><strong>Supandi</strong><small>Sekretaris Desa</small></span></article>
          <article class="staff-card is-placeholder"><span class="staff-mark" aria-hidden="true">＋</span><span><strong>Nama perangkat desa</strong><small>Jabatan dan nama menyusul</small></span></article>
          <article class="staff-card is-placeholder"><span class="staff-mark" aria-hidden="true">＋</span><span><strong>Nama perangkat desa</strong><small>Jabatan dan nama menyusul</small></span></article>
          <article class="staff-card is-placeholder"><span class="staff-mark" aria-hidden="true">＋</span><span><strong>Nama perangkat desa</strong><small>Jabatan dan nama menyusul</small></span></article>
          <article class="staff-card is-placeholder"><span class="staff-mark" aria-hidden="true">＋</span><span><strong>Nama perangkat desa</strong><small>Jabatan dan nama menyusul</small></span></article>
        </div>
      </div>
    </section>
  </div>

  <section class="shell services section-space" id="layanan" aria-labelledby="layanan-judul">
    <div class="section-side">
      <p class="eyebrow">Pelayanan Warga</p>
      <h2 id="layanan-judul">Apa yang perlu Anda urus?</h2>
      <p>Pilih keperluan untuk melihat langkah awal dan kanal yang bisa dihubungi.</p>
      <a class="text-link" href="#lokasi">Lihat lokasi balai desa <svg><use href="#arrow"/></svg></a>
    </div>
    <div class="service-list">
      <details open>
        <summary><span class="icon tone-green"><svg><use href="#document"/></svg></span><span><strong>Surat keterangan desa</strong><small>Mulai dari Balai Desa Curahsawo</small></span><span class="expand"><svg><use href="#chevron"/></svg></span></summary>
        <div class="detail-body"><p>Sebutkan jenis surat dan keperluannya kepada petugas. Tanyakan dokumen pendukung, kebutuhan pengantar RT/RW, dan perkiraan waktu penyelesaian.</p></div>
      </details>
      <details>
        <summary><span class="icon tone-blue"><svg><use href="#id-card"/></svg></span><span><strong>KTP, KK, dan akta</strong><small>Disdukcapil Kabupaten Probolinggo</small></span><span class="expand"><svg><use href="#chevron"/></svg></span></summary>
        <div class="detail-body"><p>Disdukcapil menerbitkan dokumen kependudukan. Tanyakan ke balai desa jika pengajuan Anda memerlukan bantuan atau dokumen pendukung dari desa.</p><a class="text-link" href="https://godigital-disdukcapil.probolinggokab.go.id/">Buka GODiGi Disdukcapil <svg><use href="#out"/></svg></a></div>
      </details>
      <details>
        <summary><span class="icon tone-gold"><svg><use href="#message"/></svg></span><span><strong>Informasi dan pengaduan</strong><small>Balai desa dan SP4N-LAPOR!</small></span><span class="expand"><svg><use href="#chevron"/></svg></span></summary>
        <div class="detail-body"><p>Untuk urusan desa, sampaikan pertanyaan atau keluhan di balai desa. Kanal SP4N-LAPOR! juga tersedia untuk pengaduan pelayanan publik.</p><a class="text-link" href="https://www.lapor.go.id/">Buka SP4N-LAPOR! <svg><use href="#out"/></svg></a></div>
      </details>

    </div>
  </section>

  <div class="transparency-band">
    <section class="shell section-space" id="transparansi" aria-labelledby="transparansi-judul">
      <div class="transparency-heading">
        <div><p class="eyebrow">Informasi Publik</p><h2 id="transparansi-judul">Transparansi desa</h2></div>
        <p>Ringkasan anggaran dan pembangunan Desa Curahsawo.</p>
      </div>
      <div class="transparency-links">
        <a href="#anggaran"><span class="icon tone-blue"><svg><use href="#chart"/></svg></span><span><strong>Lihat Anggaran</strong><small>Ringkasan anggaran dan realisasi</small></span><svg><use href="#arrow"/></svg></a>
        <a href="#pembangunan"><span class="icon tone-gold"><svg><use href="#pin"/></svg></span><span><strong>Cek proyek di dusun Anda</strong><small>Lokasi dan rincian pekerjaan</small></span><svg><use href="#arrow"/></svg></a>
      </div>

      <section class="budget-board" id="anggaran" aria-labelledby="anggaran-judul">
        <div class="board-heading">
          <div><p class="eyebrow">Anggaran Desa</p><h3 id="anggaran-judul">Alokasi Transfer Desa</h3></div>
          <label class="select-control" for="budget-year" hidden><span>Tahun anggaran</span><select id="budget-year"><option value="">Tahun anggaran</option></select></label>
        </div>
        <p class="budget-notice" id="budget-notice" aria-live="polite"><span>Belum tersedia</span></p><dl class="budget-metrics">
          <div><dt>Dana Desa</dt><dd>Belum tersedia</dd></div>
          <div><dt>Alokasi Dana Desa</dt><dd>Belum tersedia</dd></div>
          <div><dt>Bagi Hasil Pajak</dt><dd>Belum tersedia</dd></div>
          <div><dt>Bagi Hasil Retribusi</dt><dd>Belum tersedia</dd></div>
        </dl>
        <details class="board-docs">
          <summary><span class="icon tone-green"><svg><use href="#document"/></svg></span><span><strong>Dokumen yang bisa ditanyakan di balai desa</strong><small>Perencanaan, anggaran, dan pelaksanaan</small></span><span class="expand"><svg><use href="#chevron"/></svg></span></summary>
          <div class="detail-body">
            <dl><div><dt>RKP Desa</dt><dd>Prioritas dan rencana kerja tahunan.</dd></div><div><dt>Peraturan Desa tentang Anggaran</dt><dd>Anggaran beserta perubahan, jika ada.</dd></div><div><dt>Laporan realisasi Anggaran</dt><dd>Pendapatan, belanja, dan pembiayaan yang terealisasi.</dd></div></dl>
            <a class="text-link" href="#lokasi">Petunjuk ke balai desa <svg><use href="#arrow"/></svg></a>
          </div>
        </details>
      </section>

      <section class="project-board" id="pembangunan" aria-labelledby="pembangunan-judul">
        <div class="board-heading">
          <div><p class="eyebrow">Pembangunan Curahsawo</p><h3 id="pembangunan-judul">Papan Proyek Desa</h3></div>
          <a class="text-link" href="#usulan">Cara menyampaikan usulan <svg><use href="#arrow"/></svg></a>
        </div>
        <p class="projects-intro">Pekerjaan dan usulan pembangunan di lingkungan Desa Curahsawo.</p>
        <form class="project-filters" id="project-filters" aria-label="Saring proyek" hidden>
          <label class="select-control"><span>Lokasi</span><select name="lokasi"><option value="">Semua lokasi</option></select></label>
          <label class="select-control"><span>Tahun kegiatan</span><select name="tahun"><option value="">Semua tahun</option></select></label>
          <label class="select-control"><span>Status</span><select name="status"><option value="">Semua status</option></select></label>
          <button class="clear-filters" type="reset">Reset filter</button>
        </form>
        <p class="project-count" id="project-count" aria-live="polite" hidden></p>
        <div class="project-grid portal-mobile-stack" id="project-grid" aria-live="polite" aria-busy="true">
          <p class="portal-data-empty" role="status">Memuat informasi pembangunan…</p>
        </div>
        <p class="empty-projects" id="project-empty" hidden></p>
      </section>
    </section>
  </div>

  <section class="shell section-space village-index" id="indeks-desa" aria-labelledby="indeks-desa-judul">
    <div>
      <p class="eyebrow">Kemajuan &amp; Kemandirian Desa</p>
      <h2 id="indeks-desa-judul">Indeks Desa</h2>
      <p class="village-index-intro">Skor dan status Indeks Desa Curahsawo berdasarkan data resmi.</p>

    </div>
    @include('desa.partials.indeks-desa-result')
  </section>

  <section class="shell section-space community" id="kegiatan" aria-labelledby="kegiatan-judul">
    <div class="section-heading"><p class="eyebrow">Partisipasi Masyarakat</p><h2 id="kegiatan-judul">Kegiatan &amp; usulan warga</h2></div>
    <div class="community-grid">
      <article class="community-card proposal" id="usulan">
        <span class="icon tone-gold"><svg><use href="#message"/></svg></span>
        <h3>Cara menyampaikan usulan</h3>
        <ol><li>Catat kebutuhan, lokasi, dan siapa yang akan mendapat manfaat.</li><li>Sampaikan kepada RT/RW atau tanyakan alurnya di balai desa.</li><li>Tanyakan jadwal musyawarah dan tindak lanjut usulan.</li></ol>
      </article>
      <article class="community-card">
        <span class="icon tone-green"><svg><use href="#leaf"/></svg></span>
        <h3>Kelompok Tani Hutan</h3>
        <p>Perhutani mendukung pembentukan pengurus Kelompok Tani Hutan di Balai Desa Curahsawo pada Agustus 2025. Tanyakan ke balai desa untuk mengetahui kegiatan lanjutan.</p>
      </article>
    </div>
  </section>

  <section class="shell location" id="lokasi" aria-labelledby="lokasi-judul">
    <div class="location-panel">
      <div class="location-info"><span class="icon"><svg><use href="#pin"/></svg></span><div><p class="eyebrow">Kantor Desa</p><h2 id="lokasi-judul">Balai Desa Curahsawo</h2><p>Kecamatan Gending, Kabupaten Probolinggo, Jawa Timur</p></div></div>
      <div class="location-actions">
        <a class="button lime" href="https://www.google.com/maps/dir/?api=1&amp;destination=Balai+Desa+Curahsawo%2C+Gending%2C+Kabupaten+Probolinggo">Buka petunjuk arah <svg><use href="#out"/></svg></a>
        <a class="text-link" href="https://gending.probolinggokab.go.id/">Portal Kecamatan Gending <svg><use href="#out"/></svg></a>
      </div>
    </div>
    <div class="location-map" aria-label="Peta Balai Desa Curahsawo">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7905.9709019083575!2d113.28071619132535!3d-7.791364468914209!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7ab57060cf5df%3A0x3e2e8ab371ee5cf1!2sBalai%20Desa%20Curahsawo!5e0!3m2!1sid!2sid!4v1794390329742!5m2!1sid!2sid" title="Peta Balai Desa Curahsawo" allowfullscreen loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
    </div>
  </section>

  <section class="shell section-space profile" id="profil" aria-labelledby="profil-judul">
    <figure class="profile-photo"><img src="{{ asset('images/curahsawo-profile.webp') }}" alt="Dermaga Pantai Bentar di bawah langit senja" width="1178" height="734" loading="lazy"><figcaption><svg><use href="#pin"/></svg> Pantai Bentar, Curahsawo</figcaption></figure>
    <div>
      <p class="eyebrow">Profil &amp; Potensi Desa</p><h2 id="profil-judul">Pesisir Curahsawo</h2>
      <p>Curahsawo berada di pesisir utara Kabupaten Probolinggo. Bentang pesisirnya mencakup kawasan mangrove, tambak, dan Pantai Bentar.</p>
    </div>
  </section>
</main>
@include('desa.partials.footer', [
    'villageName' => 'Curahsawo',
    'initial' => 'C',
    'theme' => 'curahsawo',
    'instagramUrl' => 'https://www.instagram.com/curahsawo/',
    'links' => [
        ['label' => 'Profil Desa', 'href' => '#profil'],
        ['label' => 'Layanan', 'href' => '#layanan'],
        ['label' => 'Anggaran', 'href' => '#anggaran'],
        ['label' => 'Papan proyek', 'href' => '#pembangunan'],
        ['label' => 'Lokasi kantor', 'href' => '#lokasi'],
    ],
])
<div class="proposal-widget">
  <section class="proposal-chat-panel" id="proposal-chat-panel" role="dialog" aria-labelledby="proposal-chat-title" aria-modal="false" hidden>
    <header class="proposal-chat-header">
      <div class="proposal-chat-heading"><span class="proposal-chat-avatar"><svg><use href="#message"/></svg></span><span><strong id="proposal-chat-title">Kanal warga</strong><small>Layanan, usulan, pengaduan, cek status</small></span></div>
      <button class="proposal-chat-close" id="proposal-chat-close" type="button" aria-label="Tutup formulir"><svg><use href="#close"/></svg></button>
    </header>
    <p class="proposal-chat-progress" id="proposal-chat-progress">Pilih jenis pengajuan</p>
    <div class="proposal-chat-log" id="proposal-chat-log" role="log" aria-live="polite" aria-relevant="additions text"></div>
    <form class="proposal-chat-form" id="proposal-chat-form" hidden>
      <div class="proposal-chat-field" id="proposal-chat-field"></div>
      <p class="proposal-chat-error" id="proposal-chat-error" role="alert" hidden></p>
      <div class="proposal-chat-actions">
        <button class="button lime proposal-chat-send" id="proposal-chat-send" type="submit">Lanjut</button>
        <button class="proposal-chat-skip" id="proposal-chat-skip" type="button" hidden>Lewati</button>
        <button class="proposal-chat-edit" id="proposal-chat-edit" type="button" hidden>Ubah jawaban</button>
        <button class="proposal-chat-cancel" id="proposal-chat-cancel" type="button">Batal</button>
      </div>
    </form>
    <button class="proposal-chat-restart" id="proposal-chat-restart" type="button">Mulai pengajuan baru</button>
  </section>
  <button class="proposal-chat-toggle" id="proposal-chat-toggle" type="button" aria-label="Buka kanal layanan, aspirasi, dan cek status" aria-expanded="false" aria-controls="proposal-chat-panel"><svg><use href="#message"/></svg><span>Kanal warga</span></button>
</div>
<script>
async function applySiteContent(){
  const response=await fetch('/api/desa/curahsawo/content');if(!response.ok)throw new Error('Konten desa tidak dapat dimuat.');const data=await response.json();
  const set=(selector,value)=>{const el=document.querySelector(selector);if(el)el.textContent=value||'Belum tersedia'};
  set('#beranda h1',data.heroTitle);set('.hero-body>p:not(.eyebrow)',data.heroIntro);
  set('#layanan-judul',data.servicesTitle);set('#layanan .section-side>p:not(.eyebrow)',data.servicesIntro);
  set('#transparansi-judul',data.transparencyTitle);set('#transparansi .section-heading>p:not(.eyebrow)',data.transparencyIntro);

  try{const budgetResponse=await fetch('/api/desa/curahsawo/budgets');const budgets=await budgetResponse.json();window.curahsawoBudgets=budgets;const selector=document.querySelector('#budget-year');if(budgets.length&&selector){selector.innerHTML=budgets.map(item=>`<option value="${item.year}">${item.year}</option>`).join('');selector.closest('label').hidden=false;selector.value=String(budgets[0].year);selector.dispatchEvent(new Event('change'))}}catch{}
  set('#pembangunan-judul',data.projectsTitle);set('.projects-intro',data.projectsIntro);
  set('#kegiatan-judul',data.communityTitle);
  set('#lokasi-judul',data.locationTitle);set('.location-info p:not(.eyebrow)',data.locationAddress);
  set('#profil-judul',data.profileTitle);set('#profil h2+p',data.profileIntro);
  const serviceList=document.querySelector('#layanan .service-list');
  if(serviceList){const services=Array.isArray(data.services)?data.services:[];if(services.length){serviceList.replaceChildren(...services.map((item,i)=>{const d=document.createElement('details');if(i===0)d.open=true;const summary=document.createElement('summary');summary.innerHTML='<span class="icon tone-green"><svg><use href="#document"></use></svg></span>';const text=document.createElement('span');const strong=document.createElement('strong');strong.textContent=item.title||'Belum tersedia';const small=document.createElement('small');small.textContent=item.subtitle||'';text.append(strong,small);summary.append(text);summary.insertAdjacentHTML('beforeend','<span class="expand"><svg><use href="#chevron"></use></svg></span>');const body=document.createElement('div');body.className='detail-body';const p=document.createElement('p');p.textContent=item.description||'Belum tersedia';body.append(p);if(item.url){const a=document.createElement('a');a.className='text-link';a.href=item.url;a.textContent='Buka informasi terkait';a.target='_blank';a.rel='noopener noreferrer';body.append(a)}d.append(summary,body);return d}))}else{serviceList.replaceChildren(Object.assign(document.createElement('p'),{className:'portal-data-empty',textContent:'Belum tersedia'}))}}
  const grid=document.querySelector('#project-grid');
  if(grid&&Array.isArray(data.projects)){const projects=data.projects;grid.dataset.loaded='true';grid.setAttribute('aria-busy','false');if(!projects.length){grid.replaceChildren();const empty=document.querySelector('#project-empty');empty.textContent='Belum ada informasi pembangunan yang dapat ditampilkan.';empty.hidden=false;}else{const locationSelect=document.querySelector('#project-filters [name=lokasi]'),yearSelect=document.querySelector('#project-filters [name=tahun]'),statusSelect=document.querySelector('#project-filters [name=status]');for(const [select,values] of [[locationSelect,[...new Set(projects.map(project=>project.location).filter(Boolean))]],[yearSelect,[...new Set(projects.map(project=>String(project.year||'')).filter(Boolean))]],[statusSelect,[...new Set(projects.map(project=>project.status).filter(Boolean))]]]){for(const value of values){const option=document.createElement('option');option.value=value;option.textContent=value;select.append(option)}}grid.replaceChildren(...projects.map(project=>{const card=document.createElement('article');card.className='project-card';card.dataset.location=project.location||'';card.dataset.year=project.year||'';card.dataset.status=project.status||'';card.innerHTML='<div class="project-top"><span class="icon tone-green"><svg><use href="#document"></use></svg></span><span class="status green"></span></div><h4></h4><p class="project-address"><svg><use href="#pin"></use></svg></p><div class="project-summary"><span>Tahun <strong class="year"></strong></span><span>Anggaran <strong class="summary"></strong></span></div><details class="project-details"><summary><span>Rincian pekerjaan</span><span class="expand"><svg><use href="#chevron"></use></svg></span></summary><div class="project-details-body"><p class="details-copy"></p><dl><div><dt>Volume</dt><dd class="volume"></dd></div><div><dt>Sumber dana</dt><dd>Belum tersedia</dd></div><div><dt>Pelaksana</dt><dd>Belum tersedia</dd></div><div><dt>Jadwal</dt><dd>Belum tersedia</dd></div><div><dt>Progres fisik</dt><dd>Belum tersedia</dd></div><div><dt>Realisasi belanja</dt><dd>Belum tersedia</dd></div></dl></div></details>';card.querySelector('.status').textContent=project.status||'';card.querySelector('h4').textContent=project.title||'';card.querySelector('.project-address').append(document.createTextNode(' '+(project.location||'')));card.querySelector('.year').textContent=project.year||'';card.querySelector('.summary').textContent=project.summary||'Belum tersedia';card.querySelector('.details-copy').textContent=project.details||'';if(!project.details)card.querySelector('.details-copy').hidden=true;card.querySelector('.volume').textContent=project.volume||'Belum tersedia';const source=card.querySelector('.project-details-body');if(project.source){const a=document.createElement('a');a.className='text-link';a.href=project.sourceUrl||'#';a.textContent=project.source+'';a.target='_blank';a.rel='noopener noreferrer';source.append(a)}const details=card.querySelector('.project-details');details.addEventListener('toggle',()=>{if(details.open)document.querySelectorAll('#project-grid .project-details[open]').forEach(other=>{if(other!==details)other.open=false})});return card}));document.querySelector('#project-filters').hidden=false;document.querySelector('#project-count').hidden=false;document.querySelector('#project-empty').hidden=true}}
  const activityCards=document.querySelectorAll('#kegiatan .community-card');if(Array.isArray(data.activities)&&data.activities.length){data.activities.forEach((item,i)=>{const card=activityCards[i];if(!card)return;const heading=card.querySelector('h3');const p=card.querySelector('p');if(heading)heading.textContent=item.title||'';if(p)p.textContent=item.description||item.subtitle||'';const link=card.querySelector('.text-link');if(item.url&&link)link.href=item.url})}
  if(grid&&Array.isArray(data.projects)&&data.projects.length)grid.querySelectorAll('.project-card').forEach((card,index)=>{const p=data.projects[index];const values=[p.volume,p.funding,p.executor,p.schedule,p.progress?`${p.progress}%`:'',p.spent?formatRupiah(p.spent):''];card.querySelectorAll('.project-details-body dd').forEach((cell,i)=>{if(values[i]!==undefined)cell.textContent=values[i]||'Belum tersedia'})});
  const filterForm=document.querySelector('#project-filters');if(filterForm)filterForm.dispatchEvent(new Event('change'));
}
  applySiteContent().catch(()=>{const grid=document.querySelector('#project-grid'),empty=document.querySelector('#project-empty');if(!grid||!empty)return;grid.dataset.loaded='true';grid.setAttribute('aria-busy','false');grid.replaceChildren();empty.textContent='Informasi pembangunan belum dapat dimuat saat ini.';empty.hidden=false});
  const proposalPanel=document.querySelector('#proposal-chat-panel');
  const proposalToggle=document.querySelector('#proposal-chat-toggle');
  const proposalClose=document.querySelector('#proposal-chat-close');
  const proposalLog=document.querySelector('#proposal-chat-log');
  const proposalForm=document.querySelector('#proposal-chat-form');
  const proposalField=document.querySelector('#proposal-chat-field');
  const proposalProgress=document.querySelector('#proposal-chat-progress');
  const proposalSend=document.querySelector('#proposal-chat-send');
  const proposalSkip=document.querySelector('#proposal-chat-skip');
  const proposalEdit=document.querySelector('#proposal-chat-edit');
  const proposalCancel=document.querySelector('#proposal-chat-cancel');
  const proposalRestart=document.querySelector('#proposal-chat-restart');
  const proposalError=document.querySelector('#proposal-chat-error');
  const proposalStepsByFlow={
    usulan:[
    {name:'title',label:'Judul usulan',prompt:'Apa judul singkat untuk kebutuhan yang ingin disampaikan?',type:'text',required:true,maxLength:160,placeholder:'Contoh: Perbaikan jalan dusun'},
    {name:'category',label:'Jenis kebutuhan',prompt:'Usulan ini termasuk kebutuhan yang mana?',type:'select',required:true,options:['Jalan dan lingkungan','Air dan irigasi','Fasilitas umum','Pelayanan desa','Lainnya']},
    {name:'location',label:'Lokasi',prompt:'Di mana lokasi kebutuhan ini? Sebutkan dusun, RT/RW, atau patokan.',type:'text',required:true,maxLength:160,placeholder:'Dusun, RT/RW, atau patokan'},
    {name:'description',label:'Uraian kebutuhan',prompt:'Ceritakan kebutuhan dan dampaknya bagi warga.',type:'textarea',required:true,maxLength:3000,placeholder:'Jelaskan kondisi saat ini dan siapa yang terdampak.'},
    {name:'name',label:'Nama',prompt:'Siapa nama yang boleh dicantumkan pada usulan?',type:'text',required:false,maxLength:120,placeholder:'Nama Anda (opsional)'},
    {name:'contact',label:'Kontak',prompt:'Apa nomor telepon atau kontak yang bisa dihubungi jika perlu klarifikasi?',type:'text',required:false,maxLength:160,placeholder:'Nomor telepon atau kontak lain (opsional)'}
    ],
    permintaan:[
      {name:'category',label:'Layanan atau kategori',prompt:'Pilih layanan yang diperlukan.',type:'select',required:true,options:[]},
      {name:'title',label:'Judul',prompt:'Beri judul singkat untuk permintaan ini.',type:'text',required:true,maxLength:180,placeholder:'Contoh: Permohonan surat keterangan'},
      {name:'description',label:'Rincian',prompt:'Ceritakan kebutuhan atau pengaduan Anda secara singkat.',type:'textarea',required:true,maxLength:3000,placeholder:'Tambahkan informasi yang membantu pemerintah desa memahami permintaan Anda.'},
      {name:'name',label:'Nama',prompt:'Siapa nama yang dapat dicantumkan?',type:'text',required:false,maxLength:120,placeholder:'Nama Anda (opsional)'},
      {name:'contact',label:'Kontak',prompt:'Nomor telepon atau WhatsApp yang bisa dihubungi untuk tindak lanjut?',type:'text',required:true,maxLength:180,placeholder:'Nomor telepon atau WhatsApp'},
      {name:'email',label:'Email',prompt:'Masukkan email jika ingin menerima pembaruan status melalui email.',type:'email',required:false,maxLength:180,placeholder:'Email (opsional)'}
    ]
  };
  const requestFlowOptions=[
    {value:'usulan',label:'Sampaikan usulan warga'},
    {value:'layanan',label:'Ajukan permohonan layanan'},
    {value:'pengaduan',label:'Sampaikan pengaduan'},
    {value:'cek_status',label:'Cek status permintaan'}
  ];
  let proposalAnswers={};
  let proposalStep=0;
  let proposalFlow=null;
  let proposalSessionStarted=false;
  const currentProposalSteps=()=>{
    if(proposalFlow==='cek_status')return [{name:'trackingCode',label:'Kode tiket',prompt:'Masukkan kode tiket 10 karakter untuk melihat status permintaan.',type:'text',required:true,maxLength:10,pattern:'[A-Za-z0-9]{10}',placeholder:'Contoh: A1B2C3D4E5'}];
    const steps=proposalFlow==='usulan'?proposalStepsByFlow.usulan:[...proposalStepsByFlow.permintaan];
    if(proposalFlow!=='usulan'&&proposalAnswers.email)steps.push({name:'notifyByEmail',label:'Pembaruan email',prompt:'Izinkan pemerintah desa mengirim pembaruan status ke email tersebut?',type:'select',required:true,options:[['1','Ya, kirim pembaruan'],['0','Tidak']]});
    return steps;
  };
  const loadServiceOptions=async()=>{
    try{
      const response=await fetch('/api/desa/curahsawo/managed-content',{headers:{'Accept':'application/json'}});
      if(!response.ok)return ['Administrasi kependudukan','Surat keterangan','Informasi layanan','Lainnya'];
      const data=await response.json();
      const services=Array.isArray(data.services)?data.services.map(service=>service.title).filter(Boolean):[];
      return services.length?services:['Administrasi kependudukan','Surat keterangan','Informasi layanan','Lainnya'];
    }catch{return ['Administrasi kependudukan','Surat keterangan','Informasi layanan','Lainnya']}
  };
  const appendChatMessage=(text,kind='bot')=>{
    const bubble=document.createElement('div');bubble.className=`proposal-chat-bubble ${kind}`;bubble.textContent=text;proposalLog.append(bubble);proposalLog.scrollTop=proposalLog.scrollHeight;return bubble;
  };
  const closeProposalChat=()=>{proposalPanel.hidden=true;proposalToggle.setAttribute('aria-expanded','false');proposalToggle.focus()};
  const renderFlowChoice=()=>{
    proposalProgress.textContent='Pilih jenis pengajuan';proposalForm.hidden=false;proposalField.hidden=false;proposalField.replaceChildren();proposalError.hidden=true;proposalSkip.hidden=true;proposalEdit.hidden=true;proposalSend.hidden=true;
    appendChatMessage('Apa yang ingin Anda sampaikan?');
    const choices=document.createElement('div');choices.className='proposal-chat-choice-list';
    requestFlowOptions.forEach(option=>{
      const button=document.createElement('button');button.type='button';button.className='proposal-chat-choice';button.textContent=option.label;
      button.addEventListener('click',async()=>{
        if(option.value==='cek_status'){
          proposalFlow='cek_status';proposalAnswers={kind:option.value};appendChatMessage(option.label,'user');proposalStep=0;proposalSend.hidden=false;renderProposalStep();return;
        }
        proposalFlow=option.value==='usulan'?'usulan':'permintaan';
        proposalAnswers.kind=option.value;
        if(proposalFlow==='permintaan'){
          proposalStepsByFlow.permintaan[0].options=option.value==='layanan'?await loadServiceOptions():['Pelayanan desa','Infrastruktur dan lingkungan','Sosial dan ekonomi','Keamanan dan ketertiban','Lainnya'];
        }
        appendChatMessage(option.label,'user');proposalStep=0;proposalSend.hidden=false;renderProposalStep();
      });
      choices.append(button);
    });
    proposalField.append(choices);
  };
  const renderProposalStep=()=>{
    const steps=currentProposalSteps(),step=steps[proposalStep];
    proposalProgress.textContent=`Pertanyaan ${proposalStep+1} dari ${steps.length}`;
    proposalForm.hidden=false;proposalField.hidden=false;proposalField.replaceChildren();proposalError.hidden=true;proposalSkip.hidden=step.required;proposalEdit.hidden=true;
    proposalSend.textContent=proposalFlow==='cek_status'?'Cek status':proposalStep===steps.length-1?'Tinjau':'Lanjut';
    appendChatMessage(step.prompt);
    const label=document.createElement('label');label.htmlFor=`proposal-answer-${step.name}`;label.textContent=step.required?step.label:`${step.label} (opsional)`;
    let input;
    if(step.type==='select'){
      input=document.createElement('select');
      const placeholder=document.createElement('option');placeholder.value='';placeholder.textContent='Pilih salah satu';placeholder.disabled=true;placeholder.selected=true;input.append(placeholder);
      step.options.forEach(option=>{const value=Array.isArray(option)?option[0]:option,text=Array.isArray(option)?option[1]:option;const item=document.createElement('option');item.value=value;item.textContent=text;input.append(item)});
    } else if(step.type==='textarea') input=document.createElement('textarea');
    else {input=document.createElement('input');input.type='text';}
    input.id=`proposal-answer-${step.name}`;input.name=step.name;input.maxLength=step.maxLength;input.required=step.required;
    if(step.pattern)input.pattern=step.pattern;
    if(step.placeholder)input.placeholder=step.placeholder;
    input.value=proposalAnswers[step.name]||'';
    proposalField.append(label,input);
    input.focus();
  };
  const showProposalReview=()=>{
    const steps=currentProposalSteps(),isRequest=proposalFlow==='permintaan';
    proposalProgress.textContent='Periksa sebelum dikirim';proposalForm.hidden=false;proposalField.hidden=true;proposalError.hidden=true;proposalSkip.hidden=true;proposalEdit.hidden=false;proposalSend.textContent=isRequest?'Kirim permintaan':'Kirim usulan';
    appendChatMessage('Periksa kembali informasi berikut sebelum dikirim.');
    const summary=appendChatMessage('');
    const list=document.createElement('div');list.className='proposal-chat-summary';
    const flowRow=document.createElement('div');const flowHeading=document.createElement('strong');flowHeading.textContent='Jenis pengajuan';const flowValue=document.createElement('span');flowValue.textContent=requestFlowOptions.find(option=>option.value===proposalAnswers.kind)?.label||'';flowRow.append(flowHeading,flowValue);list.append(flowRow);
    steps.forEach(step=>{const row=document.createElement('div');const heading=document.createElement('strong');heading.textContent=step.label;const value=document.createElement('span');value.textContent=step.name==='notifyByEmail'?(proposalAnswers.notifyByEmail==='1'?'Ya, kirim pembaruan':'Tidak'):(proposalAnswers[step.name]||'Tidak diisi');row.append(heading,value);list.append(row)});
    summary.append(list);
  };
  const startProposalChat=()=>{
    proposalAnswers={};proposalStep=0;proposalFlow=null;proposalSessionStarted=true;proposalLog.replaceChildren();proposalForm.hidden=false;proposalRestart.style.display='none';proposalToggle.setAttribute('aria-expanded','true');proposalPanel.hidden=false;renderFlowChoice();
  };
  proposalToggle.addEventListener('click',()=>{
    if(proposalPanel.hidden){if(!proposalSessionStarted)startProposalChat();else{proposalPanel.hidden=false;proposalToggle.setAttribute('aria-expanded','true');const input=proposalPanel.querySelector('.proposal-chat-field input,.proposal-chat-field select,.proposal-chat-field textarea');if(input&&!proposalForm.hidden)input.focus()}}
    else closeProposalChat();
  });
  proposalClose.addEventListener('click',closeProposalChat);
  document.addEventListener('keydown',event=>{if(event.key==='Escape'&&!proposalPanel.hidden)closeProposalChat()});
  proposalForm.addEventListener('submit',async event=>{
    event.preventDefault();
    const steps=currentProposalSteps();
    if(proposalFlow==='cek_status'){
      const input=proposalField.querySelector('input');
      if(!input.reportValidity())return;
      const trackingCode=input.value.trim();proposalAnswers.trackingCode=trackingCode;appendChatMessage(trackingCode,'user');
      proposalSend.disabled=true;proposalError.hidden=true;proposalSend.textContent='Memeriksa…';
      try{
        const response=await fetch(`/api/desa/curahsawo/requests/${encodeURIComponent(trackingCode)}`,{headers:{'Accept':'application/json'}});
        const result=await response.json();
        if(!response.ok)throw new Error(result.message||'Status permintaan belum dapat ditampilkan.');
        appendChatMessage(`${result.title} · Status: ${result.status} · Diperbarui ${result.updatedAt}`);
        if(Array.isArray(result.history)&&result.history.length)appendChatMessage(`Riwayat status: ${result.history.map(entry=>entry.status).join(' > ')}`,'notice');
        proposalProgress.textContent='Status permintaan';proposalForm.hidden=true;proposalRestart.style.display='block';
      }catch(error){proposalError.textContent=error.message;proposalError.hidden=false;proposalSend.textContent='Coba lagi';input.focus()}
      finally{proposalSend.disabled=false;}
      return;
    }
    if(proposalStep<steps.length){
      const step=steps[proposalStep],input=proposalField.querySelector('input,select,textarea');
      if(!input.reportValidity())return;
      const value=input.value.trim();if(step.required&&!value){input.focus();return}
      proposalAnswers[step.name]=value;appendChatMessage(value||'—','user');proposalStep++;
      if(proposalStep<currentProposalSteps().length)renderProposalStep();else showProposalReview();
      return;
    }
    proposalSend.disabled=true;proposalError.hidden=true;proposalSend.textContent='Mengirim…';
    try{
      const isRequest=proposalFlow==='permintaan',endpoint=isRequest?'/api/desa/curahsawo/requests':'/api/desa/curahsawo/proposals';
      const payload=isRequest?{...proposalAnswers,kind:proposalAnswers.kind,website:''}:{...proposalAnswers,website:''};
      const response=await fetch(endpoint,{method:'POST',headers:{'Content-Type':'application/json','Accept':'application/json'},body:JSON.stringify(payload)});
      if(!response.ok){const body=(await response.text()).trim();let message=body;try{message=JSON.parse(body).message||body}catch{}throw new Error(message||'Usulan belum terkirim. Coba lagi.')}
      const result=response.status===204?{}:await response.json();appendChatMessage(result.message||(isRequest?'Permintaan diterima.':'Usulan diterima. Terima kasih telah menyampaikan kebutuhan warga.'));
      if(result.trackingCode)appendChatMessage(`Kode tiket: ${result.trackingCode}. Simpan kode ini untuk memeriksa tindak lanjut.`,'notice');
      proposalProgress.textContent='Pengajuan terkirim';proposalForm.hidden=true;proposalRestart.style.display='block';proposalAnswers={};proposalSessionStarted=true;
    }catch(error){proposalError.textContent=error.message;proposalError.hidden=false;proposalSend.textContent='Coba kirim lagi';}
    finally{proposalSend.disabled=false;}
  });
  proposalSkip.addEventListener('click',()=>{
    const step=currentProposalSteps()[proposalStep];if(!step||step.required)return;
    proposalAnswers[step.name]='';appendChatMessage('Lewati','user');proposalStep++;
    if(proposalStep<currentProposalSteps().length)renderProposalStep();else showProposalReview();
  });
  proposalEdit.addEventListener('click',()=>{appendChatMessage('Mari periksa kembali jawaban dari awal.');proposalStep=0;renderProposalStep()});
  proposalCancel.addEventListener('click',()=>{
    proposalAnswers={};proposalStep=0;proposalFlow=null;proposalForm.hidden=true;proposalError.hidden=true;proposalRestart.style.display='block';proposalProgress.textContent='Pengajuan dibatalkan';appendChatMessage('Pengajuan dibatalkan. Tidak ada data yang dikirim.','notice');
  });
  proposalRestart.addEventListener('click',startProposalChat);
</script>
  <!-- Lisensi font yang disertakan
Copyright 2014 The DM Sans Project Authors (https://github.com/googlefonts/dm-fonts)

This Font Software is licensed under the SIL Open Font License, Version 1.1.
This license is copied below, and is also available with a FAQ at:
https://scripts.sil.org/OFL


-----------------------------------------------------------
SIL OPEN FONT LICENSE Version 1.1 - 26 February 2007
-----------------------------------------------------------

PREAMBLE
The goals of the Open Font License (OFL) are to stimulate worldwide
development of collaborative font projects, to support the font creation
efforts of academic and linguistic communities, and to provide a free and
open framework in which fonts may be shared and improved in partnership
with others.

The OFL allows the licensed fonts to be used, studied, modified and
redistributed freely as long as they are not sold by themselves. The
fonts, including any derivative works, can be bundled, embedded,
redistributed and/or sold with any software provided that any reserved
names are not used by derivative works. The fonts and derivatives,
however, cannot be released under any other type of license. The
requirement for fonts to remain under this license does not apply
to any document created using the fonts or their derivatives.

DEFINITIONS
"Font Software" refers to the set of files released by the Copyright
Holder(s) under this license and clearly marked as such. This may
include source files, build scripts and documentation.

"Reserved Font Name" refers to any names specified as such after the
copyright statement(s).

"Original Version" refers to the collection of Font Software components as
distributed by the Copyright Holder(s).

"Modified Version" refers to any derivative made by adding to, deleting,
or substituting -- in part or in whole -- any of the components of the
Original Version, by changing formats or by porting the Font Software to a
new environment.

"Author" refers to any designer, engineer, programmer, technical
writer or other person who contributed to the Font Software.

PERMISSION & CONDITIONS
Permission is hereby granted, free of charge, to any person obtaining
a copy of the Font Software, to use, study, copy, merge, embed, modify,
redistribute, and sell modified and unmodified copies of the Font
Software, subject to the following conditions:

1) Neither the Font Software nor any of its individual components,
in Original or Modified Versions, may be sold by itself.

2) Original or Modified Versions of the Font Software may be bundled,
redistributed and/or sold with any software, provided that each copy
contains the above copyright notice and this license. These can be
included either as stand-alone text files, human-readable headers or
in the appropriate machine-readable metadata fields within text or
binary files as long as those fields can be easily viewed by the user.

3) No Modified Version of the Font Software may use the Reserved Font
Name(s) unless explicit written permission is granted by the corresponding
Copyright Holder. This restriction only applies to the primary font name as
presented to the users.

4) The name(s) of the Copyright Holder(s) or the Author(s) of the Font
Software shall not be used to promote, endorse or advertise any
Modified Version, except to acknowledge the contribution(s) of the
Copyright Holder(s) and the Author(s) or with their explicit written
permission.

5) The Font Software, modified or unmodified, in part or in whole,
must be distributed entirely under this license, and must not be
distributed under any other license. The requirement for fonts to
remain under this license does not apply to any document created
using the Font Software.

TERMINATION
This license becomes null and void if any of the above conditions are
not met.

DISCLAIMER
THE FONT SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO ANY WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT
OF COPYRIGHT, PATENT, TRADEMARK, OR OTHER RIGHT. IN NO EVENT SHALL THE
COPYRIGHT HOLDER BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
INCLUDING ANY GENERAL, SPECIAL, INDIRECT, INCIDENTAL, OR CONSEQUENTIAL
DAMAGES, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF THE USE OR INABILITY TO USE THE FONT SOFTWARE OR FROM
OTHER DEALINGS IN THE FONT SOFTWARE.


Copyright 2022 The Instrument Serif Project Authors (https://github.com/Instrument/instrument-serif)

This Font Software is licensed under the SIL Open Font License, Version 1.1.
This license is copied below, and is also available with a FAQ at:
https://scripts.sil.org/OFL


-----------------------------------------------------------
SIL OPEN FONT LICENSE Version 1.1 - 26 February 2007
-----------------------------------------------------------

PREAMBLE
The goals of the Open Font License (OFL) are to stimulate worldwide
development of collaborative font projects, to support the font creation
efforts of academic and linguistic communities, and to provide a free and
open framework in which fonts may be shared and improved in partnership
with others.

The OFL allows the licensed fonts to be used, studied, modified and
redistributed freely as long as they are not sold by themselves. The
fonts, including any derivative works, can be bundled, embedded,
redistributed and/or sold with any software provided that any reserved
names are not used by derivative works. The fonts and derivatives,
however, cannot be released under any other type of license. The
requirement for fonts to remain under this license does not apply
to any document created using the fonts or their derivatives.

DEFINITIONS
"Font Software" refers to the set of files released by the Copyright
Holder(s) under this license and clearly marked as such. This may
include source files, build scripts and documentation.

"Reserved Font Name" refers to any names specified as such after the
copyright statement(s).

"Original Version" refers to the collection of Font Software components as
distributed by the Copyright Holder(s).

"Modified Version" refers to any derivative made by adding to, deleting,
or substituting -- in part or in whole -- any of the components of the
Original Version, by changing formats or by porting the Font Software to a
new environment.

"Author" refers to any designer, engineer, programmer, technical
writer or other person who contributed to the Font Software.

PERMISSION & CONDITIONS
Permission is hereby granted, free of charge, to any person obtaining
a copy of the Font Software, to use, study, copy, merge, embed, modify,
redistribute, and sell modified and unmodified copies of the Font
Software, subject to the following conditions:

1) Neither the Font Software nor any of its individual components,
in Original or Modified Versions, may be sold by itself.

2) Original or Modified Versions of the Font Software may be bundled,
redistributed and/or sold with any software, provided that each copy
contains the above copyright notice and this license. These can be
included either as stand-alone text files, human-readable headers or
in the appropriate machine-readable metadata fields within text or
binary files as long as those fields can be easily viewed by the user.

3) No Modified Version of the Font Software may use the Reserved Font
Name(s) unless explicit written permission is granted by the corresponding
Copyright Holder. This restriction only applies to the primary font name as
presented to the users.

4) The name(s) of the Copyright Holder(s) or the Author(s) of the Font
Software shall not be used to promote, endorse or advertise any
Modified Version, except to acknowledge the contribution(s) of the
Copyright Holder(s) and the Author(s) or with their explicit written
permission.

5) The Font Software, modified or unmodified, in part or in whole,
must be distributed entirely under this license, and must not be
distributed under any other license. The requirement for fonts to
remain under this license does not apply to any document created
using the Font Software.

TERMINATION
This license becomes null and void if any of the above conditions are
not met.

DISCLAIMER
THE FONT SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO ANY WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT
OF COPYRIGHT, PATENT, TRADEMARK, OR OTHER RIGHT. IN NO EVENT SHALL THE
COPYRIGHT HOLDER BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
INCLUDING ANY GENERAL, SPECIAL, INDIRECT, INCIDENTAL, OR CONSEQUENTIAL
DAMAGES, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF THE USE OR INABILITY TO USE THE FONT SOFTWARE OR FROM
OTHER DEALINGS IN THE FONT SOFTWARE.

  -->
  <script>
document.documentElement.classList.add("js");

const menu = document.querySelector(".menu-toggle");
const menuIcon = menu.querySelector("use");
const navigation = document.querySelector("#navigasi");
const mobile = window.matchMedia("(max-width: 820px)");

function setMenu(open) {
  menu.setAttribute("aria-expanded", String(open));
  menuIcon.setAttribute("href", open ? "#close" : "#menu");
  navigation.classList.toggle("is-open", open);
}

function markCurrent() {
  const section = location.hash || "#beranda";
  for (const link of navigation.querySelectorAll("a")) {
    if (link.hash === section) {
      link.setAttribute("aria-current", "location");
    } else {
      link.removeAttribute("aria-current");
    }
  }
}

menu.addEventListener("click", () => {
  setMenu(menu.getAttribute("aria-expanded") === "false");
});

navigation.addEventListener("click", (event) => {
  const link = event.target.closest("a");
  if (!link || !mobile.matches) return;

  setMenu(false);
  const destination = document.querySelector(link.hash);
  destination.setAttribute("tabindex", "-1");
  destination.focus({ preventScroll: true });
});

document.addEventListener("keydown", (event) => {
  if (event.key !== "Escape" || menu.getAttribute("aria-expanded") !== "true") return;
  setMenu(false);
  menu.focus();
});

mobile.addEventListener("change", () => setMenu(false));
window.addEventListener("hashchange", markCurrent);
markCurrent();

const yearSelect = document.querySelector("#budget-year");
const budgetNotice = document.querySelector("#budget-notice span");


function showBudgetYear() {
  const year = yearSelect.value;
  const budget = (window.curahsawoBudgets || []).find(item => String(item.year) === year);
  const hasBudgetValues = budget && [budget.villageFund, budget.villageAllocation, budget.taxRevenueShare, budget.retributionShare].some((value) => value > 0);
  if (hasBudgetValues) {
    budgetNotice.textContent = `Alokasi transfer · ${year}`;
  }
  if (budget) {
    if (hasBudgetValues) {
      document.querySelectorAll(".budget-metrics dd").forEach((cell,index) => { cell.textContent = formatRupiah([budget.villageFund,budget.villageAllocation,budget.taxRevenueShare,budget.retributionShare][index]); });
    }

  } else {


  }
}

function formatRupiah(value) {
  return value ? new Intl.NumberFormat("id-ID", { style:"currency",currency:"IDR",maximumFractionDigits:0 }).format(value) : "Belum tersedia";
}

yearSelect.closest("label").hidden = false;
yearSelect.addEventListener("change", showBudgetYear);
showBudgetYear();

const projectFilters = document.querySelector("#project-filters");
const resultCount = document.querySelector("#project-count");
const projectGrid = document.querySelector("#project-grid");
const noProjects = document.querySelector("#project-empty");
const projectSelectors = [...projectFilters.querySelectorAll("select")];

for (const details of document.querySelectorAll("#project-grid .project-details")) {
  details.addEventListener("toggle", () => {
    if (!details.open) return;
    for (const other of document.querySelectorAll("#project-grid .project-details[open]")) {
      if (other !== details) other.open = false;
    }
  });
}

function filterProjects() {
  const [location, year, status] = projectSelectors.map(select => select.value);
  let visible = 0;

  const projectCards = document.querySelectorAll("#project-grid .project-card");
  for (const card of projectCards) {
    const project = card.dataset;
    const matches = (!location || project.location === location)
      && (!year || project.year === year)
      && (!status || project.status === status);
    card.hidden = !matches;
    if (matches) visible += 1;
  }

  const projectsLoaded = projectGrid.dataset.loaded === 'true';
  if (!projectsLoaded) return;
  resultCount.textContent = `${visible} dari ${projectCards.length} kegiatan dan usulan`;
  resultCount.hidden = projectCards.length === 0;
  projectFilters.hidden = projectCards.length === 0;
  noProjects.textContent = projectCards.length === 0
    ? 'Belum ada informasi pembangunan yang dapat ditampilkan.'
    : 'Tidak ada proyek yang cocok dengan filter. Coba pilih lokasi, tahun, atau status lain.';
  noProjects.hidden = visible > 0 && projectCards.length > 0;
}

projectFilters.hidden = true;
resultCount.hidden = true;
projectFilters.addEventListener("change", filterProjects);
projectFilters.addEventListener("submit", event => event.preventDefault());
projectFilters.addEventListener("reset", event => {
  event.preventDefault();
  for (const select of projectSelectors) select.value = "";
  filterProjects();
});
filterProjects();

  </script>
    @include('desa.partials.managed-content')
    @include('desa.partials.responsive')
</body>
</html>
