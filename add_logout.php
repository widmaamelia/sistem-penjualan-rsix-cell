<?php
$xml = <<<'XML'
  <diagram id="logout_activity" name="10. Logout">
    <mxGraphModel dx="1000" dy="1000" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="827" pageHeight="1169" math="0" shadow="0">
      <root>
        <mxCell id="0" />
        <mxCell id="1" parent="0" />
        <mxCell id="lane_u_logout" value="Pengguna" style="swimlane;html=1;startSize=30;fillColor=#f5f5f5;fontStyle=1;" vertex="1" parent="1">
          <mxGeometry x="100" y="40" width="300" height="600" as="geometry" />
        </mxCell>
        <mxCell id="lane_s_logout" value="Sistem (Rsix Cell)" style="swimlane;html=1;startSize=30;fillColor=#dae8fc;fontStyle=1;" vertex="1" parent="1">
          <mxGeometry x="400" y="40" width="300" height="600" as="geometry" />
        </mxCell>
        <mxCell id="lout_n1" value="" style="ellipse;html=1;fillColor=#000000;strokeColor=none;perimeter=ellipsePerimeter;" vertex="1" parent="lane_u_logout">
          <mxGeometry x="135" y="60" width="30" height="30" as="geometry" />
        </mxCell>
        <mxCell id="lout_n2" value="Klik Tombol Logout" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#fff2cc;strokeColor=#d6b656;" vertex="1" parent="lane_u_logout">
          <mxGeometry x="80" y="160" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="lout_n3" value="Hapus Sesi &amp; Kredensial" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="lane_s_logout">
          <mxGeometry x="80" y="260" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="lout_n4" value="Redirect ke Halaman Login" style="rounded=1;whiteSpace=wrap;html=1;fillColor=#dae8fc;strokeColor=#6c8ebf;" vertex="1" parent="lane_s_logout">
          <mxGeometry x="80" y="360" width="140" height="60" as="geometry" />
        </mxCell>
        <mxCell id="lout_n5" value="" style="ellipse;html=1;shape=endState;fillColor=#000000;strokeColor=#000000;" vertex="1" parent="lane_u_logout">
          <mxGeometry x="135" y="475" width="30" height="30" as="geometry" />
        </mxCell>
        <mxCell id="lout_e1" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="lout_n1" target="lout_n2">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="lout_e2" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="lout_n2" target="lout_n3">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="lout_e3" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="lout_n3" target="lout_n4">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
        <mxCell id="lout_e4" style="edgeStyle=orthogonalEdgeStyle;rounded=1;html=1;" edge="1" parent="1" source="lout_n4" target="lout_n5">
          <mxGeometry relative="1" as="geometry" />
        </mxCell>
      </root>
    </mxGraphModel>
  </diagram>
</mxfile>
XML;

$content = file_get_contents('Activity_Diagrams_Rsix_Cell.drawio');
$content = preg_replace('/<\/mxfile>\s*$/i', $xml, $content);
file_put_contents('Activity_Diagrams_Rsix_Cell.drawio', $content);
echo "Diagram Logout ditambahkan.\n";
