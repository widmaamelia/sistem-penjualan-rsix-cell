import xml.etree.ElementTree as ET
import os

def update_bagian_1():
    tree = ET.parse('Flowchart_Sistem_Bagian_1.drawio')
    root = tree.getroot()
    model = root.find('.//mxGraphModel/root')
    
    # 1. Change manualInput to parallelogram
    for cell in model.findall('mxCell'):
        style = cell.get('style', '')
        if 'shape=manualInput' in style:
            style = style.replace('shape=manualInput', 'shape=parallelogram')
            cell.set('style', style)
            
    # 2. b3_struk (Generate Struk) -> Change to Process. b3_cetak is already Document.
    b3_struk = model.find(".//*[@id='b3_struk']")
    if b3_struk is not None:
        style = b3_struk.get('style')
        style = style.replace('shape=document;whiteSpace=wrap;html=1;boundedLbl=1;', 'rounded=0;whiteSpace=wrap;html=1;')
        b3_struk.set('style', style)
        
    # 3. b4_lap (Generate Laporan Tutup Shift) -> Change to Process, Add b4_cetak (Document)
    b4_lap = model.find(".//*[@id='b4_lap']")
    if b4_lap is not None:
        style = b4_lap.get('style')
        style = style.replace('shape=document;whiteSpace=wrap;html=1;boundedLbl=1;', 'rounded=0;whiteSpace=wrap;html=1;')
        b4_lap.set('style', style)
        
        for cell in model.findall('mxCell'):
            geom = cell.find('mxGeometry')
            if geom is not None and geom.get('y'):
                y = int(geom.get('y'))
                if y > 1880 and cell.get('id') not in ['lane_sa', 'lane_ac', 'lane_kar', 'lane_sys']:
                    geom.set('y', str(y + 100))
                    
        for lane_id in ['lane_sa', 'lane_ac', 'lane_kar', 'lane_sys']:
            lane = model.find(f".//*[@id='{lane_id}']/mxGeometry")
            if lane is not None:
                h = int(lane.get('height'))
                lane.set('height', str(h + 200))
                
        b4_cetak = ET.Element('mxCell', {'id': 'b4_cetak', 'parent': 'lane_sys', 'style': 'shape=document;whiteSpace=wrap;html=1;boundedLbl=1;fontSize=14;', 'value': 'Dokumen Laporan Tutup Shift', 'vertex': '1'})
        ET.SubElement(b4_cetak, 'mxGeometry', {'x': '90', 'y': '1980', 'width': '120', 'height': '70', 'as': 'geometry'})
        model.append(b4_cetak)
        
        e_b4_9 = model.find(".//*[@id='e_b4_9']")
        if e_b4_9 is not None:
            e_b4_9.set('target', 'b4_cetak')
            
        e_b4_9b = ET.Element('mxCell', {'id': 'e_b4_9b', 'parent': '1', 'source': 'b4_cetak', 'target': 'b4_review', 'style': 'edgeStyle=orthogonalEdgeStyle;rounded=0;orthogonalLoop=1;jettySize=auto;html=1;endArrow=classic;endFill=1;strokeColor=#000000;strokeWidth=2;fontSize=14;', 'value': '', 'edge': '1'})
        ET.SubElement(e_b4_9b, 'mxGeometry', {'relative': '1', 'as': 'geometry'})
        model.append(e_b4_9b)

    # 4. Add Decision Approval to b4_review
    b4_review = model.find(".//*[@id='b4_review']")
    if b4_review is not None:
        for cell in model.findall('mxCell'):
            geom = cell.find('mxGeometry')
            if geom is not None and geom.get('y'):
                y = int(geom.get('y'))
                if y > 2080 and cell.get('id') not in ['lane_sa', 'lane_ac', 'lane_kar', 'lane_sys']:
                    geom.set('y', str(y + 120))
                    
        b4_dec = ET.Element('mxCell', {'id': 'b4_dec', 'parent': 'lane_ac', 'style': 'rhombus;whiteSpace=wrap;html=1;fontSize=14;', 'value': 'Disetujui?', 'vertex': '1'})
        ET.SubElement(b4_dec, 'mxGeometry', {'x': '100', 'y': '2190', 'width': '100', 'height': '80', 'as': 'geometry'})
        model.append(b4_dec)
        
        b4_end = model.find(".//*[@id='b4_end']/mxGeometry")
        if b4_end is not None:
            b4_end.set('y', '2310')
            
        e_b4_10 = model.find(".//*[@id='e_b4_10']")
        if e_b4_10 is not None:
            e_b4_10.set('target', 'b4_dec')
            
        e_b4_yes = ET.Element('mxCell', {'id': 'e_b4_yes', 'parent': '1', 'source': 'b4_dec', 'target': 'b4_end', 'style': 'edgeStyle=orthogonalEdgeStyle;rounded=0;orthogonalLoop=1;jettySize=auto;html=1;endArrow=classic;endFill=1;strokeColor=#000000;strokeWidth=2;fontSize=14;', 'value': 'Ya', 'edge': '1'})
        ET.SubElement(e_b4_yes, 'mxGeometry', {'relative': '1', 'as': 'geometry'})
        model.append(e_b4_yes)
        
        e_b4_no = ET.Element('mxCell', {'id': 'e_b4_no', 'parent': '1', 'source': 'b4_dec', 'target': 'b4_input', 'style': 'edgeStyle=orthogonalEdgeStyle;rounded=0;orthogonalLoop=1;jettySize=auto;html=1;endArrow=classic;endFill=1;strokeColor=#000000;strokeWidth=2;fontSize=14;', 'value': 'Tidak', 'edge': '1'})
        geom_no = ET.SubElement(e_b4_no, 'mxGeometry', {'relative': '1', 'as': 'geometry'})
        arr_no = ET.SubElement(geom_no, 'Array', {'as': 'points'})
        ET.SubElement(arr_no, 'mxPoint', {'x': '430', 'y': '2230'})
        ET.SubElement(arr_no, 'mxPoint', {'x': '430', 'y': '1710'}) # Align with b4_input y (1680+30)
        model.append(e_b4_no)
        
    tree.write('Flowchart_Sistem_Bagian_1.drawio', encoding='utf-8', xml_declaration=False)

