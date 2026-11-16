<div class="portal-index-result">
    <div class="portal-index-primary {{ $villageIndexData?->score === null ? 'portal-index-unscored' : '' }}">
        <div>
            <span class="portal-index-label">Skor Indeks Desa{{ $villageIndexData ? ' · '.$villageIndexData->year : '' }}</span>
            <strong class="portal-index-value">
                {{ $villageIndexData?->score !== null ? number_format((float) $villageIndexData->score, 2, ',', '.') : 'Belum tersedia' }}
            </strong>
        </div>
        <span class="portal-index-status">
            {{ $villageIndexData?->status ? ucwords(strtolower($villageIndexData->status)) : 'Belum tersedia' }}
        </span>
    </div>

    @if ($villageIndexData)
        <dl class="portal-index-facts">
            <div>
                <dt>Persentil nasional</dt>
                <dd>{{ $villageIndexData->national_percentile !== null ? number_format((float) $villageIndexData->national_percentile, 1, ',', '.').'%' : 'Belum tersedia' }}</dd>
            </div>
            <div>
                <dt>Rata-rata Kecamatan Gending</dt>
                <dd>{{ $villageIndexData->district_average_score !== null ? number_format((float) $villageIndexData->district_average_score, 2, ',', '.') : 'Belum tersedia' }}</dd>
            </div>
        </dl>

        <p class="portal-index-sources">
            <a href="{{ $villageIndexData->source_url }}" target="_blank" rel="noopener noreferrer">Portal Indeks Desa · Kemendesa PDT</a>
            <span aria-hidden="true">·</span>
            <a href="{{ $villageIndexData->source_document_url }}" target="_blank" rel="noopener noreferrer">Keputusan 343/2025</a>
        </p>
    @endif
</div>
