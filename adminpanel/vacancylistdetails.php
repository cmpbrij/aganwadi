<?php
  include 'master.php';
  ob_start();
  
  if(!checkLogin()){
    header('Location: login.php');

  }

  page_header_start('Admin Dashboard | ICDS | AWW Recruitment');
?>
<!-- <script type="text/javascript" src="../public/js/jquery-min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toaster/4.0.1/css/bootstrap-toaster.min.css" integrity="sha512-RLiJ5uLcu8jWxsJBevOZWLU0zWv51vwpha0Gh4jRKOqkcWbVR7+U8kKaiGsMhSua3fIkviCHRClSH+XZYKIoZA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toaster/4.0.1/css/bootstrap-toaster.css" integrity="sha512-BqX9iUcQY8V8QeSbSjk/vL2CQk8TT5SEp8OeuRO6MMSYfRtVE0DW4eqjmD7Iew2XAoa+iEXIkJQPYXaP0FqWrA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toaster/4.0.1/js/bootstrap-toaster.js" integrity="sha512-4JwsWzz1l6JIsCUPi1bopU+79qHRCUlOJhYapg5dRuXjFFgXPazVnoOgrvrUMckjJl6LPOM4GncDv3ilou8avQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toaster/4.0.1/js/bootstrap-toaster.min.js" integrity="sha512-YmkrdAXo8RdHV1JFfepR7QWLDfF7vs8Mc/t+6qKIxrEFeWbi0u/lajryYSPK6GC5nupW5t6XfPdxQpIY79+USg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
  
