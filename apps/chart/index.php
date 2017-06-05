<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>

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


    <script type="text/javascript" src="../charts/canvasjs-1.8.1/canvasjs.min.js"></script>
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
    <script src="../charts/js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../charts/js/bootstrap.min.js"></script>
  </body>
</html>
