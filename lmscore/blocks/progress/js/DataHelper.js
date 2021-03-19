/** Data Helper Functions
 @Author : Aditya Rao
 @Description: Helper functions for data processing and visualizations
 @Requires D3 JS v5.16.0 or above.
 */

/* Initialization Section
 *  Checks if D3.js is loaded and loads it from the D3.js Website if it is already not imported.
 * @todo:aditya:make this work
 * */
const d3JSMinVersionRequired = "5.16.0";
let global = {};
global.debug = false;

/**
 * logs debug messages into console if debug in global is set to true
 * @param {Object} logMessage - message or Object to be logged
 * */
function logDebugMessage(logMessage) {
    if (getGlobalVariable("debug") === true) {
        console.log(logMessage);
    }
}

/**
 * gets the value of a global variable previously set
 * @param  {string} name - the name of the variable whose value you need
 * @returns {Object} value - value of the global variable
 */
function getGlobalVariable(name) {
    return global[name];
}

/**
 * sets the value of a global variable
 * @param  {string} name - the name of the variable whose value you need
 * @param   value - the name of the variable whose value you need
 * @returns {void}
 */
function setGlobalVariable(name, value) {
    if (name !== undefined && name.trim() !== "" && value !== undefined) {

        global[variableName] = value;
    }
}

/**
 * tests if given number is a positive Integer
 * @param {number} x - the number to test
 * @returns {boolean} - true if number is a positive integer, false if not
 */

function isPositiveInteger(x) {
    return /^\d+$/.test(x);
}

/**
 * Compare two software version numbers (e.g. 1.7.1)
 *
 *
 * 0 if they're identical
 *  negative if v1 < v2
 *  positive if v1 > v2
 *  Nan if they in the wrong format
 *
 *  E.g.:
 *
 *  assert(version_number_compare("1.7.1", "1.6.10") > 0);
 *  assert(version_number_compare("1.7.1", "1.7.10") < 0);
 *
 * @param {string} v1  - current version
 * @param {string} v2 - version to be compared to
 */

function compareVersionNumbers(v1, v2) {
    var v1parts = v1.split('.');
    var v2parts = v2.split('.');

    // First, validate both numbers are true version numbers
    function validateParts(parts) {
        for (var i = 0; i < parts.length; ++i) {
            if (!isPositiveInteger(parts[i])) {
                return false;
            }
        }
        return true;
    }

    if (!validateParts(v1parts) || !validateParts(v2parts)) {
        return NaN;
    }

    for (var i = 0; i < v1parts.length; ++i) {
        if (v2parts.length === i) {
            return 1;
        }

        if (v1parts[i] === v2parts[i]) {
            continue;
        }
        if (v1parts[i] > v2parts[i]) {
            return 1;
        }
        return -1;
    }

    if (v1parts.length != v2parts.length) {
        return -1;
    }

    return 0;
}

/**
 *  Checks if given string is in a valid JSON format
 *  @param {string} json - JSON string to be checked
 *  @returns {boolean} - true if given JSON string is a valid json, false if it is not.
 * */
function isValidJSON(json) {
    try {
        JSON.parse(json)
    } catch (e) {
        logDebugMessage(e.toString());
        return false;
    }
    return true;
}

/* Data Processing Section
 *  Helper functions for processing data
 * */

/**
 *  Re-structures the data for further processing
 *                Moves Original data to 'rawData' node.
 *                Adds the node 'summaryData' for summary data
 *                Adds Charting Information Structure 'chartInfo' which contains charting (data, options, style, tooltip e.t.c)options and can be populated.
 *                Adds data download permission node 'dataDownloadAllowed' which is false by default.
 *                Adds node 'dataProcessorFunction' to specify which function will process the raw data.
 *                   This would be different for different types of data and charts.
 * @param {JSON}  dataJSON - The data in JSON format string OR a JSON object
 * @return {JSON} finalJSON - The restructured JSON object
 */
function restructureData(dataJSON) {
    let processedJSON = typeof dataJSON != 'object' && isValidJSON(dataJSON) ? JSON.parse(dataJSON) : dataJSON;
    let finalJSON = {};
    if (processedJSON !== undefined && processedJSON.isDataRestructured !== true) {
        let chartStyleInfo = { width: "", height: "", colorSchemeId: 0, strokeColor: "#FFFFFF" };
        let tooltipInfo = { tooltipHTML: "", showAdditionalData: true, dataColorStyleType: "color" };
        finalJSON["summaryData"] = {};
        finalJSON['childrenData'] = {};
        finalJSON["dataDownloadAllowed"] = false;
        finalJSON["dataProcessorFunction"] = "";
        finalJSON["filtersAvailable"] = ""; //@todo:aditya:implement filters available
        finalJSON["filtersApplied"] = ""; //@todo:aditya:implement filters applied
        finalJSON["chartInfo"] = {
            type: "",
            title: "",
            pic: "",
            picClickCallbackFunction: "",
            animate: true,
            data: "",
            tooltipInfo: tooltipInfo,
            style: chartStyleInfo
        }
        finalJSON["rawData"] = processedJSON;
        finalJSON["isDataRestructured"] = true;
    } else {
        finalJSON = processedJSON;
    }
    logDebugMessage(finalJSON);
    return finalJSON;
}

/**
 * Processes course completion data. This is just an example function of how we can process raw data into summary data
 * which can be used to generate visualizations / charts.
 * @param data - data that needs to be processed. This data should ideally be restructured using restructureData()
 * @returns {JSON} - processed JSON with course completion data.
 */

