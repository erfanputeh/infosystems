<?php
if (isset($_POST['ok'])) {
    $objective_dir = "D:/xampp/htdocs/infosystems/images/student/";
    $objective_file = $objective_dir . basename($_FILES["picture_student"]["name"]);
    $uploadsuccess = 1;
    $pictureFileType = pathinfo($objective_file,PATHINFO_EXTENSION);

    //ฟังก์ชั่นวันที่
    date_default_timezone_set('Asia/Bangkok');
    $date = date("Ymd");
    //ฟังก์ชั่นสุ่มตัวเลข
    $numrand = (mt_rand());
    //เอาชื่อไฟล์เก่าออกให้เหลือแต่นามสกุล
    $type = strrchr($_FILES['picture_student']['name'],".");
    //ตั้งชื่อไฟล์ใหม่โดยเอาเวลาไว้หน้าชื่อไฟล์เดิม
    $newfilename = $date.$numrand.$type;
    $path_copy = $objective_dir.$newfilename;

    $check = getimagesize($_FILES["picture_student"]["tmp_name"]);
    if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadsuccess = 1;
    } else {
      echo "File is not an image.";
      $uploadsuccess = 0;
    }

    // เช็คไฟล์เมื่อไฟล์นั่นมีอยู่แล้ว
    if (file_exists($objective_file)) {
        echo "Sorry, file already exists.";
        $uploadsuccess = 0;
    }
    // เช็คขนาดรูป
    if ($_FILES["picture_student"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadsuccess = 0;
    }
    // อนุญาติไฟล์ชนิดใดบ้างที่สามารถใช้ได้
    //
    if($pictureFileType != "jpg" && $pictureFileType != "png" && $pictureFileType != "gif" && $pictureFileType != "jpeg" && $pictureFileType != "JPG" && $pictureFileType != "PNG" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadsuccess = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadsuccess == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["picture_student"]["tmp_name"], $path_copy)) {

      $query = $db->prepare('INSERT INTO student (student_number, name_student, surname_student, 	date_student, address_student, picture_student, newpicture_student )
                            values(:student_number ,:name_student ,:surname_student ,:date_student ,:address_student ,:picture_student ,:newpicture_student )');
      $res = $query->execute([
        'student_number' =>$_POST['student_number'],
        'name_student' =>$_POST['name_student'],
        'surname_student' =>$_POST['surname_student'],
        'date_student' =>$_POST['date_student'],
        'address_student' =>$_POST['address_student'],
        'picture_student'=>$_FILES['picture_student']['name'],
        "newpicture_student"=> $newfilename,

          ]);
          if ($res) {
            echo "<script>
                    alert('Add Student Succesfully')
                    window.location = 'home.php?file=student/index';
                  </script>";
          }else {
            echo "<script>
                    alert('Add Fail! '".$query->errorInfo()[2].");
                  </script>";
      } // else
    } //move_uploaded_file
  }
} //ok
?>

<section class="content">
  <!-- <div class="page-content-wrap"> -->

      <div class="row">
          <div class="col-md-12">

              <form class="form-horizontal" method="post" enctype="multipart/form-data">
              <div class="panel panel-default">
                  <div class="panel-heading ui-draggable-handle">
                      <h3 class="panel-title"><strong>จัดการข้อมูลนักเรียน</strong> </h3>
                      <ul class="panel-controls">
                          <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                      </ul>
                  </div>
                  <!-- <div class="panel-body">
                      <p>This is non libero bibendum, scelerisque arcu id, placerat nunc. Integer ullamcorper rutrum dui eget porta. Fusce enim dui, pulvinar a augue nec, dapibus hendrerit mauris. Praesent efficitur, elit non convallis faucibus, enim sapien suscipit mi, sit amet fringilla felis arcu id sem. Phasellus semper felis in odio convallis, et venenatis nisl posuere. Morbi non aliquet magna, a consectetur risus. Vivamus quis tellus eros. Nulla sagittis nisi sit amet orci consectetur laoreet. Vivamus volutpat erat ac vulputate laoreet. Phasellus eu ipsum massa.</p>
                  </div> -->
                  <div class="panel-body">

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">เลขประจำตัวนักเรียน</label>
                          <div class="col-md-6 col-xs-12">
                              <div class="input-group">
                                  <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                  <input type="text" class="form-control" name="student_number"/>
                              </div>
                              <!-- <span class="help-block">This is sample of text field</span> -->
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">ชื่อ</label>
                          <div class="col-md-6 col-xs-12">
                              <div class="input-group">
                                  <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                  <input type="text" class="form-control" name="name_student"/>
                              </div>
                              <!-- <span class="help-block">Password field sample</span> -->
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">นามสกุล</label>
                          <div class="col-md-6 col-xs-12">
                              <div class="input-group">
                                  <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                  <input type="text" class="form-control" name="surname_student"/>
                              </div>
                              <!-- <span class="help-block">Password field sample</span> -->
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">วัน เดือน ปีเกิด</label>
                          <div class="col-md-6 col-xs-12">
                              <div class="input-group">
                                  <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                  <input type="date" class="form-control datepicker" name="date_student" value="2014-11-01">
                              </div>
                              <!-- <span class="help-block">Click on input field to get datepicker</span> -->
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">ที่อยู่</label>
                          <div class="col-md-6 col-xs-12">
                              <textarea class="form-control" rows="5" name="address_student"></textarea>
                              <!-- <span class="help-block">Default textarea field</span> -->
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">รูป</label>
                          <div class="col-md-6 col-xs-12">
                              <input type="file" class="fileinput btn-primary" name="picture_student" id="filename" title="Browse file"/>
                              <!-- <span class="help-block">Input type file</span> -->
                          </div>
                      </div>

                      <!-- <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">Checkbox</label>
                          <div class="col-md-6 col-xs-12">
                              <label class="check"><input type="checkbox" class="icheckbox" checked="checked"/> Checkbox title</label>
                              <span class="help-block">Checkbox sample, easy to use</span>
                          </div>
                      </div> -->

                  </div>
                  <div class="panel-footer">
                      <button class="btn btn-default" type="reset">Clear Form</button>
                      <button class="btn btn-primary pull-right" type="submit" name="ok">Submit</button>
                  </div>
              </div>
              </form>

          </div>
      </div>

  <!-- </div> -->


