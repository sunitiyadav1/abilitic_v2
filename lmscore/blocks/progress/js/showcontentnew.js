var Url = "../blocks/progress/newajaxfile.php";
var myprogressData = { "action": "get_my_progress" };
var teamprogressData = { "action": "get_team_progress" };
//var data = "action=load_progress";
$(document).ready(function () {
    $.ajax({
        type: "POST",
        url: Url,
        data: myprogressData,
        dataType: 'JSON',
        success: function (data) {
            console.log(data);
            if (!Object.keys(data).length) {
                $("#progress_dataviz").html('<BR><div><h2>No Data Found</h2></div><div>Team Progress</div><BR>');
                $("#progress_div1").html('');
                $("#myprogress-totalcourses").html('0');
                $("#myprogress-completedcourses").html('0');
                $("#myprogress-total-activities").html('0');
                $("#myprogress-completed-activities").html('0');
            }
            else {
                newmyProgressChart("progress_dataviz", data);              
            }
            /* else
             {
                 myProgressChart("progress_dataviz", data);
                 $("#progress_div1").html('');
                 myProgressCoursesChart("progress_details", data);    
             }*/
        }
    });


    /////for Team Progresss ajax function 
    $.ajax({
        type: "POST",
        url: Url,
        data: teamprogressData,
        dataType: 'JSON',
        success: function (data) {
            if (!Object.keys(data).length) {
                $("#team_progress_dataviz").html('<BR><div><h2>No Data Found</h2></div><div>Team Progress</div><BR>');
                $("#team_progress_div1").html('');
                $("#teamprogress-totalcourses").html('0');
                $("#teamprogress-completedcourses").html('0');
                $("#teamprogress-total-activities").html('0');
                $("#teamprogress-completed-activities").html('0');
            }
            else {
                newteamProgressChart("team_progress_dataviz", data);               
            }
        }
    });
});
$("#progress_dataviz").on("click", function () {
    $("#team_progress_details").css('display', 'none');
    var my_progress_detail = $("#progress_details").css('display');
    if (my_progress_detail == "none") {
        $("#progress_details").css('display', 'inline');
    }
    else {
        $("#progress_details").css('display', 'none');
    }
});

$("#team_progress_dataviz").on("click", function () {
    $("#progress_details").css('display', 'none');
    var team_progress_detail = $("#team_progress_details").css('display');
    if (team_progress_detail == "none") {
        $("#team_progress_details").css('display', 'inline');
    }
    else {
        $("#team_progress_details").css('display', 'none');
    }
});


function newmyProgressChart(containerId, data) {
    data.dataDownloadAllowed = true;
    data = addChartInfo(data, 'donut-chart', 'My Progress', data.summaryData.userPic, true, 200, 200, 60);
    drawChart(containerId, data);
    $("#progress_div1").html('');
    var courseData = data.childrenData;
    let coursecontainerId = "my_progress_courses";
    $("#myprogress-totalcourses").html(data.summaryData.totalCourses);
    $("#myprogress-completedcourses").html(data.summaryData.completedCourses);
    $("#myprogress-total-activities").html(data.summaryData.totalModules);
    $("#myprogress-completed-activities").html(data.summaryData.completedModules);
    for (x in courseData) {
        let cdata1 = courseData[x];
        cdata1.dataDownloadAllowed = false;
        if(cdata1.rawData.coursePic == "")
            var coursePic = "https://www.freeiconspng.com/uploads/courses-icon-8.png";
        else
            var coursePic = cdata1.rawData.coursePic;
        let cdata = addChartInfo(cdata1, 'donut-chart', cdata1.rawData.courseName, coursePic, true, 100, 100, 60);
        $('#' + coursecontainerId).append('<div class="column"><div id="myp-' + x + '" class="card"></div></div>');
        drawChart('myp-' + x, cdata);
    }
}