function processCourseCompletionData(data) {
    let courseDataJSON = restructureData(data);
    if (courseDataJSON !== undefined && courseDataJSON["rawData"] !== undefined) {
        let completedCourses = 0;
        let totalModules = 0;
        let completedModules = 0;
        let totalCourses = 0;
        let rawData = courseDataJSON["rawData"];
        for (let x in rawData) {
            let courseCompleted = 0;
            let courseData = rawData[x];
            if (courseData.completedModules === courseData.totalModules) {
                courseCompleted = 1;
                completedCourses++;
            }
            totalModules = totalModules + parseInt(courseData.totalModules);
            completedModules = completedModules + parseInt(courseData.completedModules);
            totalCourses++;
            courseData["courseCompleted"] = courseCompleted;
        }
        courseDataJSON.summaryData.totalCourses = totalCourses;
        courseDataJSON.summaryData.completedCourses = completedCourses;
        courseDataJSON.summaryData.inCompleteCourses = totalCourses - completedCourses;
        courseDataJSON.summaryData.completionPercentage = parseInt((completedCourses / totalCourses) * 100);
        courseDataJSON.summaryData.nonCompletionPercentage = parseInt(((totalCourses - completedCourses) / totalCourses) * 100);
        courseDataJSON.summaryData.totalModules = totalModules;
        courseDataJSON.summaryData.completedModules = completedModules;
        courseDataJSON.summaryData.incompleteModules = totalModules - completedModules;

        let chartData = [];
        let additionalDataArr = [];
        let addDataTotalCourses = { dataKey: "Total Courses", dataValue: courseDataJSON.summaryData.totalCourses };
        let addDataTotalModules = { dataKey: "Total Modules", dataValue: courseDataJSON.summaryData.totalModules };
        let addDataCompletedModules = {
            dataKey: "Completed Modules",
            dataValue: courseDataJSON.summaryData.completedModules
        };
        let addDataIncompleteModules = {
            dataKey: "Incomplete Modules",
            dataValue: courseDataJSON.summaryData.incompleteModules
        };

        additionalDataArr.push(addDataTotalCourses);
        additionalDataArr.push(addDataTotalModules);
        additionalDataArr.push(addDataCompletedModules);
        let completedCoursesObj = {
            dataKey: 'Completed',
            dataValue: courseDataJSON.summaryData.completedCourses,
            dataPercentage: courseDataJSON.summaryData.completionPercentage,
            dataAdditional: additionalDataArr
        };

        additionalDataArr = [];
        additionalDataArr.push(addDataTotalCourses);
        additionalDataArr.push(addDataTotalModules);
        additionalDataArr.push(addDataIncompleteModules);

        let incompleteCoursesObj = {
            dataKey: 'Incomplete',
            dataValue: courseDataJSON.summaryData.inCompleteCourses,
            dataPercentage: courseDataJSON.summaryData.nonCompletionPercentage,
            dataAdditional: additionalDataArr
        };
        additionalDataArr = [];
        additionalDataArr.push(addDataTotalCourses);
        additionalDataArr.push(addDataTotalModules);
        additionalDataArr.push(addDataIncompleteModules);

        /*@Todo:aditya: delete this, this is testing data */
        /*let incompleteCoursesObj2 = {
            dataKey: 'Incomplete2',
            dataValue: courseDataJSON.summaryData.inCompleteCourses,
            dataPercentage: 555,
            dataAdditional: additionalDataArr
        };
        let incompleteCoursesObj3 = {
            dataKey: 'Incomplete3',
            dataValue: courseDataJSON.summaryData.inCompleteCourses,
            dataPercentage: 555,
            dataAdditional: additionalDataArr
        };
        let incompleteCoursesObj4 = {
            dataKey: 'Incomplete4',
            dataValue: courseDataJSON.summaryData.inCompleteCourses,
            dataPercentage: 555,
            dataAdditional: additionalDataArr
        };
        let incompleteCoursesObj5 = {
            dataKey: 'Incomplete5',
            dataValue: courseDataJSON.summaryData.inCompleteCourses,
            dataPercentage: 555,
            dataAdditional: additionalDataArr
        };
        let incompleteCoursesObj6 = {
            dataKey: 'Incomplete6',
            dataValue: courseDataJSON.summaryData.inCompleteCourses,
            dataPercentage: 555,
            dataAdditional: additionalDataArr
        };*/
        /*@Todo:aditya: delete this, this is testing data */
        chartData.push(completedCoursesObj);
        chartData.push(incompleteCoursesObj);
        /*@Todo:aditya: delete this, this is testing data */
        // chartData.push(incompleteCoursesObj2);
        // chartData.push(incompleteCoursesObj3);
        // chartData.push(incompleteCoursesObj4);
        // chartData.push(incompleteCoursesObj5);
        // chartData.push(incompleteCoursesObj6);
        /*@Todo:aditya: delete this, this is testing data */
        courseDataJSON.chartInfo.data = chartData;

    }
    logDebugMessage(courseDataJSON);
    return courseDataJSON;
}

/**
 * Adds options and styling info for the chart to the data.
 * @param data - data to which the chart information needs to be added
 * @param {string} type - type of chart (e.g donut, bar, line)
 * @param {string} title - title of the chart
 * @param {string} pic - the URL or location of the user or category.
 * @param {boolean} animate - charts that can be animated will animate if this is set to true, will not animate if false.
 * @param {number} width - width of the chart. If this not passed, the chart will adjust to the parent container width
 * @param {number} height - height of the chart. If this not passed, the chart will adjust to the parent container height
 * @param {number} colorSchemeId - Index Id of the required color scheme from the color scheme array. refer getColorScheme function.
 * @param {string} strokeColor - the color of the stroke lines in the chart. defaults to white/#FFFFFF.
 * @param {string} tooltipHTML - The HTML template for the tooltip.
 * @param {Object} picClickCallbackFunction - callback function when clicking on the pic.
 * @returns {JSON} dataWithChartInfo - json with these additional parameters set.
 */
function addChartInfo(data, type, title, pic, animate, width, height, colorSchemeId, strokeColor, tooltipHTML, picClickCallbackFunction) {
    let dataWithChartInfo = restructureData(data);
    dataWithChartInfo.chartInfo.type = type !== undefined && type.trim() !== "" ? type : dataWithChartInfo.chartInfo.type;
    dataWithChartInfo.chartInfo.title = title !== undefined && title.trim() !== "" ? title : dataWithChartInfo.chartInfo.title;
    dataWithChartInfo.chartInfo.pic = pic !== undefined && pic.trim() !== "" ? pic : dataWithChartInfo.chartInfo.pic;
    dataWithChartInfo.chartInfo.animate = animate !== undefined && typeof animate === 'boolean' ? animate : dataWithChartInfo.chartInfo.animate;
    dataWithChartInfo.chartInfo.style.width = width !== undefined && !isNaN(parseInt(width)) ? width : dataWithChartInfo.chartInfo.style.width;
    dataWithChartInfo.chartInfo.style.height = height !== undefined && !isNaN(parseInt(height)) ? height : dataWithChartInfo.chartInfo.style.height;
    dataWithChartInfo.chartInfo.style.colorSchemeId = colorSchemeId !== undefined && !isNaN(parseInt(colorSchemeId)) ? colorSchemeId : dataWithChartInfo.chartInfo.style.colorSchemeId;
    dataWithChartInfo.chartInfo.style.strokeColor = strokeColor !== undefined && strokeColor.trim() !== "" ? strokeColor : dataWithChartInfo.chartInfo.style.strokeColor;
    dataWithChartInfo.chartInfo.tooltipInfo.tooltipHTML = tooltipHTML !== undefined && tooltipHTML.trim() !== "" ? tooltipHTML : dataWithChartInfo.chartInfo.tooltipInfo.tooltipHTML;
    dataWithChartInfo.chartInfo.picClickCallbackFunction = picClickCallbackFunction !== undefined && picClickCallbackFunction.trim() !== "" ? picClickCallbackFunction : dataWithChartInfo.chartInfo.picClickCallbackFunction;
    logDebugMessage(dataWithChartInfo);
    return dataWithChartInfo;
}

/**
 * generates headers for the raw data
 * @param {JSON} data - data object for which headers need to be made for the raw data
 * @returns {JSON} data - returns the data with the headers array 'rawDataHeaders' added to the data object.
 */
