<?php
$xml = <<<'XML'
  <diagram id="approve_stok_opname" name="10. Approve Stok Opname">
    <mxGraphModel dx="1000" dy="1000" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="827" pageHeight="1169" math="0" shadow="0">
      <root>
        <mxCell id="0" />
        <mxCell id="1" parent="0" />
        <mxCell id="lane_u_aso" value="Super Admin" style="swimlane;html=1;startSize=30;fillColor=#f5f5f5;fontStyle=1;" vertex="1" parent="1">
          <mxGeometry x="100" y="40" width="300" height="1100" as="geometry" />
        </mxCell>
        <mxCell id="lane_s_aso" value="Sistem (Rsix Cell)" style="swimlane;html=1;startSize=30;fillColor=#dae8fc;fontStyle=1;" vertex="1" parent="1">
          <mxGeometry x="400" y="40" width="300" height="1100" as="geometry" />
        </mxCell>
        <mxCell id="aso_n1" value="" style="ellipse;html=1;fillColor=#000000;strokeColor=none;perimeter=ellipsePerimeter;" vertex="1" parent="lane_u_aso">
          <mxGeometry x="135" y="60" width="30" height="30" as="geometry" />
        </mxCell>
        <mxCell id="aso_n2" value="Akses Menu Stok Opname" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="lane_u_aso">
          <mxGeometry x="80" y="160" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="aso_s1" value="Tampilkan Daftar Stok Opname" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="lane_s_aso">
          <mxGeometry x="80" y="260" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="aso_n2b" value="Pilih Data &amp; Klik Detail" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="lane_u_aso">
          <mxGeometry x="80" y="360" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="aso_s1b" value="Tampilkan Detail Stok Opname" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="lane_s_aso">
          <mxGeometry x="80" y="460" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="aso_n3" value="Klik Setuju/Tolak" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="lane_u_aso">
          <mxGeometry x="80" y="560" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="aso_s2" value="Tampilkan Popup Konfirmasi" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="lane_s_aso">
          <mxGeometry x="80" y="660" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="aso_n4" value="Konfirmasi" style="rhombus;whiteSpace=wrap;html=1;fillColor=#e1d5e7;strokeColor=#9673a6;" vertex="1" parent="lane_u_aso">
          <mxGeometry x="90" y="760" width="120" height="80" as="geometry" />
        </mxCell>
        <mxCell id="aso_s3" value="Update Status, Sesuaikan Stok &amp; Sukses" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="lane_s_aso">
          <mxGeometry x="60" y="860" width="180" height="60" as="geometry" />
        </mxCell>
        <mxCell id="aso_n5" value="" style="ellipse;html=1;shape=endState;fillColor=#000000;strokeColor=#000000;" vertex="1" parent="lane_u_aso">
          <mxGeometry x="135" y="980" width="30" height="30" as="geometry" />
        </mxCell>
        
        <mxCell id="aso_e1" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="aso_n1" target="aso_n2">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="aso_e2" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="aso_n2" target="aso_s1">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="aso_e3" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="aso_s1" target="aso_n2b">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="aso_e4" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="aso_n2b" target="aso_s1b">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="aso_e5" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="aso_s1b" target="aso_n3">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="aso_e6" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="aso_n3" target="aso_s2">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="aso_e7" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="aso_s2" target="aso_n4">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="aso_e8_tidak" value="Batal / Tidak" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="aso_n4" target="aso_s1b">
          <mxGeometry relative="1" as="geometry">
            <Array as="points">
              <mxPoint x="60" y="800" />
              <mxPoint x="60" y="490" />
            </Array>
          </mxGeometry>
        </mxCell>
        <mxCell id="aso_e9_ya" value="Ya" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="aso_n4" target="aso_s3">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="aso_e10" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="aso_s3" target="aso_n5">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
      </root>
    </mxGraphModel>
  </diagram>
XML;

$content = file_get_contents('Activity_Diagrams_Rsix_Cell.drawio');
$content = preg_replace('/<diagram id="approve_stok_opname"[\s\S]*?<\/diagram>/i', $xml, $content);
file_put_contents('Activity_Diagrams_Rsix_Cell.drawio', $content);
echo "Diagram Approve Stok Opname diperbarui.\n";
