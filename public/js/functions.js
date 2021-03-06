function scrollToAndGlow(name, id, state, commit) {
	setTimeout(function() {
		// Vue.scrollToElement(name);
		commit('addIdToAnimate', id)
		// state.animationClasses["glitter-dentix"].push(id);
		setTimeout(function() {
			commit('cleanAnimations', "glitter-dentix")
		},3000); 
	},1000);
}

// function gropuBy(xs, key) {
// 	return xs.reduce(function(rv, x) {
// 	  (rv[x[key]] = rv[x[key]] || []).push(x);
// 	  return rv;
// 	}, {});
// }

function groupBy(list, keyGetter) {
    const map = new Map();
    list.forEach((item) => {
        const key = keyGetter(item);
        const collection = map.get(key);
        if (!collection) {
            map.set(key, [item]);
        } else {
            collection.push(item);
        }
    });
    return map;
}

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
function getAllUrlParams(url) {

  // get query string from url (optional) or window
  var queryString = url ? url.split('?')[1] : window.location.search.slice(1);

  // we'll store the parameters here
  var obj = {};

  // if query string exists
  if (queryString) {

    // stuff after # is not part of query string, so get rid of it
    queryString = queryString.split('#')[0];

    // split our query string into its component parts
    var arr = queryString.split('&');

    for (var i=0; i<arr.length; i++) {
      // separate the keys and the values
      var a = arr[i].split('=');

      // in case params look like: list[]=thing1&list[]=thing2
      var paramNum = undefined;
      var paramName = a[0].replace(/\[\d*\]/, function(v) {
        paramNum = v.slice(1,-1);
        return '';
      });

      // set parameter value (use 'true' if empty)
      var paramValue = typeof(a[1])==='undefined' ? true : a[1];

      // (optional) keep case consistent
      paramName = cleanUpSpecialChars(paramName.toLowerCase());
      paramValue = cleanUpSpecialChars(paramValue.toLowerCase());

      // if parameter name already exists
      if (obj[paramName]) {
        // convert value to array (if still string)
        if (typeof obj[paramName] === 'string') {
          obj[paramName] = [obj[paramName]];
        }
        // if no array index number specified...
        if (typeof paramNum === 'undefined') {
          // put the value on the end of the array
          obj[paramName].push(paramValue);
        }
        // if array index number specified...
        else {
          // put the value at that index number
          obj[paramName][paramNum] = paramValue;
        }
      }
      // if param name doesn't exist yet, set it
      else {
        obj[paramName] = paramValue;
      }
    }
  }

  return obj;
}