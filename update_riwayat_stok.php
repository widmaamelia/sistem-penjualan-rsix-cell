<?php
$xml = <<<'XML'
  <diagram id="riwayat_stok" name="19. Riwayat Stok">
    <mxGraphModel dx="1000" dy="1000" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="827" pageHeight="1169" math="0" shadow="0">
      <root>
        <mxCell id="0" />
        <mxCell id="1" parent="0" />
        <mxCell id="lane_u_rs" value="Super Admin / Admin Cabang" style="swimlane;html=1;startSize=30;fillColor=#f5f5f5;fontStyle=1;" vertex="1" parent="1">
          <mxGeometry x="100" y="40" width="300" height="700" as="geometry" />
        </mxCell>
        <mxCell id="lane_s_rs" value="Sistem (Rsix Cell)" style="swimlane;html=1;startSize=30;fillColor=#dae8fc;fontStyle=1;" vertex="1" parent="1">
          <mxGeometry x="400" y="40" width="300" height="700" as="geometry" />
        </mxCell>
        <mxCell id="rs_n1" value="" style="ellipse;html=1;fillColor=#000000;strokeColor=none;perimeter=ellipsePerimeter;" vertex="1" parent="lane_u_rs">
          <mxGeometry x="135" y="60" width="30" height="30" as="geometry" />
        </mxCell>
        <mxCell id="rs_n2" value="Akses Menu Stok" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="lane_u_rs">
          <mxGeometry x="80" y="160" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="rs_s1" value="Tampilkan Daftar Stok" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="lane_s_rs">
          <mxGeometry x="80" y="260" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="rs_n3" value="Pilih Produk &amp; Klik Riwayat" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="lane_u_rs">
          <mxGeometry x="80" y="360" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="rs_s2" value="Tampilkan Detail Riwayat Stok Produk" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="lane_s_rs">
          <mxGeometry x="70" y="460" width="160" height="60" as="geometry" />
        </mxCell>
        <mxCell id="rs_n4" value="" style="ellipse;html=1;shape=endState;fillColor=#000000;strokeColor=#000000;" vertex="1" parent="lane_u_rs">
          <mxGeometry x="135" y="575" width="30" height="30" as="geometry" />
        </mxCell>
        
        <mxCell id="rs_e1" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="rs_n1" target="rs_n2">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="rs_e2" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="rs_n2" target="rs_s1">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="rs_e3" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="rs_s1" target="rs_n3">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="rs_e4" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="rs_n3" target="rs_s2">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="rs_e5" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="rs_s2" target="rs_n4">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
      </root>
    </mxGraphModel>
  </diagram>
XML;

$content = file_get_contents('Activity_Diagrams_Rsix_Cell.drawio');
$content = preg_replace('/<diagram id="riwayat_stok"[\s\S]*?<\/diagram>/i', $xml, $content);
file_put_contents('Activity_Diagrams_Rsix_Cell.drawio', $content);
echo "Diagram Riwayat Stok diupdate.\n";
