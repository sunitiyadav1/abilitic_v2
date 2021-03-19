
        
$(document).ready(function () {
    /*Tooltip*/
    $('[data-toggle="tooltip"]').tooltip();
    /*On Scroll fixheader*/
    $(window).scroll(function() {    
        var scroll = $(window).scrollTop();
        if (scroll >= 80) {
            $(".page-header").addClass("bg-white shadow-sm sticky-top");
            $(".page-header .top-head").addClass("py-sm-2 py-2")
            $(".page-header .top-head").removeClass("py-sm-4 py-4")
        } else {
            $(".page-header").removeClass("bg-white shadow-sm sticky-top");
            $(".page-header .top-head").addClass("py-sm-4 py-4")
            $(".page-header .top-head").removeClass("py-sm-2 py-2")
        }
    });
        
    /* ajax call to get notification*/
        var base = $("#cfg_wwwroot").val();
        var base_url = ''+base+'/restapi/api_dashboard.php';
        var employee_code = $("#user_employeecode").val();
        var company_code = $("#user_companycode").val();
        var data1 = {'wsfunction':'notification_count','employee_code':employee_code,'company_code':company_code};
        
        htmlcontent = "";
        makeAjaxCall(base_url,data1).then(function(respJson){

            if(respJson.result.notification_total_count > 0)
            {
                htmlcontent += "You have  "+respJson.result.notification_total_count+" notifications in your inbox today";
            }
            else
            {
                htmlcontent += "";
            }
            
            $("#totalcount").html(htmlcontent);
        });
       
     /* ajax call to get site announcement*/

     
     var data2 = {'wsfunction':'site_announcement_count','employee_code':employee_code,'company_code':company_code};

     makeAjaxCall(base_url,data2).then(function(respJson){
        
        $("#announcement_total").append(respJson.result.site_announcement_total_count);

       // $("#announcement_new").append(respJson.result.site_announcement_new_count);

        $("#announcement_href").attr('href',respJson.result.urltogo);
    });

    /* ajax call to get badges*/

    
    var data3 = {'wsfunction':'badges_count','employee_code':employee_code,'company_code':company_code};

    makeAjaxCall(base_url,data3).then(function(respJson){
        
        $("#badges_total").append(respJson.result.badges_total_count);

        $("#badges_href").attr('href',respJson.result.urltogo);
    });

    /* ajax call to get messages*/

    
    var data4 = {'wsfunction':'messages_count','employee_code':employee_code,'company_code':company_code};

    makeAjaxCall(base_url,data4).then(function(respJson){
        
        $("#message_total").append(respJson.result.messages_total_count);

        
        if(respJson.result.messages_total_new_count == 0)
        {
        
            $("#message_new").removeClass("card-notofication-count");
        }
        else
        {
            $("#message_new").append(respJson.result.messages_total_new_count);
        }

        $("#message_href").attr('href',respJson.result.urltogo);
    });


    /* ajax call to get calendar count*/

    
    var data5 = {'wsfunction':'calendar_count','employee_code':employee_code,'company_code':company_code};

    makeAjaxCall(base_url,data5).then(function(respJson){
        
        $("#calendar_total").append(respJson.result.calendar_total_count);

         if(respJson.result.calendar_total_new_count == 0)
        {
        
            $("#calendar_new").removeClass("card-notofication-count");
        }
        else
        {
            $("#calendar_new").append(respJson.result.calendar_total_new_count);
        }


        $("#calendar_href").attr('href',respJson.result.urltogo);
    });

    /* ajax call to get files count*/

    
    var data6 = {'wsfunction':'files_count','employee_code':employee_code,'company_code':company_code};

    makeAjaxCall(base_url,data6).then(function(respJson){
        
        $("#files_total").append(respJson.result.files_total_count);

        $("#files_href").attr('href',respJson.result.urltogo);
    });

    /* ajax call to get course count*/

    
    var data7 = {'wsfunction':'course_count','employee_code':employee_code,'company_code':company_code};

    makeAjaxCall(base_url,data7).then(function(respJson){
        
        $("#mycourse_count").append(respJson.result.my_courses_count);

        $("#selfnomination_count").append(respJson.result.self_nomination_count);

        $("#iltsession_total").append(respJson.result.ilt_session_count);

        $("#course_count_href").attr('href',respJson.result.urltogo);
    });


        /* ajax call to get course inprogress*/

        
    
        get_enrolled_course(1);
        var current_page,main_html="",a,b,total_course,k=0,indicator_page=0;
        var total_page;

       
        function get_enrolled_course(sentpage)
        {
            var data8 = {'wsfunction':'get_enrolled_courses','employee_code':employee_code,'company_code':company_code,'page':sentpage,'limit':'10'};
            makeAjaxCall(base_url,data8).then(function(respJson)
            {
                current_page = respJson.result.pageNo;
                total_page = respJson.result.totalPages;
               // console.log(respJson.result.courses[1].categoryname);
                //debugger;
                var htmlcontent = '';
                $("#divappend").html("");

                total_course = respJson.result.courses.length;
                
                for(var i=0 ;i<total_course;i++)
                {
                    var active = '';
                    if(respJson.result.courses[i].lastactivitylink == "")
                    {
                        respJson.result.courses[i].lastactivitylink = respJson.result.courses[i].courselink;
                    }
                   if(i == 0)
                   {
                        active = 'active';
                   }

                   if(respJson.result.courses[i].courseimage == "")
                   {
                    respJson.result.courses[i].courseimage = 'layout/assets/images/my-courses-1.jpg';
                   }


                   var color_code;
                   if(respJson.result.courses[i].completepercent <= 33)
                   {
                     color_code = '#E71D36';
                   }
                   else if(respJson.result.courses[i].completepercent <= 66)
                   {
                     color_code = '#EA9010';
                   }
                   else if(respJson.result.courses[i].completepercent > 66)
                   {
                     color_code = '#3F9A04';
                   }


                   // if(respJson.result.courses[i].completepercent == 0)
                   // {
                   //   htmlcontent += "<div class='carousel-item "+active+" mb-3'><div class='col-12 col-lg-4'><div class='card h-100'><img class='card-img-top' src='"+respJson.result.courses[i].courseimage+"' alt='Card image cap' style='height:200px;'><div class='card-body d-flex flex-column'><h3>"+respJson.result.courses[i].coursefullname+"</h3><p class='card-text'>"+respJson.result.courses[i].summary+"</p><div class='course-completed w-100 mt-auto mb-2'><div class='float-right'><a  class='square_btn' href="+respJson.result.courses[i].lastactivitylink+"><span style='color:white;'>Start Now</span></a></div></div></div></div></div></div>";
                   // }
                   // else
                   // {
                   //   htmlcontent += "<div class='carousel-item "+active+" mb-3'><div class='col-12 col-lg-4'><div class='card h-100'><img class='card-img-top' src='"+respJson.result.courses[i].courseimage+"' alt='Card image cap' style='height:200px;'><div class='card-body d-flex flex-column'><h3>"+respJson.result.courses[i].coursefullname+"</h3><p class='card-text'>"+respJson.result.courses[i].summary+"</p><div class='course-completed w-100 mt-auto mb-2'><div class='progressbar-box mt-1 pb-3 w-50 d-inline-block'><div class='progress position-relative'><div class='progress-bar rounded' role='progressbar' style='width: "+respJson.result.courses[i].completepercent+"%;background-color:"+color_code+"' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'><small class='text-muted slider-progress-number'>"+respJson.result.courses[i].completepercent+"% Completed</small></div></div></div><div class='float-right'><a  href="+respJson.result.courses[i].lastactivitylink+"><span class='arrow-icon-size'><img src='layout/assets/images/icon-next.svg'></span></a></div></div></div></div></div></div>";
                   // }


                   if(respJson.result.courses[i].completepercent == 0)
                   {
                     htmlcontent += "<div class='col-12 col-lg-4'><div class='card h-100'><img class='card-img-top' src='"+respJson.result.courses[i].courseimage+"' alt='Card image cap' style='height:200px;'><div class='card-body d-flex flex-column'><h3>"+respJson.result.courses[i].coursefullname+"</h3><p class='card-text'>"+respJson.result.courses[i].summary+"</p><div class='course-completed w-100 mt-auto mb-2'><div class='float-right'><a  class='square_btn' href="+respJson.result.courses[i].lastactivitylink+"><span style='color:white;'>Start Now</span></a></div></div></div></div></div>";
                   }
                   else
                   {
                     htmlcontent += "<div class='col-12 col-lg-4'><div class='card h-100'><img class='card-img-top' src='"+respJson.result.courses[i].courseimage+"' alt='Card image cap' style='height:200px;'><div class='card-body d-flex flex-column'><h3>"+respJson.result.courses[i].coursefullname+"</h3><p class='card-text'>"+respJson.result.courses[i].summary+"</p><div class='course-completed w-100 mt-auto mb-2'><div class='progressbar-box mt-1 pb-3 w-50 d-inline-block'><div class='progress position-relative'><div class='progress-bar rounded' role='progressbar' style='width: "+respJson.result.courses[i].completepercent+"%;background-color:"+color_code+"' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'><small class='text-muted slider-progress-number'>"+respJson.result.courses[i].completepercent+"% Completed</small></div></div></div><div class='float-right'><a  href="+respJson.result.courses[i].lastactivitylink+"><span class='arrow-icon-size'><img src='layout/assets/images/icon-next.svg'></span></a></div></div></div></div></div>";
                   }
                    k = k+1;
                  
                   if(k%3 == 0 || i+1 == total_course)
                   { 
                       if(i+1 == total_course)
                       {
                        htmlcontent +="<div class='col-12 col-lg-4'><div class='card h-100' style='background-color:black;'><a  href='"+base+"/course/index.php'><div class='card-body d-flex flex-column'><h3 class='card-title' style='color:white;text-align:center;padding-top:150px;'>View All</h3></a><div class='course-completed w-100 mt-auto mb-2'><small class='text-muted slider-progress-number'></small></div></div></div><div class='float-right'></div></div>";
                       }
                       if(indicator_page == 0)
                       {
                        active = 'active';
                       }
                       main_html += "<div class='carousel-item "+active+" mb-3'>"+htmlcontent+"</div>";
                       k = 0;
                       //console.log(htmlcontent);
                       htmlcontent = "";

                       indicator_page = indicator_page + 1;
                   }

                }

                htmlcontent +="<div class='carousel-item  mb-3'><div class='col-12 col-lg-4'><div class='card h-100' style='background-color:black;'><a  href='"+base+"/my'><div class='card-body d-flex flex-column'><h3 class='card-title' style='color:white;text-align:center;padding-top:150px;'>View All</h3></a><div class='course-completed w-100 mt-auto mb-2'><small class='text-muted slider-progress-number'></small></div></div></div><div class='float-right'></div></div></div>";

                var indi = '';
                var m=0;
                for(var j=1;j<=indicator_page;j++)
                {
                    indi += "<li data-target='#carousel-example-multi' data-slide-to='"+m+"' class='text-center rounded-circle border active'>"+j+"</li>";

                     m = m + 1 ;
    
                }
                $("#ol_indicator").html(indi);
                //console.log(htmlcontent);
                $("#divappend").html(main_html);
                multiItemsCarousel();
            });

        }
        

        // $("#bnt_prev").click(function(e){

        //    if(parseInt(current_page) == 1)
        //    {
        //         e.preventDefault();
        //         return false;

        //    }

        //    var set_page =  parseInt(current_page) - 1 ;
        //    // alert(set_page);
           
        //     get_enrolled_course(set_page);  
        //     multiItemsCarousel();
            
        // });

        
        // $("#btn_next").click(function(e){

        //     if(parseInt(current_page) >= parseInt(total_page))
        //     {
        //          e.preventDefault();
        //          return false;
 
        //     }
        //    var set_page =  parseInt(current_page) + 1 ;
        //   // alert(current_page);
        //    get_enrolled_course(set_page); 
        //    multiItemsCarousel();   
        // });

 
        
        /* ajax call to get course inprogress for slider*/

        
        var data9 = {'wsfunction':'get_inprogress_courses','employee_code':employee_code,'company_code':company_code};
    
        makeAjaxCall(base_url,data9).then(function(respJson){

            console.log(respJson.result);
            var htmlcontent = '';
            $("#slider_div").html("");


            if(respJson.result.courseflag == "inprogress")
            {
                for(var i=0 ;i<respJson.result.courses.length;i++)
                {
                    if(respJson.result.courses[i].lastactivitylink == "")
                    {
                        respJson.result.courses[i].lastactivitylink = respJson.result.courses[i].courselink;
                    }
                    var active = '';
                    if(i == 0)
                    {
                            active = 'active';
                    }

                    var color_code;
                    if(respJson.result.courses[i].completepercent <= 33)
                    {
                        color_code = '#E71D36';
                    }
                    else if(respJson.result.courses[i].completepercent <= 66)
                    {
                        color_code = '#EA9010';
                    }
                    else if(respJson.result.courses[i].completepercent > 66)
                    {
                        color_code = '#3F9A04';
                    }

                    if(respJson.result.courses[i].courseimage == "")
                    {
                        respJson.result.courses[i].courseimage = 'layout/assets/images/my-courses-1.jpg';
                    }
                

                    htmlcontent += "<div class='carousel-item overflow-hidden "+active+"'><img src='"+respJson.result.courses[i].courseimage+"' class='d-block img-fluid rounded w-100' alt='Slide One' style='height:360px;width:540px;'><div class='carousel-caption p-0 text-left'><div class='card bg-black border-0'><div class='card-body py-1 px-2 p-sm-3'><h4 class='card-title'>Resume where you left</h4><h3>"+respJson.result.courses[i].coursefullname+"</h3><div class='progressbar-box my-2 w-50'><div class='progress position-relative'><div class='progress-bar rounded' role='progressbar' style='width: "+respJson.result.courses[i].completepercent+"%;background-color:"+color_code+";' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'><small class='slider-progress-number'>"+respJson.result.courses[i].completepercent+"% Completed</small></div></div></div><div class='mt-md-4 pt-3 text-uppercase align-items-center resume-video-link'><a class='d-inline-block align-middle' href='"+respJson.result.courses[i].lastactivitylink+"'>RESUME <span class='resume-video-icon align-middle d-inline-block'><img src='layout/assets/images/video-resume.png'  style='width:26px;'></span></a></div></div></div></div></div>";
                    /*console.log(htmlcontent);*/
                
                }

            }
            else
            {
                for(var i=0 ;i<respJson.result.courses.length;i++)
                {
                    if(respJson.result.courses[i].lastactivitylink == "")
                    {
                        respJson.result.courses[i].lastactivitylink = respJson.result.courses[i].courselink;
                    }
                    var active = '';
                    if(i == 0)
                    {
                            active = 'active';
                    }

                    var color_code;
                    if(respJson.result.courses[i].completepercent <= 33)
                    {
                        color_code = '#E71D36';
                    }
                    else if(respJson.result.courses[i].completepercent <= 66)
                    {
                        color_code = '#EA9010';
                    }
                    else if(respJson.result.courses[i].completepercent > 66)
                    {
                        color_code = '#3F9A04';
                    }

                    if(respJson.result.courses[i].courseimage == "")
                    {
                        respJson.result.courses[i].courseimage = 'layout/assets/images/my-courses-1.jpg';
                    }
                    

                    htmlcontent += "<div class='carousel-item overflow-hidden "+active+"'><img src='"+respJson.result.courses[i].courseimage+"' class='d-block img-fluid rounded w-100' alt='Slide One' style='height:360px;width:540px;'><div class='carousel-caption p-0 text-left'><div class='card bg-black border-0'><div class='card-body py-1 px-2 p-sm-3'><h4 class='card-title'></h4><h3>"+respJson.result.courses[i].coursefullname+"</h3><div class='mt-md-4 pt-3 text-uppercase align-items-center resume-video-link'><a class='d-inline-block align-middle' href='"+respJson.result.courses[i].lastactivitylink+"'>Start<span class='resume-video-icon align-middle d-inline-block'><img src='layout/assets/images/video-resume.png'  style='width:26px;'></span></a></div></div></div></div></div>";
                        /*console.log(htmlcontent);*/
                
                }
            }

            $("#slider_div").html(htmlcontent);
        });



        
        /* ajax call to ilt calendar event*/

        
        var data10 = {'wsfunction':'get_ilt_calendar','employee_code':employee_code,'company_code':company_code,'page':'1','limit':'5'};
    
        makeAjaxCall(base_url,data10).then(function(respJson){

           // console.log(respJson.result.events[1]);
            var htmlcontent = '';
            $("#calendar_event").html("");
            
            var rechk_date='';
            
             if(respJson.result.events.length)
            {

                for(var i=0 ;i<respJson.result.events.length;i++)
                {
                    var timestart = moment.unix((respJson.result.events[i].timestart)).format('MMM Do YYYY hh:mm A');
                    var endtime = moment.unix((respJson.result.events[i].enddate)).format('MMM Do YYYY hh:mm A');
    
                    var date_display = moment.unix((respJson.result.events[i].timestart)).format('MMM Do');
                    
                    if(rechk_date == date_display)
                    {
                        rechk_date = "";
                    }
                    else
                    {
                        rechk_date = date_display;
                    }
                    
                   htmlcontent += "<li class='feed-item pl-3'><div class='feed-item-list p-2 rounded border'><div class='media'><div class='icon-box active mr-2'><img src='layout/assets/images/icon-calender.svg' /></div><a href="+respJson.result.events[i].eventurl+" <div class='media-body'><p class='mb-1 small'>"+respJson.result.events[i].name+"</p><p class='text-muted mt-0 mb-0 small'><i class='icon icon-time mr-1'></i><span>"+timestart+" - "+endtime+"</span></p><div class='dateTime'><div class='small'>"+rechk_date+"</div></div></div></a></div></div></li>";
                   
                   rechk_date = date_display;
                }


                $("#spcal").html('View All');

            }
            else
            {
                htmlcontent += "No Trainings Scheduled";

                $("#spcal").html('View Calendar');
            }

            $("#calendar_event").html(htmlcontent);
        });

        /* ajax call to get learning plan percentage*/

        
        var data11 = {'wsfunction':'get_learning_plan_percentage','employee_code':employee_code,'company_code':company_code};
    
        makeAjaxCall(base_url,data11).then(function(respJson){

            //console.log(respJson.result);
            var htmlcontent = '';
            var plans='';
            // $("#calendar_event").html("");
            
            // for(var i=0 ;i<=respJson.result.events.length;i++)
            // {
            //     var timestart = moment.unix((respJson.result.events[i].timestart)).format('MMM Do YYYY hh:mm A');
            //     var endtime = moment.unix((respJson.result.events[i].enddate)).format('MMM Do YYYY hh:mm A');
            
            //     htmlcontent += "<li class='feed-item pl-3'><div class='feed-item-list p-2 rounded border'><div class='media'><div class='icon-box active mr-2'><img src='layout/assets/images/icon-calender.svg' /></div><a href="+respJson.result.events[i].eventurl+" <div class='media-body'><p class='mb-1 small'>"+respJson.result.events[i].name+"</p><p class='text-muted mt-0 mb-0 small'><i class='icon icon-time mr-1'></i><span>"+timestart+" - "+endtime+"</span></p><div class='dateTime'><div class='small'>5 Dec</div></div></div></a></div></div></li>";
            //     $("#calendar_event").html(htmlcontent);
            // }

            if(respJson.result.completionPercent)
            {
                var color_code;
                if(respJson.result.completionPercent <= 33)
                {
                    color_code = '#E71D36';
                }
                else if(respJson.result.completionPercent <= 66)
                {
                    color_code = '#EA9010';
                }
                else if(respJson.result.completionPercent > 66)
                {
                    color_code = '#3F9A04';
                }
                var ctx = document.getElementById('myChart').getContext('2d');
            
                data = {
                    datasets: [{
                        data: [respJson.result.completionPercent,respJson.result.incompletionPercent],
                        backgroundColor: [
                            color_code,
                            "#808080"
                        ]
                    }]
                };
    
                var myDoughnutChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: data,
                    options: {
                        legend: {
                           display: false
                        },
                        tooltips: {
                           enabled: false
                        }
                   }
                });


                for(var i=0 ;i<respJson.result.plans.length;i++)
                {
               // console.log(respJson.result.plans[i].name);

                  //  plans += "<div class='my-2'><a href="+respJson.result.plans[i].plan_url+"><div class='cards-list-name small'>"+respJson.result.plans[i].name+"</div></a><div class='card-list-count'><span style='text-align:right;'>"+respJson.result.plans[i].completionPercent+"%</span></div></div>";
                     plans += "<div><a href="+respJson.result.plans[i].plan_url+"> <div class='cards-list-name small'>"+respJson.result.plans[i].name+"</div><div style='float: right;'>"+respJson.result.plans[i].completionPercent+"%</div></a><div><div class='progressbar-box mt-1 mb-2 w-100'><div class='progress position-relative'><div class='progress-bar rounded' role='progressbar' style='width:"+respJson.result.plans[i].completionPercent+"%;background-color:#E71D36;' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'></div></div></div></div></div>";
                  //plans += "<div><a href="+respJson.result.plans[i].plan_url+"><div class='cards-list-name small'>"+respJson.result.plans[i].name+"</div></a><div><div class='progressbar-box my-2 w-50'><div class='progress position-relative'><div class='progress-bar rounded' role='progressbar' style='width: "+respJson.result.plans[i].completionPercent+"%;background-color:#E71D36;' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'></div></div><span style='text-align:right;'>"+respJson.result.plans[i].completionPercent+"%</span></div></div></div>";

                }
            }
            else
            {
                var ctx = document.getElementById('myChart').getContext('2d');
            
                data = {
                    datasets: [{
                        data: [4,98],
                        backgroundColor: [
                            "#FF0000",
                            "#808080"
                        ]
                    }]
                };
    
                var myDoughnutChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: data,
                    options: {
                        legend: {
                           display: false
                        },
                        tooltips: {
                           enabled: false
                        }
                   }
                });

                for(var i=0 ;i<respJson.result.plans.length;i++)
                {

                    plans += "<div><a href="+respJson.result.plans[i].plan_url+"> <div class='cards-list-name small'>"+respJson.result.plans[i].name+"</div><div style='float: right;'>"+respJson.result.plans[i].completionPercent+"%</div></a><div><div class='progressbar-box mt-1 mb-2 w-100'><div class='progress position-relative'><div class='progress-bar rounded' role='progressbar' style='width:"+respJson.result.plans[i].completionPercent+"%;background-color:#E71D36;' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'></div></div></div></div></div>";

                }
            }

            $("#learning_path_percent").html(Math.floor(respJson.result.completionPercent)+'%');
             $("#learn_path").html(plans);

        });


        

    
    /* ajax call to get due in two days*/

    
    var data12 = {'wsfunction':'get_due_activities','employee_code':employee_code,'company_code':company_code,'page':'1','limit':'4','duedays':'7'};

    makeAjaxCall(base_url,data12).then(function(respJson){
   // console.log(respJson.result.length);
        
        var htmlcontent = '';
         $("#due_insome_time").html("");
        if(respJson.result.activities.length)
        {
        
            for(var i=0 ;i<respJson.result.activities.length;i++)
            {
                var activityduedate = moment.unix((respJson.result.activities[i].activityduedate)).format('MMM Do YYYY');
                
            
                htmlcontent += "<a href ='"+respJson.result.activities[i].activityurl+"'><div><div class='my-2'>"+respJson.result.activities[i].activityname+"</div><div class='text-muted small'>"+activityduedate+"</div></div></a>";

                
            }

        }
        else
        {
            htmlcontent += "<div><div class='my-2'>Nothing Here , Great Job !!!</div></div>";
        }
        
        
        //console.log(htmlcontent);   
            
      
        $("#due_insome_time").html(htmlcontent);
    });


            /* ajax call to get due immeditely*/

    
            var data13 = {'wsfunction':'get_due_immediate_activities','employee_code':employee_code,'company_code':company_code,'page':'1','limit':'4'};

            makeAjaxCall(base_url,data13).then(function(respJson){
    
                //console.log(respJson.result.length);
                var htmlcontent = '';
                 $("#due_immediately").html("");
                if(respJson.result.activities.length)
                {
                    //alert("he");
                    for(var i=0 ;i<respJson.result.activities.length;i++)
                    {
                        var activityduedate = moment.unix((respJson.result.activities[i].activityduedate)).format('MMM Do YYYY');
                        
                    
                        htmlcontent += "<a href ='"+respJson.result.activities[i].activityurl+"'><div><div class='my-2'>"+respJson.result.activities[i].activityname+"</div><div class='text-muted small'>"+activityduedate+"</div></div><a>";
        
                        
                    }
    
                }
                else{
                    htmlcontent += "<div><div class='my-2'>Nothing Here , Great Job !!!</div></div>";
                } 
                    
              
                $("#due_immediately").html(htmlcontent);
            });



            
            /* ajax call to get due later*/

    
            var data14 = {'wsfunction':'get_due_activities','employee_code':employee_code,'company_code':company_code,'page':'1','limit':'4','duedays':'30','duestartdays':8};

            makeAjaxCall(base_url,data14).then(function(respJson){
    
                //console.log(respJson.result.length);
                var htmlcontent = '';
                 $("#due_later").html("");
                if(respJson.result.activities.length)
                {
                    //alert("he");
                    for(var i=0 ;i<respJson.result.activities.length;i++)
                    {
                        var activityduedate = moment.unix((respJson.result.activities[i].activityduedate)).format('MMM Do YYYY');
                        
                    
                        htmlcontent += "<a href ='"+respJson.result.activities[i].activityurl+"'><div><div class='my-2'>"+respJson.result.activities[i].activityname+"</div><div class='text-muted small'>"+activityduedate+"</div></div></a>";
        
                        
                    }
    
                }
                else{
                    htmlcontent += "<div><div class='my-2'>Nothing Here , Great Job !!!</div></div>";
                } 
                    
              
                $("#due_later").html(htmlcontent);
            });



            /*ajax to get website logo*/

    
            var data14 = {'wsfunction':'get_site_logo','employee_code':employee_code,'company_code':company_code};

            makeAjaxCall(base_url,data14).then(function(respJson){
    
                //console.log(respJson.result.length);
                var htmlcontent = '';
                 $("#brand_logo").html("");
             
                 htmlcontent += "<img src='"+respJson.result.header_logo_dark+"'  class='d-inline-block align-top' style='max-width:none;width:auto;max-height:70px;' alt='Company Logo'>";
                $("#brand_logo").html(htmlcontent);
            });



            
                /*ajax to get pms data*/

                
                var data14 = {'wsfunction':'test','employee_code':employee_code,'company_code':company_code};
                var pms_url = base+'/restapi/pms.php';

               
               // $("#pms_top_level_list").html("");
                makeAjaxCall(pms_url,data14).then(function(respJson){
                    var html_pms ='';
                    var html_tb = '';
                   // console.log(respJson);
                   
                    $("#overall_comp").html(respJson.OverAllProgress);

                    var max_arr1 = respJson.Basic.length;
                    var max_arr2 = respJson.Advance.length;
                    var max_arr3 = respJson.Critical.length;

                    
                    var mx = Math.max(max_arr1,max_arr2,max_arr3);

                    for(var k=0 ;k<respJson.TopLevelCompetency.length;k++)
                    {
                        //console.log(respJson.TopLevelCompetency[k].name);
                        html_pms +="<div class='col-anlsis-box position-relative'><span class='d-inline-block align-middle mr-2'  style='background-color:"+respJson.TopLevelCompetency[k].color+"'></span>"+respJson.TopLevelCompetency[k].name+"</div>";
                        
                       // console.log(html_pms);
                    }

                   // console.log(html_pms);return;
                    //console.log(respJson.Advance[1].competencyname);
                    var basic = '';
                    var advance = '';
                    var critical = '';
                    var hhhh = '';                  


                    var counter = 0;
                    for(var i=0;i<mx;i++)
                    {
                        var ch = null;
                        
                        if(max_arr1 > i)
                        {
                            basic += "<td class='gridcolor1' style = 'background-color:"+respJson.Basic[i].color+" !important'>"+respJson.Basic[i].competencyname+"</td>";
                        }
                        else
                        {
                            basic += '<td></td>';
                        }
                      //  console.log(respJson.Advance[1].competencyname.length);
                        
                        if(max_arr2 > i)
                        {
                           // console.log('here');
                            advance += "<td class='gridcolor1' style = 'background-color:"+respJson.Advance[i].color+" !important'>"+respJson.Advance[i].competencyname+"</td>";
                        }
                        else
                        {
                           // console.log('here3');
                            advance += "<td></td>";
                        }

                        if(max_arr3 > i)
                        {
                            critical += "<td class='gridcolor1' style = 'background-color:"+respJson.Critical[i].color+" !important'>"+respJson.Critical[i].competencyname+"</td>";
                        }
                        else
                        {
                            critical += "<td></td>";
                        }
                       // html_tb +="<tr><td class='gridcolor1'>"+respJson.Basic[i].competencyname+"</td><td class='gridcolor2'>"+respJson.Basic[i + 1].competencyname+"</td><td class='gridcolor1'>"+respJson.Advance[i].competencyname+"</td><td></td><td class='gridcolor3'>"+respJson.Advance[i].competencyname+"</td><td> </td></tr>";

                       counter ++;
                       if(counter == 2)
                       {
                            hhhh += "<tr>"+basic+advance+critical+"</tr>";

                            counter = 0;
                            basic = '';
                            advance = '';
                            critical = '';
                       }
                    }
                    hhhh += "<tr><th colspan='2'>Basic</th><th colspan='2'>Advance</th><th colspan='2'>Critical</th></tr>";
                    // console.log(hhhh);
                     $("#pms_table").append(hhhh);
                     //return;
                    $("#pms_top_level_list").append(html_pms);
                });
        

});
