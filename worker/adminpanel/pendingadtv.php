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
        font-weight: 400 !important;
        font-size: 18px !important;
   }
   .container-fluid {
        padding-left:0px;
        padding-right:0px;
    }
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
                            <h4 class="card-title"> Distric Wise Pending Advertisement</h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="table_id">
                                            <thead>
                                                <tr>
                                                    <th width="10%">Serial</th>
                                                    <th>District Name</th>
                                                    
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                
                                                $sql = "SELECT d.id AS district_id, d.district_name
                                                    FROM districts d
                                                    LEFT JOIN vacancy_order v 
                                                        ON d.id = v.dist_id
                                                    WHERE v.dist_id IS NULL;
                                                    ";
                                                $res=execute_query($sql);
                                                $i=1;
                                                while ($data = mysqli_fetch_assoc($res)) { 
                                                   
                                                    ?>
                                                
                                                     <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td> <?php echo $data['district_name']; ?></td>
                                                       
                                                    </tr>
                                               <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <?php page_footer(); ?>
                <!-- Datatable Dependency start -->
    
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.js"></script>

    <!-- Datatable Dependency end -->
       <script>
$(document).ready(function() {
    $('#table_id').DataTable({

        dom: 'Bfrtip',
        responsive: false,
        pageLength: 25,

        buttons: [
            'copy', 'csv', 'excel',
            {
                extend: 'pdf',
                title: 'Distric Wise Pending Advertisement',
                messageTop: 'ICDS Admin Report',
            },
           {
    extend: 'print',
    title: 'Distric Wise Pending Advertisement',
    messageTop: '<h3 style="text-align:center;">ICDS Admin Report</h3>',
    customize: function (win) {

        // Inject custom print CSS
        var css = `
            table.dataTable {
                border-collapse: collapse !important;
                width: 100% !important;
            }
            table.dataTable th, table.dataTable td {
                text-align: center !important;
                vertical-align: middle !important;
                border: 1px solid #000 !important;
                padding: 6px !important;
                font-size: 16px !important;
            }
            h1 {
                text-align: center !important;
                font-size: 22px !important;
                margin-bottom: 20px !important;
            }
            body {
                margin: 20px !important;
            }
        `;

        var head = win.document.head || win.document.getElementsByTagName('head')[0];
        var style = win.document.createElement('style');
        style.type = 'text/css';
        style.appendChild(win.document.createTextNode(css));
        head.appendChild(style);

        // Ensure table width is proper
        $(win.document.body).find('table')
            .addClass('compact')
            .css('width', '100%');
    },
    
}

        ]

    });
});
</script>
