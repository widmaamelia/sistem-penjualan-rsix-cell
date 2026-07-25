<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Barcode - {{ $produk->nama_produk }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
        .barcode-container {
            display: inline-block;
            border: 1px dashed #ccc;
            padding: 20px;
            margin: 10px;
            background-color: #fff;
        }
        .product-name {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .product-price {
            font-size: 14px;
            margin-top: 5px;
        }
        @media print {
            body {
                padding: 0;
                margin: 0;
            }
            .barcode-container {
                border: none;
                padding: 10px;
                margin: 0;
                page-break-inside: avoid;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer; background: #1a5ca6; color: white; border: none; border-radius: 5px;">Print Sekarang</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer; background: #6c757d; color: white; border: none; border-radius: 5px;">Tutup</button>
    </div>

    <div class="barcode-container">
        <div class="product-name">{{ $produk->nama_produk }}</div>
        <svg id="barcode"></svg>
        <div class="product-price">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</div>
    </div>

    <!-- Gunakan JsBarcode via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var barcodeValue = "{{ $produk->barcode_imei ?? $produk->sku }}";
            
            if (barcodeValue) {
                JsBarcode("#barcode", barcodeValue, {
                    format: "CODE128",
                    lineColor: "#000",
                    width: 2,
                    height: 50,
                    displayValue: true,
                    fontSize: 14
                });
            } else {
                document.getElementById('barcode').outerHTML = "<p style='color:red;'>Produk ini tidak memiliki SKU/Barcode</p>";
            }

            // Auto print prompt after a brief delay to allow rendering
            setTimeout(function() {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