function generateHeadersForRawData(data) {
    if (data !== undefined && data !== "") {
        let rawData = data.rawData;
        let headers = {};
        for (let key in rawData) {
            if (rawData.hasOwnProperty(key)) {
                valueObj = rawData[key];
                for (let z in valueObj) {
                    headers[z] = z.replace(/,/g, '').toUpperCase();
                }
            }

        }
        data["rawDataHeaders"] = headers;
    }
    return data;
}

/**
 *
 * @param {JSON} objArray - json object to convert to csv
 * @returns {string} str = CSV string.
 */
function convertToCSV(objArray) {
    var array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;
    var str = '';

    for (var i = 0; i < array.length; i++) {
        var line = '';
        for (var index in array[i]) {
            if (line != '') line += ','

            line += array[i][index];
        }

        str += line + '\r\n';
    }
    return str;
}

/**
 * exports the data to csv to the file
 * @param {JSON} headers - csv file headers
 * @param {JSON} items - Data that needs to be exported
 * @param {string} fileTitle - title of the file
 */
function exportCSVFile(headers, items, fileTitle) {
    if (headers) {
        items.unshift(headers);
    }
    // convert object to JSON String;
    var jsonObject = JSON.stringify(items);

    var csv = this.convertToCSV(jsonObject);
    var date = new Date();
    var timestamp = date.getTime();
    var exportedFileName = fileTitle != undefined && fileTitle.trim() != "" ? fileTitle.split(/[ ,]+/).join("_") + '.csv' : 'export_' + timestamp + '.csv';

    var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });

    if (navigator.msSaveBlob) { // IE 10+
        navigator.msSaveBlob(blob, exportedFileName);
    } else {
        var link = document.createElement("a");
        if (link.download !== undefined) { // feature detection
            // Browsers that support HTML5 download attribute
            var url = URL.createObjectURL(blob);
            link.setAttribute("href", url);
            link.setAttribute("download", exportedFileName);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }

}

/**
 * wrapper function to download raw data a file.
 * @param {JSON} data - data to be exported
 * @param {string} fileTitle - title of the file to be saved once downloaded
 */
function downloadRawData(data, fileTitle) {
    generateHeadersForRawData(data);
    exportCSVFile(data.rawDataHeaders, data.rawData, fileTitle);
}



/* Data Visualization Section
*  Helper functions for visualizing data
*/

/**
 *
 * @param {string} containerId - id of the parent container.
 * @param {JSON} data - structured , processed JSON data with chart info populated.
 */
