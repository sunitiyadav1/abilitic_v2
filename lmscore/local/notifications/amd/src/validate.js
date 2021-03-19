$(document).ready(function(){
    //alert("hre");   
    function round(x) { 
      return Math.ceil(x / 5) * 5; 
    } 
    $("#id_timezone1").change(function(){
      //alert(this.value);
      var aestTime = new Date().toLocaleString("en-US", {timeZone: this.value});
      aestTime = new Date(aestTime);
      //alert('selected time: '+aestTime.toLocaleString() + "==="+ aestTime);
      //$("#span_timezonename").html(this.value+ " Timezone :: ");
      //$("#span_timezonedate").html(aestTime.toLocaleString());
      $("#id_scheduled_on_day").val(aestTime.getDate());
      $("#id_scheduled_on_month").val(aestTime.getMonth()+1);
      $("#id_scheduled_on_year").val(aestTime.getFullYear());
      $("#id_scheduled_on_hour").val(aestTime.getHours());
      $("#id_scheduled_on_minute").val(round(aestTime.getMinutes()));
      //alert(aestTime.getMinutes());
     // var aestTime = new Date().toLocaleString("en-US", {timeZone: "Asia/Dubai"});
    //  aestTime = new Date(aestTime);
      //console.log('Dubai time: '+aestTime.toLocaleString())
/*
      var asiaTime = new Date().toLocaleString("en-US", {timeZone: "Asia/Shanghai"});
      asiaTime = new Date(asiaTime);
      console.log('Asia time: '+asiaTime.toLocaleString())

      var usaTime = new Date().toLocaleString("en-US", {timeZone: "America/New_York"});
      usaTime = new Date(usaTime);
      console.log('USA time: '+usaTime.toLocaleString())

      var indiaTime = new Date().toLocaleString("en-US", {timeZone: "Asia/Kolkata"});
      indiaTime = new Date(indiaTime);
      console.log('India time: '+indiaTime.toLocaleString())*/
    });
});

