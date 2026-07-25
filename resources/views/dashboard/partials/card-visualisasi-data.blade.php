<div class="card border-1 border-light bg-white mb-4 overflow-hidden">

    <!-- Header Page -->
    <h2 class="fw-bold mt-2 mb-1 text-dark" style="letter-spacing: -0.5px;">Halaman Visualisasi Data</h2>

    <div class="card border-1 border-light bg-white rounded-4 p-4 mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            
            <!-- Interactive Chart Switcher Pills -->
            <ul class="nav nav-pills bg-light-custom p-1 rounded-3 border border-light gap-1" id="chartSelectorTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-2 py-1 px-3 small fw-semibold" 
                            id="tab-chart-risiko-tab" 
                            data-bs-toggle="pill" 
                            data-bs-target="#tab-chart-risiko" 
                            type="button" 
                            role="tab">
                        <i class="fa-solid fa-shield-halved me-1"></i> Skor Risiko
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-2 py-1 px-3 small fw-semibold" 
                            id="tab-chart-kurs-tab" 
                            data-bs-toggle="pill" 
                            data-bs-target="#tab-chart-kurs" 
                            type="button" 
                            role="tab">
                        <i class="fa-solid fa-coins me-1"></i> Kurs
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-2 py-1 px-3 small fw-semibold" 
                            id="tab-chart-gdp-tab" 
                            data-bs-toggle="pill" 
                            data-bs-target="#tab-chart-gdp" 
                            type="button" 
                            role="tab">
                        <i class="fa-solid fa-chart-bar me-1"></i> GDP
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-2 py-1 px-3 small fw-semibold" 
                            id="tab-chart-inflasi-tab" 
                            data-bs-toggle="pill" 
                            data-bs-target="#tab-chart-inflasi" 
                            type="button" 
                            role="tab">
                        <i class="fa-solid fa-chart-line me-1"></i> Inflasi
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-2 py-1 px-3 small fw-semibold" 
                            id="tab-chart-populasi-tab" 
                            data-bs-toggle="pill" 
                            data-bs-target="#tab-chart-populasi" 
                            type="button" 
                            role="tab">
                        <i class="fa-solid fa-users me-1"></i> Populasi
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Panes with Compact Chart Canvas (height="220") -->
        <div class="tab-content" id="chartSelectorTabsContent">
            
            <!-- Chart 1: Skor Risiko -->
            <div class="tab-pane fade show active" id="tab-chart-risiko" role="tabpanel">
                <div class="p-3 bg-light-custom rounded-4 border border-light">
                    <div class="d-flex justify-content-between align-items-center mb-3 px-2">
                        <span class="small fw-bold text-dark"><i class="fa-solid fa-shield-halved me-1"></i> Grafik Historis Skor Risiko Total</span>
                        <small class="text-muted" style="font-size: 0.75rem;">Agregasi Dinamika Risiko Terhadap Waktu</small>
                    </div>
                    <div class="bg-white p-3 rounded-3 border border-light">
                        <canvas id="grafikSkorRisiko" height="100"></canvas>
                    </div>
                </div>
            </div>

            <!-- Chart 2: Kurs -->
            <div class="tab-pane fade" id="tab-chart-kurs" role="tabpanel">
                <div class="p-3 bg-light-custom rounded-4 border border-light">
                    <div class="d-flex justify-content-between align-items-center mb-3 px-2">
                        <span class="small fw-bold text-dark"><i class="fa-solid fa-coins me-1"></i> Grafik Fluktuasi Nilai Tukar (USD)</span>
                        <small class="text-muted" style="font-size: 0.75rem;">Volatilitas Konversi Mata Uang</small>
                    </div>
                    <div class="bg-white p-3 rounded-3 border border-light">
                        <canvas id="grafikKurs" height="100"></canvas>
                    </div>
                </div>
            </div>

            <!-- Chart 3: GDP -->
            <div class="tab-pane fade" id="tab-chart-gdp" role="tabpanel">
                <div class="p-3 bg-light-custom rounded-4 border border-light">
                    <div class="d-flex justify-content-between align-items-center mb-3 px-2">
                        <span class="small fw-bold text-dark"><i class="fa-solid fa-chart-bar me-1"></i> Grafik Rekam Jejak Pertumbuhan GDP</span>
                        <small class="text-muted" style="font-size: 0.75rem;">Performa & Kapasitas Output Ekonomi</small>
                    </div>
                    <div class="bg-white p-3 rounded-3 border border-light">
                        <canvas id="grafikGdp" height="100"></canvas>
                    </div>
                </div>
            </div>

            <!-- Chart 4: Inflasi -->
            <div class="tab-pane fade" id="tab-chart-inflasi" role="tabpanel">
                <div class="p-3 bg-light-custom rounded-4 border border-light">
                    <div class="d-flex justify-content-between align-items-center mb-3 px-2">
                        <span class="small fw-bold text-dark"><i class="fa-solid fa-chart-line me-1"></i> Grafik Tingkat Inflasi Tahunan (%)</span>
                        <small class="text-muted" style="font-size: 0.75rem;">Laju Perubahan Harga Barang & Jasa</small>
                    </div>
                    <div class="bg-white p-3 rounded-3 border border-light">
                        <canvas id="grafikInflasi" height="100"></canvas>
                    </div>
                </div>
            </div>

            <!-- Chart 5: Populasi -->
            <div class="tab-pane fade" id="tab-chart-populasi" role="tabpanel">
                <div class="p-3 bg-light-custom rounded-4 border border-light">
                    <div class="d-flex justify-content-between align-items-center mb-3 px-2">
                        <span class="small fw-bold text-dark"><i class="fa-solid fa-users me-1"></i> Grafik Dinamika Pertumbuhan Populasi</span>
                        <small class="text-muted" style="font-size: 0.75rem;">Estimasi Jumlah Penduduk Berkelanjutan</small>
                    </div>
                    <div class="bg-white p-3 rounded-3 border border-light">
                        <canvas id="grafikPopulasi" height="100"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<style>
    .ls-wide { letter-spacing: 0.08em; }
    .bg-light-custom { background-color: #f8f9fa; }
    
    /* Grid Column for 5 KPI items on large screens */
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
        background-color: #ffffff !important;
        border-color: #cbd5e0 !important;
        transform: translateY(-2px);
    }

    /* Custom Styling for Chart Switcher Pills */
    #chartSelectorTabs .nav-link {
        color: #4a5568;
        background-color: transparent;
        border: 1px solid transparent;
        transition: all 0.2s ease-in-out;
    }

    #chartSelectorTabs .nav-link:hover {
        color: #1a202c;
        background-color: #ffffff;
        border-color: #e2e8f0;
    }

    #chartSelectorTabs .nav-link.active {
        color: #ffffff;
        background-color: #1a202c;
        border-color: #1a202c;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
</style>

<script>
    // Event listener to trigger Chart.js redraw when switching tabs in Bootstrap 5
    document.addEventListener('DOMContentLoaded', function () {
        const tabList = document.querySelectorAll('#chartSelectorTabs button[data-bs-toggle="pill"]');
        tabList.forEach(function (tabEl) {
            tabEl.addEventListener('shown.bs.tab', function () {
                window.dispatchEvent(new Event('resize'));
            });
        });
    });
</script>