<?php

include('../config/settings.php');
include('../config/db_config.php');
// if(!$_SESSION['log']){
//   header('Location: login.php');
// }
if (isset($_SESSION['uid'])) {
    $sql = "SELECT * FROM users WHERE `id`='" . $_SESSION['uid'] . "'";
    $res = $conn->query($sql);
    $data = mysqli_fetch_assoc($res);

    $sql = "";
    //print_r($data); die;
}

if (isset($_SESSION['declearation'])) {
    $sql = "";
}
topheader();

?>
<!doctype html>
<!-- <html lang="{{str_replace('_', '-', app()->getLocale())}}"> -->
<html>
<title>Registration : Anganwadi Recruitment 2024, Lucknow, India</title>
<meta charset="utf-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="csrf-token" content="O9mUTOIwJ98dHE8ncyPuGeXHGQNe6Ctjpf9lCdBX" />
<link rel="shortcut icon" href="../public/images/favicon.png" />
<link href="../public/css/bootstrap.css" rel='stylesheet' />
<link href="../public/css/all.css" rel="stylesheet" />
<link href="../public/css/custom_theme_student.css" rel="stylesheet" />
<link href="../public/css/preview-form.css" rel="stylesheet" />
<!-- <link href="https://apps.bhatkhandeuniversity.ac.in/public/css/default.css" rel="stylesheet" /> -->
<link href="../public/css/responsive.css" rel="stylesheet" />
<link href="../public/css/select2.min.css" rel="stylesheet" />
<script type="text/javascript" src="../public/js/jquery-min.js"></script>
<link href="../public/css/js_latest_toastr.min.css" rel="stylesheet" />
<link href="../public/css/dataTables.bootstrap5.min.css" rel='stylesheet' />
<link href="../public/css/draggle.css" rel="stylesheet">
<link rel="stylesheet" href="../public/css/multilevel-form.css">



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    .loader {
        width: 48px;
        height: 48px;
        border: 2px solid #128cbc;
        border-radius: 50%;
        display: inline-block;
        position: absolute;
        box-sizing: border-box;
        animation: rotation 1s linear infinite;
        z-index: 9999999999;
        top: 50%;
        left: 50%;
        transform: translate(-50%)
    }

    .loader::after,
    .loader::before {
        content: '';
        box-sizing: border-box;
        position: absolute;
        left: 0;
        top: 0;
        background: #FF3D00;
        width: 6px;
        height: 6px;
        transform: translate(150%, 150%);
        border-radius: 50%;
    }

    .loader::before {
        left: auto;
        top: auto;
        right: 0;
        bottom: 0;
        transform: translate(-150%, -150%);
    }

    @keyframes rotation {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .screen {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        backdrop-filter: blur(1.5px);
        z-index: 99999;
    }

    a.not-allowed {
        cursor: not-allowed !important;
        pointer-events: none;
    }

    .active-tab {
        background: #ffdebb;
        border-bottom: 1px solid #ef8937;
    }
</style>


<body class="dashbg">

    <div class="screen" style="display: none"> <span class="loader"></span> </div>

    <header class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-2 text-center col-md-1 b-rights px-0"><img src="../public/images/logo.png" alt="" class="dash-logo" /></div>
                <div class="col-9 col-md-9 px-0">
                    <h4 class="moudlename">Anganwadi Recruitment Uttar Pradesh</h4>
                    <!-- <h5 class="dash-head">Previously known as Bhatkhande Music Institute Deemed to be University, -->
                    <!-- Lucknow</h5> -->
                </div>
                <div class="col px-0 text-end" style="display: block ruby;">



                    <a href="javascript::void(0)" class="profileicon"><img src="../public/images/profile2.png" /></a>
                    <div class="sidebar">
                        <div class="profiletitle"> <span class="text-uppercase">Applicant Name</span> <span>Last Login :

                            </span></div>
                        <div class="scrollwrap">
                            <div class="nano-content">
                                <ul class="navsidebar">

                                    <li class="nav-item">
                                        <a href=""><span class="icons icon-speedometer"></span> Dashboard </a>

                                    </li>
                                    <li class="nav-item"> <a href=""><span class="icons icon-user"></span> Profile</a> </li>
                                    <li class="nav-item"> <a href=""><span class="icons icon-lock-open"></span>Change
                                            Password</a> </li>

                                </ul>
                            </div>
                        </div>
                        <div class="logoutbutton"><a href="{{route('student.logout')}}"><span class="fas fa-power-off"></span>&nbsp;&nbsp;Logout</a></div>
                    </div>

                </div>
            </div>
        </div>
    </header>
    <div class="contentwraper">


        <div class="container-fluid">

            <div class="row mt-3">
                <br>
                <div class="col-md-1 col-2 ">
                    <a title="Dashboard" href="student_dashboard.html" style="color: #282d6a;" class="intentbtn">
                        <span class="intenticon">
                            <span class="icons icon-home" style="font-size: 32px;"></span>
                        </span></a>
                </div>

                <div class="col-md-3 col-10"> <a href="#" class="intentbtn bg-c-yellow">
                        <span class="intenticon">
                            <img src="../public/images/icon1.png">
                        </span> <span class="intentdata"> <b class="intentno"></b> Anganwadi Application Form </span> </a>
                </div>



            </div>

            <!-- <div class="border bg-light p-2 mb-2">
      <div class="row">
                <div class="col-md-4 col-12 text-center"> <strong> Applicant's Name </strong>:   Sanchita Gupta </div>
    
                
                <div class="col-md-4 col-12 text-center"> <strong>Mobile No.</strong> : 9140942152</div>
      
                <div class="col-md-4 col-12 text-center"><strong>Category</strong>  : Backward </div>
      
            </div> 
            </div>  -->
        </div>



    </div>

    <div class="card">
        <div class="card-body">

            <!-- <h2>Preview Form</h2> -->
            <div class="headingTopMain">
                आंगनबाड़ी कार्यकत्रियों, मिनी आंगनबाड़ी कार्यकत्रियों. एवं सहायिकाओं की
                मानदेय पर संविदा आधारित नियुक्ति
                <br />आवेदन पत्र
                <br />
                बाल विकास परियोजना बैतालपुर जनपद: देवरिया
            </div>
            <div class="headingTop">
                <div class="left">पंजीकरण संख्या: 190/99999999</div>
                <div class="right">आवेदन तिथि: 12/12/12</div>
            </div>
            <table style="width: 100%">
                <thead>
                    <tr>
                        <td style="width: 5%"></td>
                        <td style="width: 30%">पद का नाम:</td>
                        <td style="width: 60%">आगनबाडी कार्यकत्री</td>
                        <td rowspan="6" style="width: fit-content !important">
                            <img src="https://www.w3schools.com/howto/img_avatar2.png" style="height: 20vh" />
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 5%"></td>
                        <td style="width: 30%">रिक्त केंद्रो का कोड</td>
                        <td>987678909</td>
                    </tr>
                    <tr>
                        <td style="width: 5%"></td>
                        <td style="width: 30%">रिक्त केंद्रो का नाम</td>
                        <td>धमोली </td>
                    </tr>
                    <tr>
                        <td style="width: 5%">1</td>
                        <td style="width: 30%">ग्राम सभा/वार्ड का नाम</td>
                        <td>धमोली /वार्ड नंबर 3</td>
                    </tr>
                    <tr>
                        <td style="width: 5%">2</td>
                        <td style="width: 30%">आवेदिका का नाम</td>
                        <td>राम कुमारी</td>
                    </tr>
                    <tr>
                        <td style="width: 5%"></td>
                        <td style="width: 30%">वैवाहिक स्थिति</td>
                        <td>विवाहिता</td>
                    </tr>
                    <tr>
                        <td style="width: 5%">3</td>
                        <td style="width: 30%">पति का नाम</td>
                        <td colspan="2">रामकुमार प्रसाद</td>
                    </tr>
                    <tr>
                        <td style="width: 5%">4</td>
                        <td style="width: 30%">पति का नाम</td>
                        <td colspan="2">रामकुमार प्रसाद</td>
                    </tr>
                    <tr>
                        <td style="width: 5%">5</td>
                        <td style="width: 30%">माता का नाम</td>
                        <td colspan="2">सुगना देवी</td>
                    </tr>
                    <tr>
                        <td style="width: 5%">6</td>
                        <td style="width: 30%">श्रेणी</td>
                        <td colspan="2">OBC</td>
                    </tr>
                    <tr>
                        <td style="width: 5%"></td>
                        <td style="width: 30%">मोबाइल नंबर</td>
                        <td colspan="2">1234568990</td>
                    </tr>
                    <tr>
                        <td style="width: 5%">7</td>
                        <td colspan="3" style="font-weight: 700 !important">विधवा/तलाकशुदा/परित्यकता प्रमाण पत्र का विवरण</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div style="display: flex; justify-content: space-around">
                                <div>जरीकर्ता का पदनाम:</div>
                                <div>क्रमांक:</div>
                                <div>दिनांक:</div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 5%">8</td>
                        <td colspan="3" style="font-weight: 700 !important">विकलांगता प्रमाण पत्र का विवरण :</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div style="display: flex; justify-content: space-around">
                                <div>जरीकर्ता का पदनाम:</div>
                                <div>क्रमांक:</div>
                                <div>दिनांक:</div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 5%">9</td>
                        <td colspan="3" style="font-weight: 700 !important">स्वतंत्रता सेनानी प्रमाण पत्र का विवरण</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div style="display: flex; justify-content: space-around">
                                <div>जरीकर्ता का पदनाम:</div>
                                <div>क्रमांक:</div>
                                <div>दिनांक:</div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 5%">10</td>
                        <td colspan="3" style="font-weight: 700 !important">यदि आवेदिका सहायिका के पद पर कार्यरत है तो उसका विवरण</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div style="display: flex; justify-content: space-around">
                                <div>योगदान का दिनांक:</div>
                                <div>केंद्र का नाम:</div>
                                <div>ग्राम सभा / वार्ड का नाम:</div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 5%">11</td>
                        <td colspan="3" style="font-weight: 700 !important">स्थाई पता</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div style="display: flex; justify-content: space-around">
                                <div>मकान नंबर:</div>
                                <div>ग्राम/ मोहल्ला:</div>
                                <div>पोस्ट:</div>
                                <div>जनपद:</div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 5%">12</td>
                        <td colspan="3" style="font-weight: 700 !important">निवास प्रमाण पत्र विवरण</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div style="display: flex; justify-content: space-around">
                                <div>जरीकर्ता का पदनाम:</div>
                                <div>क्रमांक:</div>
                                <div>दिनांक:</div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 5%">13</td>
                        <td colspan="3" style="font-weight: 700 !important">जाति प्रमाण पत्र विवरण</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div style="display: flex; justify-content: space-around">
                                <div>जरीकर्ता का पदनाम:</div>
                                <div>क्रमांक:</div>
                                <div>दिनांक:</div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 5%">14</td>
                        <td colspan="3" style="font-weight: 700 !important">आय प्रमाण पत्र का विवरण</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div style="display: flex; justify-content: space-around">
                                <div>जरीकर्ता का पदनाम:</div>
                                <div>क्रमांक:</div>
                                <div>दिनांक:</div>
                            </div>
                        </td>
                    </tr>


                    <td style="width: 5%">15</td>
                    <td colspan="1" style="font-weight: 700 !important">जन्मतिथि</td>
                    <td colspan="2" style="font-weight: 700 !important">जन्मतिथि (शब्दों में)</td>
                    </tr>
                    <tr>
                        <td style="width: 5%">16</td>
                        <td colspan="1" style="font-weight: 700 !important">आधार नंबर</td>
                        <td colspan="2">123456789012</td>
                    </tr>
                    <tr>
                        <td style="width: 5%"></td>
                        <td colspan="3" style="font-weight: 700 !important">दिनांक 1 जनवरी 2021 को आवेदिका की आयु</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div style="display: flex; justify-content: space-around">
                                <div>वर्ष</div>
                                <div>माह</div>
                                <div>दिन</div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 5%"></td>
                        <td colspan="3" style="font-weight: 700 !important">शैक्षणिक योग्यता का विवरण</td>
                    </tr>
                    <tr>
                        <table style="width: 100%; border: none !important">
                            <thead style="font-weight: 700 !important">
                                <tr>
                                    <td>क्र. स.</td>
                                    <td>कक्षा</td>
                                    <td style="width: 25%">विद्यालय का नाम</td>
                                    <td>बोर्ड का नाम</td>
                                    <td>उत्तीर्ण वर्ष</td>
                                    <td>पूर्णांक</td>
                                    <td>प्राप्तांक</td>
                                    <td>ग्रेट / श्रेणी</td>
                                    <td>प्रतिशत</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>कक्षा-5</td>
                                    <td style="width: 25%"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>कक्षा-8</td>
                                    <td style="width: 25%"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>हाईस्कूल</td>
                                    <td style="width: 25%">Subhash Inter College Bharni Devdiyya</td>
                                    <td>UP Board</td>
                                    <td>2000</td>
                                    <td>600</td>
                                    <td>293</td>
                                    <td>4.88</td>
                                    <td>48.83</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>इंटर</td>
                                    <td style="width: 25%">Subhash Inter College Bharni Devdiyya</td>
                                    <td>UP Board</td>
                                    <td>2002</td>
                                    <td>500</td>
                                    <td>231</td>
                                    <td>4.62</td>
                                    <td>46.20</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>स्नातक</td>
                                    <td style="width: 25%">DDU Gorakhpur</td>
                                    <td>DDU University</td>
                                    <td>2006</td>
                                    <td>1800</td>
                                    <td>674.00</td>
                                    <td>3.74</td>
                                    <td>37.44</td>
                                </tr>
                            </tbody>
                        </table>
                    </tr>
                </thead>
            </table>
            <div style="text-align: center">
                मैं एतदद्वारा घोषणा करती हूँ कि मैने उक्त पद से सम्मान्धित प्रकाशित विज्ञप्ति को ध्यानपूर्वक पढ़ा है चयन से सम्बन्धित
                सभी शर्ते मुझे मान्य हैं। आवेदन-पत्र के में अंकित सभी सूचना व आवेदन-पत्र के साथ सभी विवरण सत्य एवं सही है। भविष्य में
                यदि कोई तथ्य फर्जी/ असत्य पाये जाते हैं या छिपाया गया पाया जाता है, तो आवेदिका का अभ्यर्थन/निपुक्ति निरस्त कर समुचित
                वैधानिक कार्यवाही की जाय।
                <p>इस आवेदन पत्र के साथ समस्त सलग्नकों की स्वप्रमाणित छायाप्रति सहित सक्षम नियुक्ति प्रधिकारी को भेजें।</p>
            </div>
        </div>
    </div>





    </div>
    </div>


</body>

</html>