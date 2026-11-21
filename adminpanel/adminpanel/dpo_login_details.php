<?php
  include 'admin_master.php';
  ob_start();
  
  if(!checkLogin()){
    header('Location: login.php');

  }

  page_header_start('Admin Dashboard | ICDS | AWW Recruitment');
?>
<script type="text/javascript" src="../public/js/jquery-min.js"></script>

  
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
  
  ?>


        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:../../partials/_settings-panel.html -->
           
           
            <div id="right-sidebar" class="settings-panel">
                <i class="settings-close mdi mdi-close"></i>
                <ul class="nav nav-tabs" id="setting-panel" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="todo-tab" data-bs-toggle="tab" href="#todo-section" role="tab" aria-controls="todo-section" aria-expanded="true">TO DO LIST</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" id="chats-tab" data-bs-toggle="tab" href="#chats-section" role="tab" aria-controls="chats-section">CHATS</a>
                    </li> -->
                </ul>
                <div class="tab-content" id="setting-content">
                    <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
                        <div class="add-items d-flex px-3 mb-0">
                            <form class="form w-100">
                                <div class="form-group d-flex">
                                    <input type="text" class="form-control todo-list-input" placeholder="Add To-do">
                                    <button type="submit" class="add btn btn-primary todo-list-add-btn" id="add-task">Add</button>
                                </div>
                            </form>
                        </div>
                        <div class="list-wrapper px-3">
                            <ul class="d-flex flex-column-reverse todo-list">
                                
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox">
                                            Resolve all the low priority tickets due today
                                        </label>
                                    </div>
                                    <i class="remove mdi mdi-close-circle-outline"></i>
                                </li>
                                
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
                           <h4>DPO Login Data</h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="tbl" class="table">
                                            <thead>
                                                <tr>
                                                    <th width="20%">Serial</th>
                                                    <th>User ID</th>
                                                    
                                                    <th>District</th>
                                                    <th>Date & Time</th>
                                                    <th>IP</th>
                                                   
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_q="SELECT * FROM `admin_login_details` where user_type='DPO' order by timestamp DESC  limit 500";
                                                //echo $sql; die;
                                                $res=execute_query($sql_q);
                                                
                                                $i=1;
                                                while ($data = mysqli_fetch_assoc($res)) {

                                                    echo '<tr>
                                                        <td>'.$i++.'</td>
                                                        <td>'. $data['user_id'].'</td>
                                                        <td>'.strtoupper(getdistName($data['distid'])).'</td> 
                                                        <td>'.date("d-m-Y H:i:s",strtotime($data['timestamp'])).'</td> 
                                                        <td>'.$data['ip'].'</td> 
                                                       
                                                    </tr>';
                                                }?>
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
                          <label>Vacancy Available</label>  
                          <select name="vacancy" class="form-control">
                            <option>Select</option>
                            <option value="Yes">YES</option>
                            <option value="No">No</option>
                          </select>
                          <br />  
                          
                          <br />  
                          <input type="hidden" name="ag_center_id" id="ag_center_id" />  
                          <input type="submit" name="savevacancy" id="insert" value="Save" class="btn btn-success" />  
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
          
           $.ajax({  
                url:"ajax.php",  
                method:"POST",  
                data:{aganid:id},  
                dataType:"json",  
                success:function(data){   
                    $('#ag_center_id').val(data.id); 
                   // $('#ag_center_id').val(data.id); 
                     $('#add_data_Modal').modal('show');  
                }  
           });  
      });  


      $('#insert_form').on("submit", function(event){  
           event.preventDefault();  
           if($('#name').val() == "")  {  
                alert("Vacancy Available field required");  
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
                         
                     }  
                });  
           }  
      });  

      $(document).on('click', '.close', function(){ 
        $('#add_data_Modal').modal('hide');
      });
      
    }); 

   
</script>
                
                <!-- content-wrapper ends -->
        <?php page_footer(); ?>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.js"></script>

    <!-- Datatable Dependency end -->
                <script>
                    $(document).ready(function() {
            $('#tbl').DataTable({

                dom: 'Bfrtip',
                responsive: false,
                pageLength: 25,
                 lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],

                buttons: [
                    'copy', 'csv', 'excel',
                    {
                        extend: 'pdf',
                        title: 'DPO Login Details', // Set your custom title here
                        messageTop: 'ICDS admin report', // Optional message/heading
                        // customize: function (doc) {
                        //     doc.content[1].table.widths = ['10%', '25%', '25%', '25%', '15%'];  
                        //     doc.defaultStyle.fontSize = 10; // Set font size
                        // }
                    },
                    'print'
                ]

            });
        });
                </script>