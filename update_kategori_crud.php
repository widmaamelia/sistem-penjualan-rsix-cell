<?php
$xml_tambah = <<<'XML'
  <diagram id="tambah_kategori" name="11a. Tambah Kategori">
    <mxGraphModel dx="1000" dy="1000" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="827" pageHeight="1169" math="0" shadow="0">
      <root>
        <mxCell id="0" />
        <mxCell id="1" parent="0" />
        <mxCell id="lane_u_tkat" value="Super Admin / Admin" style="swimlane;html=1;startSize=30;fillColor=#f5f5f5;fontStyle=1;" vertex="1" parent="1">
          <mxGeometry x="100" y="40" width="300" height="800" as="geometry" />
        </mxCell>
        <mxCell id="lane_s_tkat" value="Sistem (Rsix Cell)" style="swimlane;html=1;startSize=30;fillColor=#dae8fc;fontStyle=1;" vertex="1" parent="1">
          <mxGeometry x="400" y="40" width="300" height="800" as="geometry" />
        </mxCell>
        <mxCell id="tkat_n1" value="" style="ellipse;html=1;fillColor=#000000;strokeColor=none;perimeter=ellipsePerimeter;" vertex="1" parent="lane_u_tkat">
          <mxGeometry x="135" y="60" width="30" height="30" as="geometry" />
        </mxCell>
        <mxCell id="tkat_n2" value="Akses Menu Kategori" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="lane_u_tkat">
          <mxGeometry x="80" y="160" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="tkat_n3" value="Klik Tambah Kategori" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="lane_u_tkat">
          <mxGeometry x="80" y="260" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="tkat_n4" value="Input Form &amp; Submit" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="lane_u_tkat">
          <mxGeometry x="80" y="360" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="tkat_n5" value="Validasi &amp; Simpan DB" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="lane_s_tkat">
          <mxGeometry x="80" y="460" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="tkat_n6" value="Tampilkan Pesan Sukses" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="lane_s_tkat">
          <mxGeometry x="80" y="560" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="tkat_n7" value="" style="ellipse;html=1;shape=endState;fillColor=#000000;strokeColor=#000000;" vertex="1" parent="lane_u_tkat">
          <mxGeometry x="135" y="675" width="30" height="30" as="geometry" />
        </mxCell>
        <mxCell id="tkat_e1" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="tkat_n1" target="tkat_n2">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="tkat_e2" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="tkat_n2" target="tkat_n3">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="tkat_e3" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="tkat_n3" target="tkat_n4">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="tkat_e4" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="tkat_n4" target="tkat_n5">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="tkat_e5" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="tkat_n5" target="tkat_n6">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="tkat_e6" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="tkat_n6" target="tkat_n7">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
      </root>
    </mxGraphModel>
  </diagram>
XML;