function donutChart(containerId, data) {
    let containerDimensions = getContainerDimensions(containerId);
    let width = data.chartInfo.style.width !== undefined && !isNaN(parseInt(data.chartInfo.style.width)) ? data.chartInfo.style.width : containerDimensions.width;
    let height = data.chartInfo.style.height !== undefined && !isNaN(parseInt(data.chartInfo.style.height)) ? data.chartInfo.style.width : containerDimensions.height;
    let margin = Math.min(width, height) / 20;
    let radius = Math.min(width, height) / 2 - margin * 2.5;
    let innerRadius = Math.min(width, height) / 5 + margin * 2;
    let strokeWidth = Math.min(width, height) / 200;
    let strokeWidthOnHover = 5 * strokeWidth;
    let chartData = data.chartInfo.data !== undefined ? data.chartInfo.data : undefined;
    let chartTitle = data.chartInfo.title !== undefined && data.chartInfo.title.trim() !== "" ? data.chartInfo.title : undefined;
    let chartPic = data.chartInfo.pic !== undefined && data.chartInfo.pic.trim() !== "" ? data.chartInfo.pic : undefined;
    let strokeColor = data.chartInfo.style.strokeColor !== undefined && data.chartInfo.style.strokeColor.trim() !== "" ? data.chartInfo.style.strokeColor : "#FFFFFF";
    let tooltipHTML = data.chartInfo.tooltipInfo.tooltipHTML !== undefined && data.chartInfo.tooltipInfo.tooltipHTML.trim() !== "" ? data.chartInfo.tooltipInfo.tooltipHTML : "";
    let dataColorStyleType = data.chartInfo.tooltipInfo.dataColorStyleType !== undefined && data.chartInfo.tooltipInfo.dataColorStyleType.trim() !== "" ? data.chartInfo.tooltipInfo.dataColorStyleType : "color";
    let colorSchemeId = data.chartInfo.style.colorSchemeId !== undefined && !isNaN(parseInt(data.chartInfo.style.colorSchemeId)) ? data.chartInfo.style.colorSchemeId : 0;
    let animateChart = data.chartInfo.animate !== undefined && typeof data.chartInfo.animate === 'boolean' ? data.chartInfo.animate : true;
    let toolTipDiv = d3.select("body").append("div").attr("class", "tooltip");
    let chartType = data.chartInfo.type !== undefined && data.chartInfo.type.trim() !== "" ? data.chartInfo.type : "donut-chart";
    if (strokeWidth < 1) {
        strokeWidth = 1;
        strokeWidthOnHover = 2.5 * strokeWidth
    }
    if (chartType === "pie-chart") {
        innerRadius = 0;
    } else if (chartPic === undefined) {
        innerRadius = Math.min(width, height) / 5;
    }

    let colorScheme = getColorScheme(colorSchemeId);
    let color = d3.scaleOrdinal().range(colorScheme);

    // add download data button
    addDownloadDataButton(containerId,data);

    /* build chart according  chart animation flag*/
    if (animateChart) {

        let arc = d3.arc().outerRadius(radius).innerRadius(innerRadius);

        let pie = d3.pie()
            .sort(null)
            .startAngle(1.1 * Math.PI)
            .endAngle(3.1 * Math.PI)
            .value(function (d) {
                return d.dataValue;
            });

        const svg = d3.select("#" + containerId).append("svg")
            .attr("width", width)
            .attr("height", height)
            .append("g")
            .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")")
            .attr("viewBox", [-width / 2, -height / 2, width, height]);

        /* create chart */
        let g = svg.selectAll(".arc")
            .data(pie(chartData))
            .enter().append("g")
            .attr("class", "arc")
            .attr("stroke", strokeColor)
            .style("stroke-width", strokeWidth + "px")
            .style("opacity", 1.0);

        /* add chartPic to the center of the donut */
        if (chartPic !== undefined) {
            var centerPic = svg.append("defs")
                .append("pattern")
                .attr("width", 1)
                .attr("height", 1)
                .attr('patternContentUnits', 'userSpaceOnUse')
                .attr("id", "centerPic_" + containerId)
                .append("svg:image")
                .attr("xlink:href", chartPic)
                .attr("width", innerRadius * 2)
                .attr("height", innerRadius * 2)
                .attr("x", 0)
                .attr("y", 0)
                .attr("preserveAspectRatio", "xMinYMin slice")
                .attr("class", "def_centerPic_" + containerId);

            svg.append("circle")
                .attr("r", innerRadius)
                .attr("cx", 0)
                .attr("cy", 0)
                .style("fill", "url('#centerPic_" + containerId + "')")
                .attr("class", "centerCircle_" + containerId)
                .attr("stroke", strokeColor)
                .style("stroke-width", strokeWidth + "px");
        }


        /* animate the arcs of the donut chart */

        g.append("path").attr("class", "path_" + containerId).style("fill", function (d) {
            return color(d.data.dataKey);
        })
            .transition().delay(function (d, i) {
            return i * 500;
        }).duration(500)
            .attrTween('d', function (d) {
                var i = d3.interpolate(d.startAngle + 0.1, d.endAngle);
                return function (t) {
                    d.endAngle = i(t);
                    return arc(d)
                }
            }).on("end", function(d){
                arcHoverInteraction(containerId,toolTipDiv,innerRadius,radius);
            });

        /* Define the interaction of mouser over / mouse out on the center picture */
        var circleAnim = function (circle, dir) {
            switch (dir) {
                case 0:
                    circle.transition()
                        .duration(500)
                        .ease(d3.easeBounce)
                        .style('stroke-width', strokeWidth + "px");
                    break;

                case 1:
                    circle.transition()
                        .duration(500)
                        .style('stroke-width', strokeWidthOnHover + "px");
                    break;
            }
        }

        /* Add interaction for center picture on mouseover / mouseout */
        d3.selectAll(".centerCircle_" + containerId).on("mouseover", function (d) {
            circleAnim(d3.select(this), 1);
        }).on("mouseout", function (d) {
            circleAnim(d3.select(this), 0);
        });

        /* Add tooltip for data on mouseover of donut arc */
        d3.selectAll(".path_" + containerId).on("mousemove", function (d) {
            toolTipDiv.style("left", d3.event.pageX + 10 + "px");
            toolTipDiv.style("top", d3.event.pageY - 25 + "px");
            toolTipDiv.style("display", "inline-block");
            toolTipDiv.html(generateToolTipHTML(tooltipHTML, d.data, color(d.data.dataKey), "background-color"));
        });

        /* Add chart title to the chart */
        if (chartTitle !== undefined) {
            /* var chartTitleFontSize = Math.min(width, height) / 200; // em
             var chartTitleYPos = radius + ((radius - innerRadius) * 1.25);
             logDebugMessage("YPOS =>"+chartTitleYPos);
             if (Math.min(width, height) <= 100) {
                 chartTitleFontSize = Math.min(width, height) / 150;
                 chartTitleYPos = radius + ((radius - innerRadius) * 1.5);
             }
             svg.append("text")
                 .attr("x", 0)
                 .attr("y", chartTitleYPos)
                 .attr("text-anchor", "middle")
                 .style("font-size", chartTitleFontSize + "em")
                 .attr("class", "chartTitle")
                 .text(chartTitle);*/
            let chartTitleFontSize = Math.min(width, height) / 200; // in em
            let chartTitleYPos = radius + ((radius - innerRadius) * 1.25);
            let chartTitleWidth = radius * 2;
            if (Math.min(width, height) <= 100) {
                chartTitleFontSize = Math.min(width, height) / 150;
                chartTitleYPos = radius + ((radius - innerRadius) * 1.5);
            }
            let chartTitleContainer = d3.select("#" + containerId).append("div").attr("id", "chartTitle_" + containerId).attr("class", "chartTitle")
                .style("position", "relative");
            chartTitleContainer.style("width", chartTitleWidth).style("top", 0).style("z-index", 10);

            chartTitleContainer.append("p").text(chartTitle).style("font-size", chartTitleFontSize + "em");
        }
    } else { // draw static chart

        let labelsArray = function (data) {
            let labels = {};
            for (let i = 0; i < data.chartInfo.data.length; i++) {
                logDebugMessage("--------->" + data.chartInfo.data[i].dataKey + "\r\n" + data.chartInfo.data[i].dataValue + "\r\n(" + data.chartInfo.data[i].dataPercentage + "%)");
                labels[data.chartInfo.data[i].dataKey + " (" + data.chartInfo.data[i].dataPercentage + "%)"] = data.chartInfo.data[i].dataValue;
            }
            return labels;
        }

        var svg = d3.select("#" + containerId)
            .append("svg")
            .attr("width", width)
            .attr("height", height)
            .append("g")
            .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")")
            .attr("viewBox", [-width / 2, -height / 2, width, height]);

        // Compute the position of each group on the pie:
        var pie = d3.pie()
            .sort(null) // Do not sort group by size
            .value(function (d) {
                return data.chartInfo.data[0].dataValue;
            })
        var data_ready = pie(d3.entries(labelsArray(data)));

// The arc generator
        var arc = d3.arc()
            .innerRadius(innerRadius)         // This is the size of the donut hole
            .outerRadius(radius)

// Another arc that won't be drawn. Just for labels positioning
        var outerArc = d3.arc()
            .innerRadius(radius * 1.1)
            .outerRadius(radius * 1.1)

// Build the pie chart: Basically, each part of the pie is a path that we build using the arc function.
        svg
            .selectAll('allSlices')
            .data(data_ready)
            .enter()
            .append('path')
            .attr('d', arc)
            .attr('fill', function (d) {
                return (color(d.data.key))
            })
            .attr("stroke", strokeColor)
            .style("stroke-width", strokeWidth)
            .style("opacity", 1);

        if (chartPic !== undefined) {
            var centerPic = svg.append("defs")
                .append("pattern")
                .attr("width", 1)
                .attr("height", 1)
                .attr('patternContentUnits', 'userSpaceOnUse')
                .attr("id", "centerPic_" + containerId)
                .append("svg:image")
                .attr("xlink:href", chartPic)
                .attr("width", innerRadius * 2)
                .attr("height", innerRadius * 2)
                .attr("x", 0)
                .attr("y", 0)
                .attr("preserveAspectRatio", "xMinYMin slice")
                .attr("class", "def_centerPic_" + containerId);

            svg.append("circle")
                .attr("r", innerRadius)
                .attr("cx", 0)
                .attr("cy", 0)
                .style("fill", "url('#centerPic_" + containerId + "')")
                .attr("class", "centerCircle_" + containerId)
                .attr("stroke", strokeColor)
                .style("stroke-width", strokeWidth + "px");
        }

        // add data labels



        // Add chart Title
        if (chartTitle !== undefined) {
            /* var chartTitleFontSize = Math.min(width, height) / 200; // em
             var chartTitleYPos = radius + ((radius - innerRadius) * 1.25);
             logDebugMessage("YPOS =>"+chartTitleYPos);
             if (Math.min(width, height) <= 100) {
                 chartTitleFontSize = Math.min(width, height) / 150;
                 chartTitleYPos = radius + ((radius - innerRadius) * 1.5);
             }
             svg.append("text")
                 .attr("x", 0)
                 .attr("y", chartTitleYPos)
                 .attr("text-anchor", "middle")
                 .style("font-size", chartTitleFontSize + "em")
                 .attr("class", "chartTitle")
                 .text(chartTitle);*/
            let chartTitleFontSize = Math.min(width, height) / 200; // in em
            let chartTitleYPos = radius + ((radius - innerRadius) * 1.25);
            let chartTitleWidth = radius * 2;
            if (Math.min(width, height) <= 100) {
                chartTitleFontSize = Math.min(width, height) / 150;
                chartTitleYPos = radius + ((radius - innerRadius) * 1.5);
            }
            let chartTitleContainer = d3.select("#" + containerId).append("div").attr("id", "chartTitle_" + containerId).attr("class", "chartTitle")
                .style("position", "relative");
            chartTitleContainer.style("width", chartTitleWidth).style("top", 0).style("z-index", 10);

            chartTitleContainer.append("p").text(chartTitle).style("font-size", chartTitleFontSize + "em");
        }
    }

}


