
<section class="content">
      <div class="row">
              <div class="col-md-12">



                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">ข้อมูลบุคลากรโรงเรียน</h3>
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>


                                          <div class="btn-group pull-right">
                                              <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                              <ul class="dropdown-menu">
                                                  <li class="divider"></li>
                                                  <li><a href="#" onClick ="$('#DataTables_Table_0').tableExport({type:'excel',escape:'false'});"><img src='../images/icons/xls.png' width="24"/> XLS</a></li>
                                                  <li><a href="#" onClick ="$('#DataTables_Table_0').tableExport({type:'doc',escape:'false'});"><img src='../images/icons/word.png' width="24"/> Word</a></li>
                                                  <li><a href="#" onClick ="$('#DataTables_Table_0').tableExport({type:'powerpoint',escape:'false'});"><img src='../images/icons/ppt.png' width="24"/> PowerPoint</a></li>
                                                  <!-- <li class="divider"></li> -->
                                                  <li><a href="#" onClick ="$('#DataTables_Table_0').tableExport({type:'png',escape:'false'});"><img src='../images/icons/png.png' width="24"/> PNG</a></li>
                                                  <li><a href="#" onClick ="$('#DataTables_Table_0').tableExport({type:'pdf',escape:'false'});"><img src='../images/icons/pdf.png' width="24"/> PDF</a></li>
                                                  <li><a href="#" onClick ="$('#DataTables_Table_0').tableExport({type:'sql'});"><img src='../images/icons/sql.png' width="24"/> SQL</a></li>
                                              </ul>
                                          </div>

                                </div>




                                <div class="panel-body">
                                    <table class="table datatable dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>รูป</th>
                                                <th>ชื่อ</th>
                                                <th>นามสกุล</th>
                                                <th>วุฒิการศึกษาสามัญ</th>
                                                <th>วุฒิการศึกษาศาสนา</th>
                                                <th>จบจากสถาบัน</th>
                                                <th>ที่อยู่</th>
                                                <th>เบอร์โทรศัพท์</th>
                                                <th>วันที่สมัคร</th>
                                                <th>จัดการ</th>

                                                <!-- <th>Salary</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                          $query = $db->prepare("SELECT * FROM personal ");//เตรียมคำสั่ง sql
                                          $query->execute();

                                          if($query->rowCount()>0){

                                          $data = $query->fetchAll(PDO::FETCH_OBJ);
                                          foreach ($data as $k => $row ) {
                                            ?>
                                            <tr role="row" class="odd">
                                              <td><?=($k+1)?></td>
                                              <td class="sorting_1"><img  class="style_prevu_kit" src="../images/personal/<?=$row->newpersonal_picture?>"</td>
                                              <td><?=$row->name_personal?></td>
                                              <td><?=$row->surname_personal?></td>
                                              <td><?=$row->ordinary_qualification?></td>
                                              <td><?=$row->religion_qualification?></td>
                                              <td><?=$row->institution?></td>
                                              <td><?=$row->address_personal?></td>
                                              <td><?=$row->telephone_personal?></td>
                                              <td><?=$row->date_register?></td>

                                              <td>
                                                &nbsp;&nbsp;<a href="home.php?file=personal/view&id=<?=$row->id_personal?>"><i class='fa fa-eye'></i></a>&nbsp;

                                                <a href="home.php?file=personal/del&id=<?=$row->id_personal?>&personal_picture=<?=$row->personal_picture?>"><i class='fa fa-trash-o'></i></a>&nbsp;
                                                <a href="home.php?file=personal/update1&id=<?=$row->id_personal?>"><i class='fa fa-pencil-square-o'></i></a>

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

                <script type="text/javascript">
                  larguraDisponivel = 600;
                  alturaDisponivel  = 400;

                  // Size img
                  $('.imagem_zoom img').each(function(){
                  larguraImg = $(this).width();
                  alturaImg  = $(this).height();

                  //value Left
                  val_left = (larguraImg - larguraDisponivel) / 2;
                  //value top
                  val_top = (alturaImg - alturaDisponivel) / 2;

                  //Put values in css
                  $(this).css({'left' : -val_left, "top" : -val_top});
                  });
                </script>
