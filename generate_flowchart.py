import xml.etree.ElementTree as ET

def create_node(parent_element, id, parent_lane, value, style, x_rel, y_abs, width, height):
    y_rel = y_abs - 40
    cell = ET.SubElement(parent_element, 'mxCell', id=id, parent=parent_lane, value=value, style=style, vertex="1")
    ET.SubElement(cell, 'mxGeometry', x=str(x_rel), y=str(y_rel), width=str(width), height=str(height))
    # Note: adding as="geometry" requires tricky kwargs because 'as' is a keyword.
    cell.find('mxGeometry').set('as', 'geometry')

def create_edge(parent_element, id, source, target, value="", style="edgeStyle=orthogonalEdgeStyle;rounded=0;orthogonalLoop=1;jettySize=auto;html=1;endArrow=classic;endFill=1;strokeColor=#000000;strokeWidth=2;", points=None):
    cell = ET.SubElement(parent_element, 'mxCell', id=id, parent="1", value=value, style=style, edge="1", source=source, target=target)
    geom = ET.SubElement(cell, 'mxGeometry', relative="1")
    geom.set('as', 'geometry')
    if points:
        array = ET.SubElement(geom, 'Array')
        array.set('as', 'points')
        for px, py in points:
            ET.SubElement(array, 'mxPoint', x=str(px), y=str(py))

