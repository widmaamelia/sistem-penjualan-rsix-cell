@extends('layouts.admin')

@section('title', 'Tambah Produk Baru')

@section('styles')
<style>
    /* Header Action Bar */
    .header-action {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 20px;
        border-bottom: 1px solid #e5e7eb;
        margin-bottom: 30px;
    }
    
    .page-title {
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 20px;
        font-weight: 700;
        color: #1a5ca6;
        margin: 0;
    }
    
    .back-btn {
        color: #4b5563;
        font-size: 18px;
        transition: color 0.2s;
    }
    
    .back-btn:hover {
        color: #111827;
    }

    /* Form Container */
    .form-section {
        margin-bottom: 40px;
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 8px;
    }
    
    .required-star {
        color: #dc2626;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #d1d5db;
        padding: 10px 15px;
        font-size: 14px;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #1a5ca6;
        box-shadow: 0 0 0 3px rgba(26,92,166,0.1);
    }

    /* Photo Upload Box */
    .upload-box {
        background-color: #f8fafc;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        height: 200px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #1a5ca6;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
        overflow: hidden;
    }
    
    .upload-box:hover {
        border-color: #1a5ca6;
        background-color: #eff6ff;
    }
    
    .upload-box i {
        font-size: 32px;
        margin-bottom: 10px;
    }
    
    .upload-box span {
        font-size: 13px;
        font-weight: 600;
    }

    /* Toggle Switch Custom */
    .form-switch {
        padding-left: 2.5em;
    }
    .form-check-input {
        cursor: pointer;
    }
    .form-check-input:checked {
        background-color: #1a5ca6;
        border-color: #1a5ca6;
    }
    .toggle-label {
        font-size: 12px;
        color: #6b7280;
        font-weight: 600;
    }

    /* Input Group Custom */
    .input-group-text {
        background-color: #f9fafb;
        border-color: #d1d5db;
        color: #6b7280;
        font-size: 14px;
        font-weight: 600;
    }

    .btn-scan {
        border-color: #1a5ca6;
        color: #1a5ca6;
        background: white;
        font-weight: 600;
    }
    .btn-scan:hover {
        background-color: #f0f7ff;
        color: #1a5ca6;
    }

    /* Table Stok */
    .table-stok {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .table-stok th {
        background-color: #f9fafb;
        font-size: 11px;
        text-transform: uppercase;
        color: #6b7280;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 15px 20px;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .table-stok td {
        padding: 15px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f3f4f6;
        font-size: 13px;
        color: #374151;
        font-weight: 500;
    }
    
    /* Quantity Input */
    .qty-input-group {
        display: flex;
        width: 120px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        overflow: hidden;
    }
    
    .qty-btn {
        background-color: #f9fafb;
        border: none;
        width: 35px;
        color: #4b5563;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    
    .qty-btn:hover {
        background-color: #e5e7eb;
    }
    
    .qty-input {
        border: none;
        border-left: 1px solid #d1d5db;
        border-right: 1px solid #d1d5db;
        width: 50px;
        text-align: center;
        font-size: 13px;
        font-weight: 600;
    }
    
    .qty-input:focus {
        outline: none;
    }

    /* Total Badge */
    .badge-total {
        background-color: #f0f7ff;
        color: #1a5ca6;
        border: 1px solid #bae6fd;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 12px;
    }
</style>
@endsection

@section('content')

<!-- Global Error Display -->
@if ($errors->any())
    <div class="alert alert-danger" style="font-size: 14px;">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Header Action -->
    <div class="header-action">
        <a href="{{ route('produk.index') }}" class="btn btn-light" style="border-radius: 8px; border: 1px solid #e5e7eb; color: #4b5563; padding: 8px 14px;" title="Kembali">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div class="d-flex gap-2">
            <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary" style="border-radius: 6px; font-weight: 500; padding: 6px 16px; font-size: 13.5px;">Batal</a>
            <button type="submit" class="btn btn-primary" style="background-color: #1a5ca6; border-color: #1a5ca6; border-radius: 6px; font-weight: 500; padding: 6px 16px; font-size: 13.5px;">
                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan
            </button>
        </div>
    </div>

    <div class="form-card p-3 bg-white" style="border-radius: 12px; border: 1px solid #e5e7eb;">
        <div class="row">
            <!-- FOTO PRODUK -->
            <div class="col-md-2 mb-2 text-center">
                <label class="form-label" style="font-size:11px; margin-bottom: 4px;">Foto Produk</label>
                <div class="upload-box mx-auto position-relative" style="height: 120px; width: 120px; border-radius: 10px; padding: 10px;" onclick="document.getElementById('foto_produk').click()">
                    <!-- Default State -->
                    <div id="uploadPlaceholder" class="d-flex flex-column align-items-center justify-content-center h-100 w-100">
                        <i class="fa-regular fa-image" style="font-size: 24px; margin-bottom: 5px;"></i>
                        <span style="font-size: 10px;">Upload Foto</span>
                    </div>
                    
                    <!-- Preview Image -->
                    <img id="imagePreview" src="" alt="Preview" style="display: none; width: 100%; height: 100%; object-fit: cover; border-radius: 8px; position: absolute; top: 0; left: 0;">
                    
                    <input type="file" name="foto_produk" id="foto_produk" style="display: none;" accept="image/*" onchange="previewImage(event)">
                </div>
            </div>

            <!-- ALL INFO -->
            <div class="col-md-10">
                <!-- Baris 1: Nama, Kategori, SKU -->
                <div class="row mb-2">
                    <div class="col-md-5 mb-2">
                        <label class="form-label" style="font-size: 11px; margin-bottom: 4px;">Nama Produk <span class="required-star">*</span></label>
                        <input type="text" name="nama_produk" class="form-control form-control-sm" placeholder="Contoh: Samsung Galaxy S24 Ultra" value="{{ old('nama_produk') }}" required>
                    </div>
                    
                    <div class="col-md-4 mb-2">
                        <label class="form-label" style="font-size: 11px; margin-bottom: 4px;">Kategori</label>
                        <select name="id_kategori" class="form-select form-select-sm">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->id_kategori }}" {{ old('id_kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label mb-0" style="font-size: 11px;">SKU</label>
                            <div class="form-check form-switch mb-0" style="min-height: auto; padding-left: 2.2em;">
                                <input class="form-check-input" type="checkbox" id="skuAutoToggle" name="sku_auto" checked style="width: 1.8em; height: 1em; margin-top: 0.1em;">
                                <label class="form-check-label toggle-label" for="skuAutoToggle" style="font-size: 10px; margin-left: 2px;">Otomatis</label>
                            </div>
                        </div>
                        <input type="text" name="sku" id="skuInput" class="form-control form-control-sm" placeholder="Otomatis sistem" disabled>
                    </div>
                </div>

                <!-- Baris 2: Barcode, Harga Beli, Harga Jual -->
                <div class="row mb-2">
                    <div class="col-md-5 mb-2">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label mb-0" style="font-size: 11px;">Barcode / IMEI</label>
                            <div class="form-check form-switch mb-0" style="min-height: auto; padding-left: 2.2em;">
                                <input class="form-check-input" type="checkbox" id="barcodeAutoToggle" name="barcode_auto" checked style="width: 1.8em; height: 1em; margin-top: 0.1em;">
                                <label class="form-check-label toggle-label" for="barcodeAutoToggle" style="font-size: 10px; margin-left: 2px;">Otomatis</label>
                            </div>
                        </div>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text"><i class="fa-solid fa-barcode"></i></span>
                            <input type="text" name="barcode_imei" id="barcodeInput" class="form-control form-control-sm" placeholder="Scan atau input" disabled>
                            <button class="btn btn-scan btn-sm px-2" type="button" id="btnScan" disabled><i class="fa-solid fa-qrcode"></i></button>
                        </div>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label class="form-label" style="font-size: 11px; margin-bottom: 4px;">Harga Beli</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="harga_beli" class="form-control form-control-sm" placeholder="0" value="{{ old('harga_beli', 0) }}" required min="0">
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label" style="font-size: 11px; margin-bottom: 4px;">Harga Jual</label>
                            @if(auth()->user()->role === 'admin cabang')
                                <small class="text-danger" style="font-size: 9px;">*Hanya Super Admin</small>
                            @endif
                        </div>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="harga_jual" class="form-control form-control-sm {{ auth()->user()->role === 'admin cabang' ? 'bg-light text-muted' : '' }}" placeholder="0" value="{{ old('harga_jual', 0) }}" required min="0" {{ auth()->user()->role === 'admin cabang' ? 'readonly tabindex="-1"' : '' }}>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-2" style="border-color: #f3f4f6;">

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="text-uppercase fw-bold m-0" style="font-size:11px; color: #1a5ca6; letter-spacing:0.5px;">Stok Awal Cabang</h6>
            <div class="badge-total" style="background-color: #f0f7ff; color: #1a5ca6; padding: 3px 8px; border-radius: 4px; font-size: 10px; font-weight: 600;">
                Total: <span id="totalStokLabel">0</span>
            </div>
        </div>

        <div class="row">
            @foreach($cabangs as $cabang)
            <div class="col-md-2 col-sm-4 col-6 mb-2">
                <label class="form-label text-muted d-block text-truncate" style="font-size:10px; margin-bottom: 3px;" title="{{ $cabang->nama_cabang }}">{{ $cabang->nama_cabang }}</label>
                <div class="qty-input-group d-flex w-100" style="border: 1px solid #d1d5db; border-radius: 4px; overflow: hidden; height: 28px;">
                    <button type="button" class="qty-btn btn-minus bg-light border-0 px-2" onclick="decreaseQty('stok_{{ $cabang->id_cabang }}')"><i class="fa-solid fa-minus" style="font-size: 9px;"></i></button>
                    <input type="number" name="stok_cabang[{{ $cabang->id_cabang }}]" id="stok_{{ $cabang->id_cabang }}" class="qty-input stok-input border-0 text-center w-100" value="0" min="0" onchange="calculateTotal()" style="outline: none; background: white; font-size: 11px;">
                    <button type="button" class="qty-btn btn-plus bg-light border-0 px-2" onclick="increaseQty('stok_{{ $cabang->id_cabang }}')"><i class="fa-solid fa-plus" style="font-size: 9px;"></i></button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</form>

