import xml.etree.ElementTree as ET

def create_diagram(filename, diagram_name, diagram_id):
    mxfile = ET.Element('mxfile', host="app.diagrams.net")
    diagram = ET.SubElement(mxfile, 'diagram', id=diagram_id, name=diagram_name)
    mxGraphModel = ET.SubElement(diagram, 'mxGraphModel', dx="1106", dy="656", grid="1", gridSize="10", guides="1", tooltips="1", connect="1", arrows="1", fold="1", page="1", pageScale="1", pageWidth="1600", pageHeight="3000", math="0", shadow="0")
    root = ET.SubElement(mxGraphModel, 'root')
    ET.SubElement(root, 'mxCell', id="0")
    ET.SubElement(root, 'mxCell', id="1", parent="0")
    
    # Lanes
    ET.SubElement(root, 'mxCell', id="lane_sa", parent="1", style="swimlane;html=1;startSize=30;fontStyle=1;fontSize=14;", value="Super Admin (Aplikasi Web)").extend([ET.Element('mxGeometry', height="2500", width="300", x="100", y="40", **{'as': 'geometry'})])
    ET.SubElement(root, 'mxCell', id="lane_ac", parent="1", style="swimlane;html=1;startSize=30;fontStyle=1;fontSize=14;", value="Admin Cabang (Aplikasi Web)").extend([ET.Element('mxGeometry', height="2500", width="300", x="400", y="40", **{'as': 'geometry'})])
    ET.SubElement(root, 'mxCell', id="lane_kar", parent="1", style="swimlane;html=1;startSize=30;fontStyle=1;fontSize=14;", value="Karyawan / Kasir (Aplikasi Mobile)").extend([ET.Element('mxGeometry', height="2500", width="300", x="700", y="40", **{'as': 'geometry'})])
    ET.SubElement(root, 'mxCell', id="lane_sys", parent="1", style="swimlane;html=1;startSize=30;fontStyle=1;fontSize=14;", value="Sistem (Server API & Database)").extend([ET.Element('mxGeometry', height="2500", width="300", x="1000", y="40", **{'as': 'geometry'})])
    return mxfile, root

def add_node(root, id, parent, style, value, x, y, w=160, h=60):
    cell = ET.SubElement(root, 'mxCell', id=id, parent=parent, style=style, value=value)
    ET.SubElement(cell, 'mxGeometry', width=str(w), height=str(h), x=str(x), y=str(y), **{'as': 'geometry'})

def add_edge(root, id, source, target, value="", points=None):
    cell = ET.SubElement(root, 'mxCell', id=id, parent="1", style="edgeStyle=orthogonalEdgeStyle;rounded=0;orthogonalLoop=1;jettySize=auto;html=1;endArrow=classic;endFill=1;strokeColor=#000000;strokeWidth=2;fontSize=14;", value=value, source=source, target=target)
    geom = ET.SubElement(cell, 'mxGeometry', relative="1", **{'as': 'geometry'})
    if points:
        arr = ET.SubElement(geom, 'Array', **{'as': 'points'})
        for pt in points:
            ET.SubElement(arr, 'mxPoint', x=str(pt[0]), y=str(pt[1]))

# PART 1
mxfile1, root1 = create_diagram("Flowchart_Sistem_Bagian_1.drawio", "Bagian 1 (Proses 1,3,4)", "part1")
styles = {
    "term": "rounded=1;whiteSpace=wrap;html=1;arcSize=50;fontSize=14;",
    "proc": "rounded=0;whiteSpace=wrap;html=1;fontSize=14;",
    "db": "shape=cylinder3;whiteSpace=wrap;html=1;boundedLbl=1;backgroundOutline=1;size=15;fontSize=14;",
    "min": "shape=manualInput;whiteSpace=wrap;html=1;fontSize=14;",
    "mop": "shape=manualOperation;whiteSpace=wrap;html=1;fontSize=14;",
    "dec": "rhombus;whiteSpace=wrap;html=1;fontSize=14;",
    "disp": "shape=display;whiteSpace=wrap;html=1;fontSize=14;",
    "doc": "shape=document;whiteSpace=wrap;html=1;boundedLbl=1;fontSize=14;",
    "sep": "text;html=1;align=left;verticalAlign=middle;whiteSpace=wrap;rounded=0;fontStyle=1;fontSize=16;"
}

# P1
add_node(root1, "sep1", "1", styles["sep"], "Proses 1: Manajemen Penjadwalan Shift (Oleh Admin Cabang)", 120, 80, 600, 30)
add_node(root1, "b1_start", "lane_ac", styles["term"], "Mulai", 120, 100, 60, 60)
add_node(root1, "b1_input", "lane_ac", styles["min"], "Input Jadwal Shift (Karyawan & Waktu)", 70, 200)
add_node(root1, "b1_simpan", "lane_sys", styles["db"], "Menyimpan Data Jadwal Shift", 70, 190, 160, 80)
add_node(root1, "b1_end", "lane_ac", styles["term"], "Selesai", 120, 300, 60, 60)