def update_bagian_2():
    tree = ET.parse('Flowchart_Sistem_Bagian_2.drawio')
    root = tree.getroot()
    model = root.find('.//mxGraphModel/root')
    
    # 1. Change manualInput to parallelogram
    for cell in model.findall('mxCell'):
        style = cell.get('style', '')
        if 'shape=manualInput' in style:
            style = style.replace('shape=manualInput', 'shape=parallelogram')
            cell.set('style', style)
            
    # 3. Pisahkan Generate dan Dokumen
    b5_struk = model.find(".//*[@id='b5_struk']")
    if b5_struk is not None:
        style = b5_struk.get('style')
        style = style.replace('shape=document;whiteSpace=wrap;html=1;boundedLbl=1;', 'rounded=0;whiteSpace=wrap;html=1;')
        b5_struk.set('style', style)
        
    b6_lap = model.find(".//*[@id='b6_lap']")
    if b6_lap is not None:
        style = b6_lap.get('style')
        style = style.replace('shape=document;whiteSpace=wrap;html=1;boundedLbl=1;', 'rounded=0;whiteSpace=wrap;html=1;')
        b6_lap.set('style', style)
        
        for cell in model.findall('mxCell'):
            geom = cell.find('mxGeometry')
            if geom is not None and geom.get('y'):
                y = int(geom.get('y'))
                if y > 1100 and cell.get('id') not in ['lane_sa', 'lane_ac', 'lane_kar', 'lane_sys']:
                    geom.set('y', str(y + 220)) 
                    
        for lane_id in ['lane_sa', 'lane_ac', 'lane_kar', 'lane_sys']:
            lane = model.find(f".//*[@id='{lane_id}']/mxGeometry")
            if lane is not None:
                h = int(lane.get('height'))
                lane.set('height', str(h + 300))
                
        b6_cetak = ET.Element('mxCell', {'id': 'b6_cetak', 'parent': 'lane_sys', 'style': 'shape=document;whiteSpace=wrap;html=1;boundedLbl=1;fontSize=14;', 'value': 'Dokumen Laporan Masuk', 'vertex': '1'})
        ET.SubElement(b6_cetak, 'mxGeometry', {'x': '90', 'y': '1200', 'width': '120', 'height': '70', 'as': 'geometry'})
        model.append(b6_cetak)
        
        e_b6_9 = model.find(".//*[@id='e_b6_9']")
        if e_b6_9 is not None:
            e_b6_9.set('target', 'b6_cetak')
            
        b6_review = model.find(".//*[@id='b6_review']/mxGeometry")
        b6_review.set('y', '1300')
        
        e_b6_9b = ET.Element('mxCell', {'id': 'e_b6_9b', 'parent': '1', 'source': 'b6_cetak', 'target': 'b6_review', 'style': 'edgeStyle=orthogonalEdgeStyle;rounded=0;orthogonalLoop=1;jettySize=auto;html=1;endArrow=classic;endFill=1;strokeColor=#000000;strokeWidth=2;fontSize=14;', 'value': '', 'edge': '1'})
        ET.SubElement(e_b6_9b, 'mxGeometry', {'relative': '1', 'as': 'geometry'})
        model.append(e_b6_9b)

    # 4. Add Decision Approval to b6_review
    b6_dec = ET.Element('mxCell', {'id': 'b6_dec', 'parent': 'lane_sa', 'style': 'rhombus;whiteSpace=wrap;html=1;fontSize=14;', 'value': 'Disetujui?', 'vertex': '1'})
    ET.SubElement(b6_dec, 'mxGeometry', {'x': '100', 'y': '1410', 'width': '100', 'height': '80', 'as': 'geometry'})
    model.append(b6_dec)
    
    e_b6_10 = model.find(".//*[@id='e_b6_10']")
    if e_b6_10 is not None:
        e_b6_10.set('target', 'b6_dec')
        
    e_b6_yes = ET.Element('mxCell', {'id': 'e_b6_yes', 'parent': '1', 'source': 'b6_dec', 'target': 'b6_end', 'style': 'edgeStyle=orthogonalEdgeStyle;rounded=0;orthogonalLoop=1;jettySize=auto;html=1;endArrow=classic;endFill=1;strokeColor=#000000;strokeWidth=2;fontSize=14;', 'value': 'Ya', 'edge': '1'})
    ET.SubElement(e_b6_yes, 'mxGeometry', {'relative': '1', 'as': 'geometry'})
    model.append(e_b6_yes)
    
    e_b6_no = ET.Element('mxCell', {'id': 'e_b6_no', 'parent': '1', 'source': 'b6_dec', 'target': 'b6_terima', 'style': 'edgeStyle=orthogonalEdgeStyle;rounded=0;orthogonalLoop=1;jettySize=auto;html=1;endArrow=classic;endFill=1;strokeColor=#000000;strokeWidth=2;fontSize=14;', 'value': 'Tidak', 'edge': '1'})
    geom_no2 = ET.SubElement(e_b6_no, 'mxGeometry', {'relative': '1', 'as': 'geometry'})
    arr_no2 = ET.SubElement(geom_no2, 'Array', {'as': 'points'})
    ET.SubElement(arr_no2, 'mxPoint', {'x': '130', 'y': '1450'})
    ET.SubElement(arr_no2, 'mxPoint', {'x': '130', 'y': '930'}) 
    model.append(e_b6_no)
    
    # b7_export
    b7_export = model.find(".//*[@id='b7_export']")
    if b7_export is not None:
        style = b7_export.get('style')
        style = style.replace('shape=document;whiteSpace=wrap;html=1;boundedLbl=1;', 'rounded=0;whiteSpace=wrap;html=1;')
        b7_export.set('style', style)
        b7_export.set('value', 'Generate Laporan')
        
        b7_cetak = ET.Element('mxCell', {'id': 'b7_cetak', 'parent': 'lane_sys', 'style': 'shape=document;whiteSpace=wrap;html=1;boundedLbl=1;fontSize=14;', 'value': 'File Laporan Cabang', 'vertex': '1'})
        ET.SubElement(b7_cetak, 'mxGeometry', {'x': '90', 'y': '1850', 'width': '120', 'height': '70', 'as': 'geometry'})
        model.append(b7_cetak)
        
        for cell in model.findall('mxCell'):
            geom = cell.find('mxGeometry')
            if geom is not None and geom.get('y'):
                y = int(geom.get('y'))
                if y > 1750 and cell.get('id') not in ['lane_sa', 'lane_ac', 'lane_kar', 'lane_sys', 'b7_cetak', 'b7_export', 'b7_end', 'e_b7_8', 'e_b7_9']:
                    geom.set('y', str(y + 100))
                    
        b7_end = model.find(".//*[@id='b7_end']/mxGeometry")
        if b7_end is not None:
            b7_end.set('y', '1950')
            
        e_b7_8 = model.find(".//*[@id='e_b7_8']")
        if e_b7_8 is not None:
            e_b7_8.set('target', 'b7_cetak')
            
        e_b7_8b = ET.Element('mxCell', {'id': 'e_b7_8b', 'parent': '1', 'source': 'b7_cetak', 'target': 'b7_end', 'style': 'edgeStyle=orthogonalEdgeStyle;rounded=0;orthogonalLoop=1;jettySize=auto;html=1;endArrow=classic;endFill=1;strokeColor=#000000;strokeWidth=2;fontSize=14;', 'value': '', 'edge': '1'})
        geom_8b = ET.SubElement(e_b7_8b, 'mxGeometry', {'relative': '1', 'as': 'geometry'})
        arr_8b = ET.SubElement(geom_8b, 'Array', {'as': 'points'})
        ET.SubElement(arr_8b, 'mxPoint', {'x': '1150', 'y': '1980'})
        ET.SubElement(arr_8b, 'mxPoint', {'x': '550', 'y': '1980'})
        model.append(e_b7_8b)
        
        e_b7_9 = model.find(".//*[@id='e_b7_9']/mxGeometry/Array")
        if e_b7_9 is not None:
            pts = e_b7_9.findall('mxPoint')
            if len(pts) > 1:
                pts[1].set('y', '1980')

    # b8_export
    b8_export = model.find(".//*[@id='b8_export']")
    if b8_export is not None:
        style = b8_export.get('style')
        style = style.replace('shape=document;whiteSpace=wrap;html=1;boundedLbl=1;', 'rounded=0;whiteSpace=wrap;html=1;')
        b8_export.set('style', style)
        b8_export.set('value', 'Generate Laporan')
        
        b8_cetak = ET.Element('mxCell', {'id': 'b8_cetak', 'parent': 'lane_sys', 'style': 'shape=document;whiteSpace=wrap;html=1;boundedLbl=1;fontSize=14;', 'value': 'File Laporan Global', 'vertex': '1'})
        ET.SubElement(b8_cetak, 'mxGeometry', {'x': '90', 'y': '2550', 'width': '120', 'height': '70', 'as': 'geometry'})
        model.append(b8_cetak)
        
        # Adjust y coordinates for lane size
        for lane_id in ['lane_sa', 'lane_ac', 'lane_kar', 'lane_sys']:
            lane = model.find(f".//*[@id='{lane_id}']/mxGeometry")
            if lane is not None:
                h = int(lane.get('height'))
                lane.set('height', str(h + 200))
                
        b8_end = model.find(".//*[@id='b8_end']/mxGeometry")
        if b8_end is not None:
            b8_end.set('y', '2670')
            
        e_b8_8 = model.find(".//*[@id='e_b8_8']")
        if e_b8_8 is not None:
            e_b8_8.set('target', 'b8_cetak')
            
        e_b8_8b = ET.Element('mxCell', {'id': 'e_b8_8b', 'parent': '1', 'source': 'b8_cetak', 'target': 'b8_end', 'style': 'edgeStyle=orthogonalEdgeStyle;rounded=0;orthogonalLoop=1;jettySize=auto;html=1;endArrow=classic;endFill=1;strokeColor=#000000;strokeWidth=2;fontSize=14;', 'value': '', 'edge': '1'})
        geom_8b2 = ET.SubElement(e_b8_8b, 'mxGeometry', {'relative': '1', 'as': 'geometry'})
        arr_8b2 = ET.SubElement(geom_8b2, 'Array', {'as': 'points'})
        ET.SubElement(arr_8b2, 'mxPoint', {'x': '1150', 'y': '2700'})
        ET.SubElement(arr_8b2, 'mxPoint', {'x': '250', 'y': '2700'})
        model.append(e_b8_8b)
        
        e_b8_9 = model.find(".//*[@id='e_b8_9']/mxGeometry/Array")
        if e_b8_9 is not None:
            pts = e_b8_9.findall('mxPoint')
            if len(pts) > 1:
                pts[1].set('y', '2700')

    tree.write('Flowchart_Sistem_Bagian_2.drawio', encoding='utf-8', xml_declaration=False)

if __name__ == '__main__':
    update_bagian_1()
    update_bagian_2()
    
    def ensure_xml_dec(f):
        with open(f, 'r', encoding='utf-8') as file:
            c = file.read()
        if '<mxfile host="app.diagrams.net">' not in c:
            pass # Element tree writes it properly but sometimes strips outer things if we used findall.
            # But we used tree.write so it's a valid XML.
            
    # We should add the mxfile tag back if it gets lost
    for f in ['Flowchart_Sistem_Bagian_1.drawio', 'Flowchart_Sistem_Bagian_2.drawio']:
        with open(f, 'r', encoding='utf-8') as file:
            c = file.read()
        # ElementTree strips the root mxfile if we parse and write, let's check
        if '<mxfile' not in c:
            # We parsed it, so the root IS mxfile. 
            pass
