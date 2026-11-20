<style>
    .portal-utility-desktop { display: inline; }
    .portal-utility-mobile { display: none; }
    @media (max-width: 700px) {
        .portal-utility-inner {
            justify-content: center !important;
            gap: 0 !important;
            min-height: 34px !important;
            font-size: 12px !important;
            white-space: nowrap;
        }
        .portal-utility-inner > :first-child { text-align: center; }
        .portal-utility-inner > :last-child { display: none !important; }
        .portal-utility-desktop { display: none !important; }
        .portal-utility-mobile { display: inline !important; }
    }
</style>
<style>
    .portal-index-result { display: grid; gap: 16px; margin-top: 16px; padding-top: 16px; border-top: 1px solid currentColor; border-color: color-mix(in srgb, currentColor 22%, transparent); }
    .portal-index-primary { display: flex; align-items: end; justify-content: space-between; gap: 18px; }
    .portal-index-primary > div { display: grid; gap: 4px; }
    .portal-index-label { font-size: 13px; font-weight: 700; }
    .portal-index-value { font-size: clamp(30px, 4vw, 44px); line-height: 1; font-variant-numeric: tabular-nums; }
    .portal-index-status { display: inline-flex; align-items: center; min-height: 32px; padding: 5px 10px; border: 1px solid currentColor; border-radius: 999px; font-size: 13px; font-weight: 800; }
    .portal-index-facts { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; margin: 0; }
    .portal-index-facts div { display: grid; gap: 3px; }
    .portal-index-facts dt { font-size: 13px; opacity: .78; }
    .portal-index-facts dd { margin: 0; font-size: 16px; font-weight: 750; font-variant-numeric: tabular-nums; }
    .portal-index-dimensions { display: grid; gap: 12px; }
    .portal-index-dimensions h3 { margin: 0; font-size: 18px; }
    .portal-index-dimension-list { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px 18px; margin: 0; padding: 0; list-style: none; }
    .portal-index-dimension { display: grid; gap: 6px; }
    .portal-index-dimension-head { display: flex; justify-content: space-between; gap: 12px; font-size: 14px; }
    .portal-index-dimension-head strong { font-variant-numeric: tabular-nums; white-space: nowrap; }
    .portal-index-dimension-meter { height: 8px; overflow: hidden; border-radius: 99px; background: color-mix(in srgb, currentColor 16%, transparent); }
    .portal-index-dimension-meter span { display: block; height: 100%; border-radius: inherit; background: currentColor; }
    .portal-index-dimension-note { margin: 0; font-size: 13px; opacity: .78; }
    .portal-index-sources { display: flex; flex-wrap: wrap; gap: 6px 9px; margin: 0; font-size: 13px; }
    .portal-index-sources a { text-decoration: underline; text-underline-offset: 3px; }
    @media (max-width: 600px) { .portal-index-primary { align-items: start; } .portal-index-primary.portal-index-unscored { flex-direction: column; } .portal-index-facts, .portal-index-dimension-list { grid-template-columns: minmax(0, 1fr); gap: 10px; } }