add_edge(root1, "e_b1_1", "b1_start", "b1_input")
add_edge(root1, "e_b1_2", "b1_input", "b1_simpan")
add_edge(root1, "e_b1_3", "b1_simpan", "b1_end", points=[(1150, 330), (550, 330)])

# P3
add_node(root1, "sep3", "1", styles["sep"], "Proses 3: Transaksi Penjualan Barang - POS (Oleh Karyawan / Kasir)", 120, 480, 600, 30)
add_node(root1, "b3_start", "lane_kar", styles["term"], "Mulai", 120, 490, 60, 60)
add_node(root1, "b3_scan", "lane_kar", styles["min"], "Scan Barcode / Cari Barang", 70, 590)
add_node(root1, "b3_dbcek", "lane_sys", styles["db"], "Mengecek Ketersediaan Stok", 70, 580, 160, 80)
add_node(root1, "b3_dec", "lane_sys", styles["dec"], "Stok Mencukupi?", 100, 690, 100, 80)
add_node(root1, "b3_err", "lane_sys", styles["disp"], "Kirim Peringatan Stok Kosong", 70, 810)
add_node(root1, "b3_notif", "lane_kar", styles["disp"], "Notifikasi Stok Menipis", 70, 810)
add_node(root1, "b3_cart", "lane_sys", styles["proc"], "Tambahkan ke Keranjang Kasir", 70, 910)
add_node(root1, "b3_pay", "lane_kar", styles["min"], "Input Pembayaran", 70, 1010)
add_node(root1, "b3_simpan", "lane_sys", styles["db"], "Proses Pembayaran & Potong Saldo Stok", 70, 1000, 160, 80)
add_node(root1, "b3_struk", "lane_sys", styles["doc"], "Generate Struk", 90, 1110, 120, 70)
add_node(root1, "b3_cetak", "lane_kar", styles["doc"], "Cetak Struk Transaksi", 90, 1110, 120, 70)
add_node(root1, "b3_end", "lane_kar", styles["term"], "Selesai", 120, 1220, 60, 60)

add_edge(root1, "e_b3_1", "b3_start", "b3_scan")
add_edge(root1, "e_b3_2", "b3_scan", "b3_dbcek")
add_edge(root1, "e_b3_3", "b3_dbcek", "b3_dec")
add_edge(root1, "e_b3_4", "b3_dec", "b3_err", "Tidak")
add_edge(root1, "e_b3_5", "b3_err", "b3_notif")
add_edge(root1, "e_b3_5b", "b3_notif", "b3_scan", points=[(730, 880), (730, 660)])
add_edge(root1, "e_b3_6", "b3_dec", "b3_cart", "Ya", points=[(1270, 730), (1270, 940)])
add_edge(root1, "e_b3_7", "b3_cart", "b3_pay", points=[(1150, 1040), (850, 1040)])
add_edge(root1, "e_b3_8", "b3_pay", "b3_simpan")
add_edge(root1, "e_b3_10", "b3_simpan", "b3_struk")
add_edge(root1, "e_b3_11", "b3_struk", "b3_cetak")
add_edge(root1, "e_b3_12", "b3_cetak", "b3_end")

# P4
add_node(root1, "sep4", "1", styles["sep"], "Proses 4: Tutup Shift (Oleh Karyawan / Kasir & Approval Admin Cabang)", 120, 1370, 700, 30)
add_node(root1, "b4_start", "lane_kar", styles["term"], "Mulai", 120, 1380, 60, 60)
add_node(root1, "b4_pilih", "lane_kar", styles["min"], "Pilih Menu Tutup Shift", 70, 1480)
add_node(root1, "b4_hitung", "lane_sys", styles["proc"], "Menghitung Total Pendapatan", 70, 1480)
add_node(root1, "b4_form", "lane_sys", styles["disp"], "Tampilkan Halaman Tutup Shift", 70, 1580)
add_node(root1, "b4_input", "lane_kar", styles["mop"], "Menghitung Fisik Uang & Input Setoran", 70, 1680)
add_node(root1, "b4_selisih", "lane_sys", styles["proc"], "Hitung Selisih Pendapatan vs Fisik", 70, 1680)
add_node(root1, "b4_simpan", "lane_sys", styles["db"], "Simpan Data Tutup Shift", 70, 1770, 160, 80)
add_node(root1, "b4_lap", "lane_sys", styles["doc"], "Generate Laporan Tutup Shift", 90, 1880, 120, 70)
add_node(root1, "b4_review", "lane_ac", styles["mop"], "Review & Approval Selisih Kasir", 90, 1880, 120, 70)
add_node(root1, "b4_end", "lane_ac", styles["term"], "Selesai", 120, 1990, 60, 60)

