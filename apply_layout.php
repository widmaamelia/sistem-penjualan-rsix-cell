<?php
$xml = <<<'XML'
<mxfile host="app.diagrams.net">
  <diagram id="sistem_saat_ini_v3" name="Sistem Saat Ini (Tanpa Crossing)">
    <mxGraphModel dx="1290" dy="765" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="1300" pageHeight="1950" math="0" shadow="0">
      <root>
        <mxCell id="0" />
        <mxCell id="1" parent="0" />
        
        <!-- Swimlanes -->
        <mxCell id="lane_k" parent="1" style="swimlane;html=1;startSize=40;fillColor=#fff2cc;strokeColor=#d6b656;fontStyle=1;fontSize=16;" value="Karyawan / Kasir" vertex="1">
          <mxGeometry height="1850" width="400" x="40" y="40" as="geometry" />
        </mxCell>
        <mxCell id="lane_s" parent="1" style="swimlane;html=1;startSize=40;fillColor=#f5f5f5;strokeColor=#666666;fontStyle=1;fontSize=16;" value="Sistem Desktop (Lama)" vertex="1">
          <mxGeometry height="1850" width="400" x="440" y="40" as="geometry" />
        </mxCell>
        <mxCell id="lane_p" parent="1" style="swimlane;html=1;startSize=40;fillColor=#d5e8d4;strokeColor=#82b366;fontStyle=1;fontSize=16;" value="Pemilik" vertex="1">
          <mxGeometry height="1850" width="400" x="840" y="40" as="geometry" />
        </mxCell>

        <!-- Y=100 -->
        <mxCell id="k_start" parent="1" style="shape=mxgraph.flowchart.terminator;whiteSpace=wrap;html=1;fontSize=14;fillColor=#000000;fontColor=#ffffff;strokeColor=none;" value="Mulai" vertex="1">
          <mxGeometry height="50" width="120" x="180" y="100" as="geometry" />
        </mxCell>
        <mxCell id="p_start" parent="1" style="shape=mxgraph.flowchart.terminator;whiteSpace=wrap;html=1;fontSize=14;fillColor=#000000;fontColor=#ffffff;strokeColor=none;" value="Mulai" vertex="1">
          <mxGeometry height="50" width="120" x="980" y="100" as="geometry" />
        </mxCell>

        <!-- Y=220 -->
        <mxCell id="k_jual" parent="1" style="rounded=0;whiteSpace=wrap;html=1;fontSize=14;fillColor=#fff2cc;strokeColor=#d6b656;" value="Menerima barang dari pelanggan" vertex="1">
          <mxGeometry height="60" width="160" x="70" y="220" as="geometry" />
        </mxCell>
        <mxCell id="k_uang" parent="1" style="rounded=0;whiteSpace=wrap;html=1;fontSize=14;fillColor=#fff2cc;strokeColor=#d6b656;" value="Pengeluaran Harian&#xa;(Kas Keluar)" vertex="1">
          <mxGeometry height="60" width="140" x="270" y="220" as="geometry" />
        </mxCell>

        <!-- Y=340 -->
        <mxCell id="k_dec" parent="1" style="rhombus;whiteSpace=wrap;html=1;fontSize=14;fillColor=#e1d5e7;strokeColor=#9673a6;" value="Ada Barcode?" vertex="1">
          <mxGeometry height="80" width="140" x="80" y="340" as="geometry" />
        </mxCell>
        <mxCell id="s_input_uang" parent="1" style="shape=parallelogram;whiteSpace=wrap;html=1;fontSize=14;fillColor=#dae8fc;strokeColor=#6c8ebf;" value="Input pengeluaran manual&#xa;ke sistem" vertex="1">
          <mxGeometry height="60" width="180" x="630" y="350" as="geometry" />
        </mxCell>

        <!-- Y=480 -->
        <mxCell id="k_cek" parent="1" style="rounded=0;whiteSpace=wrap;html=1;fontSize=14;fillColor=#fff2cc;strokeColor=#d6b656;" value="Cek Harga &amp; Stok Manual" vertex="1">
          <mxGeometry height="60" width="140" x="80" y="480" as="geometry" />
        </mxCell>
        <mxCell id="k_scan" parent="1" style="shape=parallelogram;whiteSpace=wrap;html=1;fontSize=14;fillColor=#fff2cc;strokeColor=#d6b656;" value="Scan Barcode" vertex="1">
          <mxGeometry height="60" width="140" x="270" y="480" as="geometry" />
        </mxCell>
        <mxCell id="s_simpan_uang" parent="1" style="rounded=0;whiteSpace=wrap;html=1;fontSize=14;fillColor=#dae8fc;strokeColor=#6c8ebf;" value="Simpan Data Pengeluaran" vertex="1">
          <mxGeometry height="60" width="180" x="630" y="480" as="geometry" />
        </mxCell>

        <!-- Y=600 -->
        <mxCell id="k_catat" parent="1" style="shape=parallelogram;whiteSpace=wrap;html=1;fontSize=14;fillColor=#fff2cc;strokeColor=#d6b656;" value="Catat transaksi di buku" vertex="1">
          <mxGeometry height="60" width="140" x="80" y="600" as="geometry" />
        </mxCell>
        <mxCell id="s_baca" parent="1" style="rounded=0;whiteSpace=wrap;html=1;fontSize=14;fillColor=#dae8fc;strokeColor=#6c8ebf;" value="Sistem Membaca Data Barang" vertex="1">
          <mxGeometry height="60" width="180" x="460" y="600" as="geometry" />
        </mxCell>
        

        <!-- Y=720 -->
        <mxCell id="k_buku" parent="1" style="shape=document;whiteSpace=wrap;html=1;boundedLbl=1;fontSize=14;fillColor=#fff2cc;strokeColor=#d6b656;" value="Buku Daftar&#xa;Transaksi Harian" vertex="1">
          <mxGeometry height="70" width="140" x="80" y="720" as="geometry" />
        </mxCell>
        <mxCell id="s_tambah" parent="1" style="rounded=0;whiteSpace=wrap;html=1;fontSize=14;fillColor=#dae8fc;strokeColor=#6c8ebf;" value="Tambahkan ke Keranjang / Nota" vertex="1">
          <mxGeometry height="60" width="180" x="460" y="720" as="geometry" />
        </mxCell>

        <!-- Y=840 -->
        <mxCell id="k_bayar" parent="1" style="rounded=0;whiteSpace=wrap;html=1;fontSize=14;fillColor=#fff2cc;strokeColor=#d6b656;" value="Menerima Pembayaran" vertex="1">
          <mxGeometry height="60" width="180" x="250" y="840" as="geometry" />
        </mxCell>

        <!-- Y=960 -->
        <mxCell id="s_simpan_jual" parent="1" style="rounded=0;whiteSpace=wrap;html=1;fontSize=14;fillColor=#dae8fc;strokeColor=#6c8ebf;" value="Simpan Transaksi Penjualan" vertex="1">
          <mxGeometry height="60" width="180" x="460" y="960" as="geometry" />
        </mxCell>
        
        <!-- Y=1080 -->
        <mxCell id="k_input_ulang" parent="1" style="shape=parallelogram;whiteSpace=wrap;html=1;fontSize=14;fillColor=#fff2cc;strokeColor=#d6b656;" value="Input ulang rekap buku manual&#xa;ke PC di akhir shift" vertex="1">
          <mxGeometry height="60" width="220" x="40" y="1080" as="geometry" />
        </mxCell>
        <mxCell id="k_end" parent="1" style="shape=mxgraph.flowchart.terminator;whiteSpace=wrap;html=1;fontSize=14;fillColor=#000000;fontColor=#ffffff;strokeColor=none;" value="Selesai" vertex="1">
          <mxGeometry height="50" width="120" x="280" y="1085" as="geometry" />
        </mxCell>
        
        <!-- Y=1200 -->
        <mxCell id="s_db" parent="1" style="shape=cylinder3;whiteSpace=wrap;html=1;boundedLbl=1;backgroundOutline=1;size=15;fontSize=14;fillColor=#dae8fc;strokeColor=#6c8ebf;" value="Database&#xa;Rsix Cell" vertex="1">
          <mxGeometry height="80" width="200" x="530" y="1200" as="geometry" />
        </mxCell>
        <mxCell id="p_datang" parent="1" style="rounded=0;whiteSpace=wrap;html=1;fontSize=14;fillColor=#d5e8d4;strokeColor=#82b366;" value="Mendatangi Cabang Fisik Toko" vertex="1">
          <mxGeometry height="60" width="180" x="950" y="1210" as="geometry" />
        </mxCell>

        <!-- Y=1320 -->
        <mxCell id="p_minta" parent="1" style="rounded=0;whiteSpace=wrap;html=1;fontSize=14;fillColor=#d5e8d4;strokeColor=#82b366;" value="Meminta akses PC Kasir" vertex="1">
          <mxGeometry height="60" width="180" x="950" y="1320" as="geometry" />
        </mxCell>

        <!-- Y=1440 -->
        <mxCell id="s_menu_lap" parent="1" style="rounded=0;whiteSpace=wrap;html=1;fontSize=14;fillColor=#dae8fc;strokeColor=#6c8ebf;" value="Buka Menu Laporan" vertex="1">
          <mxGeometry height="60" width="180" x="540" y="1440" as="geometry" />
        </mxCell>

        <!-- Y=1560 -->
        <mxCell id="s_lap" parent="1" style="shape=document;whiteSpace=wrap;html=1;boundedLbl=1;fontSize=14;fillColor=#dae8fc;strokeColor=#6c8ebf;" value="Laporan Penjualan&#xa;Tercetak / Layar" vertex="1">
          <mxGeometry height="80" width="180" x="540" y="1560" as="geometry" />
        </mxCell>

        <!-- Y=1680 -->
        <mxCell id="p_lihat" parent="1" style="rounded=0;whiteSpace=wrap;html=1;fontSize=14;fillColor=#d5e8d4;strokeColor=#82b366;" value="Melihat &amp; Menganalisa Laporan" vertex="1">
          <mxGeometry height="60" width="180" x="950" y="1680" as="geometry" />
        </mxCell>

        <!-- Y=1800 -->
        <mxCell id="p_end" parent="1" style="shape=mxgraph.flowchart.terminator;whiteSpace=wrap;html=1;fontSize=14;fillColor=#000000;fontColor=#ffffff;strokeColor=none;" value="Selesai" vertex="1">
          <mxGeometry height="50" width="120" x="980" y="1800" as="geometry" />
        </mxCell>


        <!-- Edges -->
        <mxCell id="e_start_jual" edge="1" parent="1" source="k_start" target="k_jual" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="e_start_uang" edge="1" parent="1" source="k_start" target="k_uang" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>

        <mxCell id="e_jual_dec" edge="1" parent="1" source="k_jual" target="k_dec" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>

        <mxCell id="e_dec_scan" edge="1" parent="1" source="k_dec" target="k_scan" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;" value="Ya">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="e_dec_cek" edge="1" parent="1" source="k_dec" target="k_cek" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;" value="Tidak">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>

        <mxCell id="e_uang_input" edge="1" parent="1" source="k_uang" target="s_input_uang" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="e_input_simpanuang" edge="1" parent="1" source="s_input_uang" target="s_simpan_uang" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        
        <mxCell id="e_scan_baca" edge="1" parent="1" source="k_scan" target="s_baca" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="e_baca_tambah" edge="1" parent="1" source="s_baca" target="s_tambah" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="e_tambah_bayar" edge="1" parent="1" source="s_tambah" target="k_bayar" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="e_bayar_simpanjual" edge="1" parent="1" source="k_bayar" target="s_simpan_jual" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="e_simpanjual_db" edge="1" parent="1" source="s_simpan_jual" target="s_db" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="e_simpanjual_kend" edge="1" parent="1" source="s_simpan_jual" target="k_end" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="e_simpanuang_db" edge="1" parent="1" source="s_simpan_uang" target="s_db" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;">
          <mxGeometry relative="1" as="geometry">
            <Array as="points"><mxPoint x="720" y="1170" /><mxPoint x="630" y="1170" /></Array>
          </mxGeometry>
        </mxCell>

        <mxCell id="e_cek_catat" edge="1" parent="1" source="k_cek" target="k_catat" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="e_catat_buku" edge="1" parent="1" source="k_catat" target="k_buku" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="e_buku_input" edge="1" parent="1" source="k_buku" target="k_input_ulang" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="e_input_db" edge="1" parent="1" source="k_input_ulang" target="s_db" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>

        <mxCell id="e_pstart_datang" edge="1" parent="1" source="p_start" target="p_datang" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="e_datang_minta" edge="1" parent="1" source="p_datang" target="p_minta" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="e_minta_menulap" edge="1" parent="1" source="p_minta" target="s_menu_lap" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="e_db_menulap" edge="1" parent="1" source="s_db" target="s_menu_lap" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="e_menulap_lap" edge="1" parent="1" source="s_menu_lap" target="s_lap" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="e_lap_lihat" edge="1" parent="1" source="s_lap" target="p_lihat" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="e_lihat_pend" edge="1" parent="1" source="p_lihat" target="p_end" style="edgeStyle=orthogonalEdgeStyle;rounded=0;html=1;strokeWidth=2;endArrow=block;">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>

      </root>
    </mxGraphModel>
  </diagram>
</mxfile>
XML;
file_put_contents('Flowchart_Sistem_Saat_Ini.drawio', $xml);
echo "Berhasil update Flowchart.\n";
