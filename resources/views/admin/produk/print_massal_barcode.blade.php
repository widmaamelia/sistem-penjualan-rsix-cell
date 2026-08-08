<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Massal Barcode</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f3f4f6;
        }
        .controls {
            margin-bottom: 20px;
            text-align: center;
        }
        .btn {
            padding: 10px 20px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            margin: 0 5px;
        }
        .btn-primary { background: #1a5ca6; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        
        .page {
            background: white;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            align-content: flex-start;
            box-sizing: border-box;
        }
        
        /* A4 Layout (Default) */
        .layout-a4 {
            width: 210mm;
            min-height: 297mm;
            padding: 10mm;
            gap: 5mm;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        .layout-a4 .barcode-item {
            width: calc(33.333% - 3.4mm);
            height: 120px;
        }

        /* Thermal 2 Column (e.g. 80x30mm) */
        .layout-thermal-2 {
            width: 80mm; /* Lebar kertas thermal */
            padding: 2mm;
            gap: 2mm;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        .layout-thermal-2 .barcode-item {
            width: calc(50% - 1mm);
            height: 30mm;
        }

        /* Thermal 1 Column (e.g. 50x30mm) */
        .layout-thermal-1 {
            width: 100%;
            max-width: 100%;
            padding: 0;
            gap: 0;
            box-shadow: none;
        }
        .layout-thermal-1 .barcode-item {
            width: 100%;
            padding: 15px 0;
            border: none;
            border-bottom: 1px dashed #ccc;
        }
        .layout-thermal-1 .product-name {
            font-size: 14px;
            white-space: normal;
        }
        .layout-thermal-1 .product-price {
            font-size: 16px;
        }
        /* Hapus svg width 100% agar barcode tidak overscale, gunakan render asli jsbarcode */
        .layout-thermal-1 svg.barcode {
            margin: 5px 0;
        }
        
        .barcode-item {
            border: 1px dashed #ccc;
            padding: 5px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: white;
            box-sizing: border-box;
            overflow: hidden;
        }
        
        .product-name {
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 100%;
        }
        
        .product-price {
            font-size: 11px;
            margin-top: 2px;
            font-weight: bold;
        }
        
        @media print {
            @page {
                margin: 0;
            }
            body {
                background: none;
                padding: 0;
                margin: 0;
                width: 100%;
            }
            .controls {
                display: none;
            }
            .page {
                box-shadow: none;
                margin: 0;
                width: 100%;
            }
            .barcode-item {
                border: 1px solid #ddd;
                page-break-inside: avoid;
            }
            .layout-thermal-1 {
                width: 100% !important;
                max-width: 100% !important;
            }
            .layout-thermal-1 .barcode-item {
                border: none !important;
                border-bottom: 1px dashed #ccc !important;
            }
            .layout-thermal-1 .product-name {
                font-size: 18px !important;
                margin-top: 5px;
            }
            .layout-thermal-1 .product-price {
                font-size: 18px !important;
                margin-bottom: 10px;
            }
            .layout-thermal-1 svg.barcode {
                max-width: 100% !important;
                /* biarkan height asli */
            }
        }
    </style>
</head>
<body>
    <div class="controls">
        <div style="margin-bottom: 10px;">
            <label for="layout-select" style="font-weight: bold; font-size: 14px;">Pilih Ukuran Kertas:</label>
            <select id="layout-select" onchange="changeLayout(this.value)" style="padding: 5px; border-radius: 4px;">
                <option value="layout-thermal-2">Thermal 2 Kolom (Cocok untuk Xprinter label)</option>
                <option value="layout-thermal-1">Kertas Kecil 58mm (Printer Bluetooth)</option>
                <option value="layout-a4">Kertas A4 Biasa (3 Kolom)</option>
            </select>
        </div>
        <button onclick="window.print()" class="btn btn-primary">Print Sekarang</button>
        <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
    </div>

    @if($produks->count() > 0)
        <div class="page layout-thermal-2" id="print-page">
            @foreach($produks as $produk)
                <div class="barcode-item">
                    <div class="product-name">{{ $produk->nama_produk }}</div>
                    <svg class="barcode" data-value="{{ $produk->barcode_imei ?? $produk->sku }}"></svg>
                    <div class="product-price">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</div>
                </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 50px; background: white;">
            Tidak ada produk untuk dicetak.
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
    <script>
        function changeLayout(layoutClass) {
            const page = document.getElementById('print-page');
            if (page) {
                // Hapus semua class layout-
                page.classList.remove('layout-a4', 'layout-thermal-1', 'layout-thermal-2');
                // Tambahkan layout terpilih
                page.classList.add(layoutClass);
                
                // Render ulang barcode dengan ukuran yang sesuai
                renderBarcodes(layoutClass);
            }
        }

        function renderBarcodes(layoutClass) {
            const barcodes = document.querySelectorAll('.barcode');
            barcodes.forEach(function(svg) {
                const value = svg.getAttribute('data-value');
                if (value) {
                    try {
                        svg.innerHTML = ''; // Kosongkan isi SVG sebelumnya
                        JsBarcode(svg, value, {
                            format: "CODE128",
                            lineColor: "#000",
                            width: layoutClass === 'layout-thermal-1' ? 2 : 1.5,
                            height: layoutClass === 'layout-thermal-1' ? 60 : 40,
                            displayValue: true,
                            fontSize: layoutClass === 'layout-thermal-1' ? 16 : 12,
                            margin: 0
                        });
                    } catch (e) {
                        svg.outerHTML = "<p style='color:red; font-size:10px; margin:0;'>Invalid Barcode Format</p>";
                    }
                } else {
                    svg.outerHTML = "<p style='color:red; font-size:10px; margin:0;'>No Barcode/SKU</p>";
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Render pertama kali
            renderBarcodes('layout-thermal-2');

            // Auto print if not empty
            @if($produks->count() > 0)
            setTimeout(function() {
                window.print();
            }, 800);
            @endif
        });
    </script>
</body>
</html>
