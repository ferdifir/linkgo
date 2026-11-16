<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f4f0e3">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Desa Gending | Portal Warga | LinkGo</title>
    <meta name="description" content="Informasi layanan, ketahanan pangan, pembangunan, dan kegiatan Desa Gending.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --paper: #f4f0e3;
            --paper-deep: #e8e1cf;
            --white: #fffdf7;
            --ink: #202820;
            --muted: #5d665a;
            --line: #d9d5c7;
            --green: #294b36;
            --green-dark: #1d3729;
            --green-soft: #e2e8dc;
            --orange: #b24a2c;
            --yellow: #e8b744;
            --shadow: 0 14px 35px rgb(33 43 31 / 9%);
            --width: 1180px;
        }
        * { box-sizing: border-box }
        html { scroll-behavior: smooth; scroll-padding-top: 78px }
        body { margin: 0; overflow-x: hidden; color: var(--ink); background: var(--paper); font: 400 15px/1.55 ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif }
        a { color: inherit; text-decoration: none }
        button, input, textarea, select { font: inherit }
        button { cursor: pointer }
        svg { display: block; width: 20px; height: 20px; flex: none }
        .wrap { width: min(var(--width), calc(100% - 48px)); margin-inline: auto }
        .topline { min-height: 35px; color: #f9f4e7; background: var(--green-dark); font-size: 11px }
        .topline-inner { display: flex; min-height: inherit; align-items: center; justify-content: space-between; gap: 16px }
        .topline p { margin: 0 }
        .topline a { color: #f4cb6c; font-weight: 700 }
        .header { position: sticky; top: 0; z-index: 30; border-bottom: 1px solid rgb(41 75 54 / 12%); background: rgb(244 240 227 / 96%); backdrop-filter: blur(14px) }
        .header-inner { display: flex; min-height: 76px; align-items: center; justify-content: space-between; gap: 26px }
        .brand { display: inline-flex; min-width: 214px; align-items: center; gap: 11px }
        .brand-mark { display: grid; width: 43px; height: 43px; place-items: center; border-radius: 50%; color: var(--paper); background: var(--green); font: 700 19px/1 var(--font-sans) }
        .brand-name { display: grid; gap: 1px; line-height: 1.15 }
        .brand-name strong { font: 700 16px/1.1 var(--font-sans); letter-spacing: -.02em }
        .brand-name small { color: var(--muted); font-size: 10px }
        .nav { display: flex; align-items: center; gap: clamp(14px, 2vw, 24px); font-size: 12px; font-weight: 700 }
        .nav a { color: #465246; transition: color .16s ease }
        .nav a:hover { color: var(--orange) }
        .nav .nav-action { padding: 10px 14px; border-radius: 4px; color: #fff; background: var(--orange) }
        .menu-button { display: none; width: 42px; height: 42px; place-items: center; border: 1px solid var(--line); border-radius: 5px; color: var(--ink); background: transparent }
        main { display: block }
        .hero { padding-block: 30px 24px }
        .hero-grid { display: grid; min-height: 420px; grid-template-columns: .88fr 1.12fr; overflow: hidden; border-radius: 8px; background: var(--yellow); box-shadow: var(--shadow) }
        .hero-copy { display: flex; flex-direction: column; align-items: flex-start; justify-content: center; padding: clamp(30px, 5vw, 62px) }
        .eyebrow { display: inline-flex; align-items: center; gap: 8px; color: var(--green); font-size: 10px; font-weight: 900; letter-spacing: .12em; text-transform: uppercase }
        .eyebrow::before { width: 19px; height: 2px; content: ""; background: currentColor }
        .hero h1 { max-width: 10ch; margin: 17px 0 13px; font: 700 clamp(42px, 5.3vw, 68px)/.99 var(--font-sans); letter-spacing: -.055em }
        .hero-copy > p { max-width: 42ch; margin: 0; color: #414337; font-size: 15px; line-height: 1.7 }
        .hero-actions { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 24px }
        .btn { display: inline-flex; min-height: 44px; align-items: center; justify-content: center; gap: 8px; padding: 0 15px; border: 1px solid transparent; border-radius: 4px; font-size: 12px; font-weight: 800; transition: transform .15s ease, background .15s ease }
        .btn:hover { transform: translateY(-1px) }
        .btn-dark { color: #fff; background: var(--green-dark) }
        .btn-light { border-color: rgb(32 40 32 / 25%); color: var(--ink); background: transparent }
        .btn svg { width: 16px; height: 16px }
        .hero-art { position: relative; min-width: 0; min-height: 390px; overflow: hidden; background: #364633 }
        .hero-art::after { position: absolute; inset: 48% 0 0; pointer-events: none; content: ""; background: linear-gradient(0deg, rgb(14 25 17 / 70%), transparent) }
        .hero-art img { position: absolute; inset: 0; display: block; width: 100%; height: 100%; object-fit: cover; object-position: 40% center }
        .hero-caption { position: absolute; right: 18px; bottom: 15px; left: 18px; z-index: 1; color: #fff; font-size: 12px; font-weight: 700; text-shadow: 0 1px 6px rgb(0 0 0 / 35%) }
        .hero-caption a { color: inherit; text-decoration: underline; text-underline-offset: 3px }
        .quick-strip { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); margin-top: 16px; border: 1px solid var(--line); border-radius: 6px; background: var(--white) }
        .quick-item { display: flex; min-height: 76px; align-items: center; gap: 12px; padding: 14px 18px; border-right: 1px solid var(--line) }
        .quick-item:last-child { border: 0 }
        .quick-item > span:first-child { display: grid; width: 37px; height: 37px; place-items: center; border-radius: 50%; color: var(--green); background: var(--green-soft) }
        .quick-item svg { width: 18px; height: 18px }
        .quick-item strong,.quick-item small { display: block }
        .quick-item strong { font-size: 12px }
        .quick-item small { margin-top: 2px; color: var(--muted); font-size: 10px }
        .quick-item small a { text-decoration: underline; text-underline-offset: 2px }
        .section { padding-block: 64px; border-top: 1px solid rgb(41 75 54 / 10%) }
        .section-white { background: var(--white) }
        .section-dark { color: #f7f3e7; background: var(--green-dark) }
        .section-head { display: flex; align-items: end; justify-content: space-between; gap: 24px; margin-bottom: 25px }
        .section-head h2 { margin: 7px 0 0; font: 700 clamp(30px, 3.8vw, 43px)/1.05 var(--font-sans); letter-spacing: -.04em }
        .section-head > p { max-width: 43ch; margin: 0; color: var(--muted); font-size: 13px; line-height: 1.65 }
        .section-dark .section-head > p { color: #c7d2c1 }
        .section-dark .eyebrow { color: #f2c965 }
        .welcome-grid { display: grid; grid-template-columns: 1.1fr .9fr; gap: 30px; align-items: stretch }
        .welcome-note { position: relative; padding: 29px 30px 29px 34px; border-left: 4px solid var(--orange); background: var(--paper) }
        .welcome-note::before { position: absolute; top: 13px; left: 18px; content: "“"; color: rgb(200 86 50 / 25%); font: 700 56px/1 var(--font-sans) }
        .welcome-note blockquote { position: relative; margin: 0; padding-top: 19px; color: #455046; font: 400 17px/1.7 var(--font-sans) }
        .signature { display: flex; align-items: center; gap: 12px; margin-top: 23px }
        .signature-mark { display: grid; width: 43px; height: 43px; place-items: center; border-radius: 50%; color: #fff; background: var(--green); font-weight: 800 }
        .signature strong,.signature small { display: block }
        .signature strong { font-size: 12px }
        .signature small { margin-top: 2px; color: var(--muted); font-size: 10px }
        .staff-panel { padding: 24px; border: 1px solid var(--line); border-radius: 6px; background: #fff }
        .staff-panel h3 { margin: 0 0 14px; font: 700 20px var(--font-sans) }
        .staff-list { display: grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap: 9px }
        .staff-person { display: flex; min-width: 0; align-items: center; gap: 10px; padding: 10px; background: var(--paper) }
        .staff-person .initial { display: grid; width: 34px; height: 34px; flex: none; place-items: center; border-radius: 50%; color: var(--green); background: #dce5d6; font: 700 14px var(--font-sans) }
        .staff-person strong,.staff-person small { display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap }
        .staff-person strong { font-size: 11px }
        .staff-person small { color: var(--muted); font-size: 9px }
        .service-grid { display: grid; grid-template-columns: repeat(4,minmax(0,1fr)); gap: 12px }
        .service-card { display: flex; min-height: 158px; flex-direction: column; padding: 19px; border: 1px solid var(--line); border-radius: 5px; background: var(--white); transition: border-color .15s ease, transform .15s ease }
        .service-card:hover { transform: translateY(-2px); border-color: #a4b59d }
        .service-icon { display: grid; width: 39px; height: 39px; place-items: center; border-radius: 5px; color: var(--green); background: var(--green-soft) }
        .service-icon svg { width: 20px; height: 20px }
        .service-card h3 { margin: 15px 0 4px; font-size: 13px }
        .service-card p { margin: 0; color: var(--muted); font-size: 11px; line-height: 1.55 }
        .service-card button { display: inline-flex; align-items: center; gap: 5px; margin-top: auto; padding: 13px 0 0; border: 0; color: var(--orange); background: transparent; font-size: 10px; font-weight: 800; text-align: left }
        .service-card button svg { width: 13px; height: 13px }
        .bumdes-grid { display: grid; grid-template-columns: .82fr 1.18fr; gap: 26px; align-items: stretch }
        .bumdes-lead { display: flex; flex-direction: column; justify-content: space-between; padding: 27px; border: 1px solid rgb(255 255 255 / 17%); border-radius: 6px; background: #294b36 }
        .bumdes-lead h3 { max-width: 12ch; margin: 16px 0 9px; font: 700 33px/1.04 var(--font-sans); letter-spacing: -.035em }
        .bumdes-lead p { max-width: 42ch; margin: 0; color: #d4dfd1; font-size: 13px; line-height: 1.65 }
        .bumdes-lead .source { margin-top: 23px; color: #f3c963; font-size: 10px; font-weight: 700 }
        .usaha-grid { display: grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap: 11px }
        .usaha-card { display: flex; min-height: 128px; flex-direction: column; justify-content: space-between; padding: 17px; border-radius: 5px; color: var(--ink); background: #f3eddc }
        .usaha-card > span { display: grid; width: 34px; height: 34px; place-items: center; border-radius: 50%; color: var(--green); background: #dfe7d9 }
        .usaha-card svg { width: 18px; height: 18px }
        .usaha-card strong { margin-top: 17px; font-size: 13px }
        .usaha-card small { margin-top: 3px; color: var(--muted); font-size: 10px }
        .transparency-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px }
        .info-card { min-width: 0; padding: 22px; border: 1px solid var(--line); border-radius: 6px; background: #fff }
        .info-card-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px }
        .info-card h3 { margin: 0; font: 700 22px/1.1 var(--font-sans) }
        .info-card-head p { margin: 6px 0 0; color: var(--muted); font-size: 11px }
        .year-picker { min-height: 35px; padding: 0 8px; border: 1px solid var(--line); border-radius: 4px; color: var(--ink); background: var(--white); font-size: 11px }
        .budget-lines { margin-top: 20px; border-top: 1px solid var(--line) }
        .budget-line { display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 12px 0; border-bottom: 1px solid var(--line); font-size: 12px }
        .budget-line span { color: var(--muted) }
        .budget-line strong { font-size: 12px }
        .budget-total { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-top: 12px; padding: 13px; border-radius: 4px; background: var(--green-soft); font-size: 11px }
        .budget-total strong { color: var(--green); font-size: 14px }
        .empty-line { padding: 21px 0; color: var(--muted); font-size: 12px }
        .idm-stat { display: flex; align-items: end; justify-content: space-between; gap: 14px; margin-top: 26px; padding-bottom: 16px; border-bottom: 1px solid var(--line) }
        .idm-stat span { color: var(--muted); font-size: 12px }
        .idm-stat strong { color: var(--green); font: 700 35px/1 var(--font-sans) }
        .idm-dimensions { display: grid; grid-template-columns: repeat(3,minmax(0,1fr)); gap: 8px; margin-top: 15px }
        .idm-dimensions span { padding: 9px 7px; border-radius: 3px; color: #566052; background: var(--paper); font-size: 10px; text-align: center }
        .projects-head { display: flex; align-items: end; justify-content: space-between; gap: 20px; margin-bottom: 22px }
        .projects-head h2 { margin: 7px 0 0; font: 700 clamp(30px,3.8vw,43px)/1.05 var(--font-sans); letter-spacing: -.04em }
        .project-list { display: grid; grid-template-columns: repeat(3,minmax(0,1fr)); gap: 13px }
        .project-card { position: relative; min-width: 0; padding: 19px; border: 1px solid var(--line); border-radius: 5px; background: #fff }
        .project-meta { display: flex; align-items: center; justify-content: space-between; gap: 8px; color: var(--muted); font-size: 10px }
        .project-status { padding: 4px 8px; border-radius: 20px; color: var(--green); background: var(--green-soft); font-size: 9px; font-weight: 800 }
        .project-card h3 { margin: 20px 0 5px; font-size: 15px; line-height: 1.3 }
        .project-card p { margin: 0; color: var(--muted); font-size: 11px; line-height: 1.6 }
        .project-bottom { display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-top: 20px; padding-top: 13px; border-top: 1px solid var(--line) }
        .project-bottom small,.project-bottom strong { display: block }
        .project-bottom small { color: var(--muted); font-size: 9px }
        .project-bottom strong { margin-top: 3px; font-size: 11px }
        .project-detail { min-height: 34px; padding: 0 10px; border: 1px solid var(--line); border-radius: 4px; color: var(--green); background: #fff; font-size: 10px; font-weight: 800 }
        .project-overlay { position: absolute; inset: 7px; z-index: 2; display: none; overflow-y: auto; padding: 15px; border: 1px solid #b2c1ae; border-radius: 4px; background: #fff; box-shadow: var(--shadow) }
        .project-overlay.open { display: block }
        .overlay-head { display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 12px; font-size: 12px; font-weight: 800 }
        .overlay-close { display: grid; width: 29px; height: 29px; place-items: center; border: 1px solid var(--line); border-radius: 4px; background: #fff }
        .overlay-close svg { width: 14px; height: 14px }
        .overlay-row { display: grid; grid-template-columns: 92px minmax(0,1fr); gap: 9px; padding: 8px 0; border-top: 1px solid var(--line); font-size: 10px }
        .overlay-row span { color: var(--muted) }
        .overlay-row strong { overflow-wrap: anywhere }
        .activities { display: grid; grid-template-columns: 1.15fr .85fr; gap: 14px }
        .activity-feature { display: grid; min-height: 225px; grid-template-columns: .86fr 1.14fr; overflow: hidden; border-radius: 5px; background: var(--paper) }
        .activity-visual { position: relative; display: grid; min-height: 190px; place-items: center; color: var(--green); background: #d7dfc7 }
        .activity-visual svg { width: 71px; height: 71px; stroke-width: 1.2 }
        .activity-visual::after { position: absolute; right: 17px; bottom: 16px; width: 52px; height: 52px; border: 1px solid rgb(41 75 54 / 35%); border-radius: 50%; content: "" }
        .activity-copy { display: flex; flex-direction: column; justify-content: center; padding: 22px }
        .activity-copy small { color: var(--orange); font-size: 9px; font-weight: 900; letter-spacing: .1em; text-transform: uppercase }
        .activity-copy h3 { margin: 9px 0 6px; font: 700 21px/1.12 var(--font-sans) }
        .activity-copy p { margin: 0; color: var(--muted); font-size: 11px; line-height: 1.6 }
        .activity-side { display: grid; align-content: start; gap: 9px }
        .activity-item { padding: 17px; border: 1px solid var(--line); border-radius: 5px; background: var(--white) }
        .activity-item small { color: var(--orange); font-size: 9px; font-weight: 900; letter-spacing: .08em; text-transform: uppercase }
        .activity-item h3 { margin: 6px 0 4px; font-size: 13px }
        .activity-item p { margin: 0; color: var(--muted); font-size: 10px }
        .profile-grid { display: grid; grid-template-columns: .86fr 1.14fr; gap: 18px; align-items: stretch }
        .profile-copy { padding: 25px; border-radius: 5px; color: #fff; background: var(--green) }
        .profile-copy h3 { max-width: 12ch; margin: 17px 0 12px; font: 700 34px/1.03 var(--font-sans) }
        .profile-copy p { margin: 0; color: #dce6d8; font-size: 13px; line-height: 1.7 }
        .profile-facts { display: grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap: 10px }
        .fact { display: flex; min-height: 115px; flex-direction: column; justify-content: space-between; padding: 16px; border: 1px solid var(--line); border-radius: 5px; background: var(--white) }
        .fact span { color: var(--green); font-size: 10px; font-weight: 900; letter-spacing: .09em; text-transform: uppercase }
        .fact strong { margin-top: 12px; font: 700 21px/1 var(--font-sans) }
        .fact small { margin-top: 5px; color: var(--muted); font-size: 10px }
        .contact-grid { display: grid; grid-template-columns: .78fr 1.22fr; gap: 15px }
        .contact-card { padding: 22px; border: 1px solid var(--line); border-radius: 5px; background: #fff }
        .contact-card h3 { margin: 0 0 12px; font: 700 22px var(--font-sans) }
        .contact-row { display: grid; grid-template-columns: 33px minmax(0,1fr); align-items: center; gap: 10px; padding: 12px 0; border-top: 1px solid var(--line) }
        .contact-icon { display: grid; width: 32px; height: 32px; place-items: center; border-radius: 50%; color: var(--green); background: var(--green-soft) }
        .contact-icon svg { width: 15px; height: 15px }
        .contact-row strong,.contact-row small { display: block }
        .contact-row strong { font-size: 11px }
        .contact-row small { margin-top: 2px; color: var(--muted); font-size: 10px }
        .map-frame { min-height: 300px; overflow: hidden; border: 1px solid var(--line); border-radius: 5px; background: var(--paper-deep) }
        .map-frame iframe { display: block; width: 100%; height: 100%; min-height: 300px; border: 0 }
        .footer { padding-block: 23px; color: #e3eadf; background: #172b20; font-size: 10px }
        .footer-inner { display: flex; align-items: center; justify-content: space-between; gap: 14px }
        .footer a { color: #f1c965; font-weight: 700 }
        .powered-by { margin: 16px auto 0; color: #aebcae; font-size: 10px; text-align: center }
        .powered-by a { color: #f1c965; text-decoration: underline; text-underline-offset: 2px }
        .proposal-button { position: fixed; right: 20px; bottom: 20px; z-index: 50; display: inline-flex; min-height: 56px; align-items: center; gap: 10px; padding: 7px 17px 7px 7px; border: 0; border-radius: 50px; color: #fff; background: var(--orange); box-shadow: 0 8px 25px rgb(29 55 41 / 28%); font-size: 12px; font-weight: 800; transition: opacity .18s ease, transform .18s ease, background .15s ease }
        .proposal-button.fab-away { opacity: 0; pointer-events: none; transform: translateY(9px) }
        .proposal-button.fab-away:focus-visible { opacity: 1; pointer-events: auto; transform: none }
        .proposal-button:hover { background: #a94125 }
        .proposal-button .fab-icon { display: grid; width: 42px; height: 42px; place-items: center; border-radius: 50%; color: var(--orange); background: #fff }
        .fab-icon svg { width: 19px; height: 19px }
        .chat-panel { position: fixed; right: 20px; bottom: 88px; z-index: 51; display: none; width: min(370px,calc(100vw - 28px)); max-height: min(570px,calc(100dvh - 110px)); overflow: auto; border: 1px solid var(--line); border-radius: 8px; background: #fffdf7; box-shadow: 0 18px 50px rgb(29 55 41 / 24%) }
        .chat-panel.open { display: block; animation: chat-rise .18s ease-out }
        @keyframes chat-rise { from { opacity: 0; transform: translateY(8px) } to { opacity: 1; transform: none } }
        .chat-head { display: flex; align-items: center; justify-content: space-between; padding: 14px 17px; color: #fff; background: var(--green) }
        .chat-head strong { font-size: 13px }
        .chat-head button { display: grid; width: 31px; height: 31px; place-items: center; border: 1px solid rgb(255 255 255 / 25%); border-radius: 50%; color: #fff; background: transparent }
        .chat-head button svg { width: 15px; height: 15px }
        .chat-body { padding: 15px }
        .chat-message { width: fit-content; max-width: 92%; padding: 10px 12px; border-radius: 3px 11px 11px; color: var(--ink); background: #edf0e7; font-size: 12px; line-height: 1.55; white-space: pre-line; overflow-wrap: anywhere }
        .chat-message + .chat-message { margin-top: 7px }
        .chat-prompt { margin-top: 13px; color: var(--muted); font-size: 9px; font-weight: 900; letter-spacing: .08em; text-transform: uppercase }
        .chat-input { width: 100%; min-height: 42px; margin-top: 8px; padding: 9px 10px; border: 1px solid #c8d1c3; border-radius: 4px; outline-color: var(--green); background: #fff; font-size: 12px }
        .chat-options { display: flex; flex-wrap: wrap; gap: 7px; margin-top: 9px }
        .chat-actions { display: flex; flex-wrap: wrap; justify-content: flex-end; gap: 7px; margin-top: 13px }
        .chat-actions button,.chat-option { min-height: 35px; padding: 0 12px; border: 1px solid #bac8b7; border-radius: 5px; color: var(--green); background: #fff; font-size: 11px; font-weight: 800 }
        .chat-actions button.primary { border-color: var(--green); color: #fff; background: var(--green) }
        .chat-actions button:disabled { cursor: not-allowed; opacity: .55 }
        .chat-error { margin-top: 8px; color: #a23020; font-size: 11px }
        .reveal { opacity: 1; transform: none }
        .motion-ready .reveal { opacity: .16; transform: translateY(9px); transition: opacity .4s ease,transform .45s cubic-bezier(.2,.72,.2,1) }
        .motion-ready .reveal.is-visible { opacity: 1; transform: none }
        :focus-visible { outline: 3px solid #a34524; outline-offset: 3px }
        .skip-link { position: fixed; top: 8px; left: 8px; z-index: 100; padding: 9px 13px; transform: translateY(-150%); color: #fff; background: var(--green-dark) }
        .skip-link:focus { transform: none }
        @media (max-width: 980px) {
            .nav { gap: 12px; font-size: 11px }
            .brand { min-width: 0 }
            .service-grid { grid-template-columns: repeat(2,minmax(0,1fr)) }
        }
        @media (max-width: 760px) {
            html { scroll-padding-top: 68px }
            .wrap { width: min(100% - 32px,620px) }
            .topline { font-size: 9px }
            .topline-inner { min-height: 32px }
            .topline-inner p:last-child { display: none }
            .header-inner { min-height: 66px; gap: 12px }
            .brand-mark { width: 39px; height: 39px }
            .brand-name strong { font-size: 14px }
            .brand-name small { font-size: 9px }
            .menu-button { display: grid }
            .nav { position: absolute; top: calc(100% + 1px); right: 0; left: 0; display: none; align-items: stretch; gap: 0; padding: 7px 16px 13px; border-bottom: 1px solid var(--line); background: var(--paper); box-shadow: 0 12px 20px rgb(29 55 41 / 10%) }
            .nav.open { display: flex; flex-direction: column }
            .nav a { padding: 11px 5px; border-bottom: 1px solid rgb(41 75 54 / 10%) }
            .nav .nav-action { margin-top: 8px; padding: 11px; border: 0; text-align: center }
            .hero { padding-block: 16px 17px }
            .hero-grid { grid-template-columns: 1fr; border-radius: 6px }
            .hero-copy { padding: 27px 23px 25px }
            .hero h1 { max-width: 12ch; margin-block: 14px 10px; font-size: clamp(39px,11vw,54px) }
            .hero-copy > p { font-size: 13px }
            .hero-art { min-height: 255px }
            .hero-art img { object-position: 40% center }
            .hero-caption { right: 12px; bottom: 10px; left: 12px; font-size: 11px }
            .quick-strip { grid-template-columns: repeat(2,minmax(0,1fr)); margin-top: 10px }
            .quick-item { min-height: 67px; padding: 11px; border-bottom: 1px solid var(--line) }
            .quick-item:nth-child(2) { border-right: 0 }
            .quick-item:nth-child(n+3) { border-bottom: 0 }
            .quick-item > span:first-child { width: 32px; height: 32px }
            .quick-item strong { font-size: 10px }
            .quick-item small { font-size: 9px }
            .section { padding-block: 44px }
            .section-head,.projects-head { align-items: flex-start; flex-direction: column; gap: 9px; margin-bottom: 18px }
            .section-head h2,.projects-head h2 { font-size: 32px }
            .section-head > p { font-size: 12px }
            .welcome-grid,.bumdes-grid,.transparency-grid,.profile-grid,.contact-grid { grid-template-columns: 1fr; gap: 12px }
            .welcome-note { padding: 23px 21px 22px 27px }
            .welcome-note blockquote { font-size: 15px }
            .staff-panel { padding: 18px }
            .staff-list { gap: 7px }
            .staff-person { gap: 7px; padding: 8px 6px }
            .staff-person .initial { width: 29px; height: 29px; font-size: 12px }
            .staff-person strong { font-size: 9px }
            .staff-person small { font-size: 8px }
            .service-grid { grid-template-columns: repeat(2,minmax(0,1fr)); gap: 8px }
            .service-card { min-height: 145px; padding: 13px }
            .service-card h3 { margin-top: 11px; font-size: 12px }
            .service-card p { font-size: 10px }
            .bumdes-lead { padding: 22px }
            .bumdes-lead h3 { font-size: 29px }
            .usaha-grid { gap: 8px }
            .usaha-card { min-height: 112px; padding: 13px }
            .usaha-card strong { font-size: 11px }
            .usaha-card small { font-size: 9px }
            .info-card { padding: 17px }
            .info-card h3 { font-size: 20px }
            .info-card-head p { font-size: 10px }
            .idm-dimensions { grid-template-columns: repeat(2,minmax(0,1fr)) }
            .project-list { grid-template-columns: 1fr; gap: 9px }
            .project-card { padding: 16px }
            .activities { grid-template-columns: 1fr }
            .activity-feature { grid-template-columns: .72fr 1.28fr; min-height: 175px }
            .activity-visual { min-height: 165px }
            .activity-visual svg { width: 54px; height: 54px }
            .activity-copy { padding: 15px }
            .activity-copy h3 { font-size: 18px }
            .activity-copy p { font-size: 10px }
            .profile-copy { padding: 21px }
            .profile-copy h3 { font-size: 30px }
            .profile-facts { gap: 8px }
            .fact { min-height: 102px; padding: 13px }
            .fact strong { font-size: 18px }
            .map-frame,.map-frame iframe { min-height: 240px }
            .footer-inner { align-items: flex-start; flex-direction: column; gap: 9px }
            .proposal-button { right: 15px; bottom: max(15px,env(safe-area-inset-bottom)); width: 52px; min-height: 52px; justify-content: center; padding: 5px }
            .proposal-button .fab-label { display: none }
            .proposal-button .fab-icon { width: 42px; height: 42px }
            .chat-panel { right: 12px; bottom: 77px; max-height: calc(100dvh - 96px) }
        }
        @media (max-width: 380px) {
            .wrap { width: calc(100% - 24px) }
            .quick-item { gap: 7px; padding-inline: 7px }
            .service-card { padding: 11px }
            .staff-list { grid-template-columns: 1fr }
            .staff-person strong { font-size: 10px }
            .activity-feature { grid-template-columns: .62fr 1.38fr }
        }
        @media (prefers-reduced-motion: reduce) {
            *,*::before,*::after { scroll-behavior: auto !important; animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important }
        }
    </style>
    @include('desa.partials.favicon')
  @include('desa.partials.village-logo-styles')
</head>
<body>
    <a class="skip-link" href="#konten">Lewati ke konten</a>
    <div class="topline"><div class="wrap topline-inner"><p>Pemerintah Desa Gending <span aria-hidden="true">·</span> Kecamatan Gending, Kabupaten Probolinggo</p><p>Portal informasi dan layanan warga</p></div></div>
    <header class="header">
        <div class="wrap header-inner">
            <a class="brand" href="#beranda" aria-label="Beranda Desa Gending"><span class="portal-village-logo" aria-hidden="true"><img src="{{ asset('images/portal-logo.webp') }}" alt="" width="44" height="44"></span><span class="brand-name"><strong>Desa Gending</strong><small>Kabupaten Probolinggo</small></span></a>
            <button class="menu-button" id="menu-button" type="button" aria-label="Buka menu" aria-expanded="false" aria-controls="main-nav"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg></button>
            <nav class="nav" id="main-nav" aria-label="Navigasi utama">
                <a href="#sambutan">Pemerintahan</a><a href="#layanan">Layanan</a><a href="#potensi">Potensi</a><a href="#transparansi">Anggaran</a><a href="#pembangunan">Pembangunan</a><a class="nav-action" href="#lokasi">Kontak Desa</a>
            </nav>
        </div>
    </header>
    <main id="konten">
        <section class="hero" id="beranda">
            <div class="wrap">
                <div class="hero-grid">
                    <div class="hero-copy">
                        <span class="eyebrow">Desa Gending · Kecamatan Gending</span>
                        <h1>Pangan tumbuh, usaha desa bergerak.</h1>
                        <p>Mengenal program ketahanan pangan, layanan, dan informasi pembangunan Desa Gending.</p>
                        <div class="hero-actions"><a class="btn btn-dark" href="#potensi">Jelajahi potensi <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></a><a class="btn btn-light" href="#layanan">Cari layanan</a></div>
                    </div>
                    <figure class="hero-art">
                        <img src="{{ asset('images/gending-bumdes-bebek.jpg') }}" alt="Direktur Belum tersedia melihat peternakan bebek petelur di Desa Gending" width="1200" height="705" fetchpriority="high">
                    </figure>
                </div>
                <div class="quick-strip" aria-label="Ringkasan wilayah">
                    <div class="quick-item"><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M4 20V8l8-5 8 5v12M8 20v-7h8v7M3 20h18"/></svg></span><div><strong>Belum tersedia</strong><small>Wilayah desa</small></div></div>
                    <div class="quick-item"><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a15 15 0 0 1 0 18"/></svg></span><div><strong>4 RW</strong><small>Wilayah desa</small></div></div>
                    <div class="quick-item"><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M4 20V5h16v15M8 9h2m4 0h2M8 13h2m4 0h2M8 17h8"/></svg></span><div><strong>13 RT</strong><small>Wilayah desa</small></div></div>
                    <div class="quick-item"><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M4 19c4-8 12-8 16 0M7 14c3-5 7-5 10 0M10 9c1-2 3-2 4 0M12 21v-1"/></svg></span><div><strong>Mandiri Utama</strong><small>BUMDes Desa Gending</small></div></div>
                </div>
            </div>
        </section>

        <section class="section section-white" id="sambutan">
            <div class="wrap">
                <div class="section-head"><div><span class="eyebrow">Pemerintahan desa</span><h2>Sambutan Kepala Desa</h2></div><p>Informasi kepemimpinan dan perangkat yang melayani warga.</p></div>
                <div class="welcome-grid portal-mobile-stack">
                    <article class="welcome-note"><blockquote>Selamat datang di portal Desa Gending. Mari bersama menjaga semangat gotong royong dan mengembangkan potensi desa untuk kesejahteraan warga.</blockquote><div class="signature"><span class="signature-mark">K</span><span><strong>Belum tersedia</strong><small>Kepala Desa Gending</small></span></div></article>
                    <article class="staff-panel"><h3>Perangkat Desa</h3><div class="staff-list">
                        <div class="staff-person"><span class="initial">S</span><span><strong>Belum tersedia</strong><small>Sekretaris Desa</small></span></div>
                        <div class="staff-person"><span class="initial">K</span><span><strong>Belum tersedia</strong><small>Kasi Pemerintahan</small></span></div>
                        <div class="staff-person"><span class="initial">K</span><span><strong>Belum tersedia</strong><small>Kasi Kesejahteraan</small></span></div>
                        <div class="staff-person"><span class="initial">K</span><span><strong>Belum tersedia</strong><small>Kaur Umum</small></span></div>
                    </div></article>
                </div>
            </div>
        </section>

        <section class="section" id="layanan">
            <div class="wrap">
                <div class="section-head"><div><span class="eyebrow">Urusan warga</span><h2>Layanan Desa</h2></div><p>Pilih kebutuhan layanan untuk melihat informasi pengajuan.</p></div>
                <div class="service-grid portal-mobile-two-col">
                    <article class="service-card"><span class="service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M6 3h9l4 4v14H6zM14 3v5h5M9 13h7m-7 4h7"/></svg></span><h3>Surat keterangan</h3><p>Persyaratan layanan belum tersedia.</p><button class="service-open" data-service="Surat keterangan" type="button">Lihat informasi <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></button></article>
                    <article class="service-card"><span class="service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="9" cy="8" r="3"/><path d="M3 20c0-4 2-6 6-6s6 2 6 6m2-9h5m-2.5-2.5v5"/></svg></span><h3>Administrasi penduduk</h3><p>Informasi layanan belum tersedia.</p><button class="service-open" data-service="Administrasi penduduk" type="button">Lihat informasi <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></button></article>
                    <article class="service-card"><span class="service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M4 20V8l8-5 8 5v12M8 20v-7h8v7M3 20h18"/></svg></span><h3>Surat pengantar</h3><p>Informasi alur layanan belum tersedia.</p><button class="service-open" data-service="Surat pengantar" type="button">Lihat informasi <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></button></article>
                    <article class="service-card"><span class="service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="12" r="9"/><path d="M12 11v5m0-8h.01"/></svg></span><h3>Layanan lainnya</h3><p>Informasi layanan belum tersedia.</p><button class="service-open" data-service="Layanan lainnya" type="button">Lihat informasi <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></button></article>
                </div>
            </div>
        </section>

        <section class="section section-dark" id="potensi">
            <div class="wrap">
                <div class="section-head"><div><span class="eyebrow">Potensi desa</span><h2>Ketahanan pangan, kerja bersama</h2></div><p>Pertanian, peternakan, dan usaha produktif warga.</p></div>
                <div class="bumdes-grid">
                    <article class="bumdes-lead"><div><span class="eyebrow">Badan Usaha Milik Desa</span><h3>Belum tersedia</h3><p>Informasi BUMDes belum tersedia.</p></div></article>
                    <div class="usaha-grid">
                        <article class="usaha-card"><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M12 21V9m0 2c-5 0-7-3-7-7 5 0 7 3 7 7Zm0 3c5 0 7-3 7-7-5 0-7 3-7 7Z"/></svg></span><div><strong>Penanaman pisang</strong><small>Unit usaha pangan</small></div></article>
                        <article class="usaha-card"><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M5 19c0-5 3-8 7-8s7 3 7 8M8 11V8m8 3V8M9 6h.01M15 6h.01M3 20h18"/></svg></span><div><strong>Bebek petelur</strong><small>Peternakan produktif</small></div></article>
                        <article class="usaha-card"><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M4 19c4-5 12-5 16 0M7 15c3-3 7-3 10 0M12 3v7m-3-4 3 3 3-3"/></svg></span><div><strong>Budidaya mentok</strong><small>Unit usaha pangan</small></div></article>
                        <article class="usaha-card"><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M4 20c1-4 3-7 8-8 5 1 7 4 8 8M12 12V4m0 4c-3 0-5-2-5-5 3 0 5 2 5 5Zm0 2c3 0 5-2 5-5-3 0-5 2-5 5Z"/></svg></span><div><strong>Penanaman padi</strong><small>Pertanian pangan</small></div></article>
                    </div>
                </div>
            </div>
        </section>

        <section class="section section-white" id="transparansi">
            <div class="wrap">
                <div class="section-head"><div><span class="eyebrow">Informasi terbuka</span><h2>Transparansi Desa</h2></div><p>Ringkasan anggaran dan indeks desa.</p></div>
                <div class="transparency-grid">
                    <article class="info-card"><div class="info-card-head"><div><h3>Alokasi transfer</h3><p>Anggaran Alokasi transfer desa</p></div><label><span class="sr-only">Tahun anggaran</span><select class="year-picker" id="budget-year" aria-label="Pilih tahun anggaran" hidden><option value="">Tahun</option></select></label></div><div class="budget-lines" id="budget-lines">
            <p class="portal-data-empty">Belum tersedia</p>
        </div><div class="budget-total"><span>Realisasi</span><strong id="budget-realized">Belum tersedia</strong></div></article>
                    <article class="info-card"><div class="info-card-head"><div><h3>Indeks Desa</h3><p>Status dan skor Indeks Desa 2025</p></div></div>@include('desa.partials.indeks-desa-result')</article>
                </div>
            </div>
        </section>

        <section class="section" id="pembangunan">
            <div class="wrap">
                <div class="projects-head"><div><span class="eyebrow">Transparansi pembangunan</span><h2>Papan Proyek</h2></div><p style="max-width:42ch;margin:0;color:var(--muted);font-size:13px">Pekerjaan dan kegiatan pembangunan Desa Gending.</p></div>
                <div class="project-list portal-mobile-stack" id="project-list" aria-live="polite" aria-busy="true">
                    <p class="portal-data-empty" role="status">Memuat informasi pembangunan…</p>
                </div>
            </div>
        </section>

        <section class="section section-white" id="kegiatan">
            <div class="wrap">
                <div class="section-head"><div><span class="eyebrow">Kabar desa</span><h2>Kegiatan dan Pengumuman</h2></div><p>Agenda dan kabar terbaru dari Desa Gending.</p></div>
                <div class="activities">
                    <article class="activity-feature"><div class="activity-visual"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20c1-5 5-8 8-8s7 3 8 8M12 12V3m0 4c-4 0-6-2-6-5 4 0 6 2 6 5Zm0 3c4 0 6-2 6-5-4 0-6 2-6 5Z"/></svg></div><div class="activity-copy"><small>18 Juni 2026</small><h3>Informasi kegiatan</h3><p>Informasi kegiatan belum tersedia.</p></div></article>
                    <div class="activity-side"><article class="activity-item"><small>Pengumuman</small><h3>Jadwal pelayanan administrasi</h3><p>Senin sampai Jumat, pukul 08.00–14.00.</p></article><article class="activity-item"><small>Agenda warga</small><h3>Informasi kegiatan</h3><p>Minggu, 23 Juni · titik kumpul balai desa.</p></article></div>
                </div>
            </div>
        </section>

        <section class="section" id="profil">
            <div class="wrap">
                <div class="section-head"><div><span class="eyebrow">Mengenal Gending</span><h2>Profil Desa</h2></div><p>Gambaran wilayah dan kehidupan masyarakat Desa Gending.</p></div>
                <div class="profile-grid"><article class="profile-copy"><span class="eyebrow">Desa · Kecamatan Gending</span><h3>Ruang tumbuh bersama warga.</h3><p>Desa Gending berada di Kecamatan Gending, Kabupaten Probolinggo. Informasi profil wilayah belum tersedia.</p></article><div class="profile-facts"><article class="fact"><span>Wilayah</span><strong>Belum tersedia</strong><small>Belum tersedia</small></article><article class="fact"><span>Ekonomi warga</span><strong>Pertanian</strong><small>Padi dan usaha pangan</small></article><article class="fact"><span>BUMDes</span><strong>Mandiri Utama</strong><small>Unit usaha ketahanan pangan</small></article><article class="fact"><span>Jumlah penduduk</span><strong>Belum tersedia</strong><small></small></article></div></div>
            </div>
        </section>

        <section class="section section-white" id="lokasi">
            <div class="wrap">
                <div class="section-head"><div><span class="eyebrow">Kunjungi kantor</span><h2>Lokasi dan Kontak</h2></div><p>Informasi alamat dan kanal komunikasi Pemerintah Desa Gending.</p></div>
                <div class="contact-grid">
                    <article class="contact-card"><h3>Kantor Desa Gending</h3><div class="contact-row"><span class="contact-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M12 21s7-4.5 7-11a7 7 0 1 0-14 0c0 6.5 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/></svg></span><span><strong>Alamat</strong><small>Belum tersedia </small></span></div><div class="contact-row"><span class="contact-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M5 4h4l2 5-3 2c1.5 3 3 4.5 6 6l2-3 5 2v4c0 1-1 2-2 2C9 21 3 15 3 6c0-1 1-2 2-2Z"/></svg></span><span><strong>Telepon</strong><small>Belum tersedia </small></span></div><div class="contact-row"><span class="contact-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span><span><strong>Jam pelayanan</strong><small>Belum tersedia </small></span></div></article>
                    <div class="map-frame"><iframe title="Pencarian Kantor Desa Gending di Google Maps" src="https://www.google.com/maps?q=Kantor+Desa+Gending,+Kecamatan+Gending,+Kabupaten+Probolinggo&output=embed" loading="lazy" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe></div>
                </div>
            </div>
        </section>
    </main>
    @include('desa.partials.footer', [
        'villageName' => 'Gending',
        'initial' => 'G',
        'theme' => 'gending',
        'links' => [
            ['label' => 'Profil Desa', 'href' => '#profil'],
            ['label' => 'Layanan', 'href' => '#layanan'],
            ['label' => 'Anggaran', 'href' => '#transparansi'],
            ['label' => 'Papan proyek', 'href' => '#pembangunan'],
            ['label' => 'Lokasi kantor', 'href' => '#lokasi'],
        ],
    ])

    <button class="proposal-button" id="proposal-open" type="button" aria-label="Sampaikan usulan" aria-expanded="false" aria-controls="proposal-chat"><span class="fab-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg></span><span class="fab-label">Sampaikan usulan</span></button>
    <section class="chat-panel" id="proposal-chat" aria-label="Form usulan warga" aria-hidden="true"><div class="chat-head"><strong>Usulan warga</strong><button id="proposal-close" type="button" aria-label="Tutup percakapan"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 6 12 12M18 6 6 18"/></svg></button></div><div class="chat-body"><div id="chat-messages" aria-live="polite"></div><div id="chat-controls"></div><div class="chat-actions" id="chat-actions"></div><div class="chat-error" id="chat-error" role="alert"></div></div></section>
    <dialog id="service-dialog"><div class="dialog-head"><strong id="service-dialog-title"></strong><button id="service-close" class="overlay-close" type="button" aria-label="Tutup"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 6 12 12M18 6 6 18"/></svg></button></div><div class="dialog-body"><p>Persyaratan dan alur layanan belum tersedia.</p></div></dialog>
    <style>
        .sr-only { position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0 }
        #service-dialog { width:min(440px,calc(100% - 28px));padding:0;border:1px solid var(--line);border-radius:6px;background:var(--white);box-shadow:var(--shadow) }
        #service-dialog::backdrop { background:rgb(20 32 22 / 50%) }
        .dialog-head { display:flex;align-items:center;justify-content:space-between;gap:12px;padding:17px 19px;border-bottom:1px solid var(--line);font-size:15px }
        .dialog-body { padding:18px 19px;color:var(--muted);font-size:13px }
        .dialog-body p { margin:0 }

        body { font-family:var(--font-sans);font-size:16px;line-height:1.6 }
        .topline,.footer,.powered-by { font-size:12px }
        .brand-name small,.quick-item small,.signature small,.staff-person small,.usaha-card small,.contact-row small,.fact small { font-size:12px }
        .brand-name strong { font-size:16px }
        .nav { font-size:13px }
        .eyebrow,.hero-caption { font-size:11px }
        .hero h1 { max-width:14ch;font-size:clamp(42px,4.5vw,58px);font-weight:750;line-height:1.02;letter-spacing:-.045em }
        .hero-copy > p,.bumdes-lead p,.profile-copy p { font-size:15px }
        .btn,.proposal-button { font-size:13px }
        .hero-stamp span { font-size:10px }
        .quick-item strong,.signature strong,.service-card p,.service-card button,.info-card-head p,.budget-line,.budget-total,.empty-line,.idm-stat span,.project-meta,.project-card p,.activity-copy p,.activity-item p,.dialog-body { font-size:13px }
        .section-head > p { font-size:15px }
        .staff-panel h3,.contact-card h3 { font-size:22px }
        .staff-person strong,.contact-row strong { font-size:13px }
        .service-card h3,.activity-item h3 { font-size:15px }
        .bumdes-lead .source { font-size:12px }
        .usaha-card strong { font-size:14px }
        .info-card-head p,.year-picker { font-size:12px }
        .budget-line strong { font-size:13px }
        .budget-total strong { font-size:15px }
        .idm-dimensions span { font-size:12px }
        .project-status { font-size:11px }
        .project-card h3 { font-size:16px }
        .project-bottom small { font-size:11px }
        .project-bottom strong { font-size:12px }
        .project-detail,.overlay-row { font-size:12px }
        .overlay-head { font-size:13px }
        .activity-copy small,.activity-item small,.fact span { font-size:11px }
        .activity-copy h3 { font-size:22px }
        .profile-copy h3 { font-size:36px }
        .fact strong { font-size:22px }
        .chat-head strong { font-size:14px }
        .chat-message,.chat-input { font-size:14px }
        .chat-prompt { font-size:11px }
        .chat-actions button,.chat-option { font-size:12px }
        .chat-error { font-size:12px }

        @media (max-width:760px) {
            body { font-size:15px }
            .topline { font-size:10px }
            .brand-name small,.quick-item small,.signature small,.staff-person small,.usaha-card small,.contact-row small,.fact small { font-size:11px }
            .nav { font-size:12px }
            .hero h1 { max-width:12ch;font-size:clamp(38px,10vw,50px) }
            .hero-copy > p,.profile-copy p,.dialog-body { font-size:14px }
            .hero-caption { font-size:10px }
            .quick-item strong,.staff-person strong,.contact-row strong { font-size:12px }
            .section-head > p { font-size:13px }
            .welcome-note blockquote { font-size:16px }
            .service-card h3,.activity-item h3 { font-size:14px }
            .service-card p,.activity-copy p,.activity-item p { font-size:12px }
            .service-card button,.project-detail,.project-meta,.overlay-row { font-size:11px }
            .usaha-card strong { font-size:12px }
            .info-card-head p,.year-picker { font-size:11px }
            .project-card h3 { font-size:15px }
            .project-card p { font-size:12px }
            .activity-copy h3 { font-size:19px }
            .profile-copy h3 { font-size:32px }
            .fact strong { font-size:19px }
        }
    </style>
    <script>
        if ('IntersectionObserver' in window && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            document.documentElement.classList.add('motion-ready');
            const observer = new IntersectionObserver(entries => entries.forEach(entry => entry.target.classList.toggle('is-visible', entry.isIntersecting)), { threshold: 0.18 });
            document.querySelectorAll('main > section').forEach(section => { section.classList.add('reveal'); observer.observe(section); });
        }

        const safeNode = (tag, className, value) => {
            const node = document.createElement(tag);
            node.className = className;
            node.textContent = value ?? '';
            return node;
        };
        const money = value => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(value || 0);
        const nav = document.querySelector('#main-nav');
        const menuButton = document.querySelector('#menu-button');
        menuButton.addEventListener('click', () => {
            const open = nav.classList.toggle('open');
            menuButton.setAttribute('aria-expanded', String(open));
            menuButton.setAttribute('aria-label', open ? 'Tutup menu' : 'Buka menu');
        });
        nav.querySelectorAll('a').forEach(link => link.addEventListener('click', () => {
            nav.classList.remove('open');
            menuButton.setAttribute('aria-expanded', 'false');
            menuButton.setAttribute('aria-label', 'Buka menu');
        }));

        const serviceDialog = document.querySelector('#service-dialog');
        document.querySelectorAll('.service-open').forEach(button => button.addEventListener('click', () => {
            document.querySelector('#service-dialog-title').textContent = button.dataset.service;
            serviceDialog.showModal();
        }));
        document.querySelector('#service-close').addEventListener('click', () => serviceDialog.close());
        serviceDialog.addEventListener('click', event => { if (event.target === serviceDialog) serviceDialog.close(); });

        const projectList = document.querySelector('#project-list');
        const projectFields = [
            ['Lokasi', project => project.location], ['Tahun', project => project.year], ['Status', project => project.status],
            ['Volume', project => project.volume], ['Sumber dana', project => project.funding], ['Pelaksana', project => project.executor],
            ['Jadwal', project => project.schedule], ['Progres', project => `${project.progress ?? 0}%`], ['Realisasi', project => money(project.spent)],
        ];
        function renderProjects(projects, emptyMessage = 'Belum ada informasi pembangunan yang dapat ditampilkan.') {
            projectList.replaceChildren();
            projectList.setAttribute('aria-busy', 'false');
            if (!projects.length) {
                const emptyState = document.createElement('p');
                emptyState.className = 'portal-data-empty';
                emptyState.textContent = emptyMessage;
                projectList.append(emptyState);
                return;
            }
            projects.forEach(project => {
                const card = document.createElement('article');
                card.className = 'project-card';
                const meta = document.createElement('div');
                meta.className = 'project-meta';
                meta.append(safeNode('span', '', `Tahun ${project.year || '—'}`), safeNode('span', 'project-status', project.status || 'Status'));

                const bottom = document.createElement('div');
                bottom.className = 'project-bottom';
                const budget = document.createElement('span');
                budget.append(safeNode('small', '', 'Anggaran'), safeNode('strong', '', project.funding || 'Belum tersedia'));
                const detailButton = safeNode('button', 'project-detail', 'Rincian');
                detailButton.type = 'button';
                bottom.append(budget, detailButton);
                card.append(meta, safeNode('h3', '', project.title), safeNode('p', '', project.summary || project.location || 'Ringkasan pekerjaan belum tersedia.'), bottom);
                const overlay = document.createElement('div');
                overlay.className = 'project-overlay';
                overlay.setAttribute('role', 'dialog');
                overlay.setAttribute('aria-label', `Rincian ${project.title}`);
                const head = document.createElement('div');
                head.className = 'overlay-head';
                head.append(safeNode('strong', '', 'Rincian pekerjaan'));
                const close = safeNode('button', 'overlay-close', '×');
                close.type = 'button';
                close.setAttribute('aria-label', 'Tutup rincian');
                close.addEventListener('click', () => overlay.classList.remove('open'));
                head.append(close);
                overlay.append(head);
                projectFields.forEach(([label, getValue]) => {
                    const value = getValue(project);
                    if (value === undefined || value === null || value === '') return;
                    const row = document.createElement('div');
                    row.className = 'overlay-row';
                    row.append(safeNode('span', '', label), safeNode('strong', '', value));
                    overlay.append(row);
                });
                detailButton.addEventListener('click', () => overlay.classList.add('open'));
                card.append(overlay);
                projectList.append(card);
            });
        }

        fetch('/api/desa/gending/content').then(response => response.ok ? response.json() : Promise.reject()).then(data => renderProjects(Array.isArray(data.projects) ? data.projects : [])).catch(() => renderProjects([], 'Informasi pembangunan belum dapat dimuat saat ini.'));

        const budgetYear = document.querySelector('#budget-year');
        const budgetLines = document.querySelector('#budget-lines');
        const budgetRealized = document.querySelector('#budget-realized');
        let budgets = [];
        function renderBudget(year) {
            const budget = budgets.find(item => String(item.year) === String(year));
            if (!budget) return;
            document.querySelector('#budget-sample')?.remove();
            budgetLines.replaceChildren();
            [['Dana Desa', budget.villageFund], ['Alokasi Dana Desa', budget.villageAllocation], ['Bagi Hasil Pajak', budget.taxRevenueShare], ['Bagi Hasil Retribusi', budget.retributionShare]].forEach(([label, amount]) => {
                const row = document.createElement('div');
                row.className = 'budget-line';
                row.append(safeNode('span', '', label), safeNode('strong', '', amount > 0 ? money(amount) : 'Belum tersedia'));
                budgetLines.append(row);
            });
            budgetRealized.textContent = 'Belum tersedia';
        }
        budgetYear.addEventListener('change', () => renderBudget(budgetYear.value));
        fetch('/api/desa/gending/budgets').then(response => response.ok ? response.json() : Promise.reject()).then(data => {
            budgets = data;
            if (!budgets.length) return;
            budgetYear.hidden = false;
            budgets.forEach(item => {
                const option = document.createElement('option');
                option.value = item.year;
                option.textContent = String(item.year);
                budgetYear.append(option);
            });
            budgetYear.value = String(budgets[0].year);
            renderBudget(budgetYear.value);
        }).catch(() => {});

        const questions = [
            { key: 'title', label: 'Judul usulan', prompt: 'Apa usulan yang ingin disampaikan?', required: true, type: 'text' },
            { key: 'location', label: 'Lokasi', prompt: 'Di mana usulan ini diperlukan?', required: true, type: 'text' },
            { key: 'category', label: 'Bidang', prompt: 'Pilih bidang usulan.', required: false, type: 'choice', options: ['Infrastruktur', 'Lingkungan', 'Sosial', 'Ekonomi', 'Lainnya'] },
            { key: 'description', label: 'Uraian', prompt: 'Jelaskan usulan secara singkat.', required: true, type: 'textarea' },
            { key: 'name', label: 'Nama', prompt: 'Nama (opsional).', required: false, type: 'text' },
            { key: 'contact', label: 'Kontak', prompt: 'Nomor telepon (opsional).', required: false, type: 'text' },
        ];
        let answers = {};
        let step = 0;
        const chat = document.querySelector('#proposal-chat');
        const chatMessages = document.querySelector('#chat-messages');
        const chatControls = document.querySelector('#chat-controls');
        const chatActions = document.querySelector('#chat-actions');
        const chatError = document.querySelector('#chat-error');
        const proposalButton = document.querySelector('#proposal-open');
        const heroVisibility = new IntersectionObserver(([entry]) => {
            proposalButton.classList.toggle('fab-away', entry.isIntersecting);
        }, { threshold: 0.01 });
        heroVisibility.observe(document.querySelector('#beranda'));
        function say(text) {
            chatMessages.append(safeNode('div', 'chat-message', text));
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
        function action(label, handler, primary = false) {
            const button = safeNode('button', primary ? 'primary' : '', label);
            button.type = 'button';
            button.addEventListener('click', handler);
            return button;
        }
        function closeChat(clear = true) {
            chat.classList.remove('open');
            chat.setAttribute('aria-hidden', 'true');
            proposalButton.setAttribute('aria-expanded', 'false');
            if (clear) {
                answers = {};
                step = 0;
                chatMessages.replaceChildren();
                chatControls.replaceChildren();
                chatActions.replaceChildren();
                chatError.textContent = '';
            }
        }
        function renderQuestion() {
            chatControls.replaceChildren();
            chatActions.replaceChildren();
            chatError.textContent = '';
            if (step >= questions.length) {
                say('Periksa kembali usulanmu sebelum dikirim.');
                say(`${answers.title}\n${answers.location}\n${answers.description}`);
                chatActions.append(action('Batal', () => closeChat()), action('Kirim usulan', submitProposal, true));
                return;
            }
            const question = questions[step];
            say(question.prompt);
            chatControls.append(safeNode('div', 'chat-prompt', `${step + 1} dari ${questions.length} · ${question.label}`));
            if (question.type === 'choice') {
                const options = document.createElement('div');
                options.className = 'chat-options';
                question.options.forEach(option => options.append(action(option, () => {
                    answers[question.key] = option;
                    say(option);
                    step += 1;
                    renderQuestion();
                })));
                chatControls.append(options);
            } else {
                const input = document.createElement(question.type === 'textarea' ? 'textarea' : 'input');
                input.className = 'chat-input';
                input.placeholder = question.label;
                input.setAttribute('aria-label', question.label);
                input.maxLength = question.key === 'description' ? 3000 : 160;
                if (question.type === 'textarea') input.rows = 3;
                chatControls.append(input);
            }
            chatActions.append(action('Batal', () => closeChat()));
            if (!question.required) chatActions.append(action('Lewati', () => {
                answers[question.key] = '';
                step += 1;
                renderQuestion();
            }));
            const next = action(step === questions.length - 1 ? 'Tinjau' : 'Lanjut', () => {
                const input = chatControls.querySelector('input,textarea');
                const value = input?.value.trim() || '';
                if (question.required && !value) {
                    chatError.textContent = 'Bagian ini perlu diisi.';
                    return;
                }
                answers[question.key] = value;
                if (value) say(value);
                step += 1;
                renderQuestion();
            }, true);
            if (question.type === 'choice') next.hidden = true;
            chatActions.append(next);
        }
        async function submitProposal() {
            chatError.textContent = '';
            const sendButton = chatActions.querySelector('.primary');
            sendButton.disabled = true;
            try {
                const response = await fetch('/api/desa/gending/proposals', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                    body: JSON.stringify({ ...answers, website: '' }),
                });
                const result = response.status === 204 ? {} : await response.json();
                if (!response.ok) throw new Error(result.message || 'Usulan belum berhasil dikirim.');
                chatMessages.replaceChildren();
                chatControls.replaceChildren();
                chatActions.replaceChildren();
                say(result.message || 'Usulan berhasil dikirim.');
                chatActions.append(action('Selesai', () => closeChat(), true));
            } catch (error) {
                chatError.textContent = error.message;
                sendButton.disabled = false;
            }
        }
        proposalButton.addEventListener('click', () => {
            chat.classList.add('open');
            chat.setAttribute('aria-hidden', 'false');
            proposalButton.setAttribute('aria-expanded', 'true');
            if (!chatMessages.childElementCount) renderQuestion();
        });
        document.querySelector('#proposal-close').addEventListener('click', () => closeChat(false));
    </script>
    @include('desa.partials.responsive')
</body>
</html>
