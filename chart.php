<!DOCTYPE html>
<html lang="en">
	<head>
    <!-- <?php include_once("libs/Db.php");?> -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>SB Admin - Bootstrap Admin Template</title>
		<!-- Bootstrap Core CSS -->
		<link href="chart/css/bootstrap.min.css" rel="stylesheet">
		<!-- Custom CSS -->
		<link href="chart/css/sb-admin.css" rel="stylesheet">
		<!-- Morris Charts CSS -->
		<link href="chart/css/plugins/morris.css" rel="stylesheet">
		<!-- Custom Fonts -->
		<link href="chart/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
<?php
  if(!function_exists("thai_month_arr")){
    function thai_month_arr($month = ""){
      $arr = array(
        "01"=>"มกราคม",
        "02"=>"กุมภาพันธ์",
        "03"=>"มีนาคม",
        "04"=>"เมษายน",
        "05"=>"พฤษภาคม",
        "06"=>"มิถุนายน",
        "07"=>"กรกฎาคม",
        "08"=>"สิงหาคม",
        "09"=>"กันยายน",
        "10"=>"ตุลาคม",
        "11"=>"พฤศจิกายน",
        "12"=>"ธันวาคม"
      );
      return $month == "" ? $arr : $arr[$month];
    }
  }
?>


<?php
$db_host = 'localhost'; // Sever database
$db_name = 'infosystems_db'; // ฐานข้อมูล
$db_user = 'root'; // ชื่อผู้ใช้
$db_pass = ''; // รหัสผ่าน
$db = null;

try { // ให้พยายามทำงานคำสั่งต่อไปนี้
  $db = new PDO("mysql:host=$db_host; dbname=$db_name", $db_user, $db_pass);
  $db->exec("SET CHARACTER SET utf8"); // ให้รองรับภาษาไทย
  // echo "ติดต่อฐานข้อมูลได้แล้ว เย้!";
}catch (PDOException $e) { //กรณีทำงานผิดพลาด
  echo "พบปัญหา : ".$e->getMessage(); //แสดง Error
}

 ?>


<script type="text/javascript" src="charts/canvasjs-1.8.1/canvasjs.min.js"></script>
<script type="text/javascript">
  window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",
    {
      exportEnabled: true,
      animationEnabled: true,
      title:{
        text: "สรุปจำนวนกระทู้ของแต่ละเดือน",
        margin: 15,
      },
      legend:{
        fontColor: "black",
        fontWeight: "bold",
      },
      data: [
        <?php
          for ($l=(date("Y")-3); $l <= date("Y") ; $l++) {
        ?>
      {
        type: "column", //change type to bar, line, area, pie, etc
        showInLegend: true,
        legendText: "ปี <?php echo ($l+543);?>",
        dataPoints: [
          <?php
            foreach (thai_month_arr() as $key => $value) {
              $result = $db->prepare("SELECT * FROM `student` WHERE DATE_FORMAT(date_attendance,'%m-%Y') = '$key-$l'");
              $result->execute();
              $count = $result->rowCount();
            ?>
          {y: <?php echo $count;?>, label: "<?php echo $value;?>" <?php echo $count != 0?', indexLabel:"{y} ครั้ง."':''; ?> },
            <?php
            }
          ?>
        ]
      },
        <?php
          }
        ?>
      ],
      axisX:{
        title: "เดือน",
        gridThickness: 1,
        labelAngle: -30,
      },
      axisY: {
        title: "จำนวน"
      }
    });

    chart.render();
  }
  </script>

</head>
<body>
  <div id="wrapper">

    <div id="page-wrapper">
      <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
          <div class="col-lg-12">
            <h1 class="page-header">
              Dashboard <small>Statistics Overview</small>
            </h1>
            <ol class="breadcrumb">
              <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard
              </li>
            </ol>
          </div>
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-lg-12">
            <div class="canvasjs-chart-container">
                <div id="chartContainer" style="height: 300px; width: 100%;"></div>
            </div>

          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </div>
  </div>

  <!-- jQuery -->
  <script src="charts/js/jquery.js"></script>
  <!-- Bootstrap Core JavaScript -->
  <script src="charts/js/bootstrap.min.js"></script>

</body>
</html>
