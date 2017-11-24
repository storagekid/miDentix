function cleanUpSpecialChars(str)
{
    str = str.replace(/[àá]/g,"a");
    str = str.replace(/[èé]/g,"e");
    str = str.replace(/[ìí]/g,"i");
    str = str.replace(/[òó]/g,"o");
    str = str.replace(/[ùú]/g,"u");
    str = str.replace(/[ñ]/g,"n");
    // return str.replace(/[^a-z0-9]/gi,''); // final clean up
    return str;
}
function scheduleToHumans(schedule) {
	let object = JSON.parse(schedule);
	let days = {};
	let string = "";
	for (let day in object) {
		let keys = Object.keys(object[day]).length;
		let start = null;
		let end = null;
		let ranges = [];
		let range = null;
		let stop = false;
		let counter = 0
		let index = 0;
 		for (let hour in object[day]) {
 			index++;
 			if (object[day][hour]) {
 				if (!days[day]) {
 					days[day] = "";
 				}
 				if (!start) {
 					start = hour;
 					counter++;
 				} else if ((hour-counter) == start) {
 					end = hour;
 					counter++;
 				}
				if (keys == index) {
					if (start) {
						if (end) {
							range = start+'-'+end;
							// console.log('Range: '+range);
						} else {
							range = start;
							// console.log('Range: '+range);						
						}
						// console.log('Start: '+start);
						ranges.push(range);
						range = null;
						counter = 0;
						start = null;
						end = null;
					}
				}
 			} else if (!object[day][hour]) {
 				// if (keys == index) {
 				// 	console.log('END!!');
 				// }
 				if (start) {
 					if (end) {
 						range = start+'-'+end;
 						// console.log('Range: '+range);
 					} else {
 						range = start;
 						// console.log('Range: '+range);						
 					}
 					// console.log('Start: '+start);
 					ranges.push(range);
 					range = null;
 					counter = 0;
 					start = null;
 					end = null;
 				}
 			}
 		}
 		if (ranges) {
 			days[day] = ranges;
 		}
	}
	let daysText = "";
	let tempText = null;
	let before = [];
	let beforeLabel = "";
	let index = 0;
	let keys = Object.keys(days).length;
	// console.log(days);
	// return JSON.stringify(days);
	for (day in days) {
		index++;
		let label = "";
		if (days[day].length > 0) {
			switch(day) {
				case '01':
				label = "L";
				break;
				case '02':
				label = "M";
				break;
				case '03':
				label = "X";
				break;
				case '04':
				label = "J";
				break;
				case '05':
				label = "V";
				break;
				case '06':
				label = "S";
				break;
				case '07':
				label = "D";
				break;
			}
			if (!tempText) {
				let string = label+': '+days[day].join();
				tempText = string;
			}
			if (days[day].join() == before.join()) {
				// console.log('SAME');
				string = beforeLabel+'-'+label+': '+days[day].join();
				tempText = string;
				if (keys == index) {
					if (!daysText) {
						daysText = tempText;
					} else {
						daysText += '<br>'+tempText;
					}
				}
 				// console.log(tempText);
			} else {
				if (keys == index) {
					if (before.length > 0) {
						if (!daysText) {
							daysText = tempText;
						} else {
							daysText += '<br>'+tempText;
						}
					}
					let string = label+': '+days[day].join();
					tempText = string;
					if (!daysText) {
						daysText = tempText;
					} else {
						daysText += '<br>'+tempText;
					}
				}
				else if (index > 1 && before.length) {
					if (!daysText) {
						daysText = tempText;
					} else {
						daysText += '<br>'+tempText;
					}
					let string = label+': '+days[day].join();
					tempText = string;
					beforeLabel = label;
				}
				beforeLabel = label;
			}
			if (!beforeLabel) {
				beforeLabel = label;
			}
			before = days[day];
		} 
		else if (tempText) {
			if (!daysText) {
				daysText = tempText;
			} else {
				daysText += '<br>'+tempText;
			}
			tempText = null;
			before = [];
			beforeLabel = "";
		}
		else if (keys == index) {
			if (tempText) {
				if (!daysText) {
					daysText = tempText;
				} else {
					daysText += '<br>'+tempText;
				}
			}
		} 
	}
	// console.log(daysText);
	return daysText;
	// console.log(JSON.parse(schedule));
}