<?php
include 'master.php';

if (!checkLogin()) {
    header('Location: login.php');
}

page_header_start('Admin Dashboard | ICDS | AWW Recruitment');

// Check if 'id' is set in the GET parameters
if (isset($_GET['id'])) {
    $uid = $_GET['id'];
} else {
    echo "Return Back";
    die;
}


page_header_end();

navigation();
?>

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
        <!-- Loader HTML -->
        <div id="loader" class="loader"></div>

        <div class="content-wrapper">
            <h4 class="card-title">Uploaded File</span></h4>
            <div class="card">
                <div class="card-body">

                    <?php
                    $sql="select isnew from users where id='".$uid."'";
                    $res=execute_query($sql);
                    $data=mysqli_fetch_assoc($res);
                    // URL of the directory containing the files
                    $directoryUrl = 'https://34.116.192.0/uploads/' . $uid . '/'; // Use uid for dynamic folder access
                    if ($data['isnew']=='1') {
                        $directoryUrl = 'http://34.118.8.62/newuploads/' . $uid . '/';
                    }
                    $directoryUrlss = 'http://34.116.192.0/uploads/' . $uid . '/';
                    if ($data['isnew']=='1') {
                        $directoryUrl = 'http://34.118.8.62/newuploads/' . $uid . '/';
                    }
                    // Context options to disable SSL verification (only for testing)
                    $contextOptions = array(
                        "ssl" => array(
                            "verify_peer" => false,
                            "verify_peer_name" => false,
                        ),
                    );

                    $context = stream_context_create($contextOptions);

                    // Fetch directory contents
                    $response = @file_get_contents($directoryUrl, false, $context); // Suppress warnings

                    if ($response === FALSE) {
                        die("Error: Unable to retrieve directory contents.");
                    }

                    // Extract file links from directory listing
                    preg_match_all('/<a href="([^"]+)">([^<]+)<\/a>/', $response, $matches);

                    $files = $matches[1];  // File links
                    $fileNames = $matches[2];  // File names

                    // Remove irrelevant elements (e.g., "Name", "Last modified", etc.)
                    $fileNames = array_slice($fileNames, 5); // Skipping first 5 elements

                    if (count($fileNames) > 0) {
                        echo "All Files:<br>";
                        echo '<div class="row"> <div class="col-md-10"><input type="checkbox" name="checkbox" id="checkAll" /> Check All </div> <div class="col-md-2"><button type="button" class="btn btn-sm btn-success" id="download">Zip Download</button></div></div>';
                        $i = 1;
                        foreach ($fileNames as $fileName) {
                            $fileUrl = $directoryUrl . $fileName;
                            $fileUrlss = $directoryUrlss . $fileName;
                            echo '<ol class="list-group">
                        <li class="list-group-item">
                        <input type="checkbox" name="downloadZip" value="' . urlencode($fileUrlss) . '">
                        ' . $i . '. 
                        <a href="downloaduserfile.php?file=' . urlencode($fileUrl) . '" target="_blank">Document-' . $i++ . ' Download</a>
                        </li>
                        </ol>';
                            // Create a download link for each file
                            // Full URL for the file
                            // echo '<a href="downloaduserfile.php?file=' . urlencode($fileUrl) . '" target="_blank">' . htmlspecialchars($fileName) . '</a><br>';
                        }
                    } else {
                        echo "No files found in the directory.";
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#download').hide();
    $('#checkAll').click(function() {

        if (this.checked == true) {
            $('#download').show();
        } else {

            $('#download').hide();
        }
        $('.card-body input[type="checkbox"]').prop('checked', this.checked);
    });

    $('input[type="checkbox"]').click(function() {
        let array = []; 
        $("input:checkbox[name=downloadZip]:checked").each(function() { 
                array.push($(this).val()); 
            });  
            if(array.length >0){
            $('#download').show();
        } else {

            $('#download').hide();
        }

    });

    $("#download").click(function(){
      
        let array = []; 
        $("input:checkbox[name=downloadZip]:checked").each(function() { 
                array.push($(this).val()); 
            });  

            window.open("zipdownloaduserfile.php?file="+array);
           //window.location.href="zipdownloaduserfile.php?file="+array;
    })
</script>