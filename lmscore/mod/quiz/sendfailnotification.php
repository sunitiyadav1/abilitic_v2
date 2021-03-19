<?php
require_once("../../config.php");
require_once("locallib.php");
$context = context_system::instance();
require_login(null, false); // Adds to $PAGE, creates $OUTPUT.
// Correct the navbar.
// Set the name for the page.
$linktext = get_string('notifications', $block);
// Set the url.
$linkurl = new moodle_url('/');
// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
$PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);

$CFG->debug 		= (E_ALL | E_STRICT); 
$CFG->debugdisplay  = 1;
$CFG->debugdeveloper= 1;


$arr =json_decode(html_entity_decode('{"course":{"id":"20","category":"3","sortorder":"450002","fullname":"Hitesh Test Prod1","shortname":"Hitesh Test Prod1","idnumber":"","summary":"<p>Hitesh Test Prod1<\/p>","summaryformat":"1","format":"topics","showgrades":"1","newsitems":"0","startdate":"1554489000","enddate":"0","relativedatesmode":"0","marker":"0","maxbytes":"0","legacyfiles":"0","showreports":"1","visible":"1","visibleold":"1","groupmode":"1","groupmodeforce":"0","defaultgroupingid":"0","lang":"","calendartype":"","theme":"","timecreated":"1554457670","timemodified":"1554976266","requested":"0","enablecompletion":"1","completionnotify":"0","cacherev":"1606213985"},"attempt":{"id":"287973","quiz":"17","userid":"39793","attempt":"1","uniqueid":"288484","layout":"1,0,2,0","currentpage":"1","preview":"0","state":"finished","timestart":"1606288370","timefinish":1606288384,"timemodified":1606288384,"timemodifiedoffline":"0","timecheckstate":null,"sumgrades":0},"quiz":{"id":"17","course":"20","name":"Quiz for Hitesh Prod Test","intro":"","introformat":"1","timeopen":"0","timeclose":"0","timelimit":"0","overduehandling":"autosubmit","graceperiod":"0","preferredbehaviour":"deferredfeedback","canredoquestions":"0","attempts":"4","attemptonlast":"0","grademethod":"1","decimalpoints":"2","questiondecimalpoints":"-1","reviewattempt":"69888","reviewcorrectness":"4352","reviewmarks":"4352","reviewspecificfeedback":"4352","reviewgeneralfeedback":"4352","reviewrightanswer":"0","reviewoverallfeedback":"4352","questionsperpage":"1","navmethod":"free","shuffleanswers":"1","sumgrades":"100.00000","grade":"100.00000","timecreated":"0","timemodified":"1606213984","password":"","subnet":"","browsersecurity":"-","delay1":"0","delay2":"0","showuserpicture":"0","showblocks":"0","completionattemptsexhausted":"0","completionpass":"1","allowofflineattempts":"0","cmid":"20"},"cm":{"id":"20","course":"20","module":"16","instance":"17","section":"79","idnumber":"","added":"1554459251","score":"0","indent":"0","visible":"1","visibleoncoursepage":"1","visibleold":"1","groupmode":"2","groupingid":"0","completion":"2","completiongradeitemnumber":"0","completionview":"0","completionexpected":"0","showdescription":"0","availability":null,"deletioninprogress":"0","groupmembersonly":null,"name":"Quiz for Hitesh Prod Test","modname":"quiz"}}'));


echo "<pre>";
print_r($arr);
$course = $arr->course;
$quiz = $arr->quiz;
$attempt = $arr->attempt;
$cm = $arr->cm;
$course_grade = $DB->get_field('grade_items', 'gradepass', array('courseid' => $course->id, 'itemtype' => 'mod',"itemmodule"=>"quiz","iteminstance"=>$quiz->id));

//$course_grade = $DB->get_record('grade_items',array('courseid' => $course->id, 'itemtype' => 'mod',"itemmodule"=>"quiz","iteminstance"=>$quiz->id));
print_r($course_grade);

$total_attempts = 2;//$quiz->attempts;
$current_attempt = 2;//$attempt->attempt;
if($current_attempt>=$total_attempts){
	$rs =$DB->get_records("quiz_attempts",array("quiz"=>$attempt->quiz,"userid"=>$attempt->userid));
	print_r($rs);
	$failcount=0;
	if($rs != null){
		foreach($rs as $r){
			if($r->sumgrades<$course_grade)
			{
				$failcount++;
			}
		}
	}
	echo "Fail count::".$failcount;
	if($current_attempt>=$total_attempts && $failcount>=$total_attempts){
		echo "you should study well";
		quiz_send_fail_attempt_reminder_message($course, $quiz, $attempt, $context, $cm);
	}
}
else
{
	echo "current attempt::".$current_attempt;
	echo "total attempts ::".$total_attempts;
	echo "in else";
	
}



