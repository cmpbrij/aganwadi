<?php
include 'admin_master.php';
ob_start();

if(!checkLogin()){
  header('Location: login.php');

}
page_header_start('Admin Dashboard | ICDS | AWW Recruitment');
?>

<style>
   .dataTables_wrapper .dataTable tbody tr td {
       
        font-size: 14px !important;
        font-weight: 350;
   }
   thead{
    font-size: 16px !important;
    
   }
</style>
  
<?php
page_header_end();
navigation();

?>


      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
          <!-- partial:../../partials/_settings-panel.html -->
         
         
          <div id="right-sidebar" class="settings-panel">
             
              <div class="tab-content" id="setting-content">
                  <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
                      
                      <div class="list-wrapper px-3">
                        
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
                            <h4 class="card-title">Vacancy updated details - <?php echo getdistName($_GET['distid']); ?></h4>
                            <div class="row">
                                <div class="col-12">
                                <div class="table-responsive">
                                    <table id="table" class="table">
                                    <thead>
                                        <tr>
                                            <th>Serial</th>
                                            <th>Project Name</th>
                                            <th>Grampanchyat/Ward</th>
                                            <th>AWC Name & Code</th>
                                            <th>Current Details</th>
                                            <th>Updated Details</th>
                                            <th>Updated Date & Time</th>
                                            <th>Remarks</th>
                                            <th>Approve/Reject</th> 
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $did=$_GET['distid'];
                                            $sql1="SELECT                                
                                                g.gram_panchayat_name,
                                                p.project_name,
                                                n.awc_name,
                                                n.id,
                                                n.unique_code,
                                                n.category,
                                                n.district_id,
                                                n.vacancy_available,
                                                n.ews,
                                                ve.isvacancy,
                                                ve.category AS cat,
                                                ve.ews AS ewsr,
                                                ve.pre_vacancy,
                                                ve.pre_category,
                                                ve.pre_ews,
                                                ve.timestamp,
                                                ve.remarks,
                                                ve.status,ve.approved_timestamp
                                            FROM 
                                                new_vacancy n
                                            JOIN 
                                                gram_panchayat g ON n.gram_panchayat_id = g.id
                                            JOIN 
                                                projects p ON n.project_id = p.id
                                            JOIN 
                                                vacancy_edit_details ve ON ve.centerid = n.id
                                            WHERE districtid='".$did."' AND ve.approved_by !=''";
                                           // echo $sql1;
                                            $res1=execute_query($sql1);
                                            $i=1;
                                            while($row=mysqli_fetch_assoc($res1)){
                                              
                                                echo'<tr>
                                                        <td>'.$i++.'</td>
                                                        <td>'.ucfirst($row['project_name']).'</td>
                                                         <td>'.ucfirst($row['gram_panchayat_name']).'</td>
                                                           <td>'.$row['awc_name'].'<br>'.$row['unique_code'].'</td>
                                                        
                                                        <td> Vacant - '.$row['pre_vacancy'].'
                                                        <br>Category -'.getCategoryTexteng($row['pre_category']).'<br>
                                                         EWS - '.ewstext($row['pre_ews']).'</td>
                                                         <td> Vacant - '.$row['vacancy_available'].'
                                                      
                                                        <br> Category -'.getCategoryTexteng($row['cat']).'<br>
                                                         EWS - '.ewstext($row['ews']).'</td>
                                                        <td>'.$row['approved_timestamp'].'</td>
                                                        <td>'.$row['remarks'].'</td>';
                                                        if($row['status']=='Reject'){
                                                         echo'<td><button class="btn btn-danger" type="button">'.$row['status'].'</button></td>';
                                                        }
                                                        else{
                                                            echo'<td><button class="btn btn-success" type="button">'.$row['status'].'</button></td>';
                                                        }

                                                       
                                                       echo'<td>

                                                       </td>
                                                       
                                                    </tr>';

                                            }
                                            
                                            
                                        ?>
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
                     <h4 class="modal-title">Requested details</h4>  
                </div>  
                <div class="modal-body">  
                     <form method="post" id="insert_form">  
                          <label>Vacancy Available*</label> <br> 
                          <!-- <select name="vacancy" id='vacany' class="form-control">
                            <option value="Yes">YES</option>
                            <option value="No"> NO</option>
                          </select> -->
                          <input type="text"  name="vacany" id="vacany" class="form-control" readonly>
                          <br/>  
                          <label>Category*</label> <br> 
                          <input type="text"  name="category" id="category" class="form-control" readonly><br>
                          <!-- <select name="category" id="category"  class="form-control">
                            <option value="UR">Unreserved(UR)</option>
                            <option value="GEN">General(GEN)</option>
                            <option value="OBC">Other Backward Caste(OBC)</option>
                            <option value="SC">Scheduled Caste(SC)</option>
                            <option value="ST">Scheduled Tribes(ST)</option>
                          </select><br> -->
                          <label>EWS*</label> <br> 
                          <input type="text"  name="ews" id="ews" class="form-control" readonly>
                          <!-- <select name="ews" id="ews" class="form-control">
                            <option value="Yes">YES</option>
                            <option value="No">NO</option>
                          </select> -->
                          <label>Reject Remarks*</label> <br> 
                          <textarea class="form-control" name="remarks"></textarea>
                          <br />  
                         
                          <input type="hidden" name="aww_center" id="aww_center" />
                          <input type="hidden" name="AdminAganwadi" id="AdminAganwadi" />
                          <div class="col-12 text-center">  
                             <input type="submit" name="savevacancy" id="insert" value="Reject" class="btn btn-danger" />
                             <!-- <input type="submit" name="savevacancy" id="insert" value="Reject" class="btn btn-danger" />   -->
                          </div>
                     </form>  
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default close" data-dismiss="modal">Close</button>  
                </div>  
           </div>  
      </div>  
 </div>  

 <div id="approve_v" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">  
                <button type="button" class="close1" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Requested details</h4>  
                     Apporve
                </div>  
                <div class="modal-body">  
                     <form method="post" id="insert_form1">  
                          <label>Vacancy Available*</label> <br> 
                          <!-- <select name="vacancy" id='vacany' class="form-control">
                            <option value="Yes">YES</option>
                            <option value="No"> NO</option>
                          </select> -->
                          <input type="text"  name="vacany1" id="vacany1" class="form-control" readonly>
                          <br/>  
                          <label>Category*</label> <br> 
                          <input type="text"  name="category1" id="category1" class="form-control" readonly><br>
                          <!-- <select name="category" id="category"  class="form-control">
                            <option value="UR">Unreserved(UR)</option>
                            <option value="GEN">General(GEN)</option>
                            <option value="OBC">Other Backward Caste(OBC)</option>
                            <option value="SC">Scheduled Caste(SC)</option>
                            <option value="ST">Scheduled Tribes(ST)</option>
                          </select><br> -->
                          <label>EWS*</label> <br> 
                          <input type="text"  name="ews1" id="ews1" class="form-control" readonly>
                          <!-- <select name="ews" id="ews" class="form-control">
                            <option value="Yes">YES</option>
                            <option value="No">NO</option>
                          </select> -->
                          <label>Accept Remarks</label> <br> 
                          <textarea class="form-control" name="remarks1"></textarea>
                          <br />  
                          <input type="hidden" name="aww_center1" id="aww_center1" />
                          <input type="hidden" name="AdminAganwadi1" id="AdminAganwadi1" />
                          <div class="col-12 text-center">  
                             <input type="submit" name="savevacancy" id="insert1" value="Approve" class="btn btn-success" />
                             <!-- <input type="submit" name="savevacancy" id="insert" value="Reject" class="btn btn-danger" />   -->
                          </div>
                     </form>  
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default close1" data-dismiss="modal">Close</button>  
                </div>  
           </div>  
      </div>  
 </div>  
              
              <!-- content-wrapper ends -->
              <?php page_footer(); ?>
              
    <!-- Datatable Dependency end -->
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
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

