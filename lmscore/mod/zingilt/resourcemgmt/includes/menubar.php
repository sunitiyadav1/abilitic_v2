<!--
<div class="row" style ="height:50px;">
        <div class="col-md-3" style="background-color:#c10f41;"><h3><a style="color:white;" href="index.php">Resource Management</a></h3></div>
        <div class="col-md-3" style="background-color:#f54266;"><h3><a style="color:white;" href="tprovider.php">Training Provider</a></h3></div>
        <div class="col-md-3" style="background-color:#2196f3;"><h3><a style="color:white;" href="tcenter.php">Training Center</a></h3></div>
        <div class="col-md-3" style="background-color:#3858f9;"><h3><a style="color:white;" href="view_calendar.php">Resource Calendar</a></h3></div>
</div><BR><BR>-->

<?php  
 $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);  
    //echo "The current page name is: ".$curPageName;  
 ?><div style="font-size: 18px;"><B>
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link <?php echo ($curPageName=="index.php"?"active":"");?>" href="index.php">Resource Management</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php echo ($curPageName=="tprovider.php"?"active":"");?>" href="tprovider.php">Training Provider</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php echo ($curPageName=="tcenter.php"?"active":"");?>" href="tcenter.php">Training Center</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php echo ($curPageName=="view_calendar.php"?"active":"");?>" href="view_calendar.php">Resource Calendar</a>
  </li>
</ul></B></div>
 <!-- disabled -->