<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f6f7f3">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Desa Pajurangan | Portal Warga | LinkGo</title>
    <meta name="description" content="Informasi pelayanan, pembangunan, dan kegiatan Desa Pajurangan.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --utility-height: 36px;
            --green-950: #17352d;
            --green-800: #285342;
            --green-700: #386a53;
            --green-100: #e5eee7;
            --cream: #f6f7f3;
            --white: #fff;
            --ink: #1e2e27;
            --muted: #68756d;
            --line: #dfe5de;
            --gold: #e7b857;
            --red: #a84d3b;
            --shadow: 0 18px 48px rgb(25 47 38 / 9%);
        }
        * { box-sizing: border-box }
        html { scroll-behavior: smooth; scroll-padding-top: 78px; scroll-snap-type: y mandatory }
        body { margin: 0; color: var(--ink); background: var(--cream); font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif }
        a { color: inherit; text-decoration: none }
        button, input, textarea, select { font: inherit }
        button { cursor: pointer }
        svg { display: block; width: 20px; height: 20px; flex: none }
        .site-width { width: min(1160px, calc(100% - 40px)); margin-inline: auto }
        .utility-bar { color: #e9f1eb; background: var(--green-950); font-size: 12px }
        .utility-inner { display: flex; min-height: 36px; align-items: center; justify-content: space-between; gap: 16px }
        .site-header { position: sticky; top: 0; z-index: 30; border-bottom: 1px solid var(--line); background: rgb(255 255 255 / 96%); backdrop-filter: blur(14px) }
        .header-inner { display: flex; min-height: 78px; align-items: center; justify-content: space-between; gap: 24px }
        .brand { display: flex; min-width: 210px; align-items: center; gap: 12px }
        .brand-mark { display: grid; width: 46px; height: 46px; flex: none; place-items: center; border: 2px solid var(--green-800); border-radius: 50%; color: var(--green-800); font: 700 20px/1 Georgia, serif }
        .brand-copy { display: grid; gap: 3px; line-height: 1.1 }
        .brand-copy strong { color: var(--green-950); font-size: 13px; letter-spacing: .02em }
        .brand-copy small { color: var(--muted); font-size: 11px }
        .main-nav { display: flex; align-items: center; gap: clamp(14px, 2.1vw, 27px); color: #48584f; font-size: 12px; font-weight: 700 }
        .main-nav a { padding-block: 10px; transition: color .16s ease }
        .main-nav a:hover { color: var(--green-700) }
        .main-nav .nav-cta { padding: 11px 15px; border-radius: 6px; color: #fff; background: var(--green-800) }
        .menu-toggle { display: none; width: 42px; height: 42px; place-items: center; border: 1px solid var(--line); border-radius: 6px; color: var(--green-950); background: #fff }
        .screen-section { min-height: calc(100svh - 78px); display: flex; align-items: center; scroll-snap-align: start; scroll-snap-stop: always }
        .screen-section > .site-width { width: min(1160px, calc(100% - 40px)); margin-inline: auto }
        .screen-hero { min-height: calc(100svh - 114px); padding-block: 22px; scroll-margin-top: var(--utility-height) }
        .hero-stack { display: grid; gap: 18px; padding-block: 12px }
        .hero-panel { position: relative; display: grid; min-height: 390px; grid-template-columns: 1.15fr .85fr; overflow: hidden; border-radius: 14px; color: #fff; background: var(--green-950); box-shadow: var(--shadow) }
        .hero-copy { position: relative; z-index: 1; display: flex; flex-direction: column; justify-content: center; padding: clamp(30px, 5.5vw, 68px) }
        .hero-copy::before { position: absolute; top: 0; right: 0; bottom: 0; width: 1px; content: ""; background: rgb(255 255 255 / 14%) }
        .hero-kicker { display: flex; align-items: center; gap: 9px; color: #e8c56f; font-size: 11px; font-weight: 800; letter-spacing: .11em; text-transform: uppercase }
        .hero-kicker svg { width: 17px; height: 17px }
        .hero h1 { max-width: 13ch; margin: 20px 0 14px; font-size: clamp(38px, 5.3vw, 66px); font-weight: 750; letter-spacing: -.055em; line-height: .99 }
        .hero-copy > p { max-width: 48ch; margin: 0; color: #d5e1d9; font-size: 15px; line-height: 1.7 }
        .hero-actions { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 25px }
        .button { display: inline-flex; min-height: 44px; align-items: center; justify-content: center; gap: 9px; padding: 0 16px; border: 1px solid transparent; border-radius: 6px; font-size: 12px; font-weight: 800; transition: background .16s ease, color .16s ease, border-color .16s ease }
        .button svg { width: 17px; height: 17px }
        .button-gold { color: var(--green-950); background: var(--gold) }
        .button-gold:hover { background: #f1cb76 }
        .button-outline { border-color: rgb(255 255 255 / 45%); color: #fff; background: transparent }
        .button-outline:hover { border-color: #fff; background: rgb(255 255 255 / 9%) }
        .hero-info { position: relative; display: flex; flex-direction: column; justify-content: center; gap: 27px; padding: 27px; background: linear-gradient(145deg, #285342, #1e4235) }
        .hero-info::after { position: absolute; right: -76px; bottom: -116px; width: 290px; height: 290px; border: 1px solid rgb(255 255 255 / 11%); border-radius: 50%; content: ""; box-shadow: 0 0 0 28px rgb(255 255 255 / 3%), 0 0 0 58px rgb(255 255 255 / 3%) }
        .hero-info-label { position: relative; z-index: 1; display: flex; align-items: center; gap: 8px; color: #d2e1d5; font-size: 10px; font-weight: 800; letter-spacing: .1em; text-transform: uppercase }
        .hero-info-label span { width: 7px; height: 7px; border-radius: 50%; background: var(--gold) }
        .announcement-card { position: relative; z-index: 1; max-width: 350px; padding: 22px; border: 1px solid rgb(255 255 255 / 19%); border-radius: 9px; background: rgb(255 255 255 / 8%); backdrop-filter: blur(4px) }
        .announcement-card .tag { display: inline-flex; margin-bottom: 14px; padding: 5px 8px; border-radius: 4px; color: var(--green-950); background: var(--gold); font-size: 9px; font-weight: 900; letter-spacing: .08em; text-transform: uppercase }
        .announcement-card h2 { margin: 0 0 9px; font-size: 22px; letter-spacing: -.03em; line-height: 1.1 }
        .announcement-card p { margin: 0; color: #d4e1d8; font-size: 12px; line-height: 1.65 }
        .announcement-meta { display: flex; justify-content: space-between; gap: 12px; margin-top: 18px; padding-top: 13px; border-top: 1px solid rgb(255 255 255 / 17%); color: #e9c96f; font-size: 10px; font-weight: 700 }
        .section { width: 100%; padding-block: clamp(52px, 8vh, 82px); border-top: 1px solid var(--line) }
        .section-white { background: #fff }
        .section-heading { display: flex; align-items: end; justify-content: space-between; gap: 24px; margin-bottom: 28px }
        .section-label { color: var(--green-700); font-size: 10px; font-weight: 900; letter-spacing: .13em; text-transform: uppercase }
        .section-heading h2 { margin: 8px 0 0; color: var(--green-950); font-size: clamp(30px, 4vw, 44px); font-weight: 750; letter-spacing: -.05em; line-height: 1.05 }
        .section-heading > p { max-width: 42ch; margin: 0; color: var(--muted); font-size: 13px; line-height: 1.65 }
        .quick-links { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); overflow: hidden; border: 1px solid var(--line); border-radius: 9px; background: #fff }
        .quick-link { display: flex; min-height: 105px; align-items: center; gap: 13px; padding: 18px; border-right: 1px solid var(--line); transition: background .16s ease }
        .quick-link:last-child { border-right: 0 }
        .quick-link:hover { background: var(--green-100) }
        .quick-icon { display: grid; width: 43px; height: 43px; flex: none; place-items: center; border-radius: 8px; color: var(--green-800); background: var(--green-100) }
        .quick-icon svg { width: 21px; height: 21px }
        .quick-link strong, .quick-link small { display: block }
        .quick-link strong { color: var(--ink); font-size: 12px }
        .quick-link small { margin-top: 5px; color: var(--muted); font-size: 10px }
        .welcome-layout { display: grid; grid-template-columns: 1fr .76fr; gap: 42px; align-items: center }
        .welcome-copy { max-width: 68ch }
        .welcome-copy h2 { margin: 10px 0 16px; color: var(--green-950); font-size: clamp(34px, 4vw, 48px); letter-spacing: -.05em; line-height: 1.03 }
        .welcome-copy > p { margin: 0; color: #56635b; font-size: 14px; line-height: 1.8 }
        .welcome-sign { display: flex; align-items: center; gap: 13px; margin-top: 22px }
        .avatar { display: grid; width: 48px; height: 48px; flex: none; place-items: center; border-radius: 50%; color: var(--green-800); background: #e5ece2; font-size: 14px; font-weight: 800 }
        .welcome-sign strong, .welcome-sign small { display: block }
        .welcome-sign strong { font-size: 12px }
        .welcome-sign small { margin-top: 4px; color: var(--muted); font-size: 10px }
        .welcome-aside { padding: 25px; border: 1px solid var(--line); border-radius: 10px; background: #fff }
        .welcome-aside h3 { margin: 0 0 16px; color: var(--green-950); font-size: 15px }
        .stat-list { display: grid; gap: 0 }
        .stat-row { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 13px 0; border-top: 1px solid var(--line); font-size: 12px }
        .stat-row span { color: var(--muted) }
        .stat-row strong { color: var(--green-800) }
        .staff-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px }
        .staff-card { padding: 21px; border: 1px solid var(--line); border-radius: 9px; background: #fff }
        .staff-card .avatar { width: 52px; height: 52px; margin-bottom: 18px; font-family: Georgia, serif; font-size: 20px }
        .staff-card small { color: var(--green-700); font-size: 9px; font-weight: 900; letter-spacing: .1em; text-transform: uppercase }
        .staff-card h3 { margin: 7px 0 4px; font-size: 14px; letter-spacing: -.02em }
        .staff-card p { margin: 0; color: var(--muted); font-size: 11px }
        .service-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px }
        .service-card { display: flex; min-height: 158px; flex-direction: column; padding: 20px; border: 1px solid var(--line); border-radius: 9px; background: #fff; transition: border-color .16s ease, transform .16s ease, box-shadow .16s ease }
        .service-card:hover { transform: translateY(-2px); border-color: #a9c1ae; box-shadow: 0 9px 24px rgb(25 47 38 / 7%) }
        .service-top { display: flex; align-items: center; justify-content: space-between }
        .service-card h3 { margin: 16px 0 6px; font-size: 14px }
        .service-card p { margin: 0; color: var(--muted); font-size: 11px; line-height: 1.6 }
        .service-card .service-link { display: inline-flex; align-items: center; gap: 6px; margin-top: auto; padding-top: 17px; color: var(--green-700); font-size: 10px; font-weight: 900 }
        .service-link svg { width: 14px; height: 14px }
        .content-grid { display: grid; grid-template-columns: 1.1fr .9fr; gap: 18px }
        .content-card { min-width: 0; padding: 24px; border: 1px solid var(--line); border-radius: 10px; background: #fff }
        .content-card h3 { margin: 0; color: var(--green-950); font-size: 20px; letter-spacing: -.04em }
        .content-card > p { margin: 7px 0 18px; color: var(--muted); font-size: 11px; line-height: 1.6 }
        .budget-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 13px }
        .year-select { min-height: 34px; padding: 0 9px; border: 1px solid var(--line); border-radius: 5px; color: var(--ink); background: #fff; font-size: 10px }
        .budget-lines { border-top: 1px solid var(--line) }
        .budget-line { display: flex; align-items: center; justify-content: space-between; gap: 15px; padding: 13px 0; border-bottom: 1px solid var(--line); font-size: 11px }
        .budget-line span { color: var(--muted) }
        .budget-line strong { color: var(--ink); font-size: 12px }
        .budget-total { margin-top: 15px; padding: 14px; border-radius: 6px; background: var(--green-100) }
        .budget-total span, .budget-total strong { display: block }
        .budget-total span { color: var(--muted); font-size: 10px }
        .budget-total strong { margin-top: 4px; color: var(--green-800); font-size: 17px }
        .index-list { display: grid; gap: 11px; margin-top: 19px }
        .index-row { display: grid; grid-template-columns: 1fr auto; gap: 7px 12px; align-items: center; font-size: 11px }
        .index-row span { font-weight: 700 }
        .index-row strong { color: var(--muted); font-size: 10px; font-weight: 700 }
        .index-track { grid-column: 1 / -1; height: 7px; overflow: hidden; border-radius: 10px; background: #edf0eb }
        .index-track i { display: block; width: 0; height: 100%; border-radius: inherit; background: #aac4a7 }
        .placeholder-note { color: var(--muted); font-size: 10px; line-height: 1.55 }
        .project-grid, .news-grid, .activity-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 15px }
        .project-card { position: relative; min-width: 0; min-height: 214px; padding: 20px; border: 1px solid var(--line); border-radius: 9px; background: #fff }
        .project-meta { display: flex; align-items: center; justify-content: space-between; gap: 9px; color: var(--muted); font-size: 10px }
        .status-pill { display: inline-flex; align-items: center; gap: 6px; padding: 5px 8px; border-radius: 20px; color: var(--green-800); background: var(--green-100); font-size: 9px; font-weight: 800 }
        .status-pill::before { width: 6px; height: 6px; border-radius: 50%; background: currentColor; content: "" }
        .project-card h3 { margin: 20px 0 7px; font-size: 15px; line-height: 1.3 }
        .project-card > p { margin: 0; color: var(--muted); font-size: 11px; line-height: 1.6 }
        .project-bottom { display: flex; align-items: end; justify-content: space-between; gap: 10px; margin-top: 20px }
        .project-bottom small, .project-bottom strong { display: block }
        .project-bottom small { color: var(--muted); font-size: 9px }
        .project-bottom strong { margin-top: 3px; font-size: 11px }
        .text-button { display: inline-flex; min-height: 34px; align-items: center; justify-content: center; gap: 6px; padding: 0 10px; border: 1px solid var(--line); border-radius: 5px; color: var(--green-800); background: #fff; font-size: 10px; font-weight: 800 }
        .text-button:hover { border-color: #a9c1ae; background: var(--green-100) }
        .text-button svg { width: 14px; height: 14px }
        .project-overlay { position: absolute; inset: 8px; z-index: 5; display: none; overflow: auto; padding: 18px; border: 1px solid #b8c8ba; border-radius: 7px; background: #fff; box-shadow: 0 12px 32px rgb(23 53 45 / 17%) }
        .project-overlay.open { display: block }
        .overlay-head { display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 14px }
        .overlay-head strong { color: var(--green-950); font-size: 12px }
        .overlay-close { display: grid; width: 30px; height: 30px; place-items: center; border: 1px solid var(--line); border-radius: 5px; color: var(--ink); background: #fff }
        .overlay-close svg { width: 15px; height: 15px }
        .overlay-detail { display: grid; grid-template-columns: 95px 1fr; gap: 10px; padding: 9px 0; border-top: 1px solid var(--line); font-size: 10px }
        .overlay-detail span { color: var(--muted) }
        .overlay-detail strong { font-weight: 700 }
        .news-card, .activity-card { overflow: hidden; border: 1px solid var(--line); border-radius: 9px; background: #fff }
        .news-thumb, .activity-thumb { display: grid; min-height: 142px; place-items: center; color: #64806c; background: linear-gradient(145deg, #dfe9dc, #f0f2e8) }
        .news-thumb svg, .activity-thumb svg { width: 38px; height: 38px; stroke-width: 1.4 }
        .news-body, .activity-body { padding: 17px }
        .news-body small, .activity-body small { color: var(--green-700); font-size: 9px; font-weight: 900; letter-spacing: .08em; text-transform: uppercase }
        .news-body h3, .activity-body h3 { margin: 8px 0 6px; font-size: 14px; line-height: 1.35 }
        .news-body p, .activity-body p { margin: 0; color: var(--muted); font-size: 11px; line-height: 1.6 }
        .profile-layout { display: grid; grid-template-columns: .85fr 1.15fr; gap: 28px; align-items: stretch }
        .profile-panel { display: flex; min-height: 280px; flex-direction: column; justify-content: space-between; padding: 28px; border-radius: 10px; color: #fff; background: var(--green-800) }
        .profile-panel h3 { max-width: 12ch; margin: 20px 0; font-size: 35px; letter-spacing: -.05em; line-height: 1.02 }
        .profile-panel p { max-width: 40ch; margin: 0; color: #dce8dd; font-size: 12px; line-height: 1.65 }
        .profile-facts { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px }
        .fact-card { display: flex; min-height: 130px; flex-direction: column; justify-content: space-between; padding: 18px; border: 1px solid var(--line); border-radius: 8px; background: #fff }
        .fact-card svg { width: 20px; height: 20px; color: var(--green-700) }
        .fact-card strong { display: block; font-size: 13px }
        .fact-card small { display: block; margin-top: 4px; color: var(--muted); font-size: 10px }
        .contact-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 18px }
        .contact-card { padding: 24px; border: 1px solid var(--line); border-radius: 9px; background: #fff }
        .contact-card h3 { margin: 0 0 16px; color: var(--green-950); font-size: 18px }
        .contact-row { display: flex; align-items: flex-start; gap: 12px; padding: 13px 0; border-top: 1px solid var(--line) }
        .contact-row .quick-icon { width: 36px; height: 36px }
        .contact-row strong, .contact-row small { display: block }
        .contact-row strong { font-size: 11px }
        .contact-row small { margin-top: 4px; color: var(--muted); font-size: 10px }
        .map-placeholder { display: grid; min-height: 282px; place-items: center; border: 1px dashed #c9d5ca; border-radius: 9px; background: #eef2ec }
        .map-placeholder iframe { display: block; width: 100%; min-height: inherit; height: 100%; border: 0; border-radius: inherit }
        .map-placeholder-inner { display: grid; justify-items: center; gap: 9px; padding: 16px 20px; border: 1px solid #d6dfd2; border-radius: 8px; background: rgb(255 255 255 / 92%); text-align: center }
        .map-placeholder-inner svg { width: 25px; height: 25px; color: var(--green-700) }
        .map-placeholder-inner strong { font-size: 11px }
        .map-placeholder-inner small { color: var(--muted); font-size: 10px }
        .site-footer { padding-block: 30px; color: #d7e3d9; background: var(--green-950); font-size: 10px }
        .footer-inner { display: flex; align-items: center; justify-content: space-between; gap: 16px }
        .footer-inner a { color: #fff }
        .powered-by { margin: 17px auto 0; color: #b6c8ba; font-size: 10px; text-align: center }
        .powered-by a { color: #fff; font-weight: 800; text-decoration: underline; text-underline-offset: 2px }
        .proposal-fab { position: fixed; right: 22px; bottom: 22px; z-index: 50; display: inline-flex; min-height: 58px; align-items: center; justify-content: center; gap: 10px; padding: 7px 18px 7px 8px; border: 0; border-radius: 50px; color: #fff; background: var(--red); box-shadow: 0 10px 30px rgb(27 49 38 / 24%); font-size: 12px; font-weight: 800 }
        .proposal-fab:hover { background: #933d2e }
        .proposal-icon { display: grid; width: 42px; height: 42px; flex: none; place-items: center; border-radius: 50%; color: var(--red); background: #fff }
        .proposal-icon svg { width: 20px; height: 20px; margin: 0 }
        .chat-panel { position: fixed; right: 22px; bottom: 92px; z-index: 51; display: none; width: min(380px, calc(100vw - 28px)); max-height: min(580px, calc(100dvh - 120px)); overflow: auto; border: 1px solid var(--line); border-radius: 12px; background: #fff; box-shadow: 0 20px 60px rgb(23 53 45 / 22%) }
        .chat-panel.open { display: block; animation: chat-in .18s ease-out }
        @keyframes chat-in { from { opacity: 0; transform: translateY(8px) } to { opacity: 1; transform: none } }
        .chat-head { display: flex; align-items: center; justify-content: space-between; padding: 15px 18px; color: #fff; background: var(--green-800) }
        .chat-head strong { font-size: 14px }
        .chat-head button { display: grid; width: 32px; height: 32px; place-items: center; border: 0; border-radius: 50%; color: #fff; background: rgb(255 255 255 / 12%) }
        .chat-head button svg { width: 17px; height: 17px }
        .chat-body { padding: 16px }
        .chat-message { width: fit-content; max-width: 92%; padding: 11px 13px; border-radius: 4px 12px 12px 12px; color: var(--ink); background: #edf2ec; font-size: 12px; line-height: 1.6; white-space: pre-line }
        .chat-message + .chat-message { margin-top: 8px }
        .chat-prompt { margin-top: 12px; color: var(--muted); font-size: 9px; font-weight: 900; letter-spacing: .08em; text-transform: uppercase }
        .chat-input { width: 100%; min-height: 42px; margin-top: 8px; padding: 10px 11px; border: 1px solid #cbd6cc; border-radius: 6px; outline-color: var(--green-700); background: #fff; font-size: 12px }
        .chat-options { display: flex; flex-wrap: wrap; gap: 7px; margin-top: 9px }
        .chat-actions { display: flex; flex-wrap: wrap; justify-content: flex-end; gap: 8px; margin-top: 13px }
        .chat-actions button, .chat-option { display: inline-flex; min-height: 36px; align-items: center; justify-content: center; padding: 0 13px; border: 1px solid #b8c9bb; border-radius: 7px; color: var(--green-800); background: #fff; font-size: 11px; font-weight: 800 }
        .chat-actions button:hover, .chat-option:hover { background: var(--green-100) }
        .chat-actions button.next { border-color: var(--green-800); color: #fff; background: var(--green-800) }
        .chat-actions button:disabled { cursor: not-allowed; opacity: .55 }
        .chat-error { margin-top: 9px; color: #a12e23; font-size: 11px }
        .motion-ready main > .screen-section .reveal,
        .motion-ready main > .screen-section .reveal-stagger { opacity: .15; transform: scale(.99); transform-origin: center; transition: opacity .38s ease, transform .46s cubic-bezier(.2,.72,.2,1) }
        .motion-ready main > .screen-section.is-visible .reveal,
        .motion-ready main > .screen-section.is-visible .reveal-stagger { opacity: 1; transform: scale(1) }
        .contact-screen { flex-direction: column; align-items: stretch; padding-bottom: 0 }
        .contact-screen > .site-width { margin-block: auto }
        .contact-footer { width: 100%; flex: none }
        :focus-visible { outline: 3px solid #d89d36; outline-offset: 3px }
        .skip-link { position: fixed; top: 8px; left: 8px; z-index: 100; padding: 10px 14px; transform: translateY(-150%); border-radius: 6px; color: #fff; background: var(--green-950) }
        .skip-link:focus { transform: translateY(0) }
        @media (max-width: 960px) {
            .main-nav { gap: 13px; font-size: 11px }
            .brand { min-width: 185px }
            .staff-grid { grid-template-columns: repeat(2, minmax(0, 1fr)) }
        }
        @media (max-width: 760px) {
            html { scroll-padding-top: 68px }
            .site-width { width: min(100% - 32px, 600px) }
            .utility-inner { min-height: 32px; font-size: 10px }
            .header-inner { min-height: 68px; gap: 12px }
            .brand { min-width: 0 }
            .brand-mark { width: 40px; height: 40px }
            .menu-toggle { display: grid }
            .main-nav { position: absolute; top: calc(100% + 1px); right: 0; left: 0; display: none; align-items: stretch; gap: 0; padding: 9px 16px 14px; border-bottom: 1px solid var(--line); background: #fff; box-shadow: 0 12px 22px rgb(23 53 45 / 9%) }
            .main-nav.open { display: flex; flex-direction: column }
            .main-nav a { padding: 12px 6px; border-bottom: 1px solid #eef1ed }
            .main-nav .nav-cta { margin-top: 8px; padding: 12px 14px; border: 0; text-align: center }
            .screen-section { min-height: calc(100svh - 68px); padding-block: 52px }
            .screen-hero { min-height: calc(100svh - 100px); padding-block: 10px; scroll-margin-top: var(--utility-height) }
            .hero-stack { gap: 12px; padding-block: 8px }
            .hero-panel { grid-template-columns: 1fr; border-radius: 10px }
            .hero-copy { padding: 30px 25px }
            .hero-copy::before { top: auto; right: 20px; bottom: 0; left: 20px; width: auto; height: 1px }
            .hero h1 { max-width: 15ch; font-size: clamp(38px, 10vw, 54px) }
            .hero-copy > p { font-size: 13px }
            .hero-info { min-height: 260px; padding: 20px 24px 24px }
            .announcement-card { max-width: none; padding: 18px }
            .announcement-card h2 { font-size: 19px }
            .section { padding-block: 58px }
            .section-heading { align-items: flex-start; flex-direction: column; gap: 10px; margin-bottom: 21px }
            .section-heading > p { font-size: 12px }
            .quick-links { grid-template-columns: repeat(2, minmax(0, 1fr)) }
            .quick-link { min-height: 92px; padding: 13px; border-bottom: 1px solid var(--line) }
            .quick-link:nth-child(2) { border-right: 0 }
            .quick-link:nth-child(n+3) { border-bottom: 0 }
            .quick-icon { width: 38px; height: 38px }
            .welcome-layout, .profile-layout, .contact-layout, .content-grid { grid-template-columns: 1fr; gap: 16px }
            .welcome-layout { gap: 24px }
            .service-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px }
            .service-card { min-height: 165px; padding: 16px }
            .project-grid, .news-grid, .activity-grid { grid-template-columns: 1fr; gap: 11px }
            .project-card { min-height: 190px }
            .news-card, .activity-card { display: grid; grid-template-columns: 100px 1fr; min-height: 125px }
            .news-thumb, .activity-thumb { min-height: 100%; }
            .news-thumb svg, .activity-thumb svg { width: 30px; height: 30px }
            .news-body, .activity-body { padding: 14px }
            .staff-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px }
            .staff-card { padding: 16px }
            .profile-panel { min-height: 245px }
            .map-placeholder { min-height: 220px }
            .footer-inner { align-items: flex-start; flex-direction: column }
            .proposal-fab { right: 14px; bottom: 14px; min-height: 54px; padding-right: 15px }
            .proposal-icon { width: 40px; height: 40px }
            .chat-panel { right: 12px; bottom: 78px; width: min(380px, calc(100vw - 24px)) }
        }
        @media (max-width: 390px) {
            .site-width { width: calc(100% - 26px) }
            .service-grid { grid-template-columns: 1fr }
            .service-card { min-height: 140px }
            .staff-card { padding: 13px }
            .staff-card h3 { font-size: 12px }
            .proposal-fab { right: 10px; bottom: 10px }
        }
        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; scroll-snap-type: none }
            *, *::before, *::after { animation-duration: .01ms !important; transition-duration: .01ms !important }
        }
        /* Each screen gets its own information layout; the viewport height is never filled with padding alone. */
        .screen-section:not(.screen-hero) { padding-block: clamp(30px, 4vh, 46px) }
        .screen-section.contact-screen { padding-bottom: 0 }
        .screen-section:not(.contact-screen) > .site-width { display: grid; align-content: center; gap: clamp(22px, 3vh, 30px) }
        .screen-section:not(.screen-hero) .section-heading { margin-bottom: 0 }
        .hero-panel { min-height: clamp(480px, 60svh, 570px) }
        .hero-copy h1 { max-width: 12ch; font-size: clamp(48px, 6vw, 72px); font-weight: 750; letter-spacing: -.055em; line-height: .99 }
        .quick-link { min-height: 116px }
        .section-heading h2 { font-size: clamp(34px, 4.2vw, 52px) }
        .welcome-layout { min-height: min(60vh, 560px); grid-template-columns: 1.12fr .88fr; gap: 16px; align-items: stretch }
        .welcome-copy { display: flex; flex-direction: column; justify-content: space-between; gap: 28px; padding: clamp(28px, 4vw, 52px); border-radius: 10px; color: white; background: var(--green-950) }
        .welcome-copy .section-label { color: #e8c56f }
        .welcome-copy h2 { max-width: 13ch; font-size: clamp(40px, 5.2vw, 64px) }
        .welcome-copy h2 { color: white }
        .welcome-copy > p { max-width: 58ch; color: #d5e1d9; font-size: 16px }
        .welcome-sign small { color: #d5e1d9 }
        .welcome-sign .avatar { color: var(--green-950); background: #f0ce7d }
        .welcome-aside { display: flex; flex-direction: column; justify-content: center; padding: clamp(24px, 3vw, 38px); border-left: 4px solid var(--gold); box-shadow: var(--shadow) }
        .welcome-aside { justify-content: space-between }
        .welcome-aside h3 { font-size: 19px }
        .stat-list { flex: 1; display: grid; grid-template-rows: repeat(5, minmax(0, 1fr)); justify-content: stretch }
        .stat-row { padding-block: 18px; font-size: 13px }
        .staff-layout { display: grid; min-height: min(58vh, 500px); grid-template-columns: minmax(230px, .68fr) 1.32fr; gap: 16px }
        .staff-lead { display: flex; flex-direction: column; justify-content: space-between; gap: 22px; padding: clamp(24px, 3vw, 38px); border-radius: 10px; color: white; background: var(--green-950) }
        .staff-lead-mark { display: grid; width: 66px; height: 66px; place-items: center; border: 1px solid rgb(255 255 255 / 45%); border-radius: 50%; color: #f0ce7d; font: 700 30px/1 Georgia, serif }
        .staff-lead .section-label { color: #e8c56f }
        .staff-lead h3 { max-width: 10ch; margin: 10px 0; font-size: clamp(24px, 2.8vw, 36px); letter-spacing: -.04em; line-height: 1.08 }
        .staff-lead p { max-width: 30ch; margin: 0; color: #d5e1d9; font-size: 13px; line-height: 1.7 }
        .staff-lead > a { display: flex; justify-content: space-between; gap: 12px; padding-top: 16px; border-top: 1px solid rgb(255 255 255 / 24%); color: #f0ce7d; font-size: 12px; font-weight: 800 }
        .staff-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); grid-template-rows: repeat(2, minmax(0, 1fr)); gap: 14px }
        .staff-card { display: grid; align-content: center; min-height: 0; padding: clamp(18px, 2vw, 28px); border-radius: 10px; box-shadow: 0 8px 24px rgb(25 47 38 / 5%) }
        .staff-card .avatar { width: 62px; height: 62px; margin-bottom: 22px }
        .services-layout { display: grid; min-height: min(68vh, 610px); grid-template-columns: minmax(235px, .68fr) 1.32fr; gap: 14px }
        .service-lead { display: flex; flex-direction: column; justify-content: space-between; gap: 24px; padding: clamp(24px, 3vw, 38px); border-radius: 10px; background: var(--green-100) }
        .service-lead h3 { max-width: 10ch; margin: 10px 0; color: var(--green-950); font-size: clamp(30px, 3.3vw, 42px); letter-spacing: -.04em; line-height: 1.08 }
        .service-lead p { max-width: 32ch; margin: 0; color: #53665a; font-size: 15px; line-height: 1.65 }
        .service-hours { padding-top: 18px; border-top: 1px solid #b9cbbb }
        .service-hours span, .service-hours strong, .service-hours small { display: block }
        .service-hours span { color: var(--green-700); font-size: 12px; font-weight: 800 }
        .service-hours strong { margin-top: 8px; color: var(--green-950); font-size: 18px }
        .service-hours small { margin-top: 4px; color: #53665a; font-size: 13px }
        .service-lead > a { display: flex; justify-content: space-between; gap: 12px; padding-top: 16px; border-top: 1px solid #b9cbbb; color: var(--green-800); font-size: 14px; font-weight: 800 }
        .service-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); grid-template-rows: repeat(3, minmax(175px, 1fr)); gap: 11px }
        .service-card { min-height: 0; padding: clamp(18px, 2vw, 26px); border-radius: 10px; text-align: left }
        .service-card h3 { margin-top: 20px; font-size: 17px }
        .service-card p { max-width: 34ch; font-size: 12px }
        .content-grid { min-height: min(56vh, 490px); gap: 16px }
        .content-card { display: flex; flex-direction: column; justify-content: center; padding: clamp(22px, 2.6vw, 34px); border-radius: 10px; box-shadow: 0 8px 24px rgb(25 47 38 / 5%) }
        .budget-line { padding-block: 17px; font-size: 12px }
        .budget-line strong { font-size: 13px }
        .budget-total { margin-top: 19px; padding: 18px }
        .budget-total strong { font-size: 20px }
        .index-list { gap: 16px; margin-top: 24px }
        .index-track { height: 9px }
        .index-row { gap: 0; padding-block: 13px; border-bottom: 1px solid var(--line) }
        .index-row strong { padding: 5px 9px; border-radius: 99px; color: var(--green-800); background: var(--green-100) }
        .index-track { display: none }
        .project-grid { min-height: min(56vh, 470px); gap: 13px }
        .project-card { display: flex; flex-direction: column; min-height: 0; padding: clamp(18px, 2vw, 25px); border-radius: 10px; box-shadow: 0 8px 24px rgb(25 47 38 / 5%) }
        .project-card h3 { margin-top: 24px; font-size: 19px }
        .project-card > p { font-size: 12px }
        .project-specs { display: grid; gap: 0; margin-top: 18px; border-top: 1px solid var(--line) }
        .project-specs > div { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding-block: 11px; border-bottom: 1px solid var(--line); font-size: 11px }
        .project-specs span { color: var(--muted) }
        .project-specs strong { font-size: 11px; font-weight: 700 }
        .project-bottom { margin-top: auto; padding-top: 22px }
        .news-grid, .activity-grid { min-height: min(54vh, 450px); gap: 14px }
        .news-card, .activity-card { display: flex; min-height: 0; flex-direction: column; border-radius: 10px; box-shadow: 0 8px 24px rgb(25 47 38 / 5%) }
        .news-thumb, .activity-thumb { min-height: 0; flex: 1; color: var(--green-800); background: linear-gradient(135deg, #e4ece2 0%, #d5e0d5 54%, #edf0e8 54%, #edf0e8 100%) }
        .news-thumb svg, .activity-thumb svg { width: 46px; height: 46px }
        .news-body, .activity-body { min-height: 175px; padding: 20px }
        .news-body h3, .activity-body h3 { font-size: 17px }
        .news-body p, .activity-body p { font-size: 12px; line-height: 1.7 }
        .profile-layout { min-height: min(56vh, 470px); gap: 16px }
        .profile-panel { min-height: 0; padding: clamp(24px, 3vw, 38px); border-radius: 10px }
        .profile-panel h3 { max-width: 9ch; font-size: clamp(38px, 5vw, 58px) }
        .profile-panel p { font-size: 14px }
        .profile-facts { gap: 14px }
        .fact-card { min-height: 0; padding: clamp(18px, 2vw, 26px); border-radius: 9px }
        .fact-card strong { font-size: 15px }
        .fact-card small { max-width: 26ch; font-size: 12px; line-height: 1.6 }
        .contact-screen { padding-top: clamp(28px, 4vh, 44px) }
        .contact-screen > .site-width { display: grid; align-content: center; gap: 22px }
        .contact-card { display: flex; flex-direction: column; justify-content: center; min-height: 310px; padding: clamp(22px, 2.5vw, 32px); border-radius: 10px }
        .contact-row { padding-block: 16px }
        .map-placeholder { min-height: 310px; border: 0; background: #e8ede5 }
        .map-placeholder-inner { padding: 22px 28px; border-radius: 10px }
        .contact-footer { margin-top: auto }
        body { font-size: 16px; line-height: 1.55 }
        .utility-bar { font-size: 13px }
        .brand-copy strong { font-size: 15px }
        .brand-copy small { font-size: 12px }
        .main-nav { font-size: 14px }
        .main-nav .nav-cta { padding: 13px 17px }
        .hero-kicker { font-size: 13px }
        .hero-copy h1 { max-width: 13ch; font-size: clamp(54px, 5vw, 76px); line-height: 1.02 }
        .hero-copy > p { font-size: 17px; line-height: 1.65 }
        .button { min-height: 48px; font-size: 14px }
        .hero-info-label { font-size: 12px }
        .announcement-card .tag { font-size: 11px }
        .announcement-card h2 { font-size: 26px }
        .announcement-card p { font-size: 14px }
        .announcement-meta { font-size: 12px }
        .section-label { font-size: 12px }
        .section-heading h2 { font-size: clamp(40px, 4.2vw, 58px) }
        .section-heading > p { font-size: 15px; line-height: 1.65 }
        .quick-link strong { font-size: 15px }
        .quick-link small { font-size: 13px }
        .welcome-copy > p { font-size: 16px; line-height: 1.7 }
        .welcome-sign strong { font-size: 14px }
        .welcome-sign small { font-size: 12px }
        .welcome-aside h3 { font-size: 20px }
        .stat-row { font-size: 15px }
        .stat-row strong { font-size: 14px }
        .staff-lead p { font-size: 15px }
        .staff-lead > a { font-size: 14px }
        .staff-card small { font-size: 12px }
        .staff-card h3 { font-size: 18px }
        .staff-card p { font-size: 14px }
        .service-card h3 { font-size: 19px }
        .service-card p { font-size: 15px; line-height: 1.6 }
        .service-card .service-link { font-size: 13px }
        .content-card h3 { font-size: 23px }
        .content-card > p { font-size: 14px }
        .year-select { font-size: 13px }
        .budget-line { font-size: 14px }
        .budget-line strong { font-size: 15px }
        .budget-total span { font-size: 13px }
        .budget-total strong { font-size: 22px }
        .index-row { font-size: 14px }
        .index-row strong { font-size: 13px }
        .placeholder-note { font-size: 12px }
        .project-meta { font-size: 13px }
        .status-pill { font-size: 12px }
        .project-card h3 { font-size: 21px }
        .project-card > p { font-size: 15px; line-height: 1.6 }
        .project-specs > div, .project-specs strong { font-size: 13px }
        .project-bottom small { font-size: 12px }
        .project-bottom strong { font-size: 15px }
        .text-button { min-height: 40px; padding-inline: 13px; font-size: 13px }
        .news-body small, .activity-body small { font-size: 12px }
        .news-body h3, .activity-body h3 { font-size: 19px }
        .news-body p, .activity-body p { font-size: 15px; line-height: 1.65 }
        .news-grid { grid-template-columns: 1.12fr .88fr; grid-template-rows: repeat(2, minmax(0, 1fr)) }
        .news-card:first-child { grid-row: 1 / 3 }
        .news-card:not(:first-child) { display: grid; grid-template-columns: minmax(120px, .72fr) 1.28fr }
        .news-card:not(:first-child) .news-thumb { min-height: 0 }
        .news-card:not(:first-child) .news-body { display: flex; min-height: 0; flex-direction: column; justify-content: center; padding: 16px }
        .news-card:not(:first-child) .news-body h3 { font-size: 16px }
        .news-card:not(:first-child) .news-body p { font-size: 13px }
        .news-thumb::after { position: absolute; right: 18px; bottom: 18px; left: 18px; color: var(--green-800); content: attr(data-caption); font-size: 13px; font-weight: 900; letter-spacing: .12em; text-align: left }
        .news-thumb { position: relative; align-items: start; justify-items: start; padding: 24px }
        .news-thumb svg { width: 52px; height: 52px }
        .activity-date { display: flex; min-height: 190px; flex-direction: column; align-items: flex-start; justify-content: center; gap: 6px; padding: 24px; color: white; background: var(--green-800) }
        .activity-date strong { font-size: clamp(46px, 5vw, 64px); font-weight: 700; letter-spacing: -.06em; line-height: 1 }
        .activity-date span { color: #f0ce7d; font-size: 14px; font-weight: 800 }
        .activity-date small { margin-top: 10px; color: #e4ece5; font-size: 13px }
        .activity-body { flex: 1; padding: 22px }
        .activity-body small { font-size: 12px }
        .profile-panel p { font-size: 15px; line-height: 1.7 }
        .fact-card strong { font-size: 16px }
        .fact-card small { font-size: 14px; line-height: 1.55 }
        .contact-card h3 { font-size: 21px }
        .contact-row strong { font-size: 14px }
        .contact-row small { font-size: 13px }
        .site-footer { font-size: 13px }
        .chat-message { font-size: 14px }
        .chat-prompt { font-size: 12px }
        .chat-actions button, .chat-option { min-height: 40px; font-size: 13px }
        @media (max-width: 760px) {
            :root { --utility-height: 32px }
            .main-nav { font-size: 15px }
            .hero-copy h1 { max-width: 14ch; font-size: clamp(42px, 10vw, 58px) }
            .hero-copy > p { font-size: 16px }
            .section-heading h2 { font-size: clamp(36px, 9vw, 48px) }
            .quick-link strong { font-size: 14px }
            .quick-link small { font-size: 12px }
        }
        @media (max-width: 760px) {
            .hero-panel { min-height: 0 }
            .hero-copy h1 { max-width: 15ch; font-size: clamp(40px, 10vw, 58px) }
            .quick-link { min-height: 92px }
            .screen-section:not(.screen-hero) { padding-block: 36px }
            .screen-section.contact-screen { padding-bottom: 0 }
            .screen-section:not(.screen-hero) > .site-width { gap: 22px }
            .welcome-layout, .staff-layout, .content-grid, .profile-layout { min-height: 0; grid-template-columns: 1fr; gap: 14px }
            .welcome-layout { gap: 14px }
            .welcome-copy { min-height: 390px; padding: 25px }
            .welcome-copy h2 { max-width: 15ch; font-size: clamp(36px, 9vw, 50px) }
            .welcome-aside { min-height: 260px }
            .staff-lead { min-height: 290px }
            .staff-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); grid-template-rows: none }
            .staff-card { min-height: 210px }
            .services-layout { min-height: 0; grid-template-columns: 1fr; gap: 12px }
            .service-lead { min-height: 300px }
            .service-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); grid-template-rows: none }
            .service-top { align-items: flex-start; flex-direction: column; gap: 10px }
            .service-card { min-height: 190px }
            .project-grid, .news-grid, .activity-grid { min-height: 0 }
            .news-grid { grid-template-columns: 1fr; grid-template-rows: none }
            .news-card:first-child { grid-row: auto }
            .news-card:not(:first-child) { display: flex; flex-direction: column }
            .news-card:not(:first-child) .news-thumb { min-height: 150px }
            .news-card:not(:first-child) .news-body { min-height: 175px; padding: 20px }
            .news-card:not(:first-child) .news-body h3 { font-size: 19px }
            .news-card:not(:first-child) .news-body p { font-size: 15px }
            .activity-date { min-height: 140px; padding: 20px }
            .project-card { min-height: 290px }
            .project-specs > div { padding-block: 8px }
            .news-card, .activity-card { min-height: 330px }
            .news-thumb, .activity-thumb { min-height: 150px }
            .profile-panel { min-height: 310px }
            .fact-card { min-height: 150px }
            .contact-screen { padding-top: 30px; padding-bottom: 0 }
            .contact-screen > .site-width { gap: 16px }
            .contact-screen .section-heading { gap: 8px }
            .contact-screen .contact-layout { gap: 12px }
            .contact-card { min-height: 0; padding: 18px }
            .contact-row { padding-block: 11px }
            .map-placeholder { min-height: 190px }
            .site-footer { padding-block: 18px }
            .proposal-fab { width: 56px; height: 56px; min-height: 56px; justify-content: center; padding: 0; border-radius: 50% }
            .proposal-fab > span:not(.proposal-icon) { display: none }
            .proposal-icon { width: 24px; height: 24px; color: #fff; background: transparent }
            .proposal-icon svg { width: 24px; height: 24px }
        }
    </style>
    @include('desa.partials.favicon')
</head>
<body>
    <a class="skip-link" href="#konten">Lewati ke konten</a>
    <div class="utility-bar">
        <div class="site-width utility-inner"><span>Pemerintah Desa Pajurangan</span><span>Kecamatan Gending · Kabupaten Probolinggo</span></div>
    </div>
    <header class="site-header">
        <div class="site-width header-inner">
            <a class="brand" href="#beranda" aria-label="Beranda Desa Pajurangan">
                <span class="portal-village-logo" aria-hidden="true"><img src="{{ asset('images/portal-logo.png') }}" alt=""></span>
                <span class="brand-copy"><strong>DESA PAJURANGAN</strong><small>Portal informasi dan layanan warga</small></span>
            </a>
            <button class="menu-toggle" id="menu-toggle" type="button" aria-label="Buka menu" aria-expanded="false" aria-controls="main-nav">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
            <nav class="main-nav" id="main-nav" aria-label="Navigasi utama">
                <a href="#beranda">Beranda</a><a href="#profil">Profil</a><a href="#layanan">Layanan</a><a href="#apbdes">APBDes</a><a href="#proyek">Pembangunan</a><a href="#kabar">Kabar desa</a><a class="nav-cta" href="#lokasi">Hubungi desa</a>
            </nav>
        </div>
    </header>

    <main id="konten">
        <section class="screen-section screen-hero" id="beranda" aria-labelledby="hero-title">
            <div class="site-width hero-stack">
            <div class="hero-panel reveal">
                <div class="hero-copy">
                    <div class="hero-kicker"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 10.5 12 4l9 6.5M5.5 9.5v10h13v-10M9 19.5v-6h6v6"/></svg>Portal resmi pemerintah desa</div>
                    <h1 id="hero-title">Selamat datang di Desa Pajurangan</h1>
                    <p>Temukan layanan, informasi pembangunan, dan kabar terbaru desa.</p>
                    <div class="hero-actions">
                        <a class="button button-gold" href="#layanan">Lihat layanan <svg class="inline-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></a>
                        <a class="button button-outline" href="#profil">Kenal desa kami</a>
                    </div>
                </div>
                <aside class="hero-info" aria-label="Pengumuman desa">
                    <div class="hero-info-label"><span aria-hidden="true"></span> Pengumuman desa</div>
                    <article class="announcement-card">
                        <span class="tag">Contoh · Pengumuman</span>
                        <h2>Jadwal pelayanan administrasi</h2>
                        <p>Contoh informasi jadwal pelayanan di kantor desa pada hari kerja.</p>
                        <div class="announcement-meta"><span>Contoh · 18 Juni 2026</span><a href="#kabar">Lihat semua <svg class="inline-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></a></div>
                    </article>
                </aside>
            </div>
            <div class="quick-links reveal" aria-label="Akses cepat">
                <a class="quick-link" href="#layanan"><span class="quick-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3.75h8l4 4v12.5H6zM14 4v4h4M9 12h6M9 15.5h6"/></svg></span><span><strong>Layanan desa</strong><small>Persyaratan dan panduan</small></span></a>
                <a class="quick-link" href="#apbdes"><span class="quick-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5h16M6.5 16V9m5.5 7V4.5m5.5 11.5v-5"/></svg></span><span><strong>APBDes</strong><small>Anggaran dan realisasi</small></span></a>
                <a class="quick-link" href="#proyek"><span class="quick-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20h16M6 20V9l6-4 6 4v11M9 20v-6h6v6M3.5 9h17"/></svg></span><span><strong>Proyek desa</strong><small>Pantau pembangunan</small></span></a>
                <a class="quick-link" href="#kabar"><span class="quick-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M5 5.5h14v13H5zM8 9h8M8 12.5h8M8 16h5"/></svg></span><span><strong>Kabar desa</strong><small>Berita dan kegiatan</small></span></a>
            </div>
            </div>
        </section>

        <section class="section screen-section section-white" id="profil">
            <div class="site-width">
                <div class="section-heading reveal"><div><span class="section-label">Pemerintah desa</span><h2>Sambutan Kepala Desa</h2></div><p>Pesan kepala desa dan informasi singkat Pajurangan.</p></div>
                <div class="welcome-layout reveal">
                    <div class="welcome-copy">
                        <span class="section-label">Desa Pajurangan</span>
                        <h2>Melayani warga, membangun desa bersama.</h2>
                        <p>Mari menjaga kebersamaan, merawat lingkungan, dan mendukung kehidupan warga Pajurangan.</p>
                        <div class="welcome-sign"><span class="avatar" aria-hidden="true">KP</span><span><strong>Nama Kepala Desa Contoh</strong><small>Kepala Desa Pajurangan</small></span></div>
                    </div>
                    <aside class="welcome-aside">
                        <div><span class="section-label">Profil wilayah</span><h3 style="margin-top:8px">Data Desa Pajurangan</h3></div>
                        <div class="stat-list">
                            <div class="stat-row"><span>Jumlah penduduk</span><strong>3.680 jiwa <small>Contoh</small></strong></div>
                            <div class="stat-row"><span>Kepala keluarga</span><strong>1.120 KK <small>Contoh</small></strong></div>
                            <div class="stat-row"><span>Jumlah dusun</span><strong>3 dusun <small>Contoh</small></strong></div>
                            <div class="stat-row"><span>RT / RW</span><strong>12 RT · 4 RW <small>Contoh</small></strong></div>
                            <div class="stat-row"><span>Alamat kantor desa</span><strong>Jl. Desa Pajurangan No. 01 <small>Contoh</small></strong></div>
                        </div>
                    </aside>
                </div>
            </div>
        </section>

        <section class="section screen-section" id="perangkat">
            <div class="site-width">
                <div class="section-heading reveal"><div><span class="section-label">Pemerintah desa</span><h2>Perangkat Desa</h2></div><p>Kenali perangkat yang melayani masyarakat.</p></div>
                <div class="staff-layout grid gap-4 reveal-stagger">
                    <aside class="staff-lead"><span class="staff-lead-mark" aria-hidden="true">P</span><div><span class="section-label">Pemerintah Pajurangan</span><h3>Perangkat desa melayani warga.</h3><p>Kenali susunan pemerintah desa dan bidang pelayanan yang tersedia.</p></div><a href="#lokasi">Hubungi kantor desa <svg class="inline-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></a></aside>
                    <div class="staff-grid portal-mobile-two-col grid grid-cols-2 gap-4">
                        <article class="staff-card"><span class="avatar" aria-hidden="true">KP</span><small>Kepala Desa</small><h3>Nama Kepala Desa Contoh</h3><p>Desa Pajurangan</p></article>
                        <article class="staff-card"><span class="avatar" aria-hidden="true">SD</span><small>Sekretaris Desa</small><h3>Nama Sekretaris Contoh</h3><p>Sekretariat desa</p></article>
                        <article class="staff-card"><span class="avatar" aria-hidden="true">KP</span><small>Kasi Pemerintahan</small><h3>Nama Kasi Contoh</h3><p>Pemerintahan</p></article>
                        <article class="staff-card"><span class="avatar" aria-hidden="true">KK</span><small>Kasi Kesejahteraan</small><h3>Nama Kasi Contoh</h3><p>Kesejahteraan</p></article>
                    </div>
                </div>
            </div>
        </section>

        <section class="section screen-section section-white" id="layanan">
            <div class="site-width">
                <div class="section-heading reveal"><div><span class="section-label">Urus keperluanmu</span><h2>Layanan Desa</h2></div><p>Pilih layanan untuk melihat informasi yang dibutuhkan.</p></div>
                <div class="services-layout grid gap-4 reveal-stagger">
                    <aside class="service-lead"><div><span class="section-label">Layanan warga</span><h3>Mulai dari kebutuhanmu.</h3><p>Contoh rincian persyaratan dan alur pengajuan.</p></div><div class="service-hours"><span>Jam pelayanan</span><strong>08.00–14.00 <span class="sample-label">Contoh</span></strong><small>Senin–Jumat</small></div><a href="#lokasi">Lihat kontak kantor desa <svg class="inline-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></a></aside>
                    <div class="service-grid portal-mobile-two-col grid grid-cols-2 gap-3">
                    <button class="service-card service-open" type="button" data-service="Surat keterangan"><span class="service-top"><span class="quick-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3.75h8l4 4v12.5H6zM14 4v4h4M9 12h6M9 15.5h6"/></svg></span><span class="section-label">Administrasi</span></span><h3>Surat keterangan</h3><p>Surat domisili, usaha, dan keterangan sesuai kebutuhan warga.</p><span class="service-link">Lihat informasi <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></span></button>
                    <button class="service-card service-open" type="button" data-service="Administrasi kependudukan"><span class="service-top"><span class="quick-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="3"/><path d="M5 20c.4-3.1 3.2-5 7-5s6.6 1.9 7 5"/></svg></span><span class="section-label">Kependudukan</span></span><h3>Administrasi kependudukan</h3><p>Pengantar pengurusan KK, KTP, akta, dan perubahan data.</p><span class="service-link">Lihat informasi <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></span></button>
                    <button class="service-card service-open" type="button" data-service="Surat pengantar"><span class="service-top"><span class="quick-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="m4 12 7 7L20 5"/></svg></span><span class="section-label">Surat</span></span><h3>Surat pengantar</h3><p>Syarat pengantar untuk kebutuhan administrasi lanjutan.</p><span class="service-link">Lihat informasi <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></span></button>
                    <button class="service-card service-open" type="button" data-service="Informasi bantuan sosial"><span class="service-top"><span class="quick-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20s-7-4.3-7-10a4 4 0 0 1 7-2.7A4 4 0 0 1 19 10c0 5.7-7 10-7 10Z"/></svg></span><span class="section-label">Sosial</span></span><h3>Informasi bantuan sosial</h3><p>Jadwal program, kategori penerima, dan informasi penyaluran.</p><span class="service-link">Lihat informasi <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></span></button>
                    <button class="service-card service-open" type="button" data-service="Pengaduan warga"><span class="service-top"><span class="quick-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M4 5h16v11H9l-5 4zM8 9h8M8 12h5"/></svg></span><span class="section-label">Aspirasi</span></span><h3>Pengaduan warga</h3><p>Laporkan kebutuhan warga dan pantau tindak lanjutnya.</p><span class="service-link">Lihat informasi <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></span></button>
                    <button class="service-card service-open" type="button" data-service="Layanan lainnya"><span class="service-top"><span class="quick-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="8.5"/><path d="M12 8v8m-4-4h8"/></svg></span><span class="section-label">Lainnya</span></span><h3>Layanan lainnya</h3><p>Daftar layanan, persyaratan, serta kontak petugas.</p><span class="service-link">Lihat informasi <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></span></button>
                    </div>
                </div>
            </div>
        </section>

        <section class="section screen-section" id="apbdes">
            <div class="site-width">
                <div class="section-heading reveal"><div><span class="section-label">Transparansi desa</span><h2>Anggaran dan Pembangunan</h2></div><p>Pantau ringkasan anggaran serta pekerjaan desa.</p></div>
                <div class="content-grid reveal-stagger">
                    <article class="content-card">
                        <div class="budget-head"><h3>APBDes</h3><select class="year-select" id="budget-year" aria-label="Tahun anggaran"><option value="">Pilih tahun</option></select></div>
                        <div id="budget-lines" class="budget-lines">
                            <span class="sample-label" id="budget-sample">APBDes 2025</span>
                            <div class="budget-line"><span>Pendapatan</span><strong>Rp 1.360.000.000</strong></div>
                            <div class="budget-line"><span>Belanja</span><strong>Rp 1.285.000.000</strong></div>
                            <div class="budget-line"><span>Pembiayaan</span><strong>Rp 75.000.000</strong></div>
                        </div>
                        <div class="budget-total"><span>Realisasi anggaran</span><strong>Rp 816.250.000</strong></div>
                    </article>
                    <article class="content-card">
                        <span class="section-label">Indeks Desa</span>
                        <h3 style="margin-top:8px">Perkembangan Desa</h3>
                        <div class="index-list">
                            <div class="index-row"><span>Layanan dasar</span><strong>0,78</strong><div class="index-track"><i style="width:78%"></i></div></div>
                            <div class="index-row"><span>Sosial</span><strong>0,73</strong><div class="index-track"><i style="width:73%"></i></div></div>
                            <div class="index-row"><span>Ekonomi</span><strong>0,69</strong><div class="index-track"><i style="width:69%"></i></div></div>
                            <div class="index-row"><span>Lingkungan</span><strong>0,75</strong><div class="index-track"><i style="width:75%"></i></div></div>
                        </div>
                        <p class="placeholder-note" style="margin:15px 0 0"><span class="sample-label">2025</span> Nilai indeks contoh: 0,74 · Maju</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="section screen-section section-white" id="proyek">
            <div class="site-width">
                <div class="section-heading reveal"><div><span class="section-label">Pembangunan desa</span><h2>Papan Proyek</h2></div><p>Lihat lokasi, progres, dan rincian pekerjaan.</p></div>
                <div class="project-grid portal-mobile-stack reveal" id="project-list" aria-live="polite">
                    <article class="project-card"><div class="project-meta"><span>2025</span><span class="status-pill">Berjalan · Contoh</span></div><h3>Peningkatan jalan lingkungan</h3><p>Perataan dan pengerasan akses jalan permukiman.</p><div class="project-specs"><div><span>Lokasi</span><strong>Dusun I · Contoh</strong></div><div><span>Volume</span><strong>320 meter</strong></div><div><span>Sumber dana</span><strong>Dana Desa · Contoh</strong></div></div><div class="project-bottom"><span><small>Anggaran · Contoh</small><strong>Rp 185.000.000</strong></span><button class="text-button" type="button" disabled>Rincian</button></div></article>
                    <article class="project-card"><div class="project-meta"><span>2025</span><span class="status-pill">Selesai · Contoh</span></div><h3>Pembangunan saluran drainase</h3><p>Penataan saluran air di kawasan permukiman.</p><div class="project-specs"><div><span>Lokasi</span><strong>Dusun II · Contoh</strong></div><div><span>Volume</span><strong>175 meter</strong></div><div><span>Sumber dana</span><strong>Dana Desa · Contoh</strong></div></div><div class="project-bottom"><span><small>Anggaran · Contoh</small><strong>Rp 92.000.000</strong></span><button class="text-button" type="button" disabled>Rincian</button></div></article>
                    <article class="project-card"><div class="project-meta"><span>2025</span><span class="status-pill">Perencanaan · Contoh</span></div><h3>Perbaikan balai warga</h3><p>Perbaikan ruang pertemuan dan fasilitas warga.</p><div class="project-specs"><div><span>Lokasi</span><strong>Dusun III · Contoh</strong></div><div><span>Volume</span><strong>1 unit</strong></div><div><span>Sumber dana</span><strong>Dana Desa · Contoh</strong></div></div><div class="project-bottom"><span><small>Anggaran · Contoh</small><strong>Rp 68.000.000</strong></span><button class="text-button" type="button" disabled>Rincian</button></div></article>
                </div>
            </div>
        </section>

        <section class="section screen-section" id="kabar">
            <div class="site-width">
                <div class="section-heading reveal"><div><span class="section-label">Informasi warga</span><h2>Kabar dan Pengumuman</h2></div><p>Berita, pengumuman, dan kegiatan Desa Pajurangan.</p></div>
                <div class="news-grid portal-mobile-stack reveal-stagger">
                    <article class="news-card"><div class="news-thumb" data-caption="PENGUMUMAN" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="5" width="16" height="15" rx="2"/><path d="M8 3v4m8-4v4M4 10h16M8 14h3m-3 3h7"/></svg></div><div class="news-body"><small>Pengumuman · 12 Juni 2026</small><h3>Jadwal pelayanan keliling <span class="sample-label">Contoh</span></h3><p>Contoh layanan administrasi di balai warga pada pekan terakhir bulan ini.</p></div></article>
                    <article class="news-card"><div class="news-thumb" data-caption="KABAR DESA" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19V5l8-2 8 2v14l-8 2zM8 9h8M8 13h8M8 17h4"/></svg></div><div class="news-body"><small>Berita desa · 19 Juni 2026</small><h3>Kerja bakti lingkungan <span class="sample-label">Contoh</span></h3><p>Contoh kegiatan perawatan saluran dan jalan lingkungan.</p></div></article>
                    <article class="news-card"><div class="news-thumb" data-caption="AGENDA WARGA" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3"/><circle cx="17" cy="9" r="2.5"/><path d="M3.5 20c.2-3.6 2.4-5.5 5.5-5.5s5.3 1.9 5.5 5.5m.2-5c3.4-.4 5.4 1.4 5.8 4.5"/></svg></div><div class="news-body"><small>Kegiatan · 23 Juni 2026</small><h3>Musyawarah warga <span class="sample-label">Contoh</span></h3><p>Contoh agenda pembahasan usulan pembangunan.</p></div></article>
                </div>
            </div>
        </section>

        <section class="section screen-section section-white" id="kegiatan">
            <div class="site-width">
                <div class="section-heading reveal"><div><span class="section-label">Agenda warga</span><h2>Kegiatan Desa</h2></div><p>Agenda dan aktivitas masyarakat.</p></div>
                <div class="activity-grid portal-mobile-stack reveal-stagger">
                    <article class="activity-card"><div class="activity-date"><strong>18</strong><span>Juni · Contoh</span><small>19.00</small></div><div class="activity-body"><small>Balai desa · Contoh agenda</small><h3>Pertemuan warga</h3><p>Contoh agenda diskusi lingkungan dan layanan warga.</p></div></article>
                    <article class="activity-card"><div class="activity-date"><strong>18</strong><span>Juni · Contoh</span><small>19.00</small></div><div class="activity-body"><small>Balai desa · Contoh agenda</small><h3>Pertemuan warga</h3><p>Contoh agenda diskusi lingkungan dan layanan warga.</p></div></article>
                    <article class="activity-card"><div class="activity-date"><strong>18</strong><span>Juni · Contoh</span><small>19.00</small></div><div class="activity-body"><small>Balai desa · Contoh agenda</small><h3>Pertemuan warga</h3><p>Contoh agenda diskusi lingkungan dan layanan warga.</p></div></article>
                </div>
            </div>
        </section>

        <section class="section screen-section" id="potensi">
            <div class="site-width">
                <div class="section-heading reveal"><div><span class="section-label">Tentang Pajurangan</span><h2>Profil dan Potensi Desa</h2></div><p>Kenali wilayah, kehidupan, dan potensi desa.</p></div>
                <div class="profile-layout reveal">
                    <article class="profile-panel"><span class="section-label" style="color:#ecd084">Profil desa</span><div><h3>Desa Pajurangan</h3><p>Contoh profil warga dan lingkungan Desa Pajurangan.</p></div></article>
                    <div class="profile-facts">
                        <article class="fact-card"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s7-4.5 7-11a7 7 0 1 0-14 0c0 6.5 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/></svg><span><strong>Wilayah</strong><small>3 dusun · 325 ha <span class="sample-label">Contoh</span></small></span></article>
                        <article class="fact-card"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20h16M6 20V9l6-5 6 5v11M9 20v-6h6v6"/></svg><span><strong>Sejarah</strong><small>Catatan sejarah desa <span class="sample-label">Contoh</span></small></span></article>
                        <article class="fact-card"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 19c4-1 6-4 9-4s5 3 9 2M4 15c3-.5 5-3 8-3s5 2 8 1M5 10c3 0 4-2 7-2s5 2 7 1"/></svg><span><strong>Potensi lokal</strong><small>Pertanian dan usaha warga <span class="sample-label">Contoh</span></small></span></article>
                        <article class="fact-card"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a15 15 0 0 1 0 18M12 3a15 15 0 0 0 0 18"/></svg><span><strong>Budaya</strong><small>Tradisi dan kegiatan warga <span class="sample-label">Contoh</span></small></span></article>
                    </div>
                </div>
            </div>
        </section>

        <section class="section screen-section section-white contact-screen" id="lokasi">
            <div class="site-width">
                <div class="section-heading reveal"><div><span class="section-label">Kunjungi kami</span><h2>Lokasi dan Kontak</h2></div><p>Hubungi Pemerintah Desa Pajurangan.</p></div>
                <div class="contact-layout reveal">
                    <article class="contact-card">
                        <h3>Kantor Desa Pajurangan</h3>
                        <div class="contact-row"><span class="quick-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s7-4.5 7-11a7 7 0 1 0-14 0c0 6.5 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/></svg></span><span><strong>Alamat</strong><small>Jl. Desa Pajurangan No. 01 <span class="sample-label">Contoh</span></small></span></div>
                        <div class="contact-row"><span class="quick-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M5 4h4l2 5-3 2c1.5 3 3 4.5 6 6l2-3 5 2v4c0 1-1 2-2 2C9 21 3 15 3 6c0-1 1-2 2-2Z"/></svg></span><span><strong>Telepon</strong><small>08xx-xxxx-xxxx <span class="sample-label">Contoh</span></small></span></div>
                        <div class="contact-row"><span class="quick-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span><span><strong>Jam pelayanan</strong><small>Senin–Jumat, 08.00–14.00 <span class="sample-label">Contoh</span></small></span></div>
                    </article>
                    <div class="map-placeholder">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d597.2978383527083!2d113.30638973693766!3d-7.792865385048131!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7ab00271fd589%3A0x2b5dc908dbb33453!2sKantor%20Desa%20Pajurangan!5e0!3m2!1sid!2sid!4v1794494987633!5m2!1sid!2sid" title="Peta Kantor Desa Pajurangan" allowfullscreen loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                    </div>
                </div>
            </div>
            @include('desa.partials.footer', [
                'villageName' => 'Pajurangan',
                'initial' => 'P',
                'theme' => 'pajurangan',
                'links' => [
                    ['label' => 'Profil Desa', 'href' => '#profil'],
                    ['label' => 'Layanan', 'href' => '#layanan'],
                    ['label' => 'APBDes', 'href' => '#apbdes'],
                    ['label' => 'Papan proyek', 'href' => '#proyek'],
                    ['label' => 'Lokasi kantor', 'href' => '#lokasi'],
                ],
            ])
        </section>
    </main>

    <button class="proposal-fab" id="proposal-open" type="button" aria-label="Sampaikan usulan" aria-expanded="false" aria-controls="proposal-chat">
        <span class="proposal-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg></span><span>Sampaikan usulan</span>
    </button>
    <section class="chat-panel" id="proposal-chat" aria-label="Form usulan warga" aria-hidden="true">
        <div class="chat-head"><strong>Usulan warga</strong><button type="button" id="proposal-close" aria-label="Tutup percakapan"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m6 6 12 12M18 6 6 18"/></svg></button></div>
        <div class="chat-body"><div id="chat-messages" aria-live="polite"></div><div id="chat-controls"></div><div class="chat-actions" id="chat-actions"></div><div class="chat-error" id="chat-error" role="alert"></div></div>
    </section>

    <dialog id="service-dialog" style="width:min(440px,calc(100% - 28px));padding:0;border:1px solid var(--line);border-radius:10px;box-shadow:var(--shadow)">
        <div style="padding:19px 21px;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;gap:12px"><strong id="service-dialog-title" style="font-size:15px"></strong><button id="service-dialog-close" class="overlay-close" type="button" aria-label="Tutup"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 6 12 12M18 6 6 18"/></svg></button></div>
        <div style="padding:20px 21px"><span class="sample-label"></span><p style="margin:10px 0 14px;color:var(--muted);font-size:12px">Persyaratan dan alur ilustrasi untuk melihat tampilan rincian.</p><div class="budget-line"><span>Persyaratan</span><strong>KTP, KK</strong></div><div class="budget-line"><span>Alur</span><strong>Formulir · Loket</strong></div><div class="budget-line"><span>Estimasi contoh</span><strong>1 hari kerja</strong></div></div>
    </dialog>

    <script>
        if ('IntersectionObserver' in window && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            document.documentElement.classList.add('motion-ready');
            const screenObserver = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    entry.target.classList.toggle('is-visible', entry.isIntersecting);
                });
            }, { threshold: 0.34 });
            document.querySelectorAll('main > .screen-section').forEach(section => screenObserver.observe(section));
        }

        const safeText = (tag, className, value) => {
            const node = document.createElement(tag);
            node.className = className;
            node.textContent = value ?? '';
            return node;
        };
        const formatRupiah = value => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(value || 0);

        const nav = document.querySelector('#main-nav');
        const menuToggle = document.querySelector('#menu-toggle');
        menuToggle.addEventListener('click', () => {
            const isOpen = nav.classList.toggle('open');
            menuToggle.setAttribute('aria-expanded', String(isOpen));
            menuToggle.setAttribute('aria-label', isOpen ? 'Tutup menu' : 'Buka menu');
        });
        nav.querySelectorAll('a').forEach(link => link.addEventListener('click', () => {
            nav.classList.remove('open');
            menuToggle.setAttribute('aria-expanded', 'false');
            menuToggle.setAttribute('aria-label', 'Buka menu');
        }));

        const serviceDialog = document.querySelector('#service-dialog');
        document.querySelectorAll('.service-open').forEach(button => button.addEventListener('click', () => {
            document.querySelector('#service-dialog-title').textContent = button.dataset.service;
            serviceDialog.showModal();
        }));
        document.querySelector('#service-dialog-close').addEventListener('click', () => serviceDialog.close());
        serviceDialog.addEventListener('click', event => {
            if (event.target === serviceDialog) serviceDialog.close();
        });

        const projectList = document.querySelector('#project-list');
        const defaultProjectCards = projectList.innerHTML;
        const sampleProjects = [
            { title: 'Peningkatan jalan lingkungan', summary: 'Perataan dan pengerasan akses jalan permukiman.', year: 2025, status: 'Berjalan', funding: 'Rp 185.000.000', location: 'Dusun I (contoh)', volume: '320 meter', executor: 'Tim Pelaksana Kegiatan (contoh)', schedule: 'Mei–Juli 2025', progress: 65, spent: 120250000, sample: true },
            { title: 'Pembangunan saluran drainase', summary: 'Penataan saluran air di kawasan permukiman.', year: 2025, status: 'Selesai', funding: 'Rp 92.000.000', location: 'Dusun II (contoh)', volume: '175 meter', executor: 'Tim Pelaksana Kegiatan (contoh)', schedule: 'Maret–Mei 2025', progress: 100, spent: 92000000, sample: true },
            { title: 'Perbaikan balai warga', summary: 'Perbaikan ruang pertemuan dan fasilitas warga.', year: 2025, status: 'Perencanaan', funding: 'Rp 68.000.000', location: 'Dusun III (contoh)', volume: '1 unit', executor: 'Pemerintah desa (contoh)', schedule: 'Agustus–Oktober 2025', progress: 15, spent: 10200000, sample: true },
        ];
        const projectFields = [
            ['Lokasi', project => project.location],
            ['Tahun', project => project.year],
            ['Status', project => project.status],
            ['Volume', project => project.volume],
            ['Sumber dana', project => project.funding],
            ['Pelaksana', project => project.executor],
            ['Jadwal', project => project.schedule],
            ['Progres fisik', project => `${project.progress ?? 0}%`],
            ['Realisasi', project => formatRupiah(project.spent)],
        ];
        function renderProjects(projects) {
            if (!projects.length) {
                projectList.innerHTML = defaultProjectCards;
                return;
            }
            projectList.replaceChildren();
            projects.forEach(project => {
                const card = document.createElement('article');
                card.className = 'project-card';
                const meta = document.createElement('div');
                meta.className = 'project-meta';
                meta.append(safeText('span', '', `Tahun ${project.year || '—'}`), safeText('span', 'status-pill', project.status || 'Status'));
                if (project.sample) meta.append(safeText('span', 'sample-label', ''));
                const bottom = document.createElement('div');
                bottom.className = 'project-bottom';
                const budget = document.createElement('span');
                budget.append(safeText('small', '', 'Anggaran'), safeText('strong', '', project.funding || 'Rp —'));
                const detailButton = safeText('button', 'text-button', 'Rincian');
                detailButton.type = 'button';
                detailButton.addEventListener('click', () => card.querySelector('.project-overlay').classList.add('open'));
                bottom.append(budget, detailButton);
                card.append(meta, safeText('h3', '', project.title), safeText('p', '', project.summary || project.location || 'Ringkasan pekerjaan'), bottom);

                const overlay = document.createElement('div');
                overlay.className = 'project-overlay';
                overlay.setAttribute('role', 'dialog');
                overlay.setAttribute('aria-label', `Rincian ${project.title}`);
                const overlayHead = document.createElement('div');
                overlayHead.className = 'overlay-head';
                overlayHead.append(safeText('strong', '', 'Rincian pekerjaan'));
                const close = safeText('button', 'overlay-close', '');
                close.type = 'button';
                close.setAttribute('aria-label', 'Tutup rincian');
                close.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 6 12 12M18 6 6 18"/></svg>';
                close.addEventListener('click', () => overlay.classList.remove('open'));
                overlayHead.append(close);
                overlay.append(overlayHead);
                projectFields.forEach(([label, getter]) => {
                    const value = getter(project);
                    if (value === undefined || value === null || value === '') return;
                    const row = document.createElement('div');
                    row.className = 'overlay-detail';
                    row.append(safeText('span', '', label), safeText('strong', '', value));
                    overlay.append(row);
                });
                if (project.details) overlay.append(safeText('p', 'placeholder-note', project.details));
                card.append(overlay);
                projectList.append(card);
            });
        }
        fetch('/api/desa/pajurangan/content').then(response => {
            if (!response.ok) throw new Error('Data proyek tidak tersedia');
            return response.json();
        }).then(data => renderProjects(data.projects?.length ? data.projects : sampleProjects)).catch(() => renderProjects(sampleProjects));

        const yearSelect = document.querySelector('#budget-year');
        const budgetLines = document.querySelector('#budget-lines');
        const budgetTotal = document.querySelector('.budget-total strong');
        let budgets = [];
        function renderBudget(year) {
            const budget = budgets.find(item => String(item.year) === String(year));
            if (!budget) {
                return;
            }
            document.querySelector('#budget-sample')?.remove();
            budgetLines.replaceChildren();
            [['Pendapatan', budget.revenue], ['Belanja', budget.expenditure], ['Pembiayaan', budget.financing]].forEach(([label, value]) => {
                const row = document.createElement('div');
                row.className = 'budget-line';
                row.append(safeText('span', '', label), safeText('strong', '', formatRupiah(value)));
                budgetLines.append(row);
            });
            budgetTotal.textContent = formatRupiah(budget.realized);
        }
        yearSelect.addEventListener('change', () => renderBudget(yearSelect.value));
        fetch('/api/desa/pajurangan/budgets').then(response => {
            if (!response.ok) throw new Error('Data anggaran tidak tersedia');
            return response.json();
        }).then(data => {
            budgets = data;
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.year;
                option.textContent = `Tahun ${item.year}`;
                yearSelect.append(option);
            });
            if (data.length) {
                yearSelect.value = data[0].year;
                renderBudget(data[0].year);
            }
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
        function appendMessage(text) {
            chatMessages.append(safeText('div', 'chat-message', text));
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
        function actionButton(label, handler, primary = false) {
            const button = safeText('button', primary ? 'next' : '', label);
            button.type = 'button';
            button.addEventListener('click', handler);
            return button;
        }
        function resetProposal() {
            answers = {};
            step = 0;
            chatMessages.replaceChildren();
            chatControls.replaceChildren();
            chatActions.replaceChildren();
            chatError.textContent = '';
            chat.classList.remove('open');
            chat.setAttribute('aria-hidden', 'true');
            proposalButton.setAttribute('aria-expanded', 'false');
        }
        function renderQuestion() {
            chatControls.replaceChildren();
            chatActions.replaceChildren();
            chatError.textContent = '';
            if (step >= questions.length) {
                appendMessage('Periksa kembali usulanmu.');
                const summary = document.createElement('div');
                summary.className = 'chat-message';
                summary.textContent = `${answers.title}\n${answers.location}\n${answers.description}`;
                chatMessages.append(summary);
                chatActions.append(actionButton('Batal', resetProposal), actionButton('Kirim usulan', submitProposal, true));
                return;
            }
            const question = questions[step];
            appendMessage(question.prompt);
            chatControls.append(safeText('div', 'chat-prompt', `${step + 1} dari ${questions.length} · ${question.label}`));
            if (question.type === 'choice') {
                const options = document.createElement('div');
                options.className = 'chat-options';
                question.options.forEach(option => {
                    options.append(actionButton(option, () => {
                        answers[question.key] = option;
                        appendMessage(option);
                        step += 1;
                        renderQuestion();
                    }));
                });
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
            chatActions.append(actionButton('Batal', resetProposal));
            if (!question.required) {
                chatActions.append(actionButton('Lewati', () => {
                    answers[question.key] = '';
                    step += 1;
                    renderQuestion();
                }));
            }
            const next = actionButton(step === questions.length - 1 ? 'Tinjau' : 'Lanjut', () => {
                const input = chatControls.querySelector('input, textarea');
                const value = input?.value.trim() || '';
                if (question.required && !value) {
                    chatError.textContent = 'Bagian ini perlu diisi.';
                    return;
                }
                answers[question.key] = value;
                if (value) appendMessage(value);
                step += 1;
                renderQuestion();
            }, true);
            if (question.type === 'choice') next.hidden = true;
            chatActions.append(next);
        }
        async function submitProposal() {
            chatError.textContent = '';
            const submit = chatActions.querySelector('.next');
            submit.disabled = true;
            try {
                const response = await fetch('/api/desa/pajurangan/proposals', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                    body: JSON.stringify({ ...answers, website: '' }),
                });
                const result = response.status === 204 ? {} : await response.json();
                if (!response.ok) throw new Error(result.message || 'Usulan belum berhasil dikirim.');
                chatMessages.replaceChildren();
                chatControls.replaceChildren();
                chatActions.replaceChildren();
                appendMessage(result.message || 'Usulan berhasil dikirim.');
                chatActions.append(actionButton('Selesai', resetProposal, true));
            } catch (error) {
                chatError.textContent = error.message;
                submit.disabled = false;
            }
        }
        proposalButton.addEventListener('click', () => {
            chat.classList.add('open');
            chat.setAttribute('aria-hidden', 'false');
            proposalButton.setAttribute('aria-expanded', 'true');
            if (!chatMessages.childElementCount) renderQuestion();
        });
        document.querySelector('#proposal-close').addEventListener('click', () => {
            chat.classList.remove('open');
            chat.setAttribute('aria-hidden', 'true');
            proposalButton.setAttribute('aria-expanded', 'false');
        });
    </script>
    @include('desa.partials.responsive')
</body>
</html>
