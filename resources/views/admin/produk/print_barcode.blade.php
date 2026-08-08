<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Barcode - {{ $produk->nama_produk }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f3f4f6;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .controls {
            margin-bottom: 20px;
            text-align: center;
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
            box-sizing: border-box;
            display: flex;
            justify-content: center;
        }

        /* Thermal 58mm (Kertas Kecil Bluetooth) */
        .layout-thermal-58 {
            width: 58mm; /* Lebar kertas printer bluetooth */
            padding: 2mm;
        }
        .layout-thermal-58 .barcode-container {
            width: 100%;
            border: 1px dashed #ccc;
            padding: 5px;
            text-align: center;
            box-sizing: border-box;
        }
        .layout-thermal-58 .product-name {
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 3px;
        }
        .layout-thermal-58 .product-price {
            font-size: 11px;
            margin-top: 3px;
            font-weight: bold;
        }

        /* Standar A4 / Normal */
        .layout-normal {
            width: 100%;
            max-width: 300px;
            padding: 10px;
        }
        .layout-normal .barcode-container {
            width: 100%;
            border: 1px dashed #ccc;
            padding: 20px;
            text-align: center;
            box-sizing: border-box;
        }
        .layout-normal .product-name {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .layout-normal .product-price {
            font-size: 14px;
            margin-top: 5px;
        }

        @media print {
            @page {
                margin: 0;
            }
            body {
                background: none;
                padding: 0;
                align-items: flex-start;
            }
            .controls {
                display: none;
            }
            .page {
                box-shadow: none;
                margin: 0;
            }
            .barcode-container {
                border: none !important;
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="controls no-print">
        <div style="margin-bottom: 10px;">
            <label for="layout-select" style="font-weight: bold; font-size: 14px;">Pilih Ukuran Kertas:</label>
            <select id="layout-select" onchange="changeLayout(this.value)" style="padding: 5px; border-radius: 4px;">
                <option value="layout-thermal-58">Kertas Kecil 58mm (Printer Bluetooth)</option>
                <option value="layout-normal">Kertas Normal / A4</option>
            </select>
        </div>
        <button onclick="window.print()" class="btn btn-primary">Print Sekarang</button>
        <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
    </div>

    <div class="page layout-thermal-58" id="print-page">
        <div class="barcode-container">
            <div class="product-name">{{ $produk->nama_produk }}</div>
            <svg id="barcode"></svg>
            <div class="product-price">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Gunakan JsBarcode via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
    <script>
        function changeLayout(layoutClass) {
            const page = document.getElementById('print-page');
            page.className = 'page ' + layoutClass;
            renderBarcode(layoutClass);
        }

        function renderBarcode(layoutClass) {
            const barcodeValue = "{{ $produk->barcode_imei ?? $produk->sku }}";
            const svg = document.querySelector("#barcode");
            
            if (barcodeValue) {
                // Sesuaikan ketebalan dan ukuran berdasarkan layout
                let width = layoutClass === 'layout-thermal-58' ? 1.2 : 2;
                let height = layoutClass === 'layout-thermal-58' ? 35 : 50;
                let fontSize = layoutClass === 'layout-thermal-58' ? 11 : 14;

                // Kosongkan isi SVG sebelumnya
                svg.innerHTML = '';
                
                try {
                    JsBarcode("#barcode", barcodeValue, {
                        format: "CODE128",
                        lineColor: "#000",
                        width: width,
                        height: height,
                        displayValue: true,
                        fontSize: fontSize,
                        margin: 0
                    });
                } catch (e) {
                    svg.outerHTML = "<p style='color:red; font-size:12px;'>Invalid Barcode</p>";
                }
            } else {
                svg.outerHTML = "<p style='color:red; font-size:12px;'>Produk ini tidak memiliki SKU/Barcode</p>";
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            renderBarcode('layout-thermal-58');
            
            // Auto print
            setTimeout(function() {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
