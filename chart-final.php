
<?php 
require('chartconn.php');
// duration
$chart_data_duration = '';
$duration="SELECT username,HOUR(timediff(lastlogin,created_at)) as duration FROM website_users";
$result=mysqli_query($conn,$duration);
while($row = mysqli_fetch_array($result))
{

 $chart_data_duration .= "{ username:'".$row["username"]."', duration:".$row["duration"]."}, ";
}
$chart_data_duration = substr($chart_data_duration, 0, -2);
// pie
$query_pie = "SELECT os, count(*) as count FROM servers WHERE os IS NOT NULL GROUP BY os ";
$result_pie = mysqli_query($conn, $query_pie);
$chart_data_pie = array();
while($row = mysqli_fetch_array($result_pie))
{
 $chart_data_pie[] = array(
   'label'  => $row["os"],
   'value'  => $row["count"]
  );
}
 $chart_data_pie = json_encode($chart_data_pie);
 // storage
$query_storage = "SELECT name,cast(totalstorage as float) as totalstorage,cast(availstorage as float) as availstorage FROM servers WHERE totalstorage IS NOT NULL AND availstorage IS NOT NULL ";
$result_storage = mysqli_query($conn, $query_storage);
$chart_data_storage = '';
while($row = mysqli_fetch_array($result_storage))
{
 $chart_data_storage .= "{ name:'".$row["name"]."', totalstorage:".$row["totalstorage"].", availstorage:".$row["availstorage"]."}, ";
}
$chart_data_storage = substr($chart_data_storage, 0, -2);
//ram
$query_ram = "SELECT name,cast(totalram as float) as totalram,cast(availram as float) as availram FROM servers WHERE totalram IS NOT NULL AND availram IS NOT NULL ";
$result_ram = mysqli_query($conn, $query_ram);
$chart_data_ram = '';
while($row = mysqli_fetch_array($result_ram))
{
 $chart_data_ram .= "{ name:'".$row["name"]."', totalram:".$row["totalram"].", availram:".$row["availram"]."}, ";
}
$chart_data_ram = substr($chart_data_ram, 0, -2);


?>


<!DOCTYPE html>
<html>
 <head>
  <title>Graphs</title>
  
  <!-- Bootstrap CDN -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <script src="https://code.jquery.com/jquery-3.4.0.js"></script>
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
</head>
<body>
  <br />
  <div class = "container">
  <button class = "btn btn-warning btn-sm" style="background-color: #000000"><a href = "welcome.php" style = "text-decoration: none; color: #ffffff;">Back to Main Page</a></button>
</div>
<br />
  <div class="container" style="width:2000px;">
   
  
<table >
    <tr><td style="width:700px">
      <h2 class="text-center">Users connectivity duration </h2>
      <div id="chart_duration"></div>
        </td>
      <td style="width:700px"><h3 class="text-center">OS Use traceability</h3>
      <div id="chart_pie"></div>
    </td>
</tr>
<tr style="width:700px"><td style="width:700px">
      <h2 class="text-center">Servers' storage (GB)</h2>
      <div id="chart_storage"></div></td>
      <td style="width:700px"><h4 class="text-center">Server's Ram (Gb)</h4>
        <div id="chart_ram"></div></td>
  </tr>
</table>
</div>
 </body>
</html>

<script>
Morris.Bar({
 element : 'chart_duration',
 data:[<?php echo $chart_data_duration; ?>],
 xkey:'username', 
 ykeys:['duration'],
 labels:['duration(Hours)'],

 hideHover:'auto',
 stacked:true
});
</script>
<script>
Morris.Donut({
 element : 'chart_pie',
 data: <?php echo $chart_data_pie; ?>
});
</script>
<script>
  Morris.Bar({
    element : 'chart_ram',
    data: [<?php echo $chart_data_ram; ?>],
    xkey: 'name',
    ykeys: ['totalram','availram'],
    labels: ['totalram'+" (GB)", 'availram'+" (GB)"],
    xLabelAngle: 60
  });
</script>
<script>
Morris.Bar({
  element : 'chart_storage',
  data:[<?php echo $chart_data_storage; ?>],
  xkey: 'name',
  ykeys: ['totalstorage', 'availstorage'],
  labels: ['totalstorage'+" (GB)", 'availstorage'+" (GB)"],
  xLabelAngle: 60
});
</script>