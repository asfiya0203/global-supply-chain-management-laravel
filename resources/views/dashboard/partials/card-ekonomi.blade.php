<div class="col-lg-6 mb-4">
    <div class="card border-1 border-light bg-white rounded-4 h-100 position-relative overflow-hidden">
        <!-- Decorative Quote Accent -->
        <div class="position-absolute top-0 end-0 me-3 mt-1 text-secondary opacity-10 pe-none" style="font-size: 5rem; font-family: serif; line-height: 1;"></div>

        <!-- Header -->
        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
            <span class="badge bg-dark rounded-0 px-2 py-1 text-uppercase ls-wide" style="font-size: 0.65rem;">
                <i class="fa-solid fa-chart-line me-1"></i> Indikator Ekonomi
            </span>
            <small id="ekonomi-tahun" class="text-muted fw-semibold" style="font-size: 0.75rem;"></small>
        </div>

        <!-- Body -->
        <div class="card-body p-4 d-flex flex-column justify-content-between">
            <!-- Lead Quote Highlights: GDP & Inflasi -->
            <div class="mb-4">
                <small class="text-uppercase fw-bold text-muted ls-wide d-block mb-2" style="font-size: 0.65rem;">Tinjauan Utama</small>
                <div class="row g-3 align-items-center bg-light-custom p-3 rounded-3 border border-light">
                    <div class="col-6 border-end">
                        <small class="text-muted d-block" style="font-size: 0.7rem;">
                            <i class="fa-solid fa-money-bill-trend-up me-1"></i> GDP
                        </small>
                        <span id="detail-gdp" class="fs-4 fw-bold text-dark d-block">-</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block" style="font-size: 0.7rem;">
                            <i class="fa-solid fa-arrow-trend-up me-1"></i> Inflasi
                        </small>
                        <span id="detail-inflasi" class="fs-4 fw-bold text-dark d-block">-</span>
                    </div>
                </div>
            </div>

            <!-- Supporting Details List -->
            <div>
                <small class="text-uppercase fw-bold text-muted ls-wide d-block mb-2" style="font-size: 0.65rem;">Metrik Wilayah</small>
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between align-items-center p-2 rounded-2 bg-light-custom border border-light">
                        <span class="small text-muted"><i class="fa-solid fa-users me-2"></i> Populasi</span>
                        <span id="detail-populasi" class="fw-bold text-dark small">-</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-2 rounded-2 bg-light-custom border border-light">
                        <span class="small text-muted"><i class="fa-solid fa-box text-info me-2"></i> Ekspor</span>
                        <span id="detail-ekspor" class="fw-bold text-dark small">-</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-2 rounded-2 bg-light-custom border border-light">
                        <span class="small text-muted"><i class="fa-solid fa-ship text-danger me-2"></i> Impor</span>
                        <span id="detail-impor" class="fw-bold text-dark small">-</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>