function arcHoverInteraction(containerId,toolTipDiv,innerRadius,radius){
     /* define the interaction on mouse over/mouse out on the arcs of the donut */
        var pathAnim = function (path, dir) {
            switch (dir) {
                case 0:
                    path.transition()
                        .duration(500)
                        .ease(d3.easeBounce)
                        .attr('d', d3.arc()
                            .innerRadius(innerRadius)
                            .outerRadius(radius)
                        );
                    break;

                case 1:
                    path.transition()
                        .attr('d', d3.arc()
                            .innerRadius(innerRadius)
                            .outerRadius(radius * 1.08)
                        );
                    //@todo:aditya: make this work properly
                    //var current = this;
                    // var others = svg.selectAll(".arc").filter(function(el) {
                    //     return this != current
                    // });
                    // others.selectAll("path").style("fill", function(d){return d3.rgb(d.color).darker(1);})
                    break;
            }
        }

        /* Add Interaction of donut arcs on mouseover / mouseout */
        d3.selectAll(".path_" + containerId).on("mouseover", function (d) {
            pathAnim(d3.select(this), 1);
        }).on("mouseout", function (d) {
            pathAnim(d3.select(this), 0);
            toolTipDiv.style("display", "none");
        });

}

/**
 * Overrides the chart type to 'pie-chart' and calls the donutChart function again which will set the innerRadius to 0;
 * @param containerId - id of the parent container.
 * @param data - - structured , processed JSON data with chart info populated.
 */
function pieChart(containerId, data) {
    data.chartInfo.type = "pie-chart";
    donutChart(containerId, data);
}

/**
 * draws a chart.
 * @param {string} containerId - id off the parent container.
 * @param {JSON} data - structured , processed JSON data with chart info populated.
 */
function drawChart(containerId, data) {
    if (data !== undefined) {
        let chartType = data.chartInfo.type !== undefined && data.chartInfo.type.trim() !== "" ? data.chartInfo.type : undefined;
        if (chartType !== undefined) {
            switch (chartType) {
                case 'donut-chart' :
                    donutChart(containerId, data);
                    break;

                case 'pie-chart':
                    pieChart(containerId, data);
                    break;
                default:
                    logDebugMessage("Invalid chart type specified in data");
            }
        } else {
            logDebugMessage("No chart type specified in data");
        }
    }
}

/**
 *
 * @param {string} tooltipTemplateHTML - HTML template for the tooltip - optional
 * @param {JSON} data - restructured data and processed data so the summaryData can be populated in the tooltip.
 * @param dataColor - applies the color of the data to elements with the placeholder $applyDataColorStyle tag - optional
 * @param dataColorStyleType - define which css style property the dataColor needs to be applied to. default is the 'color' style property- optional
 * @returns {string} - The tooltip html with the $placeholders replaced with actual values.
 */
function generateToolTipHTML(tooltipTemplateHTML, data, dataColor, dataColorStyleType) {
    var tooltipHTML = "<table><tr><th colspan='2' class='dataTitle'><div class='dataColorIndicator' $applyDataColorStyle></div> $dataPointTitle</th></tr> <tr><td class='dataPercentage'>$dataPercentage</td><td class='dataValue'>$dataPointValue</td></tr> <tr><td colspan='2' class='additionalData'>$additionalData</td></tr> </table>";
    if (tooltipTemplateHTML !== undefined && tooltipTemplateHTML !== "") {
        tooltipHTML = tooltipTemplateHTML;
    }

    if (data.dataKey !== undefined && data.dataKey.trim() !== "") {
        tooltipHTML = tooltipHTML.split("$dataPointTitle").join(data.dataKey.toUpperCase());
    } else {
        tooltipHTML = tooltipHTML.split("$dataPointTitle").join("N.A.");
    }

    if (data.dataPercentage !== undefined && data.dataPercentage !== "") {
        tooltipHTML = tooltipHTML.split("$dataPercentage").join(data.dataPercentage.toFixed(1) + "%");
    } else {
        tooltipHTML = tooltipHTML.split("$dataPercentage").join("N.A.");
    }

    if (data.dataValue !== undefined && data.dataValue !== "") {
        tooltipHTML = tooltipHTML.split("$dataPointValue").join(data.dataValue);
    } else {
        tooltipHTML = tooltipHTML.split("$dataPointValue").join("N.A.");
    }

    if (data.dataAdditional !== undefined && Array.isArray(data.dataAdditional) && data.dataAdditional.length > 0) {
        var addDataHTML = "<table>";
        for (i = 0; i < data.dataAdditional.length; i++) {
            addDataHTML += "<tr><td class='addDataKey'>" + data.dataAdditional[i].dataKey + "</td><td class='addDataValue'>" + data.dataAdditional[i].dataValue + "</td></tr>";
        }
        addDataHTML += "</table>";
        tooltipHTML = tooltipHTML.split("$additionalData").join(addDataHTML);
    } else {
        tooltipHTML = tooltipHTML.split("$additionalData").join("");
    }

    if (dataColor !== undefined && dataColor.trim() !== "") {
        tooltipHTML = tooltipHTML.split("$applyDataColorStyle").join("style='" + dataColorStyleType + ":" + dataColor + ";'");
    } else {
        tooltipHTML = tooltipHTML.split("$applyDataColorStyle").join("");
    }
    logDebugMessage(tooltipHTML);
    return tooltipHTML;
}

/**
 * Pre-defined Set of color schemes.
 * More schemes can be added.
 * Color Scheme Info here : https://observablehq.com/@d3/color-schemes?collection=@d3/d3-scale-chromatic
 * Some Custom Color Schemes from Color Hunt : https://colorhunt.co/
 * @param {number} colorSchemeId - Array Index Id of color scheme. If no Index Id is passed , a random color scheme is returned.
 * @return {array} chosenColorScheme - An array of HEX color values.
 */

