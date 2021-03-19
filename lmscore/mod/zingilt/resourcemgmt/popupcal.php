<?php
require_once('../../../config.php');
require_login(); // We need login
global $CFG, $USER;
?>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css"> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src ="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.css" />
<link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.css" />

<script src="https://uicdn.toast.com/tui.code-snippet/latest/tui-code-snippet.js"></script>
<script src="https://uicdn.toast.com/tui.dom/v3.0.0/tui-dom.js"></script>
<script src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.min.js"></script>
<script src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.min.js"></script>
<script src="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php //echo $CFG->wwwroot;
                                                ?>/mod/zingilt/resourcemgmt/scripts/css/calendar.css" />
-->
<!-- <button id="btncal" name="btncal">Show Calendar</button> -->
<?php

if (isset($_REQUEST['id']) && $_REQUEST['id'] != null) {
    $sql = "select rb.*,r.resource_name,rt.name as type_name,rs.name as subtype_name,f.name as facetoface_name,
  s.name as session_name
  from {resource_booking} as rb
  join {resources} as r on rb.resource_id=r.id
  join {resource_type} as rt on rb.resource_type_id = rt.id
  join {resource_subtype} as rs on rb.resource_subtype_id = rs.id
  join {zingilt} as f on rb.facetoface_id= f.id
  join {zingilt_sessions} as s on rb.session_id= s.id
  where rb.resource_id=" . $_REQUEST['id'];

    $rs = $DB->get_records_sql($sql);
    // print_r($rs);
    $res_arr = array();
    if ($rs != null) {
        foreach ($rs as $k => $r) {
            //echo date('Y-m-d\TH:i:s',strtotime($r->start_date))."===". userdate(strtotime($r->start_date))."<BR>";
            $res_arr[$k]['id'] = $r->id;
            $res_arr[$k]['title'] = $r->resource_name;
            $res_arr[$k]['isAllDay'] = false;
            $res_arr[$k]['start'] = date('Y-m-d\TH:i:s', strtotime($r->start_date));
            $res_arr[$k]['end'] = date('Y-m-d\TH:i:s', strtotime($r->end_date));
            $res_arr[$k]['color'] = '#ffffff';
            $res_arr[$k]['isVisible'] = true;
            $res_arr[$k]['bgColor'] = '#69BB2D';
            $res_arr[$k]['dragBgColor'] = '#69BB2D';
            $res_arr[$k]['borderColor'] = '#69BB2D';
            $res_arr[$k]['calendarId'] = 1; //$r->id;
            $res_arr[$k]['category'] = 'time';
            $res_arr[$k]['dueDateClass'] = '';
            $res_arr[$k]['customStyle'] = 'cursor:default;';
            $res_arr[$k]['isPending'] = false;
            $res_arr[$k]['isFocused'] = false;
            $res_arr[$k]['isReadOnly'] = true;
            $res_arr[$k]['isPrivate'] = false;
            $res_arr[$k]['location'] = $r->session_name;
            $res_arr[$k]['attendees'] = '';
            $res_arr[$k]['recurrenceRule'] = '';
            $res_arr[$k]['state'] = $r->facetoface_name;
        }
        if ($res_arr != null) {
            $res_arr = array_values($res_arr);
            //print_r($res_arr);
            //$resource_json = json_encode($res_arr);
            //echo $resource_json;
        } else {
            $res_arr = [];
        }
    } else {
        $res_arr = [];
    }
} else {
    $res_arr = [];
}
//echo $resource_json;
?>
<div id="menu">
    <span id="menu-navi">
        <button type="button" class="btn btn-default btn-sm move-today" data-action="move-today">Today</button>

        <button type="button" class="btn btn-default btn-sm move-day" data-action="move-prev">
            <i class="calendar-icon ic-arrow-line-left" data-action="move-prev">
                << </i> </button> <span id="renderRange" class="render-range"></span>
    <button type="button" class="btn btn-default btn-sm move-day" data-action="move-next">
        <i class="calendar-icon ic-arrow-line-right" data-action="move-next"> >> </i>
    </button>
    </span>
