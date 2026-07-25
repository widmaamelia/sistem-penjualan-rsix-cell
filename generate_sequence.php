<?php

function getLifelineStyle($type) {
    $base = "shape=umlLifeline;perimeter=lifelinePerimeter;whiteSpace=wrap;html=1;container=1;collapsible=0;recursiveResize=0;outlineConnect=0;";
    $labelAlign = "verticalAlign=bottom;verticalLabelPosition=bottom;align=center;";
    
    switch ($type) {
        case 'actor':
            return $base . "participant=umlActor;$labelAlign";
        case 'boundary':
            return $base . "participant=umlBoundary;$labelAlign";
        case 'control':
            return $base . "participant=umlControl;$labelAlign";
        case 'entity':
            return $base . "participant=umlEntity;$labelAlign";
        default:
            return $base;
    }
}

function generateSequenceXML($diagramId, $diagramName, $lifelines, $messages) {
    $xml = "  <diagram id=\"$diagramId\" name=\"$diagramName\">\n";
    $xml .= "    <mxGraphModel dx=\"1000\" dy=\"1000\" grid=\"1\" gridSize=\"10\" guides=\"1\" tooltips=\"1\" connect=\"1\" arrows=\"1\" fold=\"1\" page=\"1\" pageScale=\"1\" pageWidth=\"1200\" pageHeight=\"800\" math=\"0\" shadow=\"0\">\n";
    $xml .= "      <root>\n";
    $xml .= "        <mxCell id=\"0\" />\n";
    $xml .= "        <mxCell id=\"1\" parent=\"0\" />\n";

    // Draw lifelines
    foreach ($lifelines as $id => $data) {
        $name = htmlspecialchars($data['name']);
        $x = $data['x'];
        $h = $data['h'];
        $type = isset($data['type']) ? $data['type'] : 'default';
        $style = getLifelineStyle($type);
        
        // Lifeline
        $xml .= "        <mxCell id=\"$id\" value=\"$name\" style=\"$style\" vertex=\"1\" parent=\"1\">\n";
        $xml .= "          <mxGeometry x=\"$x\" y=\"40\" width=\"60\" height=\"$h\" as=\"geometry\" />\n";
        $xml .= "        </mxCell>\n";
        
        // Activations for this lifeline
        if (isset($data['activations'])) {
            foreach ($data['activations'] as $actId => $actData) {
                $y = $actData['y'];
                $actH = $actData['h'];
                $xml .= "        <mxCell id=\"$actId\" value=\"\" style=\"html=1;points=[];perimeter=orthogonalPerimeter;fillColor=#ffe6cc;strokeColor=#d79b00;\" vertex=\"1\" parent=\"$id\">\n";
                $xml .= "          <mxGeometry x=\"25\" y=\"$y\" width=\"10\" height=\"$actH\" as=\"geometry\" />\n";
                $xml .= "        </mxCell>\n";
            }
        }
    }

    // Draw messages
    $msgCounter = 1;
    foreach ($messages as $msg) {
        $src = $msg['src'];
        $tgt = $msg['tgt'];
        $text = htmlspecialchars($msg['text']);
        $isReturn = isset($msg['return']) && $msg['return'] ? 'dashed=1;' : '';
        $edgeStyle = "html=1;verticalAlign=bottom;endArrow=block;edgeStyle=elbowEdgeStyle;elbow=vertical;curved=0;rounded=0;$isReturn";
        
        $msgId = $diagramId . "_msg_" . $msgCounter;
        
        $pointsXml = "";
        if (isset($msg['y'])) {
            $y = $msg['y'];
            $pointsXml = "<Array as=\"points\"><mxPoint x=\"0\" y=\"$y\" /></Array>";
            if ($src === $tgt) {
                $edgeStyle = "html=1;verticalAlign=bottom;endArrow=block;edgeStyle=orthogonalEdgeStyle;curved=0;rounded=0;";
                $pointsXml = "<Array as=\"points\"><mxPoint x=\"40\" y=\"$y\" /><mxPoint x=\"40\" y=\"".($y+30)."\" /></Array>";
            }
        }
        
        $xml .= "        <mxCell id=\"$msgId\" value=\"$text\" style=\"$edgeStyle\" edge=\"1\" parent=\"1\" source=\"$src\" target=\"$tgt\">\n";
        $xml .= "          <mxGeometry relative=\"1\" as=\"geometry\">$pointsXml</mxGeometry>\n";
        $xml .= "        </mxCell>\n";
        $msgCounter++;
    }

    $xml .= "      </root>\n";
    $xml .= "    </mxGraphModel>\n";
    $xml .= "  </diagram>\n";
    return $xml;
}

// =======================
// 1. LOGIN
// =======================
$loginLifelines = [
    'u1' => ['name' => 'Pengguna', 'type' => 'actor', 'x' => 100, 'h' => 500, 'activations' => [
        'u1_a1' => ['y' => 60, 'h' => 380]
    ]],
    'v1' => ['name' => 'View (Login Page)', 'type' => 'boundary', 'x' => 300, 'h' => 500, 'activations' => [
        'v1_a1' => ['y' => 80, 'h' => 40],
        'v1_a2' => ['y' => 380, 'h' => 40]
    ]],
    'c1' => ['name' => 'LoginController', 'type' => 'control', 'x' => 500, 'h' => 500, 'activations' => [
        'c1_a1' => ['y' => 100, 'h' => 300]
    ]],
    'db1' => ['name' => 'Database', 'type' => 'entity', 'x' => 700, 'h' => 500, 'activations' => [
        'db1_a1' => ['y' => 120, 'h' => 60]
    ]]
];