function getColorScheme(colorSchemeId) {

    // Sequential (Single-Hue)
    /*id*/
    /*0*/
    const schemeBlues = ["#f7fbff", "#e3eef9", "#cfe1f2", "#b5d4e9", "#93c3df", "#6daed5", "#4b97c9", "#2f7ebc", "#1864aa", "#0a4a90", "#08306b"];
    /*1*/
    const schemeGreens = ["#f7fcf5", "#e8f6e3", "#d3eecd", "#b7e2b1", "#97d494", "#73c378", "#4daf62", "#2f984f", "#157f3b", "#036429", "#00441b"];
    /*2*/
    const schemeGreys = ["#ffffff", "#f2f2f2", "#e2e2e2", "#cecece", "#b4b4b4", "#979797", "#7a7a7a", "#5f5f5f", "#404040", "#1e1e1e", "#000000"];
    /*3*/
    const schemeOranges = ["#fff5eb", "#fee8d3", "#fdd8b3", "#fdc28c", "#fda762", "#fb8d3d", "#f2701d", "#e25609", "#c44103", "#9f3303", "#7f2704"];
    /*4*/
    const schemePurples = ["#fcfbfd", "#f1eff6", "#e2e1ef", "#cecee5", "#b6b5d8", "#9e9bc9", "#8782bc", "#7363ac", "#61409b", "#501f8c", "#3f007d"];
    /*5*/
    const schemeReds = ["#fff5f0", "#fee3d6", "#fdc9b4", "#fcaa8e", "#fc8a6b", "#f9694c", "#ef4533", "#d92723", "#bb151a", "#970b13", "#67000d"];

    // Sequential (Multi-Hue)
    /*6*/
    const schemeBlueGreen = ["#f7fcfd", "#e8f6f9", "#d5efed", "#b7e4da", "#8fd3c1", "#68c2a3", "#49b17f", "#2f9959", "#157f3c", "#036429", "#00441b"];
    /*7*/
    const schemeBluePurple = ["#f7fcfd", "#e4eef5", "#ccddec", "#b2cae1", "#9cb3d5", "#8f95c6", "#8c74b5", "#8952a5", "#852d8f", "#730f71", "#4d004b"];
    /*8*/
    const schemeGreenBlue = ["#f7fcf0", "#e5f5df", "#d3eece", "#bde5bf", "#9ed9bb", "#7bcbc4", "#58b7cd", "#399cc6", "#1d7eb7", "#0b60a1", "#084081"];
    /*9*/
    const schemeOrangeRed = ["#fff7ec", "#feebcf", "#fddcaf", "#fdca94", "#fdb07a", "#fa8e5d", "#f16c49", "#e04530", "#c81d13", "#a70403", "#7f0000"];
    /*10*/
    const schemePurpleBlueGreen = ["#fff7fb", "#efe7f2", "#dbd8ea", "#bec9e2", "#98b9d9", "#69a8cf", "#4096c0", "#19879f", "#037877", "#016353", "#014636"];
    /*11*/
    const schemePurpleBlue = ["#fff7fb", "#efeaf4", "#dbdaeb", "#bfc9e2", "#9bb9d9", "#72a8cf", "#4394c3", "#1a7db6", "#0667a1", "#045281", "#023858"];
    /*12*/
    const schemePurpleRed = ["#f7f4f9", "#eae3f0", "#dcc9e2", "#d0aad2", "#d08ac2", "#dd63ae", "#e33890", "#d71c6c", "#b70b4f", "#8f023a", "#67001f"];
    /*13*/
    const schemeRedPurple = ["#fff7f3", "#fde4e1", "#fccfcc", "#fbb5bc", "#f993b0", "#f369a3", "#e03e98", "#c01788", "#99037c", "#700174", "#49006a"];
    /*14*/
    const schemeYellowGreenBlue = ["#ffffd9", "#eff9bd", "#d5eeb3", "#a9ddb7", "#73c9bd", "#45b4c2", "#2897bf", "#2073b2", "#234ea0", "#1c3185", "#081d58"];
    /*15*/
    const schemeYellowGreen = ["#ffffe5", "#f7fcc4", "#e4f4ac", "#c7e89b", "#a2d88a", "#78c578", "#4eaf63", "#2f944e", "#15793f", "#036034", "#004529"];
    /*16*/
    const schemeYellowOrangeBrown = ["#ffffe5", "#fff8c4", "#feeaa1", "#fed676", "#feba4a", "#fb992c", "#ee7918", "#d85b0a", "#b74304", "#8f3204", "#662506"];
    /*17*/
    const schemeYellowOrangeRed = ["#ffffcc", "#fff0a9", "#fee087", "#fec965", "#feab4b", "#fd893c", "#fa5c2e", "#ec3023", "#d31121", "#af0225", "#800026"];
    /*18*/
    const schemeCividis = ["#002051", "#0a326a", "#2b446e", "#4d566d", "#696970", "#7f7c75", "#948f78", "#ada476", "#caba6a", "#ead156", "#fdea45"];
    /*19*/
    const schemeViridis = ["#440154", "#482475", "#414487", "#355f8d", "#2a788e", "#21918c", "#22a884", "#44bf70", "#7ad151", "#bddf26", "#fde725"];
    /*20*/
    const schemeInferno = ["#000004", "#160b39", "#420a68", "#6a176e", "#932667", "#bc3754", "#dd513a", "#f37819", "#fca50a", "#f6d746", "#fcffa4"];
    /*21*/
    const schemeMagma = ["#000004", "#140e36", "#3b0f70", "#641a80", "#8c2981", "#b73779", "#de4968", "#f7705c", "#fe9f6d", "#fecf92", "#fcfdbf"];
    /*22*/
    const schemePlasma = ["#0d0887", "#41049d", "#6a00a8", "#8f0da4", "#b12a90", "#cc4778", "#e16462", "#f2844b", "#fca636", "#fcce25", "#f0f921"];
    /*23*/
    const schemeWarm = ["#6e40aa", "#963db3", "#bf3caf", "#e4419d", "#fe4b83", "#ff5e63", "#ff7847", "#fb9633", "#e2b72f", "#c6d63c", "#aff05b"];
    /*24*/
    const schemeCool = ["#6e40aa", "#6054c8", "#4c6edb", "#368ce1", "#23abd8", "#1ac7c2", "#1ddfa3", "#30ef82", "#52f667", "#7ff658", "#aff05b"];
    /*25*/
    const schemeCubehelixDefault = ["#000000", "#1a1530", "#163d4e", "#1f6642", "#54792f", "#a07949", "#d07e93", "#cf9cda", "#c1caf3", "#d2eeef", "#ffffff"];
    /*26*/
    const schemeTurbo = ["#23171b", "#4a58dd", "#2f9df5", "#27d7c4", "#4df884", "#95fb51", "#dedd32", "#ffa423", "#f65f18", "#ba2208", "#900c00"];

    // Diverging
    /*27*/
    const schemeBrownBlueGreen = ["#543005", "#8c510a", "#bf812d", "#dfc27d", "#f6e8c3", "#f5f5f5", "#c7eae5", "#80cdc1", "#35978f", "#01665e", "#003c30"];
    /*28*/
    const schemePurpleGreen = ["#40004b", "#762a83", "#9970ab", "#c2a5cf", "#e7d4e8", "#f7f7f7", "#d9f0d3", "#a6dba0", "#5aae61", "#1b7837", "#00441b"];
    /*29*/
    const schemePinkYellowGreen = ["#8e0152", "#c51b7d", "#de77ae", "#f1b6da", "#fde0ef", "#f7f7f7", "#e6f5d0", "#b8e186", "#7fbc41", "#4d9221", "#276419"];
    /*30*/
    const schemePurpleOrange = ["#2d004b", "#542788", "#8073ac", "#b2abd2", "#d8daeb", "#f7f7f7", "#fee0b6", "#fdb863", "#e08214", "#b35806", "#7f3b08"];
    /*31*/
    const schemeRedBlue = ["#67001f", "#b2182b", "#d6604d", "#f4a582", "#fddbc7", "#f7f7f7", "#d1e5f0", "#92c5de", "#4393c3", "#2166ac", "#053061"];
    /*32*/
    const schemeRedGrey = ["#67001f", "#b2182b", "#d6604d", "#f4a582", "#fddbc7", "#ffffff", "#e0e0e0", "#bababa", "#878787", "#4d4d4d", "#1a1a1a"];
    /*33*/
    const schemeRedYellowBlue = ["#a50026", "#d73027", "#f46d43", "#fdae61", "#fee090", "#ffffbf", "#e0f3f8", "#abd9e9", "#74add1", "#4575b4", "#313695"];
    /*34*/
    const schemeRedYellowGreen = ["#a50026", "#d73027", "#f46d43", "#fdae61", "#fee08b", "#ffffbf", "#d9ef8b", "#a6d96a", "#66bd63", "#1a9850", "#006837"];
    /*35*/
    const schemeSpectral = ["#9e0142", "#d53e4f", "#f46d43", "#fdae61", "#fee08b", "#ffffbf", "#e6f598", "#abdda4", "#66c2a5", "#3288bd", "#5e4fa2"];

    // Cyclical
    /*36*/
    const schemeRainbow = ["#6e40aa", "#bf3caf", "#fe4b83", "#ff7847", "#e2b72f", "#aff05b", "#52f667", "#1ddfa3", "#23abd8", "#4c6edb", "#6e40aa"];
    /*37*/
    const schemeSinebow = ["#ff4040", "#e78d0b", "#a7d503", "#58fc2a", "#18f472", "#00bfbf", "#1872f4", "#582afc", "#a703d5", "#e70b8d", "#ff4040"];

    // Categorical
    /*38*/
    const schemeCategory10 = ["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd", "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"];
    /*39*/
    const schemeAccent = ["#7fc97f", "#beaed4", "#fdc086", "#ffff99", "#386cb0", "#f0027f", "#bf5b17", "#666666"];
    /*40*/
    const schemeDark2 = ["#1b9e77", "#d95f02", "#7570b3", "#e7298a", "#66a61e", "#e6ab02", "#a6761d", "#666666"];
    /*41*/
    const schemePaired = ["#a6cee3", "#1f78b4", "#b2df8a", "#33a02c", "#fb9a99", "#e31a1c", "#fdbf6f", "#ff7f00", "#cab2d6", "#6a3d9a", "#ffff99", "#b15928"];
    /*42*/
    const schemePastel1 = ["#fbb4ae", "#b3cde3", "#ccebc5", "#decbe4", "#fed9a6", "#ffffcc", "#e5d8bd", "#fddaec", "#f2f2f2"];
    /*43*/
    const schemePastel2 = ["#b3e2cd", "#fdcdac", "#cbd5e8", "#f4cae4", "#e6f5c9", "#fff2ae", "#f1e2cc", "#cccccc"];
    /*44*/
    const schemeSet1 = ["#e41a1c", "#377eb8", "#4daf4a", "#984ea3", "#ff7f00", "#ffff33", "#a65628", "#f781bf", "#999999"];
    /*45*/
    const schemeSet2 = ["#66c2a5", "#fc8d62", "#8da0cb", "#e78ac3", "#a6d854", "#ffd92f", "#e5c494", "#b3b3b3"];
    /*46*/
    const schemeSet3 = ["#8dd3c7", "#ffffb3", "#bebada", "#fb8072", "#80b1d3", "#fdb462", "#b3de69", "#fccde5", "#d9d9d9", "#bc80bd", "#ccebc5", "#ffed6f"];
    /*47*/
    const schemeTableau10 = ["#4e79a7", "#f28e2c", "#e15759", "#76b7b2", "#59a14f", "#edc949", "#af7aa1", "#ff9da7", "#9c755f", "#bab0ab"];

    // Custom Color Palettes
    /*48*/
    const schemeCP17117 = ["#08d9d6", "#252a34", "#ff2e63", "#eaeaea"];
    /*49*/
    const schemeCP238 = ["#2b2e4a", "#e84545", "#903749", "#53354a"];
    /*50*/
    const schemeCP361 = ["#f9ed69", "#f08a5d", "#b83b5e", "#6a2c70"];
    /*51*/
    const scheme5GreyReverse = ["#252525", "#636363", "#969696", "#cccccc", "#f7f7f7"];

    /*52*/
    const schemeVC = ["#EFB605", "#E3690B", "#CF003E", "#991C71", "#4F54A8", "#07997E", "#7EB852"];

    /*53*/
    const schemeCP170717 = ["#42240c", "#c81912", "#f64b3c", "#fdba9a"];

    /*54*/
    const schemeCP93362 = ["#155263", "#ff6f3c", "#ff9a3c", "#ffc93c"];

    /*55*/
    const schemeHeyLilac = ["#08090f", "#7387fa", "#343959", "#cacde0", "#9ea2ba"];

    /*56*/
    const schemeLEF = ["#2B2D42", "#8D99AE", "#EDF2F4", "#EF233C", "#D90429"];

    /*57*/
    const schemeColorful = ["#f94144", "#f3722c", "#f8961e", "#f9c74f", "#90be6d", "#43aa8b", "#577590"];
    /*58*/
    const schemeBrimstone = ["#03071e", "#370617", "#6a040f", "#9d0208", "#d00000", "#dc2f02", "#e85d04", "#f48c06", "#faa307", "#ffba08"]

    /*59*/
    const schemeGreen2Yellow = ["#007f5f", "#2b9348", "#55a630", "#80b918", "#aacc00", "#bfd200", "#d4d700", "#dddf00", "#eeef20", "#ffff3f"];

    /*60*/

    const schemeGreenRed2Color = ["#184d47","#c70039"];

    const colorSchemes = [schemeBlues, schemeGreens, schemeGreys, schemeOranges, schemePurples, schemeReds, schemeBlueGreen, schemeBluePurple, schemeGreenBlue, schemeOrangeRed, schemePurpleBlueGreen, schemePurpleBlue, schemePurpleRed, schemeRedPurple, schemeYellowGreenBlue, schemeYellowGreen, schemeYellowOrangeBrown, schemeYellowOrangeRed, schemeCividis, schemeViridis, schemeInferno, schemeMagma, schemePlasma, schemeWarm, schemeCool, schemeCubehelixDefault, schemeTurbo, schemeBrownBlueGreen, schemePurpleGreen, schemePinkYellowGreen, schemePurpleOrange, schemeRedBlue, schemeRedGrey, schemeRedYellowBlue, schemeRedYellowGreen, schemeSpectral, schemeRainbow, schemeSinebow, schemeCategory10, schemeAccent, schemeDark2, schemePaired, schemePastel1, schemePastel2, schemeSet1, schemeSet2, schemeSet3, schemeTableau10, schemeCP17117, schemeCP238, schemeCP361, scheme5GreyReverse, schemeVC, schemeCP170717, schemeCP93362, schemeHeyLilac, schemeLEF, schemeColorful, schemeBrimstone, schemeGreen2Yellow,schemeGreenRed2Color];
    var chosenColorScheme;
    if (isNaN(colorSchemeId) || colorSchemeId > colorSchemes.length || colorSchemeId === "") {
        var cr = Math.floor(Math.random() * colorSchemes.length);
        logDebugMessage("colorSchemeID chosen at random => " + cr);
        chosenColorScheme = colorSchemes[cr];
    } else {
        chosenColorScheme = colorSchemes[colorSchemeId];
    }
    return chosenColorScheme;
}