function newteamProgressChart(containerId, data) {
    //data = restructureData(data);
    //data = processCourseCompletionData(data);
    data.dataDownloadAllowed = true;
    data = addChartInfo(data, 'donut-chart', 'Team Progress', "https://www.shareicon.net/data/512x512/2016/07/28/802874_users_512x512.png", true, 200, 200, 60);
    drawChart(containerId, data);
    //window.addEventListener('resize', function(){data.chartInfo.rebuildChart = false;drawChart(containerId,data)});
    //https://www.shareicon.net/data/2016/07/05/791214_man_512x512.png
    $("#team_progress_div1").html('');
    var userData = data.childrenData;
    //let processedJSON = typeof dataJSON != 'object' && isValidJSON(dataJSON) ? JSON.parse(dataJSON) : dataJSON;
    let coursecontainerId = "team_progress_users";
    $("#teamprogress-totalcourses").html(data.summaryData.totalCourses);
    $("#teamprogress-completedcourses").html(data.summaryData.completedCourses);
    $("#teamprogress-total-activities").html(data.summaryData.totalModules);
    $("#teamprogress-completed-activities").html(data.summaryData.completedModules);
    for (x in userData) {
        let cdata1 = userData[x];
        cdata1.dataDownloadAllowed = false;
        var name = cdata1.rawData.firstName + ' ' + cdata1.rawData.lastName;
        let cdata = addChartInfo(cdata1, 'donut-chart', name, cdata1.rawData.userPic, true, 100, 100, 60);
        $('#' + coursecontainerId).append('<div class="column"><div id="mytp-' + x + '" class="card"></div></div>');
        drawChart('mytp-' + x, cdata);
        //drawChart(coursecontainerId, cdata);
    }
}
/**
 * Processes Course wise Date for My Progress. This is just an example function of 
 * how we can show the raw data
 * which can be used to generate visualizations / charts.
 * @param data - data that needs to be processed. This data should ideally be restructured using restructureData()
 * @returns {JSON} - processed JSON with Course wise structure.
 */

function coursewiseStructure(rdata) {
    let cdata = restructureData(rdata);
    let courseCompleted = 0;
    let courseData = rdata;
    if (courseData.completedModules === courseData.totalModules) {
        courseCompleted = 1;
    }
    notcompletedModules = courseData.totalModules - courseData.completedModules;
    courseData["courseCompleted"] = courseCompleted;
    courseData['incompleteModules'] = notcompletedModules;
    courseData['completionPercentage'] = (courseData.completedModules / courseData.totalModules) * 100;
    courseData['incompletionPercentage'] = (courseData.completedModules / courseData.totalModules) * 100;
    //console.log(courseData);

    let chartData = [];
    let additionalDataArr = [];
    //let addDataTotalCourses = {dataKey: "Total Courses", dataValue: };
    let courseName = { dataKey: "Course Name", dataValue: courseData['coursename'] };
    let addDataTotalModules = { dataKey: "Total Modules", dataValue: courseData.totalModules };
    let addDataCompletedModules = { dataKey: "Completed Modules", dataValue: courseData.completedModules };
    let addDataIncompleteModules = { dataKey: "Incomplete Modules", dataValue: courseData.incompleteModules };
    // additionalDataArr.push(addDataTotalCourses);
    additionalDataArr.push(courseName);
    additionalDataArr.push(addDataTotalModules);
    additionalDataArr.push(addDataCompletedModules);

    let completedCoursesObj = {
        dataKey: 'Completed Activities',
        dataValue: courseData.completedModules,
        dataPercentage: courseData['completionPercentage'],
        dataAdditional: additionalDataArr
    };

    additionalDataArr = [];
    // additionalDataArr.push(addDataTotalCourses);
    additionalDataArr.push(courseName);
    additionalDataArr.push(addDataTotalModules);
    additionalDataArr.push(addDataIncompleteModules);
    let incompleteCoursesObj = {
        dataKey: 'Incomplete Activities',
        dataValue: courseData.incompleteModules,
        dataPercentage: courseData['incompletionPercentage'],
        dataAdditional: additionalDataArr
    };
    additionalDataArr = [];
    //additionalDataArr.push(addDataTotalCourses);
    additionalDataArr.push(addDataTotalModules);
    additionalDataArr.push(addDataIncompleteModules);

    chartData.push(completedCoursesObj);
    chartData.push(incompleteCoursesObj);
    // courseDataJSON.courseData = chartData;
    // courseDataJSON.courseData[chartInfo] = {}; 
    cdata.chartInfo.data = chartData;
    return cdata;

}
function myProgressCoursesChart(containerId, data) {
    courseDataJSON = restructureData(data);
    if (courseDataJSON !== undefined && courseDataJSON["rawData"] !== undefined) {
        let rawData = courseDataJSON["rawData"];
        let courseData = [];
        for (let x in rawData) {
            cdata = restructureData(rawData[x]);
            cdata = coursewiseStructure(rawData[x]);
            cdata = addChartInfo(cdata, 'donut-chart', rawData[x].coursename, rawData[x].coursePic, true, 150, 150, 59);
            $('#' + containerId).append('<div class="column"><div id="myp-' + x + '" class="card"></div></div>');
            drawChart('myp-' + x, cdata);
        }
    }
}