def main():
    mxfile = ET.Element('mxfile', host="app.diagrams.net")
    diagram = ET.SubElement(mxfile, 'diagram', id="flowchart_rsix_cell", name="Flowchart Sistem Rsix Cell")
    model = ET.SubElement(diagram, 'mxGraphModel', dx="1106", dy="656", grid="1", gridSize="10", guides="1", tooltips="1", connect="1", arrows="1", fold="1", page="1", pageScale="1", pageWidth="1600", pageHeight="4500", math="0", shadow="0")
    root = ET.SubElement(model, 'root')
    
    ET.SubElement(root, 'mxCell', id="0")
    ET.SubElement(root, 'mxCell', id="1", parent="0")
    
    # Swimlanes
    lane_sa = ET.SubElement(root, 'mxCell', id="lane_sa", parent="1", value="Super Admin (Aplikasi Web)", style="swimlane;html=1;startSize=30;fontStyle=1;fillColor=#d5e8d4;", vertex="1")
    lane_sa_geom = ET.SubElement(lane_sa, 'mxGeometry', x="100", y="40", width="300", height="4400")
    lane_sa_geom.set('as', 'geometry')

    lane_ac = ET.SubElement(root, 'mxCell', id="lane_ac", parent="1", value="Admin Cabang (Aplikasi Web)", style="swimlane;html=1;startSize=30;fontStyle=1;fillColor=#ffe6cc;", vertex="1")
    lane_ac_geom = ET.SubElement(lane_ac, 'mxGeometry', x="400", y="40", width="300", height="4400")
    lane_ac_geom.set('as', 'geometry')

    lane_kar = ET.SubElement(root, 'mxCell', id="lane_kar", parent="1", value="Karyawan / Kasir (Aplikasi Mobile)", style="swimlane;html=1;startSize=30;fontStyle=1;fillColor=#f5f5f5;", vertex="1")
    lane_kar_geom = ET.SubElement(lane_kar, 'mxGeometry', x="700", y="40", width="300", height="4400")
    lane_kar_geom.set('as', 'geometry')

    lane_sys = ET.SubElement(root, 'mxCell', id="lane_sys", parent="1", value="Sistem (Server API & Database)", style="swimlane;html=1;startSize=30;fontStyle=1;fillColor=#dae8fc;", vertex="1")
    lane_sys_geom = ET.SubElement(lane_sys, 'mxGeometry', x="1000", y="40", width="300", height="4400")
    lane_sys_geom.set('as', 'geometry')

    # Helper for relative X
    X_SA = 70
    X_AC = 70
    X_KAR = 70
    X_SYS = 70

    # P1
    create_node(root, "sep1", "1", "Proses 1: Manajemen Penjadwalan Shift (Oleh Admin Cabang)", "text;html=1;align=left;verticalAlign=middle;whiteSpace=wrap;rounded=0;fontStyle=1;fontSize=14;", 120, 80, 600, 30)
    create_node(root, "b1_start", "lane_ac", "Mulai", "rounded=1;whiteSpace=wrap;html=1;arcSize=50;fillColor=#d5e8d4;strokeColor=#82b366;", X_AC+50, 140, 60, 60)
    create_node(root, "b1_input", "lane_ac", "Input Jadwal Shift (Karyawan & Waktu)", "shape=manualInput;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;", X_AC, 240, 160, 60)
    create_node(root, "b1_simpan", "lane_sys", "Menyimpan Data Jadwal Shift", "rounded=0;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;", X_SYS, 240, 160, 60)
    create_node(root, "b1_db", "lane_sys", "DB Shift", "shape=cylinder3;whiteSpace=wrap;html=1;boundedLbl=1;backgroundOutline=1;size=15;fillColor=#e1d5e7;strokeColor=#9673a6;", X_SYS+40, 340, 80, 80)
    create_node(root, "b1_end", "lane_ac", "Selesai", "rounded=1;whiteSpace=wrap;html=1;arcSize=50;strokeWidth=2;fillColor=#f8cecc;strokeColor=#b85450;", X_AC+50, 350, 60, 60)
    
    create_edge(root, "e_b1_1", "b1_start", "b1_input")
    create_edge(root, "e_b1_2", "b1_input", "b1_simpan")
    create_edge(root, "e_b1_3", "b1_simpan", "b1_db")
    create_edge(root, "e_b1_4", "b1_db", "b1_end", points=[(1150, 440), (550, 440)])

    # P2
    create_node(root, "sep2", "1", "Proses 2: Buka Shift (Oleh Karyawan / Kasir)", "text;html=1;align=left;verticalAlign=middle;whiteSpace=wrap;rounded=0;fontStyle=1;fontSize=14;", 120, 480, 600, 30)
    create_node(root, "b2_start", "lane_kar", "Mulai", "rounded=1;whiteSpace=wrap;html=1;arcSize=50;fillColor=#d5e8d4;strokeColor=#82b366;", X_KAR+50, 530, 60, 60)
    create_node(root, "b2_login", "lane_kar", "Login Akun Karyawan", "shape=manualInput;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;", X_KAR, 630, 160, 60)
    create_node(root, "b2_cek", "lane_sys", "Mengecek Jadwal Karyawan", "rounded=0;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;", X_SYS, 630, 160, 60)
    create_node(root, "b2_dec", "lane_sys", "Sesuai Jadwal?", "rhombus;whiteSpace=wrap;html=1;fillColor=#e1d5e7;strokeColor=#9673a6;", X_SYS+30, 730, 100, 80)
    create_node(root, "b2_err", "lane_kar", "Peringatan: Belum Waktunya Shift", "shape=display;whiteSpace=wrap;html=1;fillColor=#f8cecc;strokeColor=#b85450;", X_KAR, 740, 160, 60)
    create_node(root, "b2_end_err", "lane_kar", "Selesai", "rounded=1;whiteSpace=wrap;html=1;arcSize=50;strokeWidth=2;fillColor=#f8cecc;strokeColor=#b85450;", X_KAR+50, 830, 60, 60)
    create_node(root, "b2_form", "lane_sys", "Tampilkan Form Buka Shift", "shape=display;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;", X_SYS, 850, 160, 60)
    create_node(root, "b2_input", "lane_kar", "Input Modal Awal Shift", "shape=manualInput;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;", X_KAR, 950, 160, 60)
    create_node(root, "b2_simpan", "lane_sys", "Menyimpan Sesi Shift Aktif", "rounded=0;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;", X_SYS, 950, 160, 60)
    create_node(root, "b2_db", "lane_sys", "DB Shift", "shape=cylinder3;whiteSpace=wrap;html=1;boundedLbl=1;backgroundOutline=1;size=15;fillColor=#e1d5e7;strokeColor=#9673a6;", X_SYS+40, 1050, 80, 80)
    create_node(root, "b2_end", "lane_kar", "Selesai", "rounded=1;whiteSpace=wrap;html=1;arcSize=50;strokeWidth=2;fillColor=#f8cecc;strokeColor=#b85450;", X_KAR+50, 1060, 60, 60)
    
    create_edge(root, "e_b2_1", "b2_start", "b2_login")
    create_edge(root, "e_b2_2", "b2_login", "b2_cek")
    create_edge(root, "e_b2_3", "b2_cek", "b2_dec")
    create_edge(root, "e_b2_4", "b2_dec", "b2_err", value="Tidak")
    create_edge(root, "e_b2_5", "b2_err", "b2_end_err")
    create_edge(root, "e_b2_6", "b2_dec", "b2_form", value="Ya", points=[(1270, 770), (1270, 880)])
    create_edge(root, "e_b2_7", "b2_form", "b2_input", points=[(1150, 930), (850, 930)])
    create_edge(root, "e_b2_8", "b2_input", "b2_simpan")
    create_edge(root, "e_b2_9", "b2_simpan", "b2_db")
    create_edge(root, "e_b2_10", "b2_db", "b2_end", points=[(1150, 1160), (850, 1160)])

    # P3
    create_node(root, "sep3", "1", "Proses 3: Transaksi Penjualan Barang - POS (Oleh Karyawan / Kasir)", "text;html=1;align=left;verticalAlign=middle;whiteSpace=wrap;rounded=0;fontStyle=1;fontSize=14;", 120, 1200, 600, 30)
    create_node(root, "b3_start", "lane_kar", "Mulai", "rounded=1;whiteSpace=wrap;html=1;arcSize=50;fillColor=#d5e8d4;strokeColor=#82b366;", X_KAR+50, 1250, 60, 60)
    create_node(root, "b3_scan", "lane_kar", "Scan Barcode / Cari Barang", "shape=manualInput;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;", X_KAR, 1350, 160, 60)
    create_node(root, "b3_dbcek", "lane_sys", "DB Persediaan", "shape=cylinder3;whiteSpace=wrap;html=1;boundedLbl=1;backgroundOutline=1;size=15;fillColor=#e1d5e7;strokeColor=#9673a6;", X_SYS+40, 1340, 80, 80)
    create_node(root, "b3_dec", "lane_sys", "Stok Mencukupi?", "rhombus;whiteSpace=wrap;html=1;fillColor=#e1d5e7;strokeColor=#9673a6;", X_SYS+30, 1450, 100, 80)
    create_node(root, "b3_err", "lane_sys", "Kirim Peringatan Stok Kosong", "shape=display;whiteSpace=wrap;html=1;fillColor=#f8cecc;strokeColor=#b85450;", X_SYS, 1570, 160, 60)
    create_node(root, "b3_notif", "lane_kar", "Notifikasi Stok Menipis", "shape=display;whiteSpace=wrap;html=1;fillColor=#f8cecc;strokeColor=#b85450;", X_KAR, 1570, 160, 60)
    create_node(root, "b3_cart", "lane_sys", "Tambahkan ke Keranjang Kasir", "rounded=0;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;", X_SYS, 1670, 160, 60)
    create_node(root, "b3_pay", "lane_kar", "Input Pembayaran", "shape=manualInput;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;", X_KAR, 1770, 160, 60)
    create_node(root, "b3_simpan", "lane_sys", "Proses Pembayaran & Potong Saldo Stok", "rounded=0;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;", X_SYS, 1770, 160, 60)
    create_node(root, "b3_db", "lane_sys", "DB Penjualan", "shape=cylinder3;whiteSpace=wrap;html=1;boundedLbl=1;backgroundOutline=1;size=15;fillColor=#e1d5e7;strokeColor=#9673a6;", X_SYS+40, 1870, 80, 80)
    create_node(root, "b3_struk", "lane_sys", "Generate Struk", "shape=document;whiteSpace=wrap;html=1;boundedLbl=1;fillColor=#dae8fc;strokeColor=#6c8ebf;", X_SYS+20, 1970, 120, 70)
    create_node(root, "b3_cetak", "lane_kar", "Cetak Struk Transaksi", "shape=document;whiteSpace=wrap;html=1;boundedLbl=1;fillColor=#fff2cc;strokeColor=#d6b656;", X_KAR+20, 1970, 120, 70)
    create_node(root, "b3_end", "lane_kar", "Selesai", "rounded=1;whiteSpace=wrap;html=1;arcSize=50;strokeWidth=2;fillColor=#f8cecc;strokeColor=#b85450;", X_KAR+50, 2080, 60, 60)
    
    create_edge(root, "e_b3_1", "b3_start", "b3_scan")
    create_edge(root, "e_b3_2", "b3_scan", "b3_dbcek")
    create_edge(root, "e_b3_3", "b3_dbcek", "b3_dec")
    create_edge(root, "e_b3_4", "b3_dec", "b3_err", value="Tidak")
    create_edge(root, "e_b3_5", "b3_err", "b3_notif")
    create_edge(root, "e_b3_5b", "b3_notif", "b3_scan", points=[(730, 1600), (730, 1380)])
    create_edge(root, "e_b3_6", "b3_dec", "b3_cart", value="Ya", points=[(1270, 1490), (1270, 1700)])
    create_edge(root, "e_b3_7", "b3_cart", "b3_pay", points=[(1150, 1750), (850, 1750)])
    create_edge(root, "e_b3_8", "b3_pay", "b3_simpan")
    create_edge(root, "e_b3_9", "b3_simpan", "b3_db")
    create_edge(root, "e_b3_10", "b3_db", "b3_struk")
    create_edge(root, "e_b3_11", "b3_struk", "b3_cetak")
    create_edge(root, "e_b3_12", "b3_cetak", "b3_end")

    # P4
    create_node(root, "sep4", "1", "Proses 4: Tutup Shift (Oleh Karyawan / Kasir & Approval Admin Cabang)", "text;html=1;align=left;verticalAlign=middle;whiteSpace=wrap;rounded=0;fontStyle=1;fontSize=14;", 120, 2190, 700, 30)
    create_node(root, "b4_start", "lane_kar", "Mulai", "rounded=1;whiteSpace=wrap;html=1;arcSize=50;fillColor=#d5e8d4;strokeColor=#82b366;", X_KAR+50, 2240, 60, 60)
    create_node(root, "b4_pilih", "lane_kar", "Pilih Menu Tutup Shift", "shape=manualInput;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;", X_KAR, 2340, 160, 60)
    create_node(root, "b4_hitung", "lane_sys", "Menghitung Total Pendapatan", "rounded=0;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;", X_SYS, 2340, 160, 60)
    create_node(root, "b4_form", "lane_sys", "Tampilkan Halaman Tutup Shift", "shape=display;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;", X_SYS, 2440, 160, 60)
    create_node(root, "b4_input", "lane_kar", "Input Setoran Akhir Kasir (Fisik)", "shape=manualInput;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;", X_KAR, 2540, 160, 60)
    create_node(root, "b4_selisih", "lane_sys", "Hitung Selisih Pendapatan vs Fisik", "rounded=0;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;", X_SYS, 2540, 160, 60)
    create_node(root, "b4_simpan", "lane_sys", "Simpan Data Tutup Shift", "rounded=0;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;", X_SYS, 2640, 160, 60)
    create_node(root, "b4_db", "lane_sys", "DB Shift", "shape=cylinder3;whiteSpace=wrap;html=1;boundedLbl=1;backgroundOutline=1;size=15;fillColor=#e1d5e7;strokeColor=#9673a6;", X_SYS+40, 2740, 80, 80)
    create_node(root, "b4_lap", "lane_sys", "Generate Laporan Tutup Shift", "shape=document;whiteSpace=wrap;html=1;boundedLbl=1;fillColor=#dae8fc;strokeColor=#6c8ebf;", X_SYS+20, 2840, 120, 70)
    create_node(root, "b4_review", "lane_ac", "Review & Approval Selisih Kasir", "shape=document;whiteSpace=wrap;html=1;boundedLbl=1;fillColor=#fff2cc;strokeColor=#d6b656;", X_AC+20, 2840, 120, 70)
    create_node(root, "b4_end", "lane_ac", "Selesai", "rounded=1;whiteSpace=wrap;html=1;arcSize=50;strokeWidth=2;fillColor=#f8cecc;strokeColor=#b85450;", X_AC+50, 2950, 60, 60)
    
    create_edge(root, "e_b4_1", "b4_start", "b4_pilih")
    create_edge(root, "e_b4_2", "b4_pilih", "b4_hitung")
    create_edge(root, "e_b4_3", "b4_hitung", "b4_form")
    create_edge(root, "e_b4_4", "b4_form", "b4_input", points=[(1150, 2520), (850, 2520)])
    create_edge(root, "e_b4_5", "b4_input", "b4_selisih")
    create_edge(root, "e_b4_6", "b4_selisih", "b4_simpan")
    create_edge(root, "e_b4_7", "b4_simpan", "b4_db")
    create_edge(root, "e_b4_8", "b4_db", "b4_lap")
    create_edge(root, "e_b4_9", "b4_lap", "b4_review")
    create_edge(root, "e_b4_10", "b4_review", "b4_end")

    # P5
    create_node(root, "sep5", "1", "Proses 5: Pengeluaran Kas Cabang (Oleh Admin Cabang)", "text;html=1;align=left;verticalAlign=middle;whiteSpace=wrap;rounded=0;fontStyle=1;fontSize=14;", 120, 3060, 600, 30)
    create_node(root, "b5_start", "lane_ac", "Mulai", "rounded=1;whiteSpace=wrap;html=1;arcSize=50;fillColor=#d5e8d4;strokeColor=#82b366;", X_AC+50, 3110, 60, 60)
    create_node(root, "b5_input", "lane_ac", "Input Kas Keluar (Nominal & Keterangan)", "shape=manualInput;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;", X_AC, 3210, 160, 60)
    create_node(root, "b5_simpan", "lane_sys", "Memotong Saldo Kas Cabang", "rounded=0;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;", X_SYS, 3210, 160, 60)
    create_node(root, "b5_db", "lane_sys", "DB Kas", "shape=cylinder3;whiteSpace=wrap;html=1;boundedLbl=1;backgroundOutline=1;size=15;fillColor=#e1d5e7;strokeColor=#9673a6;", X_SYS+40, 3310, 80, 80)
    create_node(root, "b5_struk", "lane_sys", "Generate Bukti Pengeluaran", "shape=document;whiteSpace=wrap;html=1;boundedLbl=1;fillColor=#dae8fc;strokeColor=#6c8ebf;", X_SYS+20, 3420, 120, 70)
    create_node(root, "b5_cetak", "lane_ac", "Cetak Bukti Pengeluaran", "shape=document;whiteSpace=wrap;html=1;boundedLbl=1;fillColor=#fff2cc;strokeColor=#d6b656;", X_AC+20, 3420, 120, 70)
    create_node(root, "b5_end", "lane_ac", "Selesai", "rounded=1;whiteSpace=wrap;html=1;arcSize=50;strokeWidth=2;fillColor=#f8cecc;strokeColor=#b85450;", X_AC+50, 3530, 60, 60)
    
    create_edge(root, "e_b5_1", "b5_start", "b5_input")
    create_edge(root, "e_b5_2", "b5_input", "b5_simpan")
    create_edge(root, "e_b5_3", "b5_simpan", "b5_db")
    create_edge(root, "e_b5_4", "b5_db", "b5_struk")
    create_edge(root, "e_b5_5", "b5_struk", "b5_cetak")
    create_edge(root, "e_b5_6", "b5_cetak", "b5_end")

    # P6
    create_node(root, "sep6", "1", "Proses 6: Pengadaan Barang Masuk (Restock - Oleh Admin Cabang & Super Admin)", "text;html=1;align=left;verticalAlign=middle;whiteSpace=wrap;rounded=0;fontStyle=1;fontSize=14;", 120, 3640, 700, 30)
    create_node(root, "b6_start", "lane_ac", "Mulai", "rounded=1;whiteSpace=wrap;html=1;arcSize=50;fillColor=#d5e8d4;strokeColor=#82b366;", X_AC+50, 3690, 60, 60)
    create_node(root, "b6_cek", "lane_ac", "Cek Sisa Stok Barang", "shape=manualOperation;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;", X_AC, 3790, 160, 60)
    create_node(root, "b6_limit", "lane_sys", "Menampilkan Daftar Barang < Safety Stock", "shape=display;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;", X_SYS, 3790, 160, 60)
    create_node(root, "b6_pesan", "lane_ac", "Melakukan Pemesanan ke Supplier", "shape=manualInput;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;", X_AC, 3890, 160, 60)
    create_node(root, "b6_terima", "lane_ac", "Menerima & Memeriksa Fisik Barang", "shape=manualOperation;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;", X_AC, 3990, 160, 60)
    create_node(root, "b6_input", "lane_ac", "Input Transaksi Barang Masuk", "shape=manualInput;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;", X_AC, 4090, 160, 60)
    create_node(root, "b6_simpan", "lane_sys", "Menyimpan Penambahan stok", "rounded=0;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;", X_SYS, 4090, 160, 60)
    create_node(root, "b6_db", "lane_sys", "DB Persediaan", "shape=cylinder3;whiteSpace=wrap;html=1;boundedLbl=1;backgroundOutline=1;size=15;fillColor=#e1d5e7;strokeColor=#9673a6;", X_SYS+40, 4190, 80, 80)
    create_node(root, "b6_lap", "lane_sys", "Generate Laporan Barang Masuk", "shape=document;whiteSpace=wrap;html=1;boundedLbl=1;fillColor=#dae8fc;strokeColor=#6c8ebf;", X_SYS+20, 4290, 120, 70)
    create_node(root, "b6_review", "lane_sa", "Review Laporan Barang Masuk", "shape=document;whiteSpace=wrap;html=1;boundedLbl=1;fillColor=#fff2cc;strokeColor=#d6b656;", X_SA+20, 4290, 120, 70)
    create_node(root, "b6_end", "lane_sa", "Selesai", "rounded=1;whiteSpace=wrap;html=1;arcSize=50;strokeWidth=2;fillColor=#f8cecc;strokeColor=#b85450;", X_SA+50, 4400, 60, 60)
    
    create_edge(root, "e_b6_1", "b6_start", "b6_cek")
    create_edge(root, "e_b6_2", "b6_cek", "b6_limit")
    create_edge(root, "e_b6_3", "b6_limit", "b6_pesan", points=[(1150, 3870), (550, 3870)])
    create_edge(root, "e_b6_4", "b6_pesan", "b6_terima")
    create_edge(root, "e_b6_5", "b6_terima", "b6_input")
    create_edge(root, "e_b6_6", "b6_input", "b6_simpan")
    create_edge(root, "e_b6_7", "b6_simpan", "b6_db")
    create_edge(root, "e_b6_8", "b6_db", "b6_lap")
    create_edge(root, "e_b6_9", "b6_lap", "b6_review")
    create_edge(root, "e_b6_10", "b6_review", "b6_end")

    xml_str = ET.tostring(mxfile, encoding="unicode")
    # Draw.io usually saves without declaration or formatting, but lets write it raw
    with open("Flowchart_Sistem_Yang_Akan_Diajukan.drawio", "w", encoding="utf-8") as f:
        f.write(xml_str)

if __name__ == "__main__":
    main()