/**
 * gets width and height of the container (in px)
 * @param {string} containerId - Id of the container div
 * @return {JSON} dimensions - a JSOn object with width and height of the container.
 **/
function getContainerDimensions(containerId) {
    let dimensions = {};
    if (containerId !== undefined && containerId.trim() !== "") {
        let container = d3.select("#" + containerId);
        let containerW = container.style("width").split("px")[0];
        let containerH = container.style("height").split("px")[0];
        dimensions.width = parseInt(containerW);
        dimensions.height = parseInt(containerH);
    }
    return dimensions;
}

function invertColor(hex) {
    if (hex.indexOf('#') === 0) {
        hex = hex.slice(1);
    }
    // convert 3-digit hex to 6-digits.
    if (hex.length === 3) {
        hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
    }
    if (hex.length !== 6) {
        throw new Error('Invalid HEX color.');
    }
    // invert color components
    var r = (255 - parseInt(hex.slice(0, 2), 16)).toString(16),
        g = (255 - parseInt(hex.slice(2, 4), 16)).toString(16),
        b = (255 - parseInt(hex.slice(4, 6), 16)).toString(16);
    // pad each with zeros and return
    return '#' + padZero(r) + padZero(g) + padZero(b);
}

function padZero(str, len) {
    len = len || 2;
    var zeros = new Array(len).join('0');
    return (zeros + str).slice(-len);
}

