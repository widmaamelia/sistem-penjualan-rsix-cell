<?php

$nodes = [
    // Total Page Width: 1900, Height: ~5100
    ["lane_sa", "Super Admin", "swimlane", 50, 50, 400, 5000, "lane_sa"],
    ["lane_s", "Sistem", "swimlane", 450, 50, 600, 5000, "lane_s"],
    ["lane_ac", "Admin Cabang", "swimlane", 1050, 50, 400, 5000, "lane_ac"],
    ["lane_k", "Kasir", "swimlane", 1450, 50, 400, 5000, "lane_k"],
    
    // DB Pillar starts 300, ends 4750 (Height 4450)
    ["db_central", "Database Server\n(MySQL Sentral)", "db_huge", 710, 300, 80, 4450, "db_huge"],
    
    // Nodes
    ["start", "START", "terminator", 170, 100, 160, 60, "terminator"],
    ["sa1", "Mengelola data\nmaster sistem", "process", 150, 240, 200, 80, "proc_sa"],
    
    ["sys1", "Menyimpan &\nmenyinkronkan", "process", 500, 380, 200, 80, "proc_sys"],
    
    ["ac1", "Mengelola\noperasional cabang", "process", 1150, 520, 200, 80, "proc_ac"],
    ["ac2", "Input data\nbarang masuk", "process", 1150, 660, 200, 80, "proc_ac"],
    
    ["sys2", "Update data\nstok", "process", 800, 800, 200, 80, "proc_sys"],
    ["sys3", "Simpan histori\nstok", "process", 800, 940, 200, 80, "proc_sys"],
    
    ["kas1", "Login aplikasi POS", "process", 1550, 1080, 200, 80, "proc_k"],
    ["kas2", "Membuka shift", "process", 1550, 1220, 200, 80, "proc_k"],
    
    ["dec1", "Shift\nberhasil?", "decision", 1570, 1360, 160, 100, "dec_k"],
    ["kas_f1", "Info gagal", "process", 1750, 1370, 80, 80, "proc_small"],
    
    ["kas3", "Melayani transaksi\npenjualan", "process", 1550, 1540, 200, 80, "proc_k"],
    ["kas4", "Scan atau memilih\nproduk", "process", 1550, 1680, 200, 80, "proc_k"],
    
    ["sys4", "Tampilkan data\nproduk & harga", "process", 800, 1820, 200, 80, "proc_sys"],
    
    ["dec2", "Stok\ntersedia?", "decision", 820, 1960, 160, 100, "dec_sys"],
    ["kas_f3", "Info stok\nhabis", "process", 1750, 1970, 80, 80, "proc_small_red"],
    
    ["sys5", "Lanjut transaksi", "process", 800, 2140, 200, 80, "proc_sys"],
    
    ["kas5", "Menerima pembayaran\npelanggan", "process", 1550, 2280, 200, 80, "proc_k"],
    
    ["dec3", "Pembayaran\nberhasil?", "decision", 1570, 2420, 160, 100, "dec_k"],
    ["kas_f2", "Info gagal", "process", 1750, 2430, 80, 80, "proc_small"],
    
    ["sys6", "Simpan\ntransaksi", "process", 800, 2600, 200, 80, "proc_sys"],
    ["sys7", "Mengurangi stok\notomatis", "process", 800, 2740, 200, 80, "proc_sys"],
    ["sys8", "Update data\npenjualan", "process", 800, 2880, 200, 80, "proc_sys"],
    
    ["kas6", "Mencetak struk", "process", 1550, 3020, 200, 80, "proc_k"],
    ["kas7", "Menyerahkan struk\nke pelanggan", "process", 1550, 3160, 200, 80, "proc_k"],
    ["kas8", "Menutup shift", "process", 1550, 3300, 200, 80, "proc_k"],
    
    ["sys9", "Hitung hasil shift", "process", 800, 3440, 200, 80, "proc_sys"],
    ["sys10", "Buat laporan\npenjualan", "process", 800, 3580, 200, 80, "proc_sys"],
    ["sys11", "Buat laporan\nstok", "process", 800, 3720, 200, 80, "proc_sys"],
    
    ["ac3", "Meninjau laporan\ncabang", "process", 1150, 3860, 200, 80, "proc_ac"],
    
    ["dec4", "Jadwal Stock\nOpname?", "decision", 1170, 4000, 160, 100, "dec_ac"],
    
    ["ac4", "Melakukan cek fisik &\nInput Stock Opname", "process", 1150, 4180, 200, 80, "proc_ac"],
    
    ["sys12", "Memverifikasi\nselisih stok", "process", 800, 4320, 200, 80, "proc_sys"],
    
    ["dec5", "Approve\nStock Opname?", "decision", 170, 4460, 160, 100, "dec_sa"],
    
    ["sys13", "Update stok akhir\npasca Opname", "process", 800, 4640, 200, 80, "proc_sys"],
    
    ["sa2", "Memantau laporan\nseluruh cabang", "process", 150, 4820, 200, 80, "proc_sa"],
    
    ["end", "END", "terminator", 170, 4960, 160, 60, "terminator"]
];