$xml_edit = <<<'XML'
  <diagram id="edit_kategori" name="11b. Edit Kategori">
    <mxGraphModel dx="1000" dy="1000" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="827" pageHeight="1169" math="0" shadow="0">
      <root>
        <mxCell id="0" />
        <mxCell id="1" parent="0" />
        <mxCell id="lane_u_ekat" value="Super Admin / Admin" style="swimlane;html=1;startSize=30;fillColor=#f5f5f5;fontStyle=1;" vertex="1" parent="1">
          <mxGeometry x="100" y="40" width="300" height="800" as="geometry" />
        </mxCell>
        <mxCell id="lane_s_ekat" value="Sistem (Rsix Cell)" style="swimlane;html=1;startSize=30;fillColor=#dae8fc;fontStyle=1;" vertex="1" parent="1">
          <mxGeometry x="400" y="40" width="300" height="800" as="geometry" />
        </mxCell>
        <mxCell id="ekat_n1" value="" style="ellipse;html=1;fillColor=#000000;strokeColor=none;perimeter=ellipsePerimeter;" vertex="1" parent="lane_u_ekat">
          <mxGeometry x="135" y="60" width="30" height="30" as="geometry" />
        </mxCell>
        <mxCell id="ekat_n2" value="Akses Menu Kategori" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="lane_u_ekat">
          <mxGeometry x="80" y="160" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="ekat_n3" value="Pilih Data &amp; Klik Edit" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="lane_u_ekat">
          <mxGeometry x="80" y="260" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="ekat_n4" value="Ubah Data &amp; Submit" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="lane_u_ekat">
          <mxGeometry x="80" y="360" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="ekat_n5" value="Validasi &amp; Update DB" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="lane_s_ekat">
          <mxGeometry x="80" y="460" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="ekat_n6" value="Tampilkan Pesan Sukses" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="lane_s_ekat">
          <mxGeometry x="80" y="560" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="ekat_n7" value="" style="ellipse;html=1;shape=endState;fillColor=#000000;strokeColor=#000000;" vertex="1" parent="lane_u_ekat">
          <mxGeometry x="135" y="675" width="30" height="30" as="geometry" />
        </mxCell>
        <mxCell id="ekat_e1" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="ekat_n1" target="ekat_n2">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="ekat_e2" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="ekat_n2" target="ekat_n3">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="ekat_e3" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="ekat_n3" target="ekat_n4">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="ekat_e4" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="ekat_n4" target="ekat_n5">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="ekat_e5" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="ekat_n5" target="ekat_n6">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="ekat_e6" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="ekat_n6" target="ekat_n7">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
      </root>
    </mxGraphModel>
  </diagram>
XML;

$xml_hapus = <<<'XML'
  <diagram id="hapus_kategori" name="11c. Hapus Kategori">
    <mxGraphModel dx="1000" dy="1000" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="827" pageHeight="1169" math="0" shadow="0">
      <root>
        <mxCell id="0" />
        <mxCell id="1" parent="0" />
        <mxCell id="lane_u_hkat" value="Super Admin / Admin" style="swimlane;html=1;startSize=30;fillColor=#f5f5f5;fontStyle=1;" vertex="1" parent="1">
          <mxGeometry x="100" y="40" width="300" height="800" as="geometry" />
        </mxCell>
        <mxCell id="lane_s_hkat" value="Sistem (Rsix Cell)" style="swimlane;html=1;startSize=30;fillColor=#dae8fc;fontStyle=1;" vertex="1" parent="1">
          <mxGeometry x="400" y="40" width="300" height="800" as="geometry" />
        </mxCell>
        <mxCell id="hkat_n1" value="" style="ellipse;html=1;fillColor=#000000;strokeColor=none;perimeter=ellipsePerimeter;" vertex="1" parent="lane_u_hkat">
          <mxGeometry x="135" y="60" width="30" height="30" as="geometry" />
        </mxCell>
        <mxCell id="hkat_n2" value="Akses Menu Kategori" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="lane_u_hkat">
          <mxGeometry x="80" y="160" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="hkat_n3" value="Pilih Data &amp; Klik Hapus" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="lane_u_hkat">
          <mxGeometry x="80" y="260" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="hkat_n4" value="Konfirmasi Hapus" style="rhombus;whiteSpace=wrap;html=1;fillColor=#e1d5e7;strokeColor=#9673a6;" vertex="1" parent="lane_s_hkat">
          <mxGeometry x="90" y="360" width="120" height="80" as="geometry" />
        </mxCell>
        <mxCell id="hkat_n5" value="Hapus Data dari DB" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="lane_s_hkat">
          <mxGeometry x="80" y="500" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="hkat_n6" value="Tampilkan Pesan Sukses" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="lane_s_hkat">
          <mxGeometry x="80" y="600" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="hkat_n7" value="" style="ellipse;html=1;shape=endState;fillColor=#000000;strokeColor=#000000;" vertex="1" parent="lane_u_hkat">
          <mxGeometry x="135" y="700" width="30" height="30" as="geometry" />
        </mxCell>
        <mxCell id="hkat_e1" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="hkat_n1" target="hkat_n2">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="hkat_e2" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="hkat_n2" target="hkat_n3">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="hkat_e3" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="hkat_n3" target="hkat_n4">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="hkat_e4_ya" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="hkat_n4" target="hkat_n5" value="Ya">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="hkat_e4_tdk" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="hkat_n4" target="hkat_n7" value="Tidak">
          <mxGeometry relative="1" as="geometry">
            <Array as="points">
              <mxPoint x="750" y="440" />
              <mxPoint x="750" y="715" />
            </Array>
          </mxGeometry>
        </mxCell>
        <mxCell id="hkat_e5" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="hkat_n5" target="hkat_n6">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="hkat_e6" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="hkat_n6" target="hkat_n7">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
      </root>
    </mxGraphModel>
  </diagram>