<!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.css" />
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
  
  <style> 
    .info{color:#ffc100;}
  </style>
  <?php

  page_header_end();

  navigation();
  
  if(isset($_SESSION['adminid'])){
    $q="select * from admin_users where id='".$_SESSION['sid']."'";
    $res= execute_query($q);
    $adata=mysqli_fetch_assoc($res);
  }
  if(isset($_GET['gpid'])){
      
        
  }
  ?>


        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:../../partials/_settings-panel.html -->
           
           
            <div id="right-sidebar" class="settings-panel">
                <i class="settings-close mdi mdi-close"></i>
                <ul class="nav nav-tabs" id="setting-panel" role="tablist">
                   
                    <!-- <li class="nav-item">
                        <a class="nav-link" id="chats-tab" data-bs-toggle="tab" href="#chats-section" role="tab" aria-controls="chats-section">CHATS</a>
                    </li> -->
                </ul>
                <div class="tab-content" id="setting-content">
                    <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
                        <div class="add-items d-flex px-3 mb-0">
                           
                        </div>
                        <div class="list-wrapper px-3">
                            <ul class="d-flex flex-column-reverse todo-list">
                              
                                
                            </ul>
                        </div>
                        
                    </div>
                    <!-- To do section tab ends -->
                    
                    <!-- chat tab ends -->
                </div>
            </div>
            <!-- partial -->
            <?php sidebar(); ?>
                        <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Project Name  - <span class="info"><?php echo getProjectname($_GET['pid']); ?></span></h4>
                            <h4 class="card-title">Gram Panchayat/Ward  - <span class="info"><?php echo getGrampanchayatName($_GET['gpid']); ?></span></h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="table_id" class="table">
                                            <thead>
                                                <tr>
                                                    <th width="10%">Serial</th>
                                                    <th>Center Name</th>
                                                    <th>Unique Code</th>
                                                    <th>Category</th>
                                                    <th>EWS</th>
                                                    <th>Vacancy Available</th>
                                                    <!-- <th style="background-color:antiquewhite;">Action</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_q="SELECT * FROM `vacancy_order` WHERE dist_id='".$_SESSION['distid']."'";
                                                //echo $sql; die;
                                                $res_q=execute_query($sql_q);
                                                if(mysqli_num_rows($res_q) > 0){
                                                    $disable='disabled';
                                                   // die;
                                                }
                                                else{
                                                    $disable='';
                                                }
                                                $i=1;
                                                $sql1="SELECT * FROM `new_vacancy` WHERE gram_panchayat_id='".$_GET['gpid']."' and project_id='".$_GET['pid']."' AND district_id='".$_SESSION['distid']."' order by unique_code";
              //  echo $sql1; 
                                                 $gres=execute_query($sql1);
                                                 while ($data = mysqli_fetch_assoc($gres)) {
                                                    if($data['updated_status'] == 'R'){
                                                        $col='red';
                                                        $rmsg='<span style="color:green;font-weight:400;">Request send for approval</span>';
                                                    }else{
                                                        $col="";
                                                        $rmsg='';
                                                    }
                                                    
                                                    
                                                    echo '<tr style="background-color:'.$col.'">
                                                        <td>'. $i++.'</td>
                                                        <td>'. strtoupper($data['awc_name']).'</td>
                                                        <td>'.$data['unique_code'].'</td> 
                                                        <td>'.getCategoryTexteng($data['category']).'</td> 
                                                        <td>'.ewstext($data['ews']).'</td> 
                                                        <td>'.$data['vacancy_available'].'<br>'. $rmsg.'</td> 
                                                       
                                                        ';
                                                    ?>
                                                       
                                                    </tr>
                                                <?php
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              
 <div id="add_data_Modal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">  
                <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Update avilability of vacancy</h4>  
                </div>  
                <div class="modal-body">  
                     <form method="post" id="insert_form">  
                          <label>Vacancy Available*</label> <br> 
                          <select name="vacancy" id='vacany' class="form-control" required>
                          
                            <option value="Yes">YES</option>
                            <option value="No">NO</option>
                          </select>
                          <br />  
                          <label>Category*</label> <br> 
                          <select name="category" id="category"  class="form-control" required>
                           
                          <option value="6">Unreserved(UR)</option>
                            <!-- <option value="1">General(GEN)</option> -->
                            <option value="2">Other Backward Caste(OBC)</option>
                            <option value="3">Scheduled Caste(SC)</option>
                            <option value="4">Scheduled Tribes(ST)</option>
                             <option value="5">Economically Weaker Section(EWS)</option>
                          </select><br>
                          <label>EWS*</label> <br> 
                          <select name="ews" id="ews" class="form-control" required>
                            <option value="1">YES</option>
                            <option value="0">NO</option>
                          </select>
                         
                          
                          <br/>  
                          <input type="hidden" name="ag_center_id" id="ag_center_id" />
                          <div class="col-12 text-center">  
                             <input type="submit" name="savevacancy" id="insert" value="Save" class="btn btn-success" />  
                          </div>
                     </form>  
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default close" data-dismiss="modal">Close</button>  
                </div>  
           </div>  
      </div>  
 </div>  
<script>
 $(document).ready(function(){  
      $(document).on('click', '.edit_data', function(){  
           var id = $(this).attr("id");  
           //alert(id);
          
           $.ajax({  
                url:"ajax.php",  
                method:"POST",  
                data:{aganid:id},  
                dataType:"json",  
                success:function(data){   
                    $('#ag_center_id').val(data.id); 
                    $('#vacany').val(data.vacancy_available); 
                    $('#category').val(data.category).change();;
                    //$('#ews').val(data.ews);
                    $('#ews').val(data.ewsid).change();
                     $('#add_data_Modal').modal('show');  
                }  
           });  
      });  


      $('#insert_form').on("submit", function(event){  
           event.preventDefault();  
           if($('#vacancy').val() == "")  {  
                alert("Please select Vacancy Available!");  
               
           }  
           if($('#category').val() == "")  {  
                alert("Please select category!");  
               
           }  
           if($('#ews').val() == "")  {  
                alert("Please select EWS!");  
               
           }  
           else {  
                $.ajax({  
                     url:"ajax.php",  
                     method:"POST",  
                     data:$('#insert_form').serialize(),  
                     beforeSend:function(){  
                          $('#insert').val("Inserting");  
                     },  
                     success:function(data){  
                         $('#insert_form')[0].reset();  
                         $('#add_data_Modal').modal('hide');  
                         location.reload();
                          alert('Request send for approval!');
                         
                     }  
                });  
           }  
      });  

      $(document).on('click', '.close', function(){ 
        $('#add_data_Modal').modal('hide');
      });
      
    }); 
</script>
 <?php page_footer(); ?>
    <script>
        $(document).ready(function() {
            $('#table_id').DataTable({

                dom: 'Bfrtip',
                responsive: false,
                pageLength: 25,
                 lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],

                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]

            });
        });
    </script>