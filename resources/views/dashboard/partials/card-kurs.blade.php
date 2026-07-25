<!-- Chosen Palette: Warm Sand & Slate (Minimalist Neutral) -->
<!-- Layout Plan: 
     - Testimonial Quote Style Card (Side-by-side with Ekonomi Card in a 2-column grid).
     - Flat border design with no heavy shadows, matching the modern UI theme.
     - Large decorative quotation mark graphic in background accent.
     - Lead Section: Conversion Rate (USD) styled as a focal quote statement.
     - Secondary Section: Exchange code, trend, change rate, and risk level styled as minimalist metadata badges/rows.
-->

<div class="col-lg-6 mb-4">
    <div class="card border-1 border-light bg-white rounded-4 h-100 position-relative overflow-hidden">
        <!-- Decorative Quote Accent -->
        <div class="position-absolute top-0 end-0 me-3 mt-1 text-secondary opacity-10 pe-none" style="font-size: 5rem; font-family: serif; line-height: 1;"></div>

        <!-- Header -->
        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
            <span class="badge bg-dark rounded-0 px-2 py-1 text-uppercase ls-wide" style="font-size: 0.65rem;">
                <i class="fa-solid fa-coins me-1"></i> Kurs Mata Uang
            </span>
            <small id="kurs-tanggal" class="text-muted fw-semibold" style="font-size: 0.75rem;"></small>
        </div>

        <!-- Body -->
        <div class="card-body p-4 d-flex flex-column justify-content-between">
            <!-- Loading Indicator -->
            <div id="loading-kurs" class="text-center py-4" style="display:none;">
                <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                <span class="ms-2 text-muted small">Memuat data kurs...</span>
            </div>

            <!-- Content Area -->
            <div id="konten-kurs" class="d-flex flex-column justify-content-between h-100">
                <!-- Lead Quote Highlight: Exchange Value -->
                <div class="mb-4">
                    <small class="text-uppercase fw-bold text-muted ls-wide d-block mb-2" style="font-size: 0.65rem;">Konversi Utama</small>
                    <div class="p-3 rounded-3 bg-light-custom border border-light">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small text-muted"><i class="fa-solid fa-tag me-1"></i> Kode Mata Uang</span>
                            <span id="detail-kode-mata-uang" class="badge bg-dark text-white font-monospace">-</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-baseline mt-2">
                            <span class="small text-muted"><i class="fa-solid fa-dollar-sign me-1"></i> 1 USD =</span>
                            <span id="detail-kurs" class="fs-3 fw-bold text-dark">-</span>
                        </div>
                    </div>
                </div>

                <!-- Supporting Details List -->
                <div>
                    <small class="text-uppercase fw-bold text-muted ls-wide d-block mb-2" style="font-size: 0.65rem;">Analisis Pergerakan</small>
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between align-items-center p-2 rounded-2 bg-light-custom border border-light">
                            <span class="small text-muted"><i class="fa-solid fa-arrow-trend-up me-2"></i> Perubahan</span>
                            <span id="detail-perubahan-kurs" class="fw-bold text-dark small">-</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center p-2 rounded-2 bg-light-custom border border-light">
                            <span class="small text-muted"><i class="fa-solid fa-chart-line me-2"></i> Tren</span>
                            <span id="detail-tren-kurs" class="fw-bold text-dark small">-</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>