$edges = [
    ["start", "sa1", "", "std_down"],
    ["sa1", "sys1", "", "std_right"],
    ["sys1", "ac1", "", "std_down"], 
    ["ac1", "ac2", "", "std_down"],
    ["ac2", "sys2", "", "std_left"],
    ["sys2", "sys3", "", "std_down"],
    ["sys3", "kas1", "", "std_right"],
    
    ["kas1", "kas2", "", "std_down"],
    ["kas2", "dec1", "", "std_down"],
    ["dec1", "kas_f1", "Tidak", "fail_right"],
    ["kas_f1", "kas2", "", "fail_up_right"],
    ["dec1", "kas3", "Ya", "std_down"],
    
    ["kas3", "kas4", "", "std_down"],
    ["kas4", "sys4", "", "std_left"],
    ["sys4", "dec2", "", "std_down"],
    ["dec2", "kas_f3", "Tidak", "fail_right"],
    ["kas_f3", "kas4", "", "fail_up_right"],
    ["dec2", "sys5", "Ya", "std_down"],
    
    ["sys5", "kas5", "", "std_right"],
    ["kas5", "dec3", "", "std_down"],
    ["dec3", "kas_f2", "Tidak", "fail_right"],
    ["kas_f2", "kas5", "", "fail_up_right"],
    ["dec3", "sys6", "Ya", "std_down"],
    
    ["sys6", "sys7", "", "std_down"],
    ["sys7", "sys8", "", "std_down"],
    ["sys8", "kas6", "", "std_right"],
    ["kas6", "kas7", "", "std_down"],
    ["kas7", "kas8", "", "std_down"],
    
    ["kas8", "sys9", "", "std_left"],
    
    ["sys9", "sys10", "", "std_down"],
    ["sys10", "sys11", "", "std_down"],
    ["sys11", "ac3", "", "std_right"],
    ["ac3", "dec4", "", "std_down"],
    
    ["dec4", "ac4", "Ya", "std_down"],
    ["dec4", "sa2", "Tidak", "skip_ac_sa"], 
    
    ["ac4", "sys12", "", "std_left"],
    ["sys12", "dec5", "", "std_left_cross"],
    
    ["dec5", "sys13", "Setuju", "std_down"],
    ["dec5", "ac4", "Tolak", "reject_sa_ac"],
    
    ["sys13", "sa2", "", "std_down"], 
    
    ["sa2", "end", "", "std_down"]
];

$db_edges = [
    ["sys1", "db_central", "Tulis", "db_edge_left"],
    ["sys2", "db_central", "Tulis", "db_edge_right"],
    ["sys3", "db_central", "Tulis", "db_edge_right"],
    ["sys4", "db_central", "Baca", "db_edge_right"],
    ["sys6", "db_central", "Tulis", "db_edge_right"],
    ["sys8", "db_central", "Tulis", "db_edge_right"],
    ["sys10", "db_central", "Tulis", "db_edge_right"],
    ["sys11", "db_central", "Tulis", "db_edge_right"],
    ["sys13", "db_central", "Tulis", "db_edge_right"]
];

function getNodeY($nodeId, $nodes) {
    foreach ($nodes as $n) {
        if ($n[0] == $nodeId) return $n[4];
    }
    return 0;
}

