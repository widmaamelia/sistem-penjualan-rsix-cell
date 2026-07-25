<?php
$content = file_get_contents('Activity_Diagrams_Rsix_Cell.drawio');

// Match Start cells
$content = preg_replace_callback('/(<mxCell[^>]+value="Start"[^>]+style="[^"]*ellipse[^"]*"[^>]*>)\s*<mxGeometry([^>]+)>/', function($matches) {
    $tag = $matches[1];
    $geom = $matches[2];
    
    // Replace value="Start" with value=""
    $tag = preg_replace('/value="Start"/', 'value=""', $tag);
    // Replace style="..." with new style
    $tag = preg_replace('/style="[^"]*"/', 'style="ellipse;html=1;fillColor=#000000;strokeColor=none;perimeter=ellipsePerimeter;"', $tag);
    
    // Parse geometry
    preg_match('/width="([^"]+)"/', $geom, $wm);
    preg_match('/height="([^"]+)"/', $geom, $hm);
    preg_match('/x="([^"]+)"/', $geom, $xm);
    preg_match('/y="([^"]+)"/', $geom, $ym);
    
    $w = isset($wm[1]) ? floatval($wm[1]) : 60;
    $h = isset($hm[1]) ? floatval($hm[1]) : 60;
    $x = isset($xm[1]) ? floatval($xm[1]) : 0;
    $y = isset($ym[1]) ? floatval($ym[1]) : 0;
    
    $nw = 30;
    $nh = 30;
    $nx = $x + ($w - $nw)/2;
    $ny = $y + ($h - $nh)/2;
    
    $geom = preg_replace('/width="[^"]+"/', 'width="' . $nw . '"', $geom);
    $geom = preg_replace('/height="[^"]+"/', 'height="' . $nh . '"', $geom);
    $geom = preg_replace('/x="[^"]+"/', 'x="' . $nx . '"', $geom);
    $geom = preg_replace('/y="[^"]+"/', 'y="' . $ny . '"', $geom);
    
    return $tag . "\n          <mxGeometry" . $geom . ">";
}, $content);

// Match End cells
$content = preg_replace_callback('/(<mxCell[^>]+value="End"[^>]+style="[^"]*ellipse[^"]*"[^>]*>)\s*<mxGeometry([^>]+)>/', function($matches) {
    $tag = $matches[1];
    $geom = $matches[2];
    
    $tag = preg_replace('/value="End"/', 'value=""', $tag);
    $tag = preg_replace('/style="[^"]*"/', 'style="ellipse;html=1;shape=endState;fillColor=#000000;strokeColor=#000000;"', $tag);
    
    preg_match('/width="([^"]+)"/', $geom, $wm);
    preg_match('/height="([^"]+)"/', $geom, $hm);
    preg_match('/x="([^"]+)"/', $geom, $xm);
    preg_match('/y="([^"]+)"/', $geom, $ym);
    
    $w = isset($wm[1]) ? floatval($wm[1]) : 60;
    $h = isset($hm[1]) ? floatval($hm[1]) : 60;
    $x = isset($xm[1]) ? floatval($xm[1]) : 0;
    $y = isset($ym[1]) ? floatval($ym[1]) : 0;
    
    $nw = 30;
    $nh = 30;
    $nx = $x + ($w - $nw)/2;
    $ny = $y + ($h - $nh)/2;
    
    $geom = preg_replace('/width="[^"]+"/', 'width="' . $nw . '"', $geom);
    $geom = preg_replace('/height="[^"]+"/', 'height="' . $nh . '"', $geom);
    $geom = preg_replace('/x="[^"]+"/', 'x="' . $nx . '"', $geom);
    $geom = preg_replace('/y="[^"]+"/', 'y="' . $ny . '"', $geom);
    
    return $tag . "\n          <mxGeometry" . $geom . ">";
}, $content);

file_put_contents('Activity_Diagrams_Rsix_Cell.drawio', $content);
echo "Done replacing Start and End elements.\n";
