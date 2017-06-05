<?php
if(isset($_POST['ok'])){
  $query = $db->prepare("UPDATE personal SET
    name_personal = :name_personal,
    surname_personal = :surname_personal,
    ordinary_qualification = :ordinary_qualification,
    religion_qualification = :religion_qualification,
    institution = :institution,
    address_personal = :address_personal,
    telephone_personal = :telephone_personal
  WHERE personal.id_personal = :id ;");

  $result = $query->execute([
  "id" => $_GET["id"],
  'name_personal' => $_POST["name_personal"],
  'surname_personal' => $_POST["surname_personal"],
  'ordinary_qualification' => $_POST["ordinary_qualification"],
  'religion_qualification' => $_POST["religion_qualification"],
  'institution' => $_POST["institution"],
  'address_personal' => $_POST["address_personal"],
  'telephone_personal' => $_POST["telephone_personal"],
  ]);
if($result){
    echo "<script>alert('Update Successfully')
          window.location = 'home.php?file=personal/index';
          </script>";
}else{
    echo "<script>
          alert('Update fail! '".$query->errorInfo()[2].");
          </script>";
}
}

if(isset($_GET['id'])){
$query = $db->prepare("SELECT * FROM personal WHERE id_personal = :id");
$query->execute([
'id'=>$_GET['id']
]);//รัน sql
    $data = $query->fetch(PDO::FETCH_OBJ);
  }
?>


<section class="content">
  <!-- <div class="page-content-wrap"> -->

      <div class="row">
          <div class="col-md-12">

              <form class="form-horizontal" method="post" role="form"  enctype="multipart/form-data" >
              <div class="panel panel-default">
                  <div class="panel-heading ui-draggable-handle">
                      <h3 class="panel-title"><strong>จัดการข้อมูลบุคลากร</strong> </h3>
                      <ul class="panel-controls">
                          <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                      </ul>
                  </div>

                  <div class="panel-body">

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">ชื่อ</label>
                          <div class="col-md-6 col-xs-12">
                              <div class="input-group">
                                  <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                  <input type="text" class="form-control" id="name_personal" name="name_personal" value="<?=$data->name_personal?>"/>
                              </div>
                              <!-- <span class="help-block">This is sample of text field</span> -->
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">นามสกุล</label>
                          <div class="col-md-6 col-xs-12">
                              <div class="input-group">
                                  <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                  <input type="text" class="form-control" id="surname_personal" name="surname_personal" value="<?=$data->surname_personal?>"/>
                              </div>
                              <!-- <span class="help-block">This is sample of text field</span> -->
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">วุฒิการศึกษาสามัญ</label>
                          <div class="col-md-6 col-xs-12">
                              <div class="input-group">
                                  <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                  <input type="text" class="form-control" id="ordinary_qualification" name="ordinary_qualification" value="<?=$data->ordinary_qualification?>"/>
                              </div>
                              <!-- <span class="help-block">Password field sample</span> -->
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">วุฒิการศึกษาศาสนา</label>
                          <div class="col-md-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                <input type="text" class="form-control" id="religion_qualification" name="religion_qualification" value="<?=$data->religion_qualification?>"/>
                            </div>
                              <!-- <span class="help-block">Click on input field to get datepicker</span> -->
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">จบจากสถาบัน</label>
                          <div class="col-md-6 col-xs-12">
                              <textarea class="form-control" rows="5" id="institution" name="institution"><?=$data->institution?></textarea>
                              <!-- <span class="help-block">Default textarea field</span> -->
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">ที่อยู่</label>
                          <div class="col-md-6 col-xs-12">
                              <textarea class="form-control" rows="5" name="address_personal" id="address_personal" placeholder="ที่อยู่"><?=$data->address_personal?></textarea>
                              <!-- <span class="help-block">Default textarea field</span> -->
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">เบอร์โทรศัพท์</label>
                          <div class="col-md-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                <input type="text" class="form-control" name="telephone_personal" id="telephone_personal" placeholder="เบอร์โทรศัพท์" value="<?=$data->telephone_personal?>"/>
                            </div>
                              <!-- <span class="help-block">Click on input field to get datepicker</span> -->
                          </div>
                      </div>


                      <!-- <div class="form-group">
                          <label class="col-md-3 col-xs-12 control-label">รูป</label>
                          <div class="col-md-6 col-xs-12">
                              <input type="file" class="fileinput btn-primary" title="Browse file" type="file" name="personal_picture" value="<?=$data->personal_picture?>"  accept="image/*"/>
                          </div>
                      </div> -->


                  </div>
                  <div class="panel-footer">
                      <button class="btn btn-default" type="reset">Clear Form</button>
                      <button class="btn btn-primary pull-right" name="ok" type="submit" >Submit</button>
                  </div>
              </div>
              </form>

          </div>
      </div>

  <!-- </div> -->


</section>