add_edge(root1, "e_b4_1", "b4_start", "b4_pilih")
add_edge(root1, "e_b4_2", "b4_pilih", "b4_hitung")
add_edge(root1, "e_b4_3", "b4_hitung", "b4_form")
add_edge(root1, "e_b4_4", "b4_form", "b4_input", points=[(1150, 1660), (850, 1660)])
add_edge(root1, "e_b4_5", "b4_input", "b4_selisih")
add_edge(root1, "e_b4_6", "b4_selisih", "b4_simpan")
add_edge(root1, "e_b4_8", "b4_simpan", "b4_lap")
add_edge(root1, "e_b4_9", "b4_lap", "b4_review")
add_edge(root1, "e_b4_10", "b4_review", "b4_end")

ET.ElementTree(mxfile1).write("d:/Semester_6/TUGAS AKHIR NGODING/sistem-penjualan-rsix-cell/Flowchart_Sistem_Bagian_1.drawio", encoding="utf-8", xml_declaration=False)

# PART 2
mxfile2, root2 = create_diagram("Flowchart_Sistem_Bagian_2.drawio", "Bagian 2 (Proses 5-8)", "part2")

# P5
add_node(root2, "sep5", "1", styles["sep"], "Proses 5: Pengeluaran Kas Cabang (Oleh Admin Cabang)", 120, 80, 600, 30)
add_node(root2, "b5_start", "lane_ac", styles["term"], "Mulai", 120, 130, 60, 60)
add_node(root2, "b5_input", "lane_ac", styles["min"], "Input Kas Keluar (Nominal & Keterangan)", 70, 230)
add_node(root2, "b5_simpan", "lane_sys", styles["db"], "Menyimpan & Memotong Saldo Kas Cabang", 70, 220, 160, 80)
add_node(root2, "b5_struk", "lane_sys", styles["doc"], "Generate Bukti Pengeluaran", 90, 330, 120, 70)
add_node(root2, "b5_cetak", "lane_ac", styles["doc"], "Cetak Bukti Pengeluaran", 90, 330, 120, 70)
add_node(root2, "b5_end", "lane_ac", styles["term"], "Selesai", 120, 440, 60, 60)

add_edge(root2, "e_b5_1", "b5_start", "b5_input")
add_edge(root2, "e_b5_2", "b5_input", "b5_simpan")
add_edge(root2, "e_b5_4", "b5_simpan", "b5_struk")
add_edge(root2, "e_b5_5", "b5_struk", "b5_cetak")
add_edge(root2, "e_b5_6", "b5_cetak", "b5_end")

# P6
add_node(root2, "sep6", "1", styles["sep"], "Proses 6: Pengadaan Barang Masuk (Restock - Oleh Admin Cabang & Super Admin)", 120, 550, 700, 30)
add_node(root2, "b6_start", "lane_ac", styles["term"], "Mulai", 120, 600, 60, 60)
add_node(root2, "b6_cek", "lane_ac", styles["mop"], "Cek Sisa Stok Barang Secara Manual", 70, 700)
add_node(root2, "b6_limit", "lane_sys", styles["disp"], "Menampilkan Daftar Barang < Safety Stock", 70, 700)
add_node(root2, "b6_pesan", "lane_ac", styles["mop"], "Melakukan Pemesanan ke Supplier", 70, 800)
add_node(root2, "b6_terima", "lane_ac", styles["mop"], "Menerima & Memeriksa Fisik Barang", 70, 900)
add_node(root2, "b6_input", "lane_ac", styles["min"], "Input Transaksi Barang Masuk", 70, 1000)
add_node(root2, "b6_simpan", "lane_sys", styles["db"], "Menyimpan Penambahan stok", 70, 990, 160, 80)
add_node(root2, "b6_lap", "lane_sys", styles["doc"], "Generate Laporan Barang Masuk", 90, 1100, 120, 70)
add_node(root2, "b6_review", "lane_sa", styles["mop"], "Review Laporan Barang Masuk", 90, 1100, 120, 70)
add_node(root2, "b6_end", "lane_sa", styles["term"], "Selesai", 120, 1210, 60, 60)

add_edge(root2, "e_b6_1", "b6_start", "b6_cek")
add_edge(root2, "e_b6_2", "b6_cek", "b6_limit")
add_edge(root2, "e_b6_3", "b6_limit", "b6_pesan", points=[(1150, 780), (550, 780)])
add_edge(root2, "e_b6_4", "b6_pesan", "b6_terima")
add_edge(root2, "e_b6_5", "b6_terima", "b6_input")
add_edge(root2, "e_b6_6", "b6_input", "b6_simpan")
add_edge(root2, "e_b6_8", "b6_simpan", "b6_lap")
add_edge(root2, "e_b6_9", "b6_lap", "b6_review")
add_edge(root2, "e_b6_10", "b6_review", "b6_end")