</section>




<section class="content">
      <div class="row">
              <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">ข้อมูลนักเรียน</h3>
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>

                                      <div class="btn-group pull-right">
                                          <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                          <ul class="dropdown-menu">
                                              <li class="divider"></li>
                                              <li><a href="#DataTablesTable" onClick ="$('#DataTablesTable').tableExport({type:'excel',escape:'false'});"><img src='../images/icons/xls.png' width="24"/> XLS</a></li>
                                              <li><a href="#DataTablesTable" onClick ="$('#DataTablesTable').tableExport({type:'doc',escape:'false'});"><img src='../images/icons/word.png' width="24"/> Word</a></li>
                                              <li><a href="#DataTablesTable" onClick ="$('#DataTablesTable').tableExport({type:'powerpoint',escape:'false'});"><img src='../images/icons/ppt.png' width="24"/> PowerPoint</a></li>
                                              <!-- <li class="divider"></li> -->
                                              <li><a href="#DataTablesTable" onClick ="$('#DataTablesTable').tableExport({type:'png',escape:'false'});"><img src='../images/icons/png.png' width="24"/> PNG</a></li>
                                              <li><a href="#DataTablesTable" onClick ="$('#DataTablesTable').tableExport({type:'pdf',escape:'false'});"><img src='../images/icons/pdf.png' width="24"/> PDF</a></li>
                                              <li><a href="#DataTablesTable" onClick ="$('#DataTablesTable').tableExport({type:'sql'});"><img src='../images/icons/sql.png' width="24"/> SQL</a></li>
                                          </ul>
                                      </div>

                                </div>



                                <div class="panel-body">
                                    <table class="table datatable dataTable no-footer" id="DataTablesTable" role="grid" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>รูป</th>
                                                <th>เลขประจำตัวนักเรียน</th>
                                                <th>ชื่อ</th>
                                                <th>นามสกุล</th>
                                                <th>วัน เดือน ปีเกิด</th>
                                                <th>ที่อยู่</th>
                                                <th>จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                          $query = $db->prepare("SELECT * FROM student");//เตรียมคำสั่ง sql
                                          $query->execute();

                                          if($query->rowCount()>0){

                                          $data = $query->fetchAll(PDO::FETCH_OBJ);
                                          foreach ($data as $k => $row ) {
                                            ?>
                                            <tr>
                                              <td><?=($k+1)?></td>
                                              <td class="sorting_1"><img  class="style_prevu_kit" src="../images/student/<?=$row->newpicture_student?>"></td>
                                              <td><?=$row->student_number?></td>
                                              <td><?=$row->name_student?></td>
                                              <td><?=$row->surname_student?></td>
                                              <td><?=$row->date_student?></td>
                                              <td><?=$row->address_student?></td>
                                              <td>
                                                &nbsp;&nbsp;<a href="home.php?file=student/view&id=<?=$row->member_id?>"><i class='fa fa-eye'></i></a>&nbsp;
                                                <a href="home.php?file=student/del&id=<?=$row->member_id?>"><i class='fa fa-trash'></i></a>
                                              </td>
                                            </tr>
                                            <?php
                                              }
                                            }
                                          ?>
                                        </tbody>
                                    </table>
                                </div> <!--panel-body-->

                            </div>  <!--panel panel-default-->
                            <!-- END DEFAULT DATATABLE -->

                        </div> <!--col-->
                    </div> <!--row-->

                </section>
