<style>
    .village-managed-feed { margin-block: 20px; padding: 18px 0; border-top: 1px solid color-mix(in srgb, currentColor 22%, transparent); }
    .village-managed-feed h3 { margin: 0 0 12px; font-size: clamp(20px, 2.2vw, 26px); line-height: 1.25; }
    .village-managed-feed-list { display: grid; gap: 10px; }
    .village-managed-item { display: grid; gap: 6px; padding: 14px 0; border-bottom: 1px solid color-mix(in srgb, currentColor 18%, transparent); }
    .village-managed-item time, .village-managed-category { font-size: 13px; font-weight: 700; opacity: .78; }
    .village-managed-item h4 { margin: 0; font-size: 18px; line-height: 1.35; }
    .village-managed-item p { margin: 0; white-space: pre-line; }
    .village-managed-item a { width: fit-content; font-weight: 700; text-underline-offset: 3px; }
    .village-managed-item img { display: block; width: min(100%, 560px); max-height: 320px; border-radius: 10px; object-fit: cover; }
</style>
<script>
(() => {
    const match = window.location.pathname.match(/^\/desa\/([a-z0-9-]+)\/?$/);
    if (!match) return;

    const villageSlug = match[1];
    const createText = (tagName, text, className = '') => {
        const element = document.createElement(tagName);
        if (className) element.className = className;
        element.textContent = text;

        return element;
    };
    const formatDate = (date) => {
        if (!date) return '';
        const parsedDate = new Date(`${date}T00:00:00`);
        if (Number.isNaN(parsedDate.getTime())) return '';

        return new Intl.DateTimeFormat('id-ID', { dateStyle: 'long' }).format(parsedDate);
    };
    const findSection = (type) => {
        if (type === 'activity') return document.querySelector('#kegiatan') || document.querySelector('#kabar');

        return document.querySelector('#kabar') || document.querySelector('#kegiatan');
    };
    const mountFeed = (type, items) => {
        if (!items.length) return;

        const section = findSection(type);
        if (!section) return;

        const host = section.querySelector(':scope > div') || section;
        const feed = document.createElement('div');
        feed.className = 'village-managed-feed';
        feed.setAttribute('aria-label', type === 'activity' ? 'Kegiatan desa terbaru' : 'Kabar desa terbaru');
        feed.append(createText('h3', type === 'activity' ? 'Kegiatan desa terbaru' : 'Kabar dan pengumuman terbaru'));

        const list = document.createElement('div');
        list.className = 'village-managed-feed-list';
        for (const item of items) {
            const article = document.createElement('article');
            article.className = 'village-managed-item';
            const date = formatDate(item.publishedAt);
            const category = item.category?.trim();
            if (date) article.append(createText('time', date));
            else if (category) article.append(createText('span', category, 'village-managed-category'));

            article.append(createText('h4', item.title));
            const description = item.summary || item.body;
            if (description) article.append(createText('p', description));

            if (item.imageUrl) {
                const image = document.createElement('img');
                image.src = item.imageUrl;
                image.alt = item.title || '';
                image.loading = 'lazy';
                image.decoding = 'async';
                article.append(image);
            }

            if (item.link) {
                const link = document.createElement('a');
                link.href = item.link;
                link.target = '_blank';
                link.rel = 'noopener noreferrer';
                link.textContent = 'Buka informasi';
                article.append(link);
            }

            list.append(article);
        }
        feed.append(list);
        host.append(feed);

        section.querySelectorAll('.portal-data-empty').forEach((placeholder) => placeholder.remove());
    };

    fetch(`/api/desa/${villageSlug}/managed-content`, { headers: { Accept: 'application/json' } })
        .then((response) => response.ok ? response.json() : Promise.reject())
        .then((content) => {
            mountFeed('news', Array.isArray(content.news) ? content.news : []);
            mountFeed('activity', Array.isArray(content.activities) ? content.activities : []);
        })
        .catch(() => {});
})();
</script>
