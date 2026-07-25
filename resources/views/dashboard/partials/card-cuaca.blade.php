
<div class="card border-1 border-light bg-white mb-4 overflow-hidden">
    <!-- Sitemap Footer Style Header -->
    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2 w-100">
            <span class="badge bg-dark rounded-0 px-2 py-1 text-uppercase ls-wide" style="font-size: 0.65rem;">
                <i class="fa-solid fa-cloud-sun me-1"></i> Cuaca Saat Ini
            </span>
            <hr class="flex-grow-1 my-0 opacity-10">
        </div>
    </div>

    <!-- Body Card: Sitemap Footer Columns -->
    <div class="card-body p-4">
        <div class="row g-4 align-items-stretch">
            
            <!-- FAR LEFT COLUMN: Weather Condition (Featured Brand/Headline Area) -->
            <div class="col-12 col-md-4 col-lg-3 border-end-md">
                <div class="pe-md-3 h-100 d-flex flex-column justify-content-center">
                    <small class="text-uppercase fw-bold text-muted ls-wide mb-2 d-block" style="font-size: 0.65rem;">
                        Kondisi Utama
                    </small>
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-3 rounded-circle bg-light-custom text-dark">
                            <i id="detail-icon-kondisi" class="fa-solid fa-cloud-sun fs-3 opacity-75"></i>
                        </div>
                        <div>
                            <span id="detail-kondisi" class="fw-bold text-dark d-block fs-4" style="line-height: 1.2;">-</span>
                            <small class="text-muted" style="font-size: 0.75rem;">Status Lingkungan</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GROUPED SITEMAP COLUMNS: Metrics Grid -->
            <div class="col-12 col-md-8 col-lg-9">
                <div class="row g-3 ps-md-2">
                    
                    <!-- Column 1: Temperature (Suhu) -->
                    <div class="col-12 col-sm-4">
                        <div class="sitemap-group p-3 rounded-3 bg-light-custom border border-light h-100">
                            <span class="text-uppercase fw-bold text-muted d-block mb-2 ls-wide" style="font-size: 0.65rem;">
                                <i class="fa-solid fa-temperature-half me-1 text-muted"></i> Suhu
                            </span>
                            <div id="detail-suhu" class="fs-4 fw-bold text-dark mb-1">-</div>
                            <small class="text-muted d-block" style="font-size: 0.7rem;">Termometer Wilayah</small>
                        </div>
                    </div>

                    <!-- Column 2: Precipitation (Curah Hujan) -->
                    <div class="col-12 col-sm-4">
                        <div class="sitemap-group p-3 rounded-3 bg-light-custom border border-light h-100">
                            <span class="text-uppercase fw-bold text-muted d-block mb-2 ls-wide" style="font-size: 0.65rem;">
                                <i class="fa-solid fa-cloud-rain me-1 text-muted"></i> Curah Hujan
                            </span>
                            <div id="detail-hujan" class="fs-4 fw-bold text-dark mb-1">-</div>
                            <small class="text-muted d-block" style="font-size: 0.7rem;">Presipitasi Harian</small>
                        </div>
                    </div>

                    <!-- Column 3: Wind Speed (Kecepatan Angin) -->
                    <div class="col-12 col-sm-4">
                        <div class="sitemap-group p-3 rounded-3 bg-light-custom border border-light h-100">
                            <span class="text-uppercase fw-bold text-muted d-block mb-2 ls-wide" style="font-size: 0.65rem;">
                                <i class="fa-solid fa-wind me-1 text-muted"></i> Kecepatan Angin
                            </span>
                            <div id="detail-angin" class="fs-4 fw-bold text-dark mb-1">-</div>
                            <small class="text-muted d-block" style="font-size: 0.7rem;">Vektor Aliran Udara</small>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .ls-wide { letter-spacing: 0.08em; }
    .bg-light-custom { background-color: #f8f9fa; }
    
    @media (min-width: 768px) {
        .border-end-md {
            border-right: 1px solid #edf2f7 !important;
        }
    }

    .sitemap-group {
        transition: border-color 0.2s ease, background-color 0.2s ease;
    }
    .sitemap-group:hover {
        background-color: #ffffff;
        border-color: #cbd5e0 !important;
    }
</style>