/**
 *  Add the data download button to the chart container
 * @param {string} containerId - ID of the container where the chart is appended
 * @param {JSON} data - the data object that contains the raw data to be downloaded.
 */
function addDownloadDataButton(containerId, data) {
    //console.log('kajal');console.log(data);
    if (data.dataDownloadAllowed === true) {
        var containerDimensions = getContainerDimensions(containerId);
        if (typeof data != undefined && typeof data.rawData != undefined) {

            var container = d3.select("#" + containerId);
            var downloadButtonSVG = container.append("svg").attr("width", 48).attr("height", 48).style("position", "absolute");
            var downloadButton = downloadButtonSVG.append("defs").append("g").attr("id", "downloadButton_" + containerId);

            downloadButton.append("path")
                .attr("d", "M20.54 5.23l-1.39-1.68C18.88 3.21 18.47 3 18 3H6c-.47 0-.88.21-1.16.55L3.46 5.23C3.17 5.57 3 6.02 3 6.5V19c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6.5c0-.48-.17-.93-.46-1.27zM12 17.5L6.5 12H10v-2h4v2h3.5L12 17.5zM5.12 5l.81-1h12l.94 1H5.12z")
                .attr("x", 0)
                .attr("y", 0);
            //downloadButton.append("rect").attr("y",0).attr("width",100).attr("height",2);
            downloadButtonSVG.append("g")
                .attr("transform", "scale(1.5)")
                .append("use")
                .attr("xlink:href", "#downloadButton_" + containerId).attr("fill", "black").attr("class", "downloadButton_" + containerId);

            var downloadBtnColorAnim = function(path, dir) {
                switch (dir) {
                    case 0:
                        path.transition()
                            .duration(500)
                            .ease(d3.easeBounce)
                            .attr("transform", "scale(1)")
                            .attr("fill", "black")
                        break;

                    case 1:
                        path.transition()
                            .attr("transform", "scale(1.1)")
                            .attr("fill", "steelblue");
                        break;
                }
            }
            d3.selectAll(".downloadButton_" + containerId).on("mouseover", function(d) {
                downloadBtnColorAnim(d3.select(this), 1);
            }).on("mouseout", function(d) {
                downloadBtnColorAnim(d3.select(this), 0);
            }).on("click", function(d) {
                var fileName = data.chartInfo.chartTitle != undefined && data.chartInfo.chartTitle != "" ? data.chartInfo.chartTitle + "_" + new Date().getTime() : undefined;
                downloadRawData(data, fileName);
            });
        }
    }
}

/*
 *    Tests
 */
var jsonSTR = '[ { "courseid": "3", "coursename": "Soft-skill Courses", "totalmodules": "1", "completedmodules": "1", "totalModules": 1, "completedModules": 1 }, { "courseid": "2", "coursename": "Test course", "totalmodules": "2", "completedmodules": "1", "totalModules": 2, "completedModules": 1 } ]';

function myProgressChart(containerId, data) {
    data = restructureData(data);
    data = processCourseCompletionData(data);
    data.dataDownloadAllowed = true;
    data = addChartInfo(data, 'pie-chart', 'My Progress - My Progress - My Progress - My Progress', '', true, '', '', 36);
    drawChart(containerId, data);
    //window.addEventListener('resize', function(){data.chartInfo.rebuildChart = false;drawChart(containerId,data)});
    //https://www.shareicon.net/data/2016/07/05/791214_man_512x512.png
}


/*
 * todo: re-implement non-animated donut chart labels
 * todo: download data button
 * todo: re-implement title //> done
 * todo: rework default tooltip HTML to have web safe fonts. rework data color. //> Done. but need to fix dataColorDecoration box css.
 * todo: make charts responsive //> done? check on actual mobile
 */