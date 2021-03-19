<?php

$base = __DIR__ . '/../';
//define('CLI_SCRIPT', true);
require_once $base.'config.php';
//use core_completion\progress;

//require_once($CFG->libdir.'/moodlelib.php');
//$count = 0;
//$records = [];

$data = array('Token' => '058b1fac917546008c12e1cb111bd2a6');

$bodyData = json_encode($data); 

$url = "https://portal.zinghr.com/pmsapi/api/1.0/Competency/GetCompetencyAssessmentByEmployeeId?employeeId=33518&apTemplateId=255&frequencyCodeId=114865";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'Content-Length: '.strlen($bodyData)));
curl_setopt($ch, CURLOPT_POST, 1);
//curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyData);
$result       = curl_exec($ch); 
$jsonResponse = json_decode($result, true); 



$J = '{
    "Status": true,
    "Details": [
      {
        "ClusterId": 5113,
        "ClusterName": "Values",
        "Weightage": 60,
        "CompetencyContainerId": 110491,
        "CompetenciesList": [
          {
            "Id": 5967,
            "CompetencyName": "Large Value Creation ",
            "EmployeeCode": null,
            "EmployeeName": null,
            "CompetencyRatings": null,
            "Cluster": null,
            "ManagerComments": null,
            "ExpectedRating": 0,
            "Weightage": 20,
            "RatingDetails": [
              {
                "Id": 5113,
                "CompetencyId": 5967,
                "RatingDetails": "Unsatisfactory: Performance was consistently below expectations in most essential areas of responsibility, and/or reasonable progress toward critical goals was not made. Significant improvement is needed in one or more important areas. ",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5113,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              },
              {
                "Id": 5113,
                "CompetencyId": 5967,
                "RatingDetails": "Improvement needed: Performance did not consistently meet expectations – performance failed to meet expectations in one or more essentialareas of responsibility, and/or one or more of the most critical goals were not met. ",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5113,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              },
              {
                "Id": 5113,
                "CompetencyId": 5967,
                "RatingDetails": "Meets Expectations: Performance consistently met expectations in all essential areas of responsibility, at times possibly exceeding expectations, and the quality of work overall was very good. The most critical annual goals were met.",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5113,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              },
              {
                "Id": 5113,
                "CompetencyId": 5967,
                "RatingDetails": "Exceeds Expectations: Performance consistently exceeded expectations in all essential areas of responsibility, and the quality of work overall was excellent. Annual goals were met.",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5113,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              },
              {
                "Id": 5113,
                "CompetencyId": 5967,
                "RatingDetails": "Exceptional: Performance far exceeded expectations that may include the completion of a major goal or project, or 2) made an exceptional or unique contribution in support of unit, department, or Organization objectives. This rating is achievable by any employee.",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5113,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              }
            ],
            "Questionnaries": null,
            "ManagerRatingDetails": null,
            "Status": 0,
            "IsActive": false,
            "CompetencyAssessmentRating": 0,
            "CompAssessmentContainerId": 110491,
            "ClusterId": 5113,
            "CompetencyId": 5967,
            "Rating": null,
            "ManagerRating": null,
            "ReviewerRating": null,
            "RatingCount": 5,
            "EmployeeId": 33518,
            "Evaluator": 0,
            "WeightedScore": null,
            "APTemplateId": 255,
            "Comment": null,
            "ManagerComment": null,
            "ReviewerComments": null,
            "LevelId": 1,
            "CompetencyAssessmentEvaluatorList": null,
            "CompetencyEvaluatorList": [
              {
                "ClusterId": 5113,
                "CompetencyId": 5967,
                "RespondentId": 33518,
                "RespondentName": "Rishav  Goyal",
                "WeightageScore": 1,
                "LevelId": 1,
                "Rating": 5,
                "FrequencyCodeId": 114865,
                "Comment": "Worked on star tv PEP and make it live on web and in mobile app. Also worked on quick pin which is completely different approach for login and punch in. Also made the product smooth in many ways. "
              },
              {
                "ClusterId": 5113,
                "CompetencyId": 5967,
                "RespondentId": 33513,
                "RespondentName": "Nikhil K Mishra",
                "WeightageScore": null,
                "LevelId": 2,
                "Rating": null,
                "FrequencyCodeId": 114865,
                "Comment": null
              },
              {
                "ClusterId": 5113,
                "CompetencyId": 5967,
                "RespondentId": 33447,
                "RespondentName": "Prasad R Rajappan",
                "WeightageScore": null,
                "LevelId": 3,
                "Rating": null,
                "FrequencyCodeId": 114865,
                "Comment": null
              }
            ],
            "FrequencyCodeId": 114865,
            "ClusterWeightage": 60,
            "ClusterName": "Values",
            "DevelopmentMode": null,
            "ActorId": 0,
            "CompetencyDescription": null,
            "AdditionalCommentsBySupervisor": null,
            "CompetencyEvaluationPoints": null,
            "EvalScore": 0,
            "FinalTotal": 0,
            "Total": 0,
            "AdditionalPoints": 0,
            "StrenghtAndDevelopmentImrovement": null
          },
          {
            "Id": 5968,
            "CompetencyName": "Impeccable Quality",
            "EmployeeCode": null,
            "EmployeeName": null,
            "CompetencyRatings": null,
            "Cluster": null,
            "ManagerComments": null,
            "ExpectedRating": 0,
            "Weightage": 20,
            "RatingDetails": [
              {
                "Id": 5113,
                "CompetencyId": 5968,
                "RatingDetails": "Unsatisfactory: Performance was consistently below expectations in most essential areas of responsibility, and/or reasonable progress toward critical goals was not made. Significant improvement is needed in one or more important areas. ",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5113,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              },
              {
                "Id": 5113,
                "CompetencyId": 5968,
                "RatingDetails": "Improvement needed: Performance did not consistently meet expectations – performance failed to meet expectations in one or more essentialareas of responsibility, and/or one or more of the most critical goals were not met. ",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5113,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              },
              {
                "Id": 5113,
                "CompetencyId": 5968,
                "RatingDetails": "Meets Expectations: Performance consistently met expectations in all essential areas of responsibility, at times possibly exceeding expectations, and the quality of work overall was very good. The most critical annual goals were met.",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5113,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              },
              {
                "Id": 5113,
                "CompetencyId": 5968,
                "RatingDetails": "Exceeds Expectations: Performance consistently exceeded expectations in all essential areas of responsibility, and the quality of work overall was excellent. Annual goals were met.",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5113,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              },
              {
                "Id": 5113,
                "CompetencyId": 5968,
                "RatingDetails": "Exceptional: Performance far exceeded expectations that may include the completion of a major goal or project, or 2) made an exceptional or unique contribution in support of unit, department, or Organization objectives. This rating is achievable by any employee.",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5113,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              }
            ],
            "Questionnaries": null,
            "ManagerRatingDetails": null,
            "Status": 0,
            "IsActive": false,
            "CompetencyAssessmentRating": 0,
            "CompAssessmentContainerId": 110491,
            "ClusterId": 5113,
            "CompetencyId": 5968,
            "Rating": null,
            "ManagerRating": null,
            "ReviewerRating": null,
            "RatingCount": 5,
            "EmployeeId": 33518,
            "Evaluator": 0,
            "WeightedScore": null,
            "APTemplateId": 255,
            "Comment": null,
            "ManagerComment": null,
            "ReviewerComments": null,
            "LevelId": 1,
            "CompetencyAssessmentEvaluatorList": null,
            "CompetencyEvaluatorList": [
              {
                "ClusterId": 5113,
                "CompetencyId": 5968,
                "RespondentId": 33518,
                "RespondentName": "Rishav  Goyal",
                "WeightageScore": 1,
                "LevelId": 1,
                "Rating": 5,
                "FrequencyCodeId": 114865,
                "Comment": "in ZingHR I am doing development with awesome quality and with zero error. "
              },
              {
                "ClusterId": 5113,
                "CompetencyId": 5968,
                "RespondentId": 33513,
                "RespondentName": "Nikhil K Mishra",
                "WeightageScore": null,
                "LevelId": 2,
                "Rating": null,
                "FrequencyCodeId": 114865,
                "Comment": null
              },
              {
                "ClusterId": 5113,
                "CompetencyId": 5968,
                "RespondentId": 33447,
                "RespondentName": "Prasad R Rajappan",
                "WeightageScore": null,
                "LevelId": 3,
                "Rating": null,
                "FrequencyCodeId": 114865,
                "Comment": null
              }
            ],
            "FrequencyCodeId": 114865,
            "ClusterWeightage": 60,
            "ClusterName": "Values",
            "DevelopmentMode": null,
            "ActorId": 0,
            "CompetencyDescription": null,
            "AdditionalCommentsBySupervisor": null,
            "CompetencyEvaluationPoints": null,
            "EvalScore": 0,
            "FinalTotal": 0,
            "Total": 0,
            "AdditionalPoints": 0,
            "StrenghtAndDevelopmentImrovement": null
          },
          {
            "Id": 5969,
            "CompetencyName": "Speed & Agility",
            "EmployeeCode": null,
            "EmployeeName": null,
            "CompetencyRatings": null,
            "Cluster": null,
            "ManagerComments": null,
            "ExpectedRating": 0,
            "Weightage": 10,
            "RatingDetails": [
              {
                "Id": 5113,
                "CompetencyId": 5969,
                "RatingDetails": "Unsatisfactory: Performance was consistently below expectations in most essential areas of responsibility, and/or reasonable progress toward critical goals was not made. Significant improvement is needed in one or more important areas. ",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5113,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              },
              {
                "Id": 5113,
                "CompetencyId": 5969,
                "RatingDetails": "Improvement needed: Performance did not consistently meet expectations – performance failed to meet expectations in one or more essentialareas of responsibility, and/or one or more of the most critical goals were not met. ",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5113,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              },
              {
                "Id": 5113,
                "CompetencyId": 5969,
                "RatingDetails": "Meets Expectations: Performance consistently met expectations in all essential areas of responsibility, at times possibly exceeding expectations, and the quality of work overall was very good. The most critical annual goals were met.",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5113,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              },
              {
                "Id": 5113,
                "CompetencyId": 5969,
                "RatingDetails": "Exceeds Expectations: Performance consistently exceeded expectations in all essential areas of responsibility, and the quality of work overall was excellent. Annual goals were met.",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5113,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              },
              {
                "Id": 5113,
                "CompetencyId": 5969,
                "RatingDetails": "Exceptional: Performance far exceeded expectations that may include the completion of a major goal or project, or 2) made an exceptional or unique contribution in support of unit, department, or Organization objectives. This rating is achievable by any employee.",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5113,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              }
            ],
            "Questionnaries": null,
            "ManagerRatingDetails": null,
            "Status": 0,
            "IsActive": false,
            "CompetencyAssessmentRating": 0,
            "CompAssessmentContainerId": 110491,
            "ClusterId": 5113,
            "CompetencyId": 5969,
            "Rating": null,
            "ManagerRating": null,
            "ReviewerRating": null,
            "RatingCount": 5,
            "EmployeeId": 33518,
            "Evaluator": 0,
            "WeightedScore": null,
            "APTemplateId": 255,
            "Comment": null,
            "ManagerComment": null,
            "ReviewerComments": null,
            "LevelId": 1,
            "CompetencyAssessmentEvaluatorList": null,
            "CompetencyEvaluatorList": [
              {
                "ClusterId": 5113,
                "CompetencyId": 5969,
                "RespondentId": 33518,
                "RespondentName": "Rishav  Goyal",
                "WeightageScore": null,
                "LevelId": 1,
                "Rating": null,
                "FrequencyCodeId": 114865,
                "Comment": null
              },
              {
                "ClusterId": 5113,
                "CompetencyId": 5969,
                "RespondentId": 33513,
                "RespondentName": "Nikhil K Mishra",
                "WeightageScore": null,
                "LevelId": 2,
                "Rating": null,
                "FrequencyCodeId": 114865,
                "Comment": null
              },
              {
                "ClusterId": 5113,
                "CompetencyId": 5969,
                "RespondentId": 33447,
                "RespondentName": "Prasad R Rajappan",
                "WeightageScore": null,
                "LevelId": 3,
                "Rating": null,
                "FrequencyCodeId": 114865,
                "Comment": null
              }
            ],
            "FrequencyCodeId": 114865,
            "ClusterWeightage": 60,
            "ClusterName": "Values",
            "DevelopmentMode": null,
            "ActorId": 0,
            "CompetencyDescription": null,
            "AdditionalCommentsBySupervisor": null,
            "CompetencyEvaluationPoints": null,
            "EvalScore": 0,
            "FinalTotal": 0,
            "Total": 0,
            "AdditionalPoints": 0,
            "StrenghtAndDevelopmentImrovement": null
          },
          {
            "Id": 5970,
            "CompetencyName": "Distruptive Innovation ",
            "EmployeeCode": null,
            "EmployeeName": null,
            "CompetencyRatings": null,
            "Cluster": null,
            "ManagerComments": null,
            "ExpectedRating": 0,
            "Weightage": 10,
            "RatingDetails": [
              {
                "Id": 5113,
                "CompetencyId": 5970,
                "RatingDetails": "Unsatisfactory: Performance was consistently below expectations in most essential areas of responsibility, and/or reasonable progress toward critical goals was not made. Significant improvement is needed in one or more important areas. ",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5113,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              },
              {
                "Id": 5113,
                "CompetencyId": 5970,
                "RatingDetails": "Improvement needed: Performance did not consistently meet expectations – performance failed to meet expectations in one or more essentialareas of responsibility, and/or one or more of the most critical goals were not met. ",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5113,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              },
              {
                "Id": 5113,
                "CompetencyId": 5970,
                "RatingDetails": "Meets Expectations: Performance consistently met expectations in all essential areas of responsibility, at times possibly exceeding expectations, and the quality of work overall was very good. The most critical annual goals were met.",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5113,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              },
              {
                "Id": 5113,
                "CompetencyId": 5970,
                "RatingDetails": "Exceeds Expectations: Performance consistently exceeded expectations in all essential areas of responsibility, and the quality of work overall was excellent. Annual goals were met.",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5113,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              },
              {
                "Id": 5113,
                "CompetencyId": 5970,
                "RatingDetails": "Exceptional: Performance far exceeded expectations that may include the completion of a major goal or project, or 2) made an exceptional or unique contribution in support of unit, department, or Organization objectives. This rating is achievable by any employee.",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5113,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              }
            ],
            "Questionnaries": null,
            "ManagerRatingDetails": null,
            "Status": 0,
            "IsActive": false,
            "CompetencyAssessmentRating": 0,
            "CompAssessmentContainerId": 110491,
            "ClusterId": 5113,
            "CompetencyId": 5970,
            "Rating": null,
            "ManagerRating": null,
            "ReviewerRating": null,
            "RatingCount": 5,
            "EmployeeId": 33518,
            "Evaluator": 0,
            "WeightedScore": null,
            "APTemplateId": 255,
            "Comment": null,
            "ManagerComment": null,
            "ReviewerComments": null,
            "LevelId": 1,
            "CompetencyAssessmentEvaluatorList": null,
            "CompetencyEvaluatorList": [
              {
                "ClusterId": 5113,
                "CompetencyId": 5970,
                "RespondentId": 33518,
                "RespondentName": "Rishav  Goyal",
                "WeightageScore": null,
                "LevelId": 1,
                "Rating": null,
                "FrequencyCodeId": 114865,
                "Comment": null
              },
              {
                "ClusterId": 5113,
                "CompetencyId": 5970,
                "RespondentId": 33513,
                "RespondentName": "Nikhil K Mishra",
                "WeightageScore": null,
                "LevelId": 2,
                "Rating": null,
                "FrequencyCodeId": 114865,
                "Comment": null
              },
              {
                "ClusterId": 5113,
                "CompetencyId": 5970,
                "RespondentId": 33447,
                "RespondentName": "Prasad R Rajappan",
                "WeightageScore": null,
                "LevelId": 3,
                "Rating": null,
                "FrequencyCodeId": 114865,
                "Comment": null
              }
            ],
            "FrequencyCodeId": 114865,
            "ClusterWeightage": 60,
            "ClusterName": "Values",
            "DevelopmentMode": null,
            "ActorId": 0,
            "CompetencyDescription": null,
            "AdditionalCommentsBySupervisor": null,
            "CompetencyEvaluationPoints": null,
            "EvalScore": 0,
            "FinalTotal": 0,
            "Total": 0,
            "AdditionalPoints": 0,
            "StrenghtAndDevelopmentImrovement": null
          }
        ],
        "clusterQuantumScore": null,
        "RWRclusterQuantumScore": null
      },
      {
        "ClusterId": 5114,
        "ClusterName": "People Management",
        "Weightage": 40,
        "CompetencyContainerId": 110491,
        "CompetenciesList": [
          {
            "Id": 5971,
            "CompetencyName": "Ownership",
            "EmployeeCode": null,
            "EmployeeName": null,
            "CompetencyRatings": null,
            "Cluster": null,
            "ManagerComments": null,
            "ExpectedRating": 0,
            "Weightage": 40,
            "RatingDetails": [
              {
                "Id": 5114,
                "CompetencyId": 5971,
                "RatingDetails": "Unsatisfactory: Performance was consistently below expectations in most essential areas of responsibility, and/or reasonable progress toward critical goals was not made. Significant improvement is needed in one or more important areas.",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5114,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              },
              {
                "Id": 5114,
                "CompetencyId": 5971,
                "RatingDetails": "Improvement needed: Performance did not consistently meet expectations – performance failed to meet expectations in one or more essential areas of responsibility, and/or one or more of the most critical goals were not met.",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5114,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              },
              {
                "Id": 5114,
                "CompetencyId": 5971,
                "RatingDetails": "Meets Expectations: Performance consistently met expectations in all essential areas of responsibility, at times possibly exceeding expectations, and the quality of work overall was very good. The most critical annual goals were met.",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5114,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              },
              {
                "Id": 5114,
                "CompetencyId": 5971,
                "RatingDetails": "Exceeds Expectations: Performance consistently exceeded expectations in all essential areas of responsibility, and the quality of work overall was excellent. Annual goals were met.",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5114,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              },
              {
                "Id": 5114,
                "CompetencyId": 5971,
                "RatingDetails": "Exceptional: Performance far exceeded expectations that may include the completion of a major goal or project, or 2) made an exceptional or unique contribution in support of unit, department, or Organization objectives. This rating is achievable by any employee.",
                "IsActive": false,
                "CultureInfoId": 1,
                "ClusterId": 5114,
                "RowNumber": 0,
                "isChecked": false,
                "FuncBehaviouralIndicators": null,
                "LeaderShipBehaviouralIndicators": null,
                "LeaderShipIsActive": false
              }
            ],
            "Questionnaries": null,
            "ManagerRatingDetails": null,
            "Status": 0,
            "IsActive": false,
            "CompetencyAssessmentRating": 0,
            "CompAssessmentContainerId": 110491,
            "ClusterId": 5114,
            "CompetencyId": 5971,
            "Rating": null,
            "ManagerRating": null,
            "ReviewerRating": null,
            "RatingCount": 5,
            "EmployeeId": 33518,
            "Evaluator": 0,
            "WeightedScore": null,
            "APTemplateId": 255,
            "Comment": null,
            "ManagerComment": null,
            "ReviewerComments": null,
            "LevelId": 1,
            "CompetencyAssessmentEvaluatorList": null,
            "CompetencyEvaluatorList": [
              {
                "ClusterId": 5114,
                "CompetencyId": 5971,
                "RespondentId": 33518,
                "RespondentName": "Rishav  Goyal",
                "WeightageScore": 2,
                "LevelId": 1,
                "Rating": 5,
                "FrequencyCodeId": 114865,
                "Comment": "Completed many features with sole ownership and motivate team for awesome product. Complete the PMS on mobile"
              },
              {
                "ClusterId": 5114,
                "CompetencyId": 5971,
                "RespondentId": 33513,
                "RespondentName": "Nikhil K Mishra",
                "WeightageScore": null,
                "LevelId": 2,
                "Rating": null,
                "FrequencyCodeId": 114865,
                "Comment": null
              },
              {
                "ClusterId": 5114,
                "CompetencyId": 5971,
                "RespondentId": 33447,
                "RespondentName": "Prasad R Rajappan",
                "WeightageScore": null,
                "LevelId": 3,
                "Rating": null,
                "FrequencyCodeId": 114865,
                "Comment": null
              }
            ],
            "FrequencyCodeId": 114865,
            "ClusterWeightage": 40,
            "ClusterName": "People Management",
            "DevelopmentMode": null,
            "ActorId": 0,
            "CompetencyDescription": null,
            "AdditionalCommentsBySupervisor": null,
            "CompetencyEvaluationPoints": null,
            "EvalScore": 0,
            "FinalTotal": 0,
            "Total": 0,
            "AdditionalPoints": 0,
            "StrenghtAndDevelopmentImrovement": null
          }
        ],
        "clusterQuantumScore": null,
        "RWRclusterQuantumScore": null
      },
      {
        "ClusterId": 5115,
        "ClusterName": "Outcome",
        "Weightage": 0,
        "CompetencyContainerId": 110491,
        "CompetenciesList": [],
        "clusterQuantumScore": null,
        "RWRclusterQuantumScore": null
      }
    ]
  }';

  $de = json_decode($J);
  
  $array1 = array();

  $compentencyname = array();
  $total_compentency_list = 0;
  $level_rating = 0;
  $color = array('pink','red','orange','blue','violet');
  $final_arr = array();

  $array_basic = array();
  $array_advance = array();
  $array_critical = array();

  $array_all = array();

  foreach ($de->Details as $key => $value)
  {
    $obj1 = new stdClass();
    $obj1->id = $value->ClusterId;
    $obj1->name = $value->ClusterName;
    $obj1->color = $color[$key];
    array_push($array1,$obj1);

    foreach($value->CompetenciesList as $key1 => $value1)
    {
        $total_compentency_list++;

        $obj2 = new stdClass();

        $obj3 = new stdClass();
       
        if($value1->Weightage <= 30)
        {

            $obj2->competencyname= $value1->CompetencyName;
            $obj2->weightage = $value1->Weightage;
            $obj2->color = $color[$key];

            array_push($array_basic,$obj2);
            
        }
        else if($value1->Weightage <= 50)
        {
            
            $obj2->competencyname= $value1->CompetencyName;
            $obj2->weightage = $value1->Weightage;
            $obj2->color = $color[$key];

            
            array_push($array_advance,$obj2);

        }
        else if($value1->Weightage > 50)
        {
            $obj2->competencyname= $value1->CompetencyName;
            $obj2->weightage = $value1->Weightage;
            $obj2->color = $color[$key];

            
            array_push($array_critical,$obj2);

        }

        
      

        $last_level = count($value1->CompetencyEvaluatorList) - 1;
        $level_rating +=  $value1->CompetencyEvaluatorList[$last_level]->Rating;
       
      
    }
   
    
  }

  $obj4 = new stdClass();
  $obj4->OverAllProgress = $level_rating * 5 / $total_compentency_list;
  $obj4->TopLevelCompetency = $array1;
  $obj4->Basic = $array_basic;
  $obj4->Advance = $array_advance;
  $obj4->Critical = $array_critical;

  echo json_encode($obj4);


?>