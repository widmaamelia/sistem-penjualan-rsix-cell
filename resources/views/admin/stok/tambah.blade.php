@extends('layouts.admin')

@section('title', 'Tambah Stok (Restock)')

@section('styles')
<style>
    .form-container {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 25px;
    }
    .btn-remove {
        color: #ef4444;
        cursor: pointer;
        font-size: 16px;
    }
    .btn-remove:hover {
        color: #dc2626;
    }
</style>
@endsection

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('stok.index') }}" class="btn btn-outline-secondary me-3" style="border-radius: 50%; width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h4 class="m-0 fw-bold">Tambah Stok Baru (Restock)</h4>
</div>

<div class="form-container shadow-sm">
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('stok.tambah-proses') }}" method="POST" id="restockForm">
        @csrf
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold m-0">Daftar Barang Belanja Stok</h5>
            <button type="button" class="btn btn-outline-primary btn-sm" id="addRowBtn" style="border-radius: 6px; font-weight: 600;">
                <i class="fa-solid fa-plus me-1"></i> Tambah Baris
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle" id="restockTable">
                <thead class="bg-light">
                    <tr>
                        <th style="font-size: 13px; width: 45%;">Pilih Produk</th>
                        <th style="font-size: 13px; width: 20%;" class="text-center">Jumlah Tambah (Qty)</th>
                        <th style="font-size: 13px; width: 25%;">Harga Beli per Unit (Rp)</th>
                        <th style="font-size: 13px; width: 10%;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="restock-row" id="row_0">
                        <td>
                            <select name="items[0][id_produk]" class="form-select select-produk" required data-row="0">
                                <option value="">-- Pilih Produk --</option>
                                @foreach($produks as $produk)
                                    <option value="{{ $produk->id_produk }}" data-harga="{{ $produk->harga_beli }}">
                                        {{ $produk->nama_produk }} (SKU: {{ $produk->sku ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="items[0][qty_tambah]" class="form-control text-center" placeholder="1" min="1" required>
                        </td>
                        <td>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="items[0][harga_beli]" id="harga_0" class="form-control input-harga" placeholder="0" min="0" required>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="btn-remove disabled" style="opacity: 0.3; cursor: not-allowed;"><i class="fa-solid fa-trash"></i></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-4 text-end">
            <a href="{{ route('stok.index') }}" class="btn btn-outline-secondary me-2" style="border-radius: 8px; font-weight: 500;">Batal</a>
            <button type="submit" class="btn btn-primary" style="background-color: #1a5ca6; padding: 10px 24px; border-radius: 8px;">
                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Stok Baru
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let rowCount = 1;
        const addRowBtn = document.getElementById('addRowBtn');
        const restockTableBody = document.querySelector('#restockTable tbody');

        // Handle dropdown selection to automatically populate current price
        function initRowEvents(rowId) {
            const selectEl = document.querySelector(`#row_${rowId} .select-produk`);
            const hargaEl = document.querySelector(`#row_${rowId} .input-harga`);

            selectEl.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const currentHarga = selectedOption.getAttribute('data-harga');
                hargaEl.value = currentHarga || 0;
            });
        }

        // Initialize first row
        initRowEvents(0);

        // Add Row dynamically
        addRowBtn.addEventListener('click', function() {
            const newRow = document.createElement('tr');
            newRow.className = 'restock-row';
            newRow.id = `row_${rowCount}`;
            newRow.innerHTML = `
                <td>
                    <select name="items[${rowCount}][id_produk]" class="form-select select-produk" required data-row="${rowCount}">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($produks as $produk)
                            <option value="{{ $produk->id_produk }}" data-harga="{{ $produk->harga_beli }}">
                                {{ $produk->nama_produk }} (SKU: {{ $produk->sku ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][qty_tambah]" class="form-control text-center" placeholder="1" min="1" required>
                </td>
                <td>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="items[${rowCount}][harga_beli]" id="harga_${rowCount}" class="form-control input-harga" placeholder="0" min="0" required>
                    </div>
                </td>
                <td class="text-center">
                    <span class="btn-remove" onclick="removeRow(${rowCount})"><i class="fa-solid fa-trash"></i></span>
                </td>
            `;
            restockTableBody.appendChild(newRow);
            initRowEvents(rowCount);
            rowCount++;
        });
    });

    function removeRow(rowId) {
        const row = document.getElementById(`row_${rowId}`);
        if (row) {
            row.remove();
        }
    }
</script>
@endsection
