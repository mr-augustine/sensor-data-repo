/**
 * Updates the Sensor Units dropdown according to the Sensor Type
 * that the user selects
 */

function updateSensorUnits() {
	var sensorType = document.getElementById('sensorType');
	
	var validUnits = undefined;
	
	switch (sensorType.value) {
		case 'ALTITUDE':
			validUnits = ['FEET', 'KILOMETERS', 'METERS', 'MILES'];
			break;
		case 'BINARY':
			validUnits = ['1-0', 'ON-OFF', 'TRUE-FALSE', 'YES-NO'];
			break;
		case 'COUNT':
			validUnits = ['PER'];
			break;
		case 'DIRECTION':
			validUnits = ['BACKWARD', 'FORWARD', 'LEFT', 'RIGHT'];
			break;
		case 'DISTANCE':
			validUnits = ['CENTIMETERS', 'FEET', 'INCHES', 'KILOMETERS', 'METERS', 'MILES'];
			break;
		case 'HEADING':
			validUnits = ['DEGREES', 'RADIANS'];
			break;
		case 'IMAGING':
			validUnits = ['COLOR', 'GRAYSCALE', 'INFRARED'];
			break;
		case 'LATITUDE':
		case 'LONGITUDE':
			validUnits = ['DDMS', 'DMS'];
			break;
		case 'RANGE':
			validUnits = ['CENTIMETERS', 'FEET', 'INCHES', 'METERS'];
			break;
		case 'RATE':
			validUnits = ['METERS-PER-SECOND', 'MILES-PER-HOUR'];
			break;
		case 'TEMPERATURE':
			validUnits = ['DEGREES-CELCIUS', 'DEGREES-FAHRENHEIT'];
			break;
		default:
		
	}
	
	var sensorUnit = document.getElementById('sensorUnits');
	
	while (sensorUnit.firstChild) {
        sensorUnit.removeChild(sensorUnit.firstChild);
    }

    if (sensorUnit.selectedIndex == 0) {
        return;
    }
    for (var i = 0; i < validUnits.length; i++) {
        var o = document.createElement('option');
        o.value = validUnits[i].toString();
        o.text = validUnits[i].toString();
        sensorUnit.appendChild(o);
    }
}