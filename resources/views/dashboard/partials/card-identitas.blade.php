
<div class="card border-0 bg-transparent mb-5">
    <div class="card-body p-0">
        <div class="row g-4 align-items-center">
            <!-- Kolom Bendera: Menonjol dan Besar -->
            <div class="col-12 col-md-4 text-center">
                <div class="position-relative d-inline-block">
                    <img id="detail-bendera" 
                         src="" 
                         alt="Bendera Negara" 
                         class="img-fluid rounded-4" 
                         style="max-height: 180px; width: auto; border: 4px solid #fff; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.1);">
                </div>
            </div>

            <!-- Kolom Identitas: Gaya Testimonial -->
            <div class="col-12 col-md-8">
                <div class="ps-md-4">
                    <!-- Simbol Kutipan Besar (Unicode) -->
                    <div class="text-secondary opacity-25 mb-n2" style="font-size: 4rem; line-height: 1; font-family: serif;"></div>
                    
                    <!-- Nama Negara sebagai Quote -->
                    <h1 id="detail-nama" class="display-4 fw-bold mb-3 mt-n3" style="color: #2d3748; letter-spacing: -1px;">
                        <!-- Nama negara akan muncul di sini -->
                    </h1>

                    <!-- Informasi Detail sebagai Keterangan Testimonial -->
                    <div class="d-flex flex-wrap gap-4 text-muted mb-4">
                        <div>
                            <small class="text-uppercase fw-bold ls-wide d-block mb-1" style="font-size: 0.7rem; color: #a0aec0;">Ibu Kota</small>
                            <span id="detail-ibukota" class="fs-5 text-dark fw-semibold">-</span>
                        </div>
                        <div class="border-start ps-4">
                            <small class="text-uppercase fw-bold ls-wide d-block mb-1" style="font-size: 0.7rem; color: #a0aec0;">Wilayah</small>
                            <span id="detail-wilayah" class="fs-5 text-dark fw-semibold">-</span>
                        </div>
                        <div class="border-start ps-4">
                            <small class="text-uppercase fw-bold ls-wide d-block mb-1" style="font-size: 0.7rem; color: #a0aec0;">ISO Code</small>
                            <span id="detail-iso" class="fs-5 text-dark fw-semibold">-</span>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex align-items-center gap-3">
                        <form action="{{ route('favorit.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="negara_id" id="favorit-negara-id">
                            <button type="submit" class="btn btn-outline-dark rounded-pill px-4 btn-sm fw-bold shadow-sm">
                                <i class="fa-solid fa-bookmark me-2 text-warning"></i> Simpan ke Favorit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling tambahan untuk memperhalus estetika */
    #detail-nama {
        font-family: 'Inter', -apple-system, sans-serif;
    }
    .ls-wide {
        letter-spacing: 0.05em;
    }
    .bg-light-custom {
        background-color: #fdfbf7; /* Warna warm neutral yang tenang */
    }
</style>