XML;

$xml_detail = <<<'XML'
  <diagram id="detail_kategori" name="11d. Detail Kategori">
    <mxGraphModel dx="1000" dy="1000" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="827" pageHeight="1169" math="0" shadow="0">
      <root>
        <mxCell id="0" />
        <mxCell id="1" parent="0" />
        <mxCell id="lane_u_dkat" value="Super Admin / Admin" style="swimlane;html=1;startSize=30;fillColor=#f5f5f5;fontStyle=1;" vertex="1" parent="1">
          <mxGeometry x="100" y="40" width="300" height="600" as="geometry" />
        </mxCell>
        <mxCell id="lane_s_dkat" value="Sistem (Rsix Cell)" style="swimlane;html=1;startSize=30;fillColor=#dae8fc;fontStyle=1;" vertex="1" parent="1">
          <mxGeometry x="400" y="40" width="300" height="600" as="geometry" />
        </mxCell>
        <mxCell id="dkat_n1" value="" style="ellipse;html=1;fillColor=#000000;strokeColor=none;perimeter=ellipsePerimeter;" vertex="1" parent="lane_u_dkat">
          <mxGeometry x="135" y="60" width="30" height="30" as="geometry" />
        </mxCell>
        <mxCell id="dkat_n2" value="Akses Menu Kategori" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="lane_u_dkat">
          <mxGeometry x="80" y="160" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="dkat_n3" value="Pilih Data &amp; Klik Detail" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="lane_u_dkat">
          <mxGeometry x="80" y="260" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="dkat_n4" value="Ambil &amp; Tampilkan Detail" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="lane_s_dkat">
          <mxGeometry x="80" y="360" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="dkat_n5" value="" style="ellipse;html=1;shape=endState;fillColor=#000000;strokeColor=#000000;" vertex="1" parent="lane_u_dkat">
          <mxGeometry x="135" y="475" width="30" height="30" as="geometry" />
        </mxCell>
        <mxCell id="dkat_e1" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="dkat_n1" target="dkat_n2">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="dkat_e2" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="dkat_n2" target="dkat_n3">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="dkat_e3" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="dkat_n3" target="dkat_n4">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="dkat_e4" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="dkat_n4" target="dkat_n5">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
      </root>
    </mxGraphModel>
  </diagram>
XML;

$content = file_get_contents('Activity_Diagrams_Rsix_Cell.drawio');

// First check if '11. Kelola Kategori' exists and remove it
$content = preg_replace('/<diagram id="kategori"[^>]*name="11[^"]*Kategori"[\s\S]*?<\/diagram>/i', '', $content);

// Insert the new diagrams at the end before </mxfile>
$new_diagrams = $xml_tambah . "\n" . $xml_edit . "\n" . $xml_hapus . "\n" . $xml_detail . "\n";
$content = preg_replace('/<\/mxfile>\s*$/i', $new_diagrams . "</mxfile>\n", $content);

file_put_contents('Activity_Diagrams_Rsix_Cell.drawio', $content);
echo "Diagram Kategori CRUD terpisah ditambahkan.\n";