# P7
add_node(root2, "sep7", "1", styles["sep"], "Proses 7: Laporan Keuangan Cabang (Oleh Admin Cabang)", 120, 1330, 700, 30)
add_node(root2, "b7_start", "lane_ac", styles["term"], "Mulai", 120, 1340, 60, 60)
add_node(root2, "b7_menu", "lane_ac", styles["min"], "Pilih Menu Laporan Keuangan Cabang & Filter Waktu", 70, 1440)
add_node(root2, "b7_tarik", "lane_sys", styles["db"], "Menarik Data Transaksi, Shift, dan Kas Keluar", 70, 1430, 160, 80)
add_node(root2, "b7_hitung", "lane_sys", styles["proc"], "Menyusun Laporan Keuangan Cabang", 70, 1540)
add_node(root2, "b7_tampil", "lane_sys", styles["disp"], "Menampilkan Laporan di Aplikasi", 70, 1640)
add_node(root2, "b7_dec", "lane_ac", styles["dec"], "Download/Cetak Laporan?", 100, 1630, 100, 80)
add_node(root2, "b7_export", "lane_sys", styles["doc"], "Generate File PDF/Excel", 90, 1750, 120, 70)
add_node(root2, "b7_end", "lane_ac", styles["term"], "Selesai", 120, 1850, 60, 60)

add_edge(root2, "e_b7_1", "b7_start", "b7_menu")
add_edge(root2, "e_b7_2", "b7_menu", "b7_tarik")
add_edge(root2, "e_b7_4", "b7_tarik", "b7_hitung")
add_edge(root2, "e_b7_5", "b7_hitung", "b7_tampil")
add_edge(root2, "e_b7_6", "b7_tampil", "b7_dec", points=[(1150, 1670), (550, 1670)])
add_edge(root2, "e_b7_7", "b7_dec", "b7_export", "Ya", points=[(550, 1780), (1150, 1780)])
add_edge(root2, "e_b7_8", "b7_export", "b7_end", points=[(1150, 1880), (550, 1880)])
add_edge(root2, "e_b7_9", "b7_dec", "b7_end", "Tidak", points=[(450, 1670), (450, 1880)])

# P8
add_node(root2, "sep8", "1", styles["sep"], "Proses 8: Laporan Keuangan Global (Oleh Super Admin)", 120, 2000, 700, 30)
add_node(root2, "b8_start", "lane_sa", styles["term"], "Mulai", 120, 2010, 60, 60)
add_node(root2, "b8_menu", "lane_sa", styles["min"], "Pilih Menu Laporan Semua Cabang & Filter Waktu", 70, 2110)
add_node(root2, "b8_tarik", "lane_sys", styles["db"], "Menarik Data Konsolidasi Seluruh Cabang", 70, 2100, 160, 80)
add_node(root2, "b8_hitung", "lane_sys", styles["proc"], "Menyusun Laporan Keuangan Keseluruhan", 70, 2220)
add_node(root2, "b8_tampil", "lane_sys", styles["disp"], "Menampilkan Laporan di Aplikasi", 70, 2320)
add_node(root2, "b8_dec", "lane_sa", styles["dec"], "Download/Cetak Laporan?", 100, 2310, 100, 80)
add_node(root2, "b8_export", "lane_sys", styles["doc"], "Generate File PDF/Excel", 90, 2430, 120, 70)
add_node(root2, "b8_end", "lane_sa", styles["term"], "Selesai", 120, 2530, 60, 60)

add_edge(root2, "e_b8_1", "b8_start", "b8_menu")
add_edge(root2, "e_b8_2", "b8_menu", "b8_tarik")
add_edge(root2, "e_b8_4", "b8_tarik", "b8_hitung")
add_edge(root2, "e_b8_5", "b8_hitung", "b8_tampil")
add_edge(root2, "e_b8_6", "b8_tampil", "b8_dec", points=[(1150, 2350), (250, 2350)])
add_edge(root2, "e_b8_7", "b8_dec", "b8_export", "Ya", points=[(250, 2460), (1150, 2460)])
add_edge(root2, "e_b8_8", "b8_export", "b8_end", points=[(1150, 2560), (250, 2560)])
add_edge(root2, "e_b8_9", "b8_dec", "b8_end", "Tidak", points=[(150, 2350), (150, 2560)])

ET.ElementTree(mxfile2).write("d:/Semester_6/TUGAS AKHIR NGODING/sistem-penjualan-rsix-cell/Flowchart_Sistem_Bagian_2.drawio", encoding="utf-8", xml_declaration=False)