</div>
<div id="calendar" style="display:none;"></div>
<script>
    var CalendarList = [];

    function CalendarInfo() {
        this.id = null;
        this.name = null;
        this.checked = true;
        this.color = null;
        this.bgColor = null;
        this.borderColor = null;
        this.dragBgColor = null;
    }

    function addCalendar(calendar) {
        CalendarList.push(calendar);
    }

    function findCalendar(id) {
        var found;

        CalendarList.forEach(function(calendar) {
            if (calendar.id === id) {
                found = calendar;
            }
        });

        return found || CalendarList[0];
    }

    function hexToRGBA(hex) {
        var radix = 16;
        var r = parseInt(hex.slice(1, 3), radix),
            g = parseInt(hex.slice(3, 5), radix),
            b = parseInt(hex.slice(5, 7), radix),
            a = parseInt(hex.slice(7, 9), radix) / 255 || 1;
        var rgba = 'rgba(' + r + ', ' + g + ', ' + b + ', ' + a + ')';

        return rgba;
    }

    (function() {
        var calendar;
        var id = 0;

        calendar = new CalendarInfo();
        id += 1;
        calendar.id = String(id);
        calendar.name = 'Resource';
        calendar.color = '#624AC0';
        calendar.bgColor = '#F0EFF6';
        calendar.dragBgColor = '#F0EFF6';
        calendar.borderColor = '#F0EFF6';
        addCalendar(calendar);

        calendar = new CalendarInfo();
        id += 1;
        calendar.id = String(id);
        calendar.name = 'Holidays';
        calendar.color = '#FF8C1A';
        calendar.bgColor = '#FDF8F3';
        calendar.dragBgColor = '#FDF8F3';
        calendar.borderColor = '#FDF8F3';
        addCalendar(calendar);

        calendar = new CalendarInfo();
        id += 1;
        calendar.id = String(id);
        calendar.name = 'Leaves';
        calendar.color = '#578E1C';
        calendar.bgColor = '#EEF8F0';
        calendar.dragBgColor = '#EEF8F0';
        calendar.borderColor = '#EEF8F0';
        addCalendar(calendar);
    })();


    //alert("here befor cal.");
    //  $(document).ready(function(){
    // $("#calendar").html('');

    var cal, resizeThrottled;
    var useCreationPopup = false;
    var useDetailPopup = true;
    var datePicker, selectedCalendar;
    var cal = new tui.Calendar('#calendar', {
        defaultView: 'month' // monthly view option
            ,
        useCreationPopup: useCreationPopup,
        useDetailPopup: useDetailPopup,
        calendars: CalendarList,
        // getDateRangeStart: new Date("2020-08-01"),
        // getDateRangeEnd:new Date("2020-08-15"),
        template: {
            milestone: function(model) {
                return '<span class="calendar-font-icon ic-milestone-b"></span> <span style="background-color: ' + model.bgColor + '">' + model.title + '</span>';
            },
            allday: function(schedule) {
                return getTimeTemplate(schedule, true);
            },
            time: function(schedule) {
                return getTimeTemplate(schedule, false);
            }
        }
    });
    // event handlers
    cal.on({
        'clickMore': function(e) {
            console.log('clickMore', e);
        },
        'clickSchedule': function(e) {
            $("#card_event").fadeIn();
            var topValue;
            var leftValue;
            topValue = (e.event.clientY / 2) + 45;
            leftValue = e.event.clientX;
            console.log('ada ', e.event.clientX, window.width)
            if (e.event.clientX > (window.windth - 200)) {}
            console.log('clickSchedule', e);
            if (e.calendar === undefined) {
                console.log('clickSchedule', e);
                $("#card_event").removeClass("show_card_event show_card_offer").addClass("show_card_post");
                $("#card_event").removeClass("show_card_event show_card_offer").css({
                    top: topValue,
                    left: leftValue
                })
                return;
            }
            /* if ( e.calendar.name === 'Events' ) {
                 console.log('clickSchedule', e.calendar.name);
                 $("#card_event").removeClass("show_card_post show_card_offer").addClass("show_card_event");
                 return;
             }
             if ( e.calendar.name === 'Offer' ) {
                 console.log('clickSchedule', e.calendar.name);
                 $("#card_event").removeClass("show_card_event show_card_offer").addClass("show_card_offer");
                 return;
             }
             if ( e.calendar.name === 'Post' ) {
                 console.log('clickSchedule', e.calendar.name);
                 $("#card_event").removeClass("show_card_event show_card_offer").addClass("show_card_post");
                 return;
             }*/
        },
        'clickDayname': function(date) {
            console.log('clickDayname', date);
        },
        'beforeCreateSchedule': function(e) {
            //$("#add_new_post_popup").addClass('active');
            //  console.log('beforeCreateSchedule', e);
            /*$('.add_new_post_fld_date').find('.schedule_post_btn').html(moment(e.start).format('llll'));
            var title = $('.add_new_post_fld_date').find('#BusinessName_001').val();
            var schedule = {
                id: '1',
                title: 'Test',
                // isAllDay: scheduleData.isAllDay,
                start: e.start,
                end: e.end,
                category: 'time',
                // category: scheduleData.isAllDay ? 'allday' : 'time',
                // dueDateClass: '',
                color: calendar.color,
                bgColor: calendar.bgColor,
                dragBgColor: calendar.bgColor,
                borderColor: calendar.borderColor,
                location: '',
                // raw: {
                //     class: scheduleData.raw['class']
                // },
                // state: scheduleData.state
            };
          //  console.log('title ', title);
            // save from new data
            saveNewSchedule(schedule);*/
            // e.guide.clearGuideElement();
            return false;
        },
        'beforeUpdateSchedule': function(e) {
            var schedule = e.schedule;
            var changes = e.changes;

            console.log('beforeUpdateSchedule', e);

            cal.updateSchedule(schedule.id, schedule.calendarId, changes);
            refreshScheduleVisibility();
        },
        'beforeDeleteSchedule': function(e) {
            console.log('beforeDeleteSchedule', e);
            cal.deleteSchedule(e.schedule.id, e.schedule.calendarId);
        },
        'afterRenderSchedule': function(e) {
            var schedule = e.schedule;
            // var element = cal.getElement(schedule.id, schedule.calendarId);
            // console.log('afterRenderSchedule', element);
        },
        'clickTimezonesCollapseBtn': function(timezonesCollapsed) {
            console.log('timezonesCollapsed', timezonesCollapsed);

            if (timezonesCollapsed) {
                cal.setTheme({
                    'week.daygridLeft.width': '77px',
                    'week.timegridLeft.width': '77px'
                });
            } else {
                cal.setTheme({
                    'week.daygridLeft.width': '60px',
                    'week.timegridLeft.width': '60px'
                });
            }

            return true;
        }
    });
    // setDropdownCalendarType();
    setRenderRangeText();
    setSchedules();
    setEventListener();
    //-----------------------------------------------------------
    $("#calendar").show();
    //   return false; 
    //});

    function getTimeTemplate(schedule, isAllDay) {
        var html = [];
        var start = moment(schedule.start.toUTCString());
        // if (!isAllDay) {
        //    html.push('<strong>' + start.format('HH:mm') + '</strong> ');
        // }
        if (schedule.isPrivate) {
            html.push('<span class="calendar-font-icon ic-lock-b"></span>');
            html.push(' Private');
        } else {
            if (schedule.isReadOnly) {
                html.push('<span class="calendar-font-icon ic-readonly-b"></span>');
            } else if (schedule.recurrenceRule) {
                html.push('<span class="calendar-font-icon ic-repeat-b"></span>');
            } else if (schedule.attendees.length) {
                html.push('<span class="calendar-font-icon ic-user-b"></span>');
            } else if (schedule.location) {
                html.push('<span class="calendar-font-icon ic-location-b"></span>');
            }
            html.push(' ' + schedule.title);
        }
        //alert(html);

        return html.join('');
        ``
    }

    function onClickNavi(e) {
        var action = getDataAction(e.target);

        switch (action) {
            case 'move-prev':
                cal.prev();
                break;
            case 'move-next':
                cal.next();
                break;
            case 'move-today':
                cal.today();
                break;
            default:
                return;
        }

        setRenderRangeText();
        setSchedules();
    }

    function onNewSchedule() {
        var title = $('#new-schedule-title').val();
        var location = $('#new-schedule-location').val();
        var isAllDay = document.getElementById('new-schedule-allday').checked;
        var start = datePicker.getStartDate();
        var end = datePicker.getEndDate();
        var calendar = selectedCalendar ? selectedCalendar : CalendarList[0];

        if (!title) {
            return;
        }

        console.log('calendar.id ', calendar.id)
        cal.createSchedules([{
            id: '1',
            calendarId: calendar.id,
            title: title,
            isAllDay: isAllDay,
            start: start,
            end: end,
            category: isAllDay ? 'allday' : 'time',
            dueDateClass: '',
            color: calendar.color,
            bgColor: calendar.bgColor,
            dragBgColor: calendar.bgColor,
            borderColor: calendar.borderColor,
            raw: {
                location: location
            },
            state: 'Busy'
        }]);

        $('#modal-new-schedule').modal('hide');
    }

    function onChangeNewScheduleCalendar(e) {
        var target = $(e.target).closest('a[role="menuitem"]')[0];
        var calendarId = getDataAction(target);
        changeNewScheduleCalendar(calendarId);
    }

    function changeNewScheduleCalendar(calendarId) {
        var calendarNameElement = document.getElementById('calendarName');
        var calendar = findCalendar(calendarId);
        var html = [];

        html.push('<span class="calendar-bar" style="background-color: ' + calendar.bgColor + '; border-color:' + calendar.borderColor + ';"></span>');
        html.push('<span class="calendar-name">' + calendar.name + '</span>');

        calendarNameElement.innerHTML = html.join('');

        selectedCalendar = calendar;
    }

    function createNewSchedule(event) {
        var start = event.start ? new Date(event.start.getTime()) : new Date();
        var end = event.end ? new Date(event.end.getTime()) : moment().add(1, 'hours').toDate();

        if (useCreationPopup) {
            cal.openCreationPopup({
                start: start,
                end: end
            });
        }
    }

    function saveNewSchedule(scheduleData) {
        console.log('scheduleData ', scheduleData)
        var calendar = scheduleData.calendar || findCalendar(scheduleData.calendarId);
        var schedule = {
            id: '1',
            title: scheduleData.title,
            // isAllDay: scheduleData.isAllDay,
            start: scheduleData.start,
            end: scheduleData.end,
            category: 'allday',
            // category: scheduleData.isAllDay ? 'allday' : 'time',
            // dueDateClass: '',
            color: calendar.color,
            bgColor: calendar.bgColor,
            dragBgColor: calendar.bgColor,
            borderColor: calendar.borderColor,
            location: scheduleData.location,
            // raw: {
            //     class: scheduleData.raw['class']
            // },
            // state: scheduleData.state
        };
        if (calendar) {
            schedule.calendarId = calendar.id;
            schedule.color = calendar.color;
            schedule.bgColor = calendar.bgColor;
            schedule.borderColor = calendar.borderColor;
        }

        cal.createSchedules([schedule]);

        refreshScheduleVisibility();
    }

    function refreshScheduleVisibility() {

        var calendarElements = Array.prototype.slice.call(document.querySelectorAll('#calendarList input'));
        // console.log(calendarElements);
        if (calendarElements.length > 0) {
            CalendarList.forEach(function(calendar) {
                cal.toggleSchedules(calendar.id, !calendar.checked, false);
            });
            // console.log(cal);
            cal.render(true);

            calendarElements.forEach(function(input) {
                var span = input.nextElementSibling;
                span.style.backgroundColor = input.checked ? span.style.borderColor : 'transparent';
            });
        }
    }


    function setRenderRangeText() {
        var renderRange = document.getElementById('renderRange');
        console.log(renderRange);
        var options = cal.getOptions();
        var viewName = cal.getViewName();
        console.log(viewName);
        var html = [];
        if (viewName === 'day') {
            html.push(moment(cal.getDate().getTime()).format('MMM YYYY DD'));
        } else if (viewName === 'month' &&
            (!options.month.visibleWeeksCount || options.month.visibleWeeksCount > 4)) {
            html.push(moment(cal.getDate().getTime()).format('MMM YYYY'));
        } else {
            html.push(moment(cal.getDateRangeStart().getTime()).format('MMM YYYY DD'));
            html.push(' ~ ');
            html.push(moment(cal.getDateRangeEnd().getTime()).format(' MMM DD'));
        }
        // alert(html);console.log(html);
        renderRange.innerHTML = html.join('');
    }

    function setSchedules() {
        cal.clear();
        var schedules = JSON.parse('<?php echo json_encode($res_arr); ?>');
        cal.createSchedules(schedules);
        /*var calendar = scheduleData.calendar || findCalendar(scheduleData.calendarId);
        if (calendar) {
            schedule.calendarId = calendar.id;
            schedule.color = calendar.color;
            schedule.bgColor = calendar.bgColor;
            schedule.borderColor = calendar.borderColor;
        }*/
        refreshScheduleVisibility();
        /* var schedules = [
                          {
                              id: 489273, 
                              title: 'Workout for 2020-04-05', 
                              isAllDay: false, 
                              start: '2020-08-03T11:30:00+09:00', 
                              end: '2020-08-03T12:00:00+09:00', 
                              //goingDuration: 30, 
                              //comingDuration: 30, 
                              color: '#ffffff', 
                              isVisible: true, 
                              bgColor: '#69BB2D', 
                              dragBgColor: '#69BB2D', 
                              borderColor: '#69BB2D', 
                              calendarId: '1', 
                              category: 'time', 
                              dueDateClass: '', 
                              customStyle: 'cursor: default;', 
                              isPending: true, 
                              isFocused: true, 
                              isReadOnly: true, 
                              isPrivate: true, 
                              location: '', 
                              attendees: '', 
                              recurrenceRule: '', 
                              state: ''
                            },
                          {id: 489273, title: 'Workout for 2020-04-05', isAllDay: false, start: '2020-08-11T11:30:00+09:00', end: '2020-08-11T12:00:00+09:00', goingDuration: 30, comingDuration: 30, color: '#ffffff', isVisible: true, bgColor: '#69BB2D', dragBgColor: '#69BB2D', borderColor: '#69BB2D', calendarId: '2', category: 'time', dueDateClass: '', customStyle: 'cursor: default;', isPending: false, isFocused: false, isReadOnly: false, isPrivate: false, location: '', attendees: '', recurrenceRule: '', state: ''},
                          {id: 18073, title: 'completed with blocks', isAllDay: false, start: '2020-08-20T09:00:00+09:00', end: '2020-08-20T10:00:00+09:00', color: '#ffffff', isVisible: true, bgColor: '#54B8CC', dragBgColor: '#54B8CC', borderColor: '#54B8CC', calendarId: '1', category: 'time', dueDateClass: '', customStyle: '', isPending: false, isFocused: false, isReadOnly: false, isPrivate: false, location: '', attendees: '', recurrenceRule: '', state: ''},
                          {id: 18073, title: 'completed with blocks', isAllDay: false, start: '2020-08-25T09:00:00+09:00', end: '2020-08-25T10:00:00+09:00', color: '#ffffff', isVisible: true, bgColor: '#54B8CC', dragBgColor: '#54B8CC', borderColor: '#54B8CC', calendarId: '1', category: 'time', dueDateClass: '', customStyle: '', isPending: false, isFocused: false, isReadOnly: false, isPrivate: false, location: '', attendees: '', recurrenceRule: '', state: ''},
                          {id: 18073, title: 'completed with blocks', isAllDay: false, start: '2020-08-28T09:00:00+09:00', end: '2020-08-28T10:00:00+09:00', color: '#ffffff', isVisible: true, bgColor: '#54B8CC', dragBgColor: '#54B8CC', borderColor: '#54B8CC', calendarId: '1', category: 'time', dueDateClass: '', customStyle: '', isPending: false, isFocused: false, isReadOnly: false, isPrivate: false, location: '', attendees: '', recurrenceRule: '', state: ''},
                          {id: 18073, title: 'completed with blocks', isAllDay: false, start: '2020-08-07T09:00:00+09:00', end: '2020-08-07T10:00:00+09:00', color: '#ffffff', isVisible: true, bgColor: '#54B8CC', dragBgColor: '#54B8CC', borderColor: '#54B8CC', calendarId: '1', category: 'time', dueDateClass: '', customStyle: '', isPending: false, isFocused: false, isReadOnly: false, isPrivate: false, location: '', attendees: '', recurrenceRule: '', state: ''},
                          {id: 18073, title: 'completed with blocks', isAllDay: false, start: '2020-08-28T09:00:00+09:00', end: '2020-08-28T10:00:00+09:00', color: '#ffffff', isVisible: true, bgColor: '#54B8CC', dragBgColor: '#54B8CC', borderColor: '#54B8CC', calendarId: '1', category: 'time', dueDateClass: '', customStyle: '', isPending: false, isFocused: false, isReadOnly: false, isPrivate: false, location: '', attendees: '', recurrenceRule: '', state: ''},
                          {id: 18073, title: 'completed with blocks', isAllDay: false, start: '2020-08-17T09:00:00+09:00', end: '2020-08-17T10:00:00+09:00', color: '#ffffff', isVisible: true, bgColor: '#54B8CC', dragBgColor: '#54B8CC', borderColor: '#54B8CC', calendarId: '3', category: 'time', dueDateClass: '', customStyle: '', isPending: false, isFocused: false, isReadOnly: false, isPrivate: false, location: '', attendees: '', recurrenceRule: '', state: ''}
                      ];
                */
        // generateSchedule(cal.getViewName(), cal.getDateRangeStart(), cal.getDateRangeEnd());       
    }

    function setEventListener() {
        $('#menu-navi').on('click', onClickNavi);
        // $('.dropdown-menu a[role="menuitem"]').on('click', onClickMenu);
        // $('#lnb-calendars').on('change', onChangeCalendars);

        $('#btn-save-schedule').on('click', onNewSchedule);
        $('#btn-new-schedule').on('click', createNewSchedule);

        $('#dropdownMenu-calendars-list').on('click', onChangeNewScheduleCalendar);

        window.addEventListener('resize', resizeThrottled);
    }

    function getDataAction(target) {
        return target.dataset ? target.dataset.action : target.getAttribute('data-action');
    }

    resizeThrottled = tui.util.throttle(function() {
        cal.render();
    }, 50);
</script>