@endsection

@section('scripts')
<script>
    // Preview Image Logic
    function previewImage(event) {
        var input = event.target;
        var preview = document.getElementById('imagePreview');
        var placeholder = document.getElementById('uploadPlaceholder');
        
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Logic untuk Toggle SKU
    const skuToggle = document.getElementById('skuAutoToggle');
    const skuInput = document.getElementById('skuInput');
    
    skuToggle.addEventListener('change', function() {
        if (this.checked) {
            skuInput.disabled = true;
            skuInput.placeholder = "Otomatis dibuat oleh sistem";
            skuInput.value = "";
        } else {
            skuInput.disabled = false;
            skuInput.placeholder = "Masukkan SKU unik (Misal: RSX-001)";
        }
    });

    // Logic untuk Toggle Barcode
    const barcodeToggle = document.getElementById('barcodeAutoToggle');
    const barcodeInput = document.getElementById('barcodeInput');
    const btnScan = document.getElementById('btnScan');
    
    barcodeToggle.addEventListener('change', function() {
        if (this.checked) {
            barcodeInput.disabled = true;
            btnScan.disabled = true;
            barcodeInput.placeholder = "Scan atau input nomor barcode (Otomatis jika kosong)";
            barcodeInput.value = "";
        } else {
            barcodeInput.disabled = false;
            btnScan.disabled = false;
            barcodeInput.placeholder = "Scan atau input nomor barcode";
        }
    });

    // Logic untuk Kuantitas Stok (Plus/Minus)
    function increaseQty(inputId) {
        let input = document.getElementById(inputId);
        input.value = parseInt(input.value || 0) + 1;
        calculateTotal();
    }

    function decreaseQty(inputId) {
        let input = document.getElementById(inputId);
        let val = parseInt(input.value || 0);
        if (val > 0) {
            input.value = val - 1;
            calculateTotal();
        }
    }

    // Logic untuk Hitung Total Stok Realtime
    function calculateTotal() {
        let inputs = document.querySelectorAll('.stok-input');
        let total = 0;
        inputs.forEach(function(input) {
            total += parseInt(input.value || 0);
        });
        document.getElementById('totalStokLabel').innerText = total;
    }
</script>
@endsection