<script>
 $(document).ready(function(){  
      $(document).on('click', '.edit_data', function(){  
           var id = $(this).attr("id");  
           //alert(id);
           $('#vacancy, #category, #ews').prop('disabled', false);
           $.ajax({  
                url:"ajax.php",  
                method:"POST",  
                data:{Adminaganid:id},  
                dataType:"json",  
                success:function(data){   
                    // alert(data.isvacancy);
                    $('#AdminAganwadi').val(data.id); 
                    $('#vacany').val(data.isvacancy); 
                    $('#category').val(data.category)
                    $('#ews').val(data.ews);
                    $('#aww_center').val(data.centerid);
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
                        //   $('#insert_form')[0].reset();  
                        //   $('#add_data_Modal').modal('hide');  
                        //   location.reload();
                          alert('Vacancy details updated successfully!');
                         
                     }  
                });  
           }  
      });  

      $(document).on('click', '.close', function(){ 
        $('#add_data_Modal').modal('hide');
      });
      
    }); 
</script>

<script>
 $(document).ready(function(){  
      $(document).on('click', '.app_data', function(){  
           var id = $(this).attr("id");  
         
           $('#vacancy1, #category1, #ews1').prop('disabled', false);
           $.ajax({  
                url:"ajax.php",  
                method:"POST",  
                data:{Adminaganid:id},  
                dataType:"json",  
                success:function(data){   
                    // alert(data.isvacancy);
                    $('#AdminAganwadi1').val(data.id); 
                    $('#vacany1').val(data.isvacancy); 
                    $('#category1').val(data.category)
                    $('#ews1').val(data.ews);
                    $('#aww_center1').val(data.centerid);
                    $('#approve_v').modal('show');  
                }  
           });  
      });  


      $('#insert_form1').on("submit", function(event){  
           event.preventDefault();  
           alert($('#vacany1').val());
           alert($('#category1').val());
           alert($('#ews1').val());
           if($('#vacancy1').val() == "")  {  
                alert("Please select Vacancy Available!");  
               
           }  
           if($('#category1').val() == "")  {  
                alert("Please select category!");  
               
           }  
           if($('#ews1').val() == "")  {  
                alert("Please select EWS!");  
               
           }  
          
           else {  
                $.ajax({  
                     url:"ajax.php",  
                     method:"POST",  
                     data:$('#insert_form1').serialize(),  
                     beforeSend:function(){  
                          $('#insert1').val("Inserting");  
                     },  
                     success:function(data){  
                    //       $('#insert_form1')[0].reset();  
                    //       $('#approve_v').modal('hide');  
                    //       location.reload();
                          alert('Vacancy details updated successfully!');
                         
                     }  
                });  
           }  
      });  

      $(document).on('click', '.close1', function(){ 
      
        $('#approve_v').modal('hide');
      });
 });
      </script>