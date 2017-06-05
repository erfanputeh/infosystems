<?php
if (isset($_POST['ok'])) {
    $objective_dir = "D:/xampp/htdocs/infosystems/images/personal/";
    $objective_file = $objective_dir . basename($_FILES["images"]["name"]);
    $uploadsuccess = 1;
    $pictureFileType = pathinfo($objective_file,PATHINFO_EXTENSION);

    //ฟังก์ชั่นวันที่
    date_default_timezone_set('Asia/Bangkok');
    $date = date("Ymd");
    //ฟังก์ชั่นสุ่มตัวเลข
    $numrand = (mt_rand());
    //เอาชื่อไฟล์เก่าออกให้เหลือแต่นามสกุล
    $type = strrchr($_FILES['images']['name'],".");
    //ตั้งชื่อไฟล์ใหม่โดยเอาเวลาไว้หน้าชื่อไฟล์เดิม
    $newfilename = $date.$numrand.$type;
    $path_copy = $objective_dir.$newfilename;

    $check = getimagesize($_FILES["images"]["tmp_name"]);
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
    if ($_FILES["images"]["size"] > 5000000) {
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
        if (move_uploaded_file($_FILES["images"]["tmp_name"], $path_copy)) {

      $query = $db->prepare('INSERT INTO personal (name_personal, surname_personal, ordinary_qualification, 	religion_qualification, institution, address_personal, telephone_personal, images, newpersonal_picture )
                            values(:name_personal ,:surname_personal ,:ordinary_qualification ,:religion_qualification ,:institution ,:address_personal ,:telephone_personal ,:images ,:newpersonal_picture)');
      $res = $query->execute([
        'name_personal' =>$_POST['name_personal'],
        'surname_personal' =>$_POST['surname_personal'],
        'ordinary_qualification' =>$_POST['ordinary_qualification'],
        'religion_qualification' =>$_POST['religion_qualification'],
        'institution' =>$_POST['institution'],
        'address_personal' =>$_POST['address_personal'],
        'telephone_personal' =>$_POST['telephone_personal'],
        'images'=>$_FILES['images']['name'],
        "newpersonal_picture"=> $newfilename,

          ]);
          if ($res) {
            echo "<script>
                    alert('เพิ่มข้อมูลบุคลากรเรียบร้อย')
                    window.location = 'home.php?file=personal/index';
                  </script>";
          }else {
            echo "<script>
                    alert('ผิดพลาด '".$query->errorInfo()[2].");
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

              <form class="form-horizontal">
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
                                  <input type="text" class="form-control"/>
                              </div>
                              <!-- <span class="help-block">This is sample of text field</span> -->
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">ชื่อ-นามสกุล</label>
                          <div class="col-md-6 col-xs-12">
                              <div class="input-group">
                                  <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                  <input type="password" class="form-control"/>
                              </div>
                              <!-- <span class="help-block">Password field sample</span> -->
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">วัน เดือน ปีเกิด</label>
                          <div class="col-md-6 col-xs-12">
                              <div class="input-group">
                                  <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                  <input type="text" class="form-control datepicker" value="2014-11-01">
                              </div>
                              <!-- <span class="help-block">Click on input field to get datepicker</span> -->
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">ที่อยู่</label>
                          <div class="col-md-6 col-xs-12">
                              <textarea class="form-control" rows="5"></textarea>
                              <!-- <span class="help-block">Default textarea field</span> -->
                          </div>
                      </div>

                      <!-- <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">Tags</label>
                          <div class="col-md-6 col-xs-12">
                              <input type="text" class="tagsinput" value="First,Second,Third"/>
                              <span class="help-block">Default textarea field</span>
                          </div>
                      </div> -->

                      <!-- <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">Select</label>
                          <div class="col-md-6 col-xs-12">
                              <select class="form-control select">
                                  <option>Option 1</option>
                                  <option>Option 2</option>
                                  <option>Option 3</option>
                                  <option>Option 4</option>
                                  <option>Option 5</option>
                              </select>
                              <span class="help-block">Select box example</span>
                          </div>
                      </div> -->

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">รูป</label>
                          <div class="col-md-6 col-xs-12">
                              <input type="file" class="fileinput btn-primary" name="filename" id="filename" title="Browse file"/>
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
                      <button class="btn btn-default">Clear Form</button>
                      <button class="btn btn-primary pull-right">Submit</button>
                  </div>
              </div>
              </form>

          </div>
      </div>

  <!-- </div> -->


</section>