</style>
<style>
    /* Shared responsive guardrails. Keep village-specific layout and visual identity in each page. */
    :where(main, section, header, footer, nav, figure, article, aside, form, fieldset, dl, ul, ol, iframe, img, video) {
        min-width: 0;
        max-width: 100%;
    }

    :where(img, video, iframe) {
        max-width: 100%;
    }

    :where([class*="grid"], [class*="layout"], [class*="list"]) > * {
        min-width: 0;
    }

    .portal-mobile-stack,
    .portal-mobile-two-col {
        min-width: 0;
    }

    .sample-label {
        display: none !important;
    }

    :where(p, li) {
        font-size: max(14px, 1em) !important;
    }

    :where(
        small,
        time,
        svg text,
        [class*="date"],
        [class*="status"],
        [class*="meta"],
        [class*="kicker"],
        [class*="eyebrow"],
        [class*="caption"],
        [class*="label"],
        [class*="number"],
        [class*="credit"],
        [class~="tag"],
        [class~="hero-index"],
        [class~="utility-inner"] > span,
        [class~="notice-top"] > span,
        [class~="paper-foot"] > span,
        [class~="project-top"] > span,
        [class~="project-card-budget"] > span,
        [class~="feature-foot"] > span,
        [class~="location-detail"] strong,
        [class~="staff-row"] > *,
        [class~="staff-item"] > span,
        [class~="index-dim"] > *,
        [class~="fact-intro"] > span,
        [class~="fact-cell"] > span,
        [class~="fact"] > span
    ) {
        font-size: clamp(12px, 0.85em, 14px) !important;
    }

    :where(dt, dd, th, td) {
        font-size: clamp(13px, 0.85em, 15px) !important;
        overflow-wrap: anywhere;
    }

    :where(nav, nav a, a, button, input, select, textarea) {
        font-size: max(14px, 0.9em) !important;
    }

    @media (max-width: 700px) {
        :where(.portal-mobile-stack) {
            grid-template-columns: minmax(0, 1fr) !important;
        }

        :where(.portal-mobile-two-col) {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }

        :where(p, li) {
            font-size: max(15px, 1em) !important;
        }

        :where(
            small,
            time,
            svg text,
            [class*="date"],
            [class*="status"],
            [class*="meta"],
            [class*="kicker"],
            [class*="eyebrow"],
            [class*="caption"],
            [class*="label"],
            [class*="number"],
            [class*="credit"],
            [class~="tag"],
            [class~="hero-index"],
            [class~="utility-inner"] > span,
            [class~="notice-top"] > span,
            [class~="paper-foot"] > span,
            [class~="project-top"] > span,
            [class~="project-card-budget"] > span,
            [class~="feature-foot"] > span,
            [class~="location-detail"] strong,
            [class~="staff-row"] > *,
            [class~="staff-item"] > span,
            [class~="index-dim"] > *,
            [class~="fact-intro"] > span,
            [class~="fact-cell"] > span,
            [class~="fact"] > span
        ) {
            font-size: clamp(12px, 0.85em, 14px) !important;
        }

        :where(dt, dd, th, td) {
            font-size: max(13px, 1em) !important;
            overflow-wrap: anywhere;
        }

        :where(nav) {
            font-size: max(14px, 1em) !important;
        }

        :where(button, input, select, textarea) {
            font-size: max(14px, 1em) !important;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        :where(*, *::before, *::after) {
            scroll-behavior: auto !important;
            animation-duration: 0.01ms !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>
<style>
    .village-cms { padding: clamp(36px, 6vw, 76px) 0; border-top: 1px solid rgb(80 92 82 / 18%); }
    .village-cms-inner { width: min(1240px, calc(100% - 40px)); margin-inline: auto; }
    .village-cms-heading { margin: 0 0 24px; font-size: clamp(28px, 4vw, 42px); line-height: 1.12; }
    .village-cms-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; }
    .village-cms-group { min-width: 0; padding: 20px; border: 1px solid rgb(80 92 82 / 22%); border-radius: 12px; }
    .village-cms-group h3 { margin: 0 0 14px; font-size: 19px; }
    .village-cms-item + .village-cms-item { margin-top: 16px; padding-top: 16px; border-top: 1px solid rgb(80 92 82 / 18%); }
    .village-cms-item h4 { margin: 0 0 6px; font-size: 16px; }
    .village-cms-image { display: block; width: 100%; max-height: 260px; margin-bottom: 12px; border-radius: 8px; object-fit: cover; }
    .village-cms-item p { margin: 0 0 8px; white-space: pre-line; }
    .village-cms-item small { display: block; margin-bottom: 6px; opacity: .75; }
    .village-cms-item a { display: inline-block; margin-top: 5px; font-weight: 700; }
    .village-cms-facts { display: grid; grid-template-columns: minmax(0, .8fr) minmax(0, 1.2fr); gap: 6px 12px; margin: 8px 0 14px; }
    .village-cms-facts dt { font-weight: 700; }
    .village-cms-facts dd { margin: 0; overflow-wrap: anywhere; }
    @media (max-width: 760px) { .village-cms-inner { width: min(100% - 32px, 600px); } .village-cms-grid { grid-template-columns: minmax(0, 1fr); } .village-cms-group { padding: 17px; } }
</style>
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const match = window.location.pathname.match(/^\/desa\/([a-z0-9-]+)\/?$/);
        if (!match) return;

        try {
            const response = await fetch(`/api/desa/${encodeURIComponent(match[1])}/managed-content`);
            if (!response.ok) return;

            const content = await response.json();
            const groups = [
                ['news', 'Berita dan pengumuman'],
                ['services', 'Layanan warga'],
                ['profile', 'Profil dan potensi desa'],
            ].filter(([key]) => Array.isArray(content[key]) ? content[key].length > 0 : Boolean(content[key]));
            const footer = document.querySelector('footer');

            if (groups.length > 0) {
            const section = document.createElement('section');
            section.className = 'village-cms';
            section.setAttribute('aria-labelledby', 'village-cms-heading');
            const inner = document.createElement('div');
            inner.className = 'village-cms-inner';
            const heading = document.createElement('h2');
            heading.id = 'village-cms-heading';
            heading.className = 'village-cms-heading';
            heading.textContent = 'Informasi dari pemerintah desa';
            const grid = document.createElement('div');
            grid.className = 'village-cms-grid';

            for (const [key, title] of groups) {
                const group = document.createElement('section');
                group.className = 'village-cms-group';
                const groupHeading = document.createElement('h3');
                groupHeading.textContent = title;
                group.append(groupHeading);
                const items = Array.isArray(content[key]) ? content[key] : [content[key]];

                for (const item of items) {
                    const article = document.createElement('article');
                    article.className = 'village-cms-item';
                    if (item.imageUrl) {
                        const image = document.createElement('img');
                        image.className = 'village-cms-image';
                        image.src = item.imageUrl;
                        image.alt = item.title;
                        image.loading = 'lazy';
                        article.append(image);
                    }
                    if (item.category || item.publishedAt) {
                        const meta = document.createElement('small');
                        meta.textContent = [item.category, item.publishedAt].filter(Boolean).join(' · ');
                        article.append(meta);
                    }
                    const titleElement = document.createElement('h4');
                    titleElement.textContent = item.title;
                    article.append(titleElement);
                    if (item.summary) {
                        const summary = document.createElement('p');
                        summary.textContent = item.summary;
                        article.append(summary);
                    }
                    const body = document.createElement('p');
                    body.textContent = item.body;
                    article.append(body);

                    if (key === 'profile') {
                        const metadata = item.metadata || {};
                        const identity = [
                            ['Kepala desa', metadata.headName],
                            ['Alamat kantor', metadata.address],
                            ['Telepon', metadata.phone],
                            ['Email', metadata.email],
                            ['Jam pelayanan', metadata.officeHours],
                            ['Dusun', metadata.hamlets],
                            ['RW', metadata.rw],
                            ['RT', metadata.rt],
                        ].filter(([, value]) => value !== undefined && value !== null && value !== '');

                        if (identity.length > 0) {
                            const heading = document.createElement('h4');
                            heading.textContent = 'Informasi pemerintahan';
                            article.append(heading);
                            const details = document.createElement('dl');
                            details.className = 'village-cms-facts';
                            for (const [label, value] of identity) {
                                const term = document.createElement('dt');
                                term.textContent = label;
                                const description = document.createElement('dd');
                                description.textContent = value;
                                details.append(term, description);
                            }
                            article.append(details);
                        }
                    }

                    if (item.link) {
                        const link = document.createElement('a');
                        link.href = item.link;
                        link.target = '_blank';
                        link.rel = 'noopener noreferrer';
                        link.textContent = 'Informasi selengkapnya';
                        article.append(link);
                    }
                    group.append(article);
                }

                grid.append(group);
            }

            inner.append(heading, grid);
            section.append(inner);
            (footer?.parentNode ?? document.body).insertBefore(section, footer ?? null);
            }

        } catch (error) {
            console.error('Konten desa gagal dimuat.', error);
        }
    });
</script>

@include('desa.partials.kanal-warga')
