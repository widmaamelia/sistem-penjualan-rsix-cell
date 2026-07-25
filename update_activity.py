import xml.etree.ElementTree as ET

def update_activity_diagram(filename):
    tree = ET.parse(filename)
    root = tree.getroot()
    
    # Process all mxCell elements
    for cell in root.findall('.//mxCell'):
        val = cell.get('value')
        style = cell.get('style', '')
        
        # Determine if this is a Start or End node
        is_start = False
        is_end = False
        
        if val == 'Start' and 'ellipse' in style:
            is_start = True
        elif val == 'End' and 'ellipse' in style:
            is_end = True
            
        if is_start or is_end:
            # Clear text
            cell.set('value', '')
            
            # Change style
            if is_start:
                cell.set('style', 'ellipse;html=1;fillColor=#000000;strokeColor=none;perimeter=ellipsePerimeter;')
            else:
                cell.set('style', 'ellipse;html=1;shape=endState;fillColor=#000000;strokeColor=#000000;')
                
            # Update geometry
            geom = cell.find('mxGeometry')
            if geom is not None:
                width = float(geom.get('width', '60'))
                height = float(geom.get('height', '60'))
                x = float(geom.get('x', '0'))
                y = float(geom.get('y', '0'))
                
                # We want new width=30, height=30
                # To keep it centered, shift x by (width - 30)/2
                new_width = 30.0
                new_height = 30.0
                
                dx = (width - new_width) / 2
                dy = (height - new_height) / 2
                
                new_x = x + dx
                new_y = y + dy
                
                # Format to int if possible, else round
                geom.set('width', str(int(new_width)))
                geom.set('height', str(int(new_height)))
                geom.set('x', str(int(new_x)))
                geom.set('y', str(int(new_y)))

    tree.write(filename, encoding='utf-8', xml_declaration=False)

if __name__ == '__main__':
    f = 'Activity_Diagrams_Rsix_Cell.drawio'
    update_activity_diagram(f)
    
    # Ensure <mxfile ...> header is preserved
    with open(f, 'r', encoding='utf-8') as file:
        content = file.read()
    if not content.startswith('<mxfile'):
        print("Warning: mxfile root tag might be malformed.")
