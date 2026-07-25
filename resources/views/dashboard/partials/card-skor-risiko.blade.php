<div class="card border-1 border-light bg-white mb-4 overflow-hidden">
    <!-- Magazine Header -->
    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-dark rounded-0 px-2 py-1 text-uppercase ls-wide" style="font-size: 0.65rem;">Risk Assessment</span>
            <hr class="flex-grow-1 my-0 opacity-10">
        </div>
    </div>

    <div class="card-body p-4">
        <!-- FEATURED POST: Total Score -->
        <div class="row g-0 mb-5 align-items-center bg-light-custom rounded-4 p-4 border border-white shadow-sm">
            <div class="col-md-7">
                <h6 class="text-uppercase fw-bold text-muted ls-wide mb-2" style="font-size: 0.75rem;">Lead Indicator</h6>
                <h2 class="display-5 fw-bold mb-1" style="color: #2d3748;">Skor Risiko Total</h2>
                <p class="text-muted small mb-0">Evaluasi komprehensif berdasarkan parameter cuaca, ekonomi, dan stabilitas wilayah.</p>
            </div>
            <div class="col-md-5 text-md-end mt-4 mt-md-0">
                <div class="d-inline-block text-center">
                    <div id="skor-total" class="display-3 fw-bold text-primary" style="line-height: 1;">-</div>
                    <div class="mt-2">
                        <span id="level-risiko" class="badge rounded-pill px-3 py-2 fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px; background-color: #e2e8f0; color: #ffffff;">
                            MENUNGGU DATA
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- GRID POSTS: Specific Scores -->
        <div class="row g-3">
            <!-- Item 1: Cuaca -->
            <div class="col-6 col-md-4 col-lg-2-4">
                <div class="h-100 p-3 rounded-3 border border-light transition-hover bg-white text-center">
                    <i class="fa-solid fa-cloud-sun text-muted mb-2 opacity-50"></i>
                    <small class="text-uppercase fw-bold d-block text-muted mb-1" style="font-size: 0.6rem;">Cuaca</small>
                    <div id="skor-cuaca" class="fw-bold fs-5 text-dark">-</div>
                </div>
            </div>

            <!-- Item 2: Bencana -->
            <div class="col-6 col-md-4 col-lg-2-4">
                <div class="h-100 p-3 rounded-3 border border-light transition-hover bg-white text-center">
                    <i class="fa-solid fa-house-crack text-muted mb-2 opacity-50"></i>
                    <small class="text-uppercase fw-bold d-block text-muted mb-1" style="font-size: 0.6rem;">Bencana</small>
                    <div id="skor-bencana" class="fw-bold fs-5 text-dark">-</div>
                </div>
            </div>

            <!-- Item 3: Berita -->
            <div class="col-6 col-md-4 col-lg-2-4">
                <div class="h-100 p-3 rounded-3 border border-light transition-hover bg-white text-center">
                    <i class="fa-solid fa-newspaper text-muted mb-2 opacity-50"></i>
                    <small class="text-uppercase fw-bold d-block text-muted mb-1" style="font-size: 0.6rem;">Berita</small>
                    <div id="skor-berita" class="fw-bold fs-5 text-dark">-</div>
                </div>
            </div>

            <!-- Item 4: Kurs -->
            <div class="col-6 col-md-4 col-lg-2-4">
                <div class="h-100 p-3 rounded-3 border border-light transition-hover bg-white text-center">
                    <i class="fa-solid fa-money-bill-transfer text-muted mb-2 opacity-50"></i>
                    <small class="text-uppercase fw-bold d-block text-muted mb-1" style="font-size: 0.6rem;">Kurs</small>
                    <div id="skor-kurs" class="fw-bold fs-5 text-dark">-</div>
                </div>
            </div>

            <!-- Item 5: Ekonomi -->
            <div class="col-12 col-md-4 col-lg-2-4">
                <div class="h-100 p-3 rounded-3 border border-light transition-hover bg-white text-center">
                    <i class="fa-solid fa-chart-line text-muted mb-2 opacity-50"></i>
                    <small class="text-uppercase fw-bold d-block text-muted mb-1" style="font-size: 0.6rem;">Ekonomi</small>
                    <div id="skor-ekonomi" class="fw-bold fs-5 text-dark">-</div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .ls-wide { letter-spacing: 0.1em; }
    .bg-light-custom { background-color: #f8f9fa; }
    
    @media (min-width: 992px) {
        .col-lg-2-4 {
            flex: 0 0 auto;
            width: 20%;
        }
    }
    .transition-hover {
        transition: all 0.2s ease;
    }
    .transition-hover:hover {
        background-color: #fff !important;
        border-color: #cbd5e0 !important;
        transform: translateY(-2px);
    }
</style>