$loginMessages = [
    ['src' => 'u1_a1', 'tgt' => 'v1_a1', 'text' => '1. Input Username & Password', 'y' => 120],
    ['src' => 'v1_a1', 'tgt' => 'c1_a1', 'text' => '2. Submit Data Login (POST)', 'y' => 140],
    ['src' => 'c1_a1', 'tgt' => 'db1_a1', 'text' => '3. Query User by Username', 'y' => 160],
    ['src' => 'db1_a1', 'tgt' => 'c1_a1', 'text' => '4. Return Data User', 'return' => true, 'y' => 200],
    ['src' => 'c1_a1', 'tgt' => 'c1_a1', 'text' => '5. Verify Password Hash', 'y' => 240], // self message
    ['src' => 'c1_a1', 'tgt' => 'c1_a1', 'text' => '6. Set Session & Role', 'y' => 300], // self message
    ['src' => 'c1_a1', 'tgt' => 'v1_a2', 'text' => '7. Redirect ke Dashboard / Home', 'y' => 400],
    ['src' => 'v1_a2', 'tgt' => 'u1_a1', 'text' => '8. Tampilkan Halaman Utama', 'return' => true, 'y' => 440]
];

// =======================
// 2. TRANSAKSI POS
// =======================
$posLifelines = [
    'u2' => ['name' => 'Karyawan / Kasir', 'type' => 'actor', 'x' => 100, 'h' => 700, 'activations' => [
        'u2_a1' => ['y' => 60, 'h' => 580]
    ]],
    'v2' => ['name' => 'View (POS / Kasir)', 'type' => 'boundary', 'x' => 300, 'h' => 700, 'activations' => [
        'v2_a1' => ['y' => 80, 'h' => 80],
        'v2_a2' => ['y' => 220, 'h' => 60],
        'v2_a3' => ['y' => 560, 'h' => 60]
    ]],
    'c2' => ['name' => 'TransaksiController', 'type' => 'control', 'x' => 500, 'h' => 700, 'activations' => [
        'c2_a1' => ['y' => 100, 'h' => 40],
        'c2_a2' => ['y' => 240, 'h' => 320]
    ]],
    'db2' => ['name' => 'Database', 'type' => 'entity', 'x' => 700, 'h' => 700, 'activations' => [
        'db2_a1' => ['y' => 120, 'h' => 40],
        'db2_a2' => ['y' => 280, 'h' => 60],
        'db2_a3' => ['y' => 400, 'h' => 40],
        'db2_a4' => ['y' => 480, 'h' => 40]
    ]]
];

$posMessages = [
    ['src' => 'u2_a1', 'tgt' => 'v2_a1', 'text' => '1. Scan Barcode / Input Manual', 'y' => 120],
    ['src' => 'v2_a1', 'tgt' => 'c2_a1', 'text' => '2. Request Data Produk', 'y' => 140],
    ['src' => 'c2_a1', 'tgt' => 'db2_a1', 'text' => '3. Query Harga & Stok', 'y' => 160],
    ['src' => 'db2_a1', 'tgt' => 'c2_a1', 'text' => '4. Return Data Produk', 'return' => true, 'y' => 180],
    ['src' => 'c2_a1', 'tgt' => 'v2_a1', 'text' => '5. Update Keranjang di Layar', 'return' => true, 'y' => 200],
    ['src' => 'u2_a1', 'tgt' => 'v2_a2', 'text' => '6. Input Pembayaran & Klik Bayar', 'y' => 260],
    ['src' => 'v2_a2', 'tgt' => 'c2_a2', 'text' => '7. Submit Transaksi (POST)', 'y' => 280],
    ['src' => 'c2_a2', 'tgt' => 'c2_a2', 'text' => '8. Validasi Stok & Hitung Total', 'y' => 300],
    ['src' => 'c2_a2', 'tgt' => 'db2_a2', 'text' => '9. Simpan Data Transaksi (Header)', 'y' => 360],
    ['src' => 'db2_a2', 'tgt' => 'c2_a2', 'text' => '10. Return Transaksi ID', 'return' => true, 'y' => 380],
    ['src' => 'c2_a2', 'tgt' => 'db2_a3', 'text' => '11. Simpan Detail Transaksi (Items)', 'y' => 440],
    ['src' => 'db2_a3', 'tgt' => 'c2_a2', 'text' => '12. Success', 'return' => true, 'y' => 460],
    ['src' => 'c2_a2', 'tgt' => 'db2_a4', 'text' => '13. Kurangi Stok Produk', 'y' => 520],
    ['src' => 'db2_a4', 'tgt' => 'c2_a2', 'text' => '14. Stok Updated', 'return' => true, 'y' => 540],
    ['src' => 'c2_a2', 'tgt' => 'v2_a3', 'text' => '15. Return Data Struk (JSON/HTML)', 'y' => 600],
    ['src' => 'v2_a3', 'tgt' => 'u2_a1', 'text' => '16. Tampilkan Struk & Buka Laci Uang', 'return' => true, 'y' => 620]
];


// =======================
// BUILD XML
// =======================
$xmlHeader = '<?xml version="1.0" encoding="UTF-8"?>
<mxfile host="app.diagrams.net">
';
$xmlFooter = '</mxfile>';

$diagram1 = generateSequenceXML("seq_login", "1. Sequence - Login", $loginLifelines, $loginMessages);
$diagram2 = generateSequenceXML("seq_pos", "2. Sequence - Transaksi POS", $posLifelines, $posMessages);

$finalXml = $xmlHeader . $diagram1 . $diagram2 . $xmlFooter;

file_put_contents('Sequence_Diagrams_Rsix_Cell.drawio', $finalXml);
echo "Sequence_Diagrams_Rsix_Cell.drawio berhasil diupdate dengan simbol yang benar.\n";

