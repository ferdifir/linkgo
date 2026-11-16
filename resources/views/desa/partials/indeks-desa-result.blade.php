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

        @php
            $indexDimensions = [
                ['Layanan dasar', $villageIndexData->basic_services_score],
                ['Sosial', $villageIndexData->social_score],
                ['Ekonomi', $villageIndexData->economy_score],
                ['Lingkungan', $villageIndexData->environment_score],
                ['Aksesibilitas', $villageIndexData->accessibility_score],
                ['Tata kelola pemerintahan', $villageIndexData->governance_score],
            ];
            $hasIndexDimensions = collect($indexDimensions)->every(fn (array $dimension): bool => $dimension[1] !== null);
        @endphp

        @if ($hasIndexDimensions)
            <section class="portal-index-dimensions" aria-labelledby="portal-index-dimensions-title">
                <h3 id="portal-index-dimensions-title">Enam dimensi Indeks Desa</h3>
                <ul class="portal-index-dimension-list">
                    @foreach ($indexDimensions as [$label, $score])
                        <li class="portal-index-dimension">
                            <div class="portal-index-dimension-head">
                                <span>{{ $label }}</span>
                                <strong>{{ number_format((float) $score, 2, ',', '.') }}%</strong>
                            </div>
                            <div class="portal-index-dimension-meter" role="meter" aria-label="{{ $label }}" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ number_format((float) $score, 2, '.', '') }}">
                                <span style="width: {{ min(100, max(0, (float) $score)) }}%"></span>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <p class="portal-index-dimension-note">Persentase capaian tiap dimensi.</p>
            </section>
        @else
            <p class="portal-index-dimension-note">Rincian enam dimensi belum tersedia.</p>
        @endif

        <p class="portal-index-sources">
            <a href="{{ $villageIndexData->source_url }}" target="_blank" rel="noopener noreferrer">Portal Indeks Desa · Kemendesa PDT</a>
            <span aria-hidden="true">·</span>
            <a href="{{ $villageIndexData->source_document_url }}" target="_blank" rel="noopener noreferrer">Keputusan 343/2025</a>
            @if ($hasIndexDimensions && $villageIndexData->dimensions_source_url)
                <span aria-hidden="true">·</span>
                <a href="{{ $villageIndexData->dimensions_source_url }}" target="_blank" rel="noopener noreferrer">Rincian dimensi · Kemendesa</a>
            @endif
        </p>
    @endif
</div>