$styles = [
    "lane_sa" => "swimlane;horizontal=1;startSize=50;fillColor=#f8f9fa;fontColor=#212529;fontStyle=1;fontSize=20;strokeColor=#dee2e6;",
    "lane_s"  => "swimlane;horizontal=1;startSize=50;fillColor=#f8f9fa;fontColor=#212529;fontStyle=1;fontSize=20;strokeColor=#dee2e6;",
    "lane_ac" => "swimlane;horizontal=1;startSize=50;fillColor=#f8f9fa;fontColor=#212529;fontStyle=1;fontSize=20;strokeColor=#dee2e6;",
    "lane_k"  => "swimlane;horizontal=1;startSize=50;fillColor=#f8f9fa;fontColor=#212529;fontStyle=1;fontSize=20;strokeColor=#dee2e6;",
    
    "terminator" => "rounded=1;whiteSpace=wrap;html=1;arcSize=50;fillColor=#212529;strokeColor=#212529;fontColor=#ffffff;fontStyle=1;shadow=0;fontSize=18;",
    
    "proc_sa" => "rounded=0;whiteSpace=wrap;html=1;fillColor=#e9ecef;strokeColor=#ced4da;fontColor=#212529;shadow=0;strokeWidth=2;fontSize=16;",
    "proc_sys"=> "rounded=0;whiteSpace=wrap;html=1;fillColor=#e9ecef;strokeColor=#ced4da;fontColor=#212529;shadow=0;strokeWidth=2;fontSize=16;",
    "proc_ac" => "rounded=0;whiteSpace=wrap;html=1;fillColor=#e9ecef;strokeColor=#ced4da;fontColor=#212529;shadow=0;strokeWidth=2;fontSize=16;",
    "proc_k"  => "rounded=0;whiteSpace=wrap;html=1;fillColor=#e9ecef;strokeColor=#ced4da;fontColor=#212529;shadow=0;strokeWidth=2;fontSize=16;",
    
    "proc_small" => "rounded=0;whiteSpace=wrap;html=1;fillColor=#f8d7da;strokeColor=#f5c2c7;fontColor=#842029;shadow=0;fontSize=12;strokeWidth=2;",
    "proc_small_red" => "rounded=0;whiteSpace=wrap;html=1;fillColor=#f8d7da;strokeColor=#f5c2c7;fontColor=#842029;shadow=0;fontSize=12;strokeWidth=2;",
    
    // DB Text is moved to the top explicitly using verticalAlign=top
    "db_huge" => "shape=cylinder3;whiteSpace=wrap;html=1;boundedLbl=1;backgroundOutline=1;size=15;fillColor=#ffffff;strokeColor=#0dcaf0;fontColor=#055160;fontStyle=1;shadow=0;fontSize=18;strokeWidth=2;verticalAlign=top;spacingTop=40;",
    
    "dec_k" => "rhombus;whiteSpace=wrap;html=1;fillColor=#ffffff;strokeColor=#ffc107;fontColor=#664d03;shadow=0;strokeWidth=2;fontSize=16;",
    "dec_sys" => "rhombus;whiteSpace=wrap;html=1;fillColor=#ffffff;strokeColor=#ffc107;fontColor=#664d03;shadow=0;strokeWidth=2;fontSize=16;",
    "dec_ac" => "rhombus;whiteSpace=wrap;html=1;fillColor=#ffffff;strokeColor=#ffc107;fontColor=#664d03;shadow=0;strokeWidth=2;fontSize=16;",
    "dec_sa" => "rhombus;whiteSpace=wrap;html=1;fillColor=#ffffff;strokeColor=#ffc107;fontColor=#664d03;shadow=0;strokeWidth=2;fontSize=16;"
];

$xml = '<?xml version="1.0" encoding="UTF-8"?>
<mxfile host="app.diagrams.net">
  <diagram id="diag_master_large" name="Flowchart Final">
    <mxGraphModel dx="1200" dy="1600" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="1950" pageHeight="5100" math="0" shadow="0">
      <root>
        <mxCell id="0" />
        <mxCell id="1" parent="0" />
';

foreach ($nodes as $node) {
    list($n_id, $text, $n_type, $x, $y, $w, $h, $s_class) = $node;
    $style = isset($styles[$s_class]) ? $styles[$s_class] : "";
    $escaped_text = htmlspecialchars($text, ENT_QUOTES | ENT_XML1, 'UTF-8');
    
    $xml .= '        <mxCell id="' . $n_id . '" value="' . $escaped_text . '" style="' . $style . '" vertex="1" parent="1">
          <mxGeometry x="' . $x . '" y="' . $y . '" width="' . $w . '" height="' . $h . '" as="geometry" />
        </mxCell>
';
}

$edgeId = 1;