function quiz_send_fail_attempt_reminder_message($course, $quiz, $attempt, $context, $cm) {
    global $CFG, $DB;

    // Do nothing if required objects not present.
    if (empty($course) or empty($quiz) or empty($attempt) or empty($context)) {
        throw new coding_exception('$course, $quiz, $attempt, $context and $cm must all be set.');
    }

    $submitter = $DB->get_record('user', array('id' => $attempt->userid), '*', MUST_EXIST);

    $a = new stdClass();
    // Course info.
    $a->courseid        = $course->id;
    $a->coursename      = $course->fullname;
    $a->courseshortname = $course->shortname;
    // Quiz info.
    $a->quizname        = $quiz->name;
    $a->quizreporturl   = $CFG->wwwroot . '/mod/quiz/report.php?id=' . $cm->id;
    $a->quizreportlink  = '<a href="' . $a->quizreporturl . '">' .
            format_string($quiz->name) . ' report</a>';
    $a->quizurl         = $CFG->wwwroot . '/mod/quiz/view.php?id=' . $cm->id;
    $a->quizlink        = '<a href="' . $a->quizurl . '">' . format_string($quiz->name) . '</a>';
    $a->quizid          = $quiz->id;
    $a->quizcmid        = $cm->id;
    // Attempt info.
    $a->submissiontime  = userdate($attempt->timefinish);
    $a->timetaken       = format_time($attempt->timefinish - $attempt->timestart);
    $a->quizreviewurl   = $CFG->wwwroot . '/mod/quiz/review.php?attempt=' . $attempt->id;
    $a->quizreviewlink  = '<a href="' . $a->quizreviewurl . '">' .
            format_string($quiz->name) . ' review</a>';
    $a->attemptid       = $attempt->id;
    // Student who sat the quiz info.
    $a->studentidnumber = $submitter->idnumber;
    $a->studentname     = fullname($submitter);
    $a->studentusername = $submitter->username;
    $a->grade = $quiz->grade;
    $a->sumgrade = $attempt->sumgrades;

    $allok = true;
    $allok = $allok && quiz_send_fail_attempt_reminder($submitter, $a);
    return $allok;
}




function quiz_send_fail_attempt_reminder($recipient, $a){
	$mailsubject = $a->quizname " : All Attempt Submission Failed";
    $mailcontent ="<p> Hi ".$a->studentname.",<BR>

        Thank you for submitting your answers to '".$a->quizname."' in course '".$a->coursename."' at ".$a->submissiontime.".<br>

        This message confirms that your answers have been saved and Unfortunately you <B>FAIL</B> in all the Attempts in the Quiz.<BR>

        Please Study Well Next Time.     <BR>
         
        You can access this quiz at https://learnuat.zinghr.com/Abilitic/lmscore/mod/quiz/view.php?id=20.
        ";
     //   echo $mailcontent;die("here");
    // Add information about the recipient to $a.
    // Don't do idnumber. we want idnumber to be the submitter's idnumber.
    $a->username     = fullname($recipient);
    $a->userusername = $recipient->username;

    // Prepare the message.
    $eventdata = new \core\message\message();
    $eventdata->courseid          = $a->courseid;
    $eventdata->component         = 'mod_quiz';
    $eventdata->name              = 'confirmation';
    $eventdata->notification      = 2;

    $eventdata->userfrom          = core_user::get_noreply_user();
    $eventdata->userto            = $recipient;
    $eventdata->subject           = $mailsubject;//get_string('emailconfirmsubject', 'quiz', $a);
    $eventdata->fullmessage       = $mailcontent;//get_string('emailconfirmbody', 'quiz', $a). ' ' .get_string("gradingdetails","quiz",$a);
    $eventdata->fullmessageformat = FORMAT_PLAIN;
    $eventdata->fullmessagehtml   = $mailcontent;

    $eventdata->smallmessage      = get_string('emailconfirmsmall', 'quiz', $a);
    $eventdata->contexturl        = $a->quizurl;
    $eventdata->contexturlname    = $a->quizname;
    $eventdata->customdata        = [
        'cmid' => $a->quizcmid,
        'instance' => $a->quizid,
        'attemptid' => $a->attemptid,
    ];
    print_r($eventdata);
    //die("here");
    // ... and send it.
    email_to_user($eventdata->userto,$eventdata->userfrom,$eventdata->subject,$eventdata->fullmessage,$eventdata->fullmessagehtml);
    return message_send($eventdata);
}








































/*global $DB;
$sql = "select (@a:=@a+1) AS 'sr.no.',q.id,q.course,q.name,q.attempts,count(qa.id) as cnt,qa.userid ,
	@st :=(CASE 
              WHEN (qg.grade >= gi.gradepass) THEN 'Pass' 
              WHEN (qg.grade IS NULL or qg.grade = '') THEN 
                (CASE WHEN (((q.grade / q.sumgrades) * qa.sumgrades) >= gi.gradepass) THEN 'Pass' ELSE 'Fail' END)
              ELSE
                  'Fail' 
            END) AS 'Status',
           @st
            
			FROM mdl_user u
            JOIN mdl_quiz_attempts qa on u.id=qa.userid
            JOIN mdl_quiz q ON q.id=qa.quiz
            LEFT JOIN mdl_quiz_grades qg ON u.id=qg.userid AND (q.id=qg.quiz)           
            LEFT JOIN mdl_course c ON q.course=c.id
            LEFT join mdl_grade_items as gi on gi.itemname=q.name,(SELECT @a:= 0) AS a
            where q.attempts>0  
            and qa.attempt >=q.attempts 
            #and @st like 'Fail'
         
            GROUP BY u.id,q.id,q.course,q.name,q.attempts,qg.grade,gi.gradepass,qa.sumgrades,qa.id
            order by qa.id desc
            ";
   $rs= $DB->get_records_sql($sql);
   echo "<pre>"; //print_r($rs);
   if($rs !=null){
   	foreach($rs as $r){
   		if($r->status=="Fail"){
   			print_r($r);
   		}
   	}
   }*/