foreach ($edges as $edge) {
    $src = $edge[0];
    $tgt = $edge[1];
    $label = isset($edge[2]) ? $edge[2] : "";
    $type = isset($edge[3]) ? $edge[3] : "std";
    
    $escaped_label = htmlspecialchars($label, ENT_QUOTES | ENT_XML1, 'UTF-8');
    
    $base_edge = "endArrow=classic;html=1;rounded=0;strokeColor=#212529;strokeWidth=3;fontColor=#212529;fontSize=16;labelBackgroundColor=#ffffff;edgeStyle=orthogonalEdgeStyle;jumpStyle=arc;jumpSize=20;fontStyle=1;";
    $points_xml = "";
    
    if ($type == "fail_right") {
        $edge_style = $base_edge . "strokeColor=#dc3545;fontColor=#dc3545;exitX=1;exitY=0.5;entryX=0;entryY=0.5;";
    } else if ($type == "fail_up_right") {
        $edge_style = $base_edge . "strokeColor=#dc3545;fontColor=#dc3545;exitX=0.5;exitY=0;entryX=1;entryY=0.5;";
    } else if ($type == "reject_sa_ac") {
        $edge_style = $base_edge . "strokeColor=#dc3545;fontColor=#dc3545;exitX=1;exitY=0.5;entryX=0;entryY=0.5;";
        $points_xml = '<Array as="points"><mxPoint x="420" y="4510" /><mxPoint x="420" y="4220" /></Array>';
    } else if ($type == "skip_ac_sa") {
        // Enters SA2 on the Left edge to cleanly merge below DB
        $edge_style = $base_edge . "exitX=0;exitY=0.5;entryX=0;entryY=0.5;";
        $points_xml = '<Array as="points"><mxPoint x="1030" y="4050" /><mxPoint x="1030" y="4860" /><mxPoint x="150" y="4860" /></Array>';
    } else if ($type == "std_down") {
        $edge_style = $base_edge . "exitX=0.5;exitY=1;entryX=0.5;entryY=0;";
    } else if ($type == "std_right") {
        $edge_style = $base_edge . "exitX=1;exitY=0.5;entryX=0;entryY=0.5;";
    } else if ($type == "std_left") {
        $edge_style = $base_edge . "exitX=0;exitY=0.5;entryX=1;entryY=0.5;";
    } else if ($type == "std_left_cross") {
        $edge_style = $base_edge . "exitX=0;exitY=0.5;entryX=1;entryY=0.5;";
    } else {
        $edge_style = $base_edge;
    }
    
    $xml .= '        <mxCell id="edge_' . $edgeId . '" value="' . $escaped_label . '" style="' . $edge_style . '" edge="1" parent="1" source="' . $src . '" target="' . $tgt . '">
      <mxGeometry relative="1" as="geometry">';
    
    if ($points_xml != "") {
        $xml .= $points_xml;
    } else {
        $xml .= '<mxPoint as="offset" />';
    }
        
    $xml .= '</mxGeometry>
    </mxCell>
';
    $edgeId++;
}

// Database Edges
foreach ($db_edges as $edge) {
    $src = $edge[0];
    $tgt = $edge[1];
    $label = isset($edge[2]) ? $edge[2] : "";
    $dir = isset($edge[3]) ? $edge[3] : "db_edge_right";
    
    $srcY = getNodeY($src, $nodes);
    $srcCenterY = $srcY + 40; // Half of height 80
    
    $db_y_start = 300;
    $db_height = 4450;
    
    $relative_entryY = ($srcCenterY - $db_y_start) / $db_height;
    $entryY_str = number_format($relative_entryY, 4, ".", "");
    
    $escaped_label = htmlspecialchars($label, ENT_QUOTES | ENT_XML1, 'UTF-8');
    
    // Increased stroke width and font size for DB edges
    if ($dir == "db_edge_left") {
        $edge_style = "endArrow=classic;html=1;rounded=0;strokeColor=#0dcaf0;strokeWidth=3;dashed=1;fontColor=#055160;fontSize=14;fontStyle=1;labelBackgroundColor=#ffffff;edgeStyle=none;exitX=1;exitY=0.5;entryX=0;entryY=" . $entryY_str . ";";
    } else {
        $edge_style = "endArrow=classic;html=1;rounded=0;strokeColor=#0dcaf0;strokeWidth=3;dashed=1;fontColor=#055160;fontSize=14;fontStyle=1;labelBackgroundColor=#ffffff;edgeStyle=none;exitX=0;exitY=0.5;entryX=1;entryY=" . $entryY_str . ";";
    }
    
    $xml .= '        <mxCell id="edge_' . $edgeId . '" value="' . $escaped_label . '" style="' . $edge_style . '" edge="1" parent="1" source="' . $src . '" target="' . $tgt . '">
      <mxGeometry relative="1" as="geometry">
        <mxPoint as="offset" />
      </mxGeometry>
    </mxCell>
';
    $edgeId++;
}

$xml .= '      </root>
    </mxGraphModel>
  </diagram>
</mxfile>';

file_put_contents('Flowchart_Sistem_Rsix_Cell.drawio', $xml);
echo "Berhasil memperbesar font, kotak proses, ketebalan panah, dan memperbaiki label database agar tidak tertindih.\n";
