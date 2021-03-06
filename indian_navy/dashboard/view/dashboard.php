<?php
//print_r($this->session->userdata);die('*');
$arrayKey = [
    'INSERT_DATE' => ['Date', ''],
    'ORG_ID' => ['Organization Id', ''],
    'YEAR' => ['Year', '<i class="fa fa-calendar" style="float:left;padding-top:15px;"></i>'],
    'BOARD' => ['Board', ''],
    'SESSION' => ['Session', ''],
    'CERT_TYPE' => ['Cource Type', ''],
    'RESULT' => ['Result', ''],
    'SEX' => ['Gender', ''],
    'TOTAL_COUNT' => ['Total Awards', ''],
    '10' => ['X th', ''],
    '12' => ['XII th', ''],
    'M' => ['Male', '<img src="' . base_url('theme/assets/img/male_icon_40.png') . '" alt="awards" style="width:30px;float:left;padding-top:15px;" />'],
    'F' => ['Female', '<img src="' . base_url('theme/assets/img/female_icon_40.png') . '" alt="awards" style="width:30px;float:left;padding-top:15px;" />'],
];
$keyOnly = '';
$totalData = array();
$today = date('Y');
$year = [];
$year_order = [];
$urlYear = $UrlYear;
if (!empty($stats_years)) {
    $i = 0;
 foreach ($stats_years as $yr1) {
     $i++;
          if(''. $_SERVER['REQUEST_URI'] == '/dashboard'){
            $year[] = '<li class="col-md-1" style="padding:10px; color:#C5C5C5;"><a style="color:#C5C5C5; font-weight: 600;" href="javascript:void(0)" onclick="return gotoYear(' . $yr1 . ')">' . $yr1 . '</a></li>';
          } else{
            if (!empty($urlYear) && $urlYear == $yr1) {
                $year[] = '<li class="col-md-1" style="padding:10px; font-weight: bold;">' . $yr1 .'</li>';
            } else {
                $year[] = '<li class="col-md-1" style="padding:10px; color:#C5C5C5;"><a style="color:#C5C5C5; font-weight: 600;" href="javascript:void(0)" onclick="return gotoYear(' . $yr1 . ')">' . $yr1 . '</a></li>';
            } 
          }
             
    }
}
$UniBoard = '';
$TOTAL_COUNT = [];
$KeySections = [];
$RESULT = [];
$Gender['MALE'] = [];
$Gender['FEMALE'] = [];
$COURSE_NAME = [];
$STREAM = [];
if (!empty($stats)) {
    foreach ($stats as $stat) {
        $UniBoard = $stat['ORG_TYPE'];
        $degree = $stat['total_degree'];
        $marksheet = $stat['total_marksheet'];
        $diploma = $stat['total_diploma'];

        $STANDARD = !empty($stat['STANDARD']) ? $stat['STANDARD'] : $stat['ORG_TYPE'];
        $KeySections[$STANDARD]['YEAR'] = $stat['YEAR'];
        $KeySections[$STANDARD]['ORG_TYPE'] = $stat['ORG_TYPE'];
        $KeySections[$STANDARD]['TOTAL_COUNT'] = $stat['TOTAL_COUNT'];
        $TOTAL_COUNT[] = $stat['TOTAL_COUNT'];
        if (is_array($stat)) {
            foreach ($stat as $mainKey => $sts) {
                if (is_array($sts)) {
                    foreach ($sts as $key => $st) {
                        $KeySections[$STANDARD][$mainKey][$st['_id']] = $st['total'];
                        if($st['_id'] == 'M')
                        {
                            $Gender['MALE'][] = $st['total'];
                        }
                        if($st['_id'] == 'F')
                        {
                            $Gender['FEMALE'][] = $st['total'];
                        }
                        if($st['_id'] == 'T')
                        {
                            $Gender['TRANSGENDER'][] = $st['total'];
                        }
                        if($mainKey == 'RESULT')
                        {
                            if(strtolower($st['_id']) == 'fail')
                            {
                                $RESULT['FAIL'][] = $st['total'];
                            } else {
                                $RESULT['PASSED'][] = $st['total'];
                            }
                        }
                        if($mainKey == 'COURSE_NAME' && $st['_id'] != '')
                        {
                            $COURSE_NAME[] = array("name" => $st['_id'], 'y' => $st['total']);
                        }
                        if($mainKey == 'STREAM' && $st['_id'] != '')
                        {
                            $STREAM[] = array("name" => $st['_id'], 'y' => $st['total']);
                        }
                    }
                }
            }
        }
    }
}
$TotalAwards = array_sum($TOTAL_COUNT);

//Added for IndianNavy 
if(isset($IndianNavyStats)){
    $UniBoard = $IndianNavyStats['ORG_TYPE'];
    $degree = $IndianNavyStats['total_degree'];
    $marksheet = $IndianNavyStats['total_marksheet'];
    $TotalAwards = $IndianNavyStats['total_awards'];
}



?>
<style>
	h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
		font-family: "Roboto", "Helvetica", "Arial", sans-serif !important;
	}
    .info-box .info-box-text,.info-box .progress-description {font-size: 24px; line-height: 29px;}
    .info-box .info-box-number {font-size: 25px;}
    .upldbtn{width: 112px;height: 35px;background: #0BAF37;border-radius: 20px !important;color:#fff !important; font-size:15px !important;}
    .boxiconmrgn{width:30px; height:30px; margin-left:0px; margin-bottom:12px; vertical-align: middle;}
    .bxtxtnum{font-size: 22px !important; color: #424242;}
    .btns{width: 206px;height: 46px;background: #157FFB;border-radius: 20px !important; color:#fff !important; font-size:15px !important;}
    .upldfilebtn label{padding: 7px 9px 9px 30px;cursor:pointer;width: 112px;height: 35px;background: #0BAF37;border-radius: 20px !important;color:#fff !important; font-size:15px !important;}
    .upldfilebtn input[type="file"] {display: none;}
    .info-box {
        Width: 277px ;
        Height: 127px;
        border: solid 1px #888282;
        padding: 10px 10px 0px 10px;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 30px;
    }
    .info-box .info-box-number {
        display: block;
        font-weight: lighter; /*700;*/
        padding-top: 16px;
    }
    .info-box .info-box-text,
    .info-box .progress-description {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        color:#424242;
    }
    .info_tex{
        width: 160px;
        float: left;
    }
    .info_img{
        width:90px; 
        float: left; 
        margin-top: 15px;
    }
    .bxtxtnumyear{background-image: url('../../../theme/assets/img/blank_clander_2.png'); text-align:center !important; height:101px; background-repeat: no-repeat; background-size: cover;}
    /*Charts css starts*/
    .highcharts-figure, .highcharts-data-table table {
        min-width: 310px; 
        max-width: 800px;
        margin: 1em auto;
    }
  #container {
        height: 400px;
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #EBEBEB;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }
    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }
    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }
    .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
        padding: 0.5em;
    }
    .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }
    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }
    .highcharts-a11y-proxy-container button{display:none !important; opacity: 0 !important;}

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #EBEBEB;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }
    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }
    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }
    .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
        padding: 0.5em;
    }
    .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }
    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }
    .highcharts-a11y-proxy-container button{display:none !important; opacity: 0 !important;}
.boxicons{font-size:35px; opacity:0.7;}
    /*Charts css ends*/
    
    .col-md-2{padding-right:0px !important;}
    .radius_50 {
    border-radius: 50px;
}

element.style {
}
.btn:not(:disabled):not(.disabled) {
    cursor: pointer;
}
.btn-lg {
    padding: 15px 40px;
    font-size: 20px;
}
.btn {
    padding: 4px 10px;
    font-size: 12px;
}
.radius_50 {
    border-radius: 50px !important;
}
.btn-group-lg>.btn, .btn-lg {
    padding: .5rem 1rem;
    font-size: 1rem !important;
    line-height: 1.5;
    border-radius: .3rem;
}
.btn-primary-blnk {
    color: #fff;/*#fff !important;*/
    background: #004582;
    border-radius: 21.5px;
}
.btn-primary-blnk:hover{background-color:#0069d9 !important;border-color:#0069d9;color:#fff !important;}

.hidden{display:none !important;}
.disblock{display:block !important;}
.more{display:block;}
.less{display:none;}
.info-box-text {padding-bottom:15px !important;}

/*css for abc pop*/
.loader-section {
    position: fixed;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.2);;
    z-index: 1000;
}
.ownbox{border:1px solid #ccc;margin-left: 10px; margin-right: 10px; border-radius:10px; box-shadow: 0 0 20px rgba(90, 70, 87, 0.12); background-color: #fff;border: 1px solid #dddddd;margin-top:60px;height: 570px;}
.abc_popup{
width: 475px !important;
height: 262px !important;
background:#1e38a7;
left: 415px !important;
margin-top: 199px;
position:relative;
-webkit-transform:translateY(300%);
  transform:translateY(300%);
  -webkit-transition: all 900ms cubic-bezier(0.68, -0.55, 0.265, 1.55);
  transition: all 900ms cubic-bezier(0.68, -0.55, 0.265, 1.55);
}
.popup_head{
  Width: 150px !important;
  Height: 150px !important;
  background:#e15559;
  border-radius:12rem;
  padding-top: 3px;
  margin-top: -79px !important;
  position: absolute;
  right: 165px !important;
  box-shadow:3px 6px 3px -2px rgba(0, 0, 0, 0.3);
}
.btn_time{
  background: transparent;
border: none;
font-size: 26px;
color: #fff;
float: right;
margin: 15px;
}
.btn_join{
background: transparent;
border: none;
width: 170px;
height: 45px;
background: #E15559;
border-radius: 20px;
font-size: 18px;
color:#fff;
}
.btn_Know{
  background: transparent;
border: none;
width: 170px;
height: 45px;
background: #edd9da;
border-radius: 20px;
font-size: 18px;
color:#E15559;
}
.header_name {
  border-bottom: solid 1px #C4C4C4;
  box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.25);
}
.year_box{
width: 417px;
max-height: 120px;
background: #FFFFFF;
box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.25);
border-radius: 20px;
border: 1px solid #dfdfdfdf;
position: absolute;
z-index: 9;
margin-top: -15px;
margin-left: 7px;
display:none;
padding:10px;
text-align: center;
}
.year_ul li{
    width: 50px;
}
.Notification_box{
    max-Width:416px;
  Height:225px;
  border-radius: 10px;
  box-shadow: 0px 2px 3px 2px rgba(0,0,0,0.3);
  padding: 20px;
  color:#424242;
  margin-bottom: 50px;
}
.Notification_box h1{
    text-align: center;
font-size: 26px;
font-weight: 500;
line-height: 26px;
border-bottom: 1px solid #888282;
padding-bottom: 12px;
}
/* #myList li{ display:none;} */
#totalBox{
    display:none;   
}
#yearbox{
    display:none;   
}
/* by junmoni for tour guide */
.anno .anno-inner {
    background: #004582 !important;
    width: 349px;
    height: 149px;
    border-radius: 15px;
}


.anno .anno-inner .anno-content {
    padding: 11px 14px !important;
}

.anno-btn-container {
    text-align: center !important;
    padding-left: 97px !important;
}

.anno-arrow {
    border-radius: 50px !important;
    border: 9px solid #f9f871 !important;
    /* bottom: 93% !important; */
    /* left: 20px !important; */
    /* border-color: #004582 transparent !important; */
}

.anno-btn-container > .anno-btn-skip {
    border: 2px solid white !important;
    color: white !important;
    background: #004582 !important;
}

.anno-btn {
    background: #ffffff !important;
    color: #004582 !important;
    border-radius: 12.5px !important;
    width: 70px !important;
    height: 20px !important;
    padding: 0 !important;
}

.first-popup {
    left: 693px !important;
    top: 52px !important;
}

.first-popup .anno-arrow {
    bottom: 93% !important;
    left: 168px !important;
}

.second-popup {
    top: 11px !important;
    left: 900.422px !important;
}

.second-popup .anno-arrow {
    left: 97% !important;
}


.third-popup .anno-arrow {
    left: 97% !important;
    top: 62px !important;
}

.third-popup {
    top: 369px !important;
    left: 280.906px !important;
}

.fourth-popup {
    top: 307px !important;
    left: 223px !important;
}

.fourth-popup .anno-arrow {
    left: -2% !important;
    top: 64px !important;
}

/* .leftmenu-highlight {
    margin-left: 225px !important;
} */

/* 
.fourth-popup .anno-overlay {
    z-index: 1 !important;
} */
/* .anno.anno-target-center-right .anno-arrow, .anno.anno-target-right .anno-arrow {
    border-color: transparent #004582 !important;
} */

/* by junmoni ends */
.activity_ul{
    list-style-image: url(https://img1.digitallocker.gov.in/nad/assets/images/li.png);
    margin-left: 34px;
    font-size: 16px;
}
.activity_ul li{
    padding:10px 0;
    border-bottom: solid 1px #bebebe;
}
.noti_box{
    padding: 10px 0;
    border-bottom: solid 1px #bebebe;
    font-size: 24px;
}
.noti_box p{
    font-size: 16px;
     color: #424242;
     margin-left: 25px;
     }
</style>
<script src="<?php echo base_url(); ?>theme/assets/charts/js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>theme/assets/charts/js/data.js"></script>
<script src="<?php echo base_url(); ?>theme/assets/charts/js/drilldown.js"></script>
<script src="<?php echo base_url(); ?>theme/assets/charts/js/exporting.js"></script>
<script src="<?php echo base_url(); ?>theme/assets/charts/js/export-data.js"></script>
<script src="<?php echo base_url(); ?>theme/assets/charts/js/accessibility.js"></script>
<div class="loader-section" style="display:none;">
    <div class="abc_popup">
        <div class="popup_head">
            <img src="https://img1.digitallocker.gov.in/nad/assets/images/Ellipse 40.png" style="margin: 10px;"  width="130" height="130">
        </div>
            <button type="button" class="btn_time"><i class="" style="font-size: 16px;font-style: normal;">&#10005</i></button>
         <div class="row" style="text-align: center;">
            <div class="col-md-12" style="margin-top: 7px;">
                 <h1 style="font-size: 24px;font-weight: 800;color: #fff; line-height: 40px;">Join Academic Bank of Credits!</h1>
                 <p style="font-size: 16px;color: #fff;margin: 0px;">Enable student???s mobility by letting</p>
                 <p style="font-size: 15px;color: #fff;margin: 0px; margin-bottom: 19px;">them enter the Credit Based system.</p>
            </div>
            <div class="col-md-6">
                 <button type="button" class="btn_join pull-right" onclick="window.open('https://www.abc.gov.in/','_blank')"   target=???_blank???>Join Now</button>
            </div>
            <div class="col-md-6">
                 <button type="button" class="btn_Know pull-left">Know more</button>
            </div>
            <div class="col-md-12"><p style=" font-size: 14px; text-decoration-line: underline; color: #FFFFFF;margin-top: 10px; cursor:pointer" onClick="window.open('https://www.abc.gov.in/assets/resources/9992758_Academic-Bank-of-Credits-Letter.pdf','_blank')"  target=???_blank???>Related UGC Amendments Regulations, 2021</p>
            </div>
            </div>
            </div>
        </div>
<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar.less -->
        <?php $this->load->view('../../__inc/header_sidebar'); ?>
        <!-- /.sidebar -->
    </aside>

    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">
        <?php $this->load->view('../../__inc/base_links'); ?>
        <!-- Main content -->
        <section class="content">
        <div class="row header_name">
            <div class="col-md-12 form-group" style="margin-top: 30px;">
              <div class="col-md-6 col-lg-7">
                <h3>Dashboard</h3>
              </div>
                <div class="col-md-6 col-lg-5 text-center" id="upload-buttons" style="padding-top: 10px; padding-bottom: 10px;">
                    <a style="margin-right: 25px;" class="btn btn-primary-blnk btn-lg radius_50 text-center" href="<?php echo site_url('academicrepoengine/upload_step1'); ?>"><i style="font-size: 18px;" class="fa fa-file-o" aria-hidden="true"></i><i style="position: absolute;margin-left: -13px;margin-top: 6px;-webkit-text-stroke: 1px #004582; font-size: 12px;" class="fa fa-plus" aria-hidden="true"></i> &nbspUpload Records</a>
                    <a class="btn btn-primary-blnk btn-lg radius_50 text-center" href="<?php echo site_url('media/Upload'); ?>"><i style="font-size: 18px;" class="fa fa-picture-o" aria-hidden="true"></i><i style="position: absolute;margin-left: -5px;margin-top: 11px;-webkit-text-stroke: 1px #004582; font-size: 12px;" class="fa fa-plus" aria-hidden="true"></i> &nbspUpload Photos</a>
                </div>
            </div>
            </div>
			<?php
			if($this->session->flashdata('message')){
				echo $this->session->flashdata('message');
			}
			?>
			<!--<section class="content" style="margin-bottom:-19px; margin-top:-3px;"> 
			<div class="col-md-12 form-group"><h3>Dashboard</h3></div>
			</section>-->

            <!-- Dashboard boxes starts -->

            <div class="row university">
                <div class="col-md-7">
                <?php if($this->session->userdata['is_Approved'] == "V"){ ?>
                <?php if(!empty($UniBoard)):?>
                <div id="year_modal" class="row" style="padding: 4px 8px 4px 14px; border:1px solid #B0B0B0;margin-left:15px;margin-right:15px;border-radius: 20px; box-shadow: 0px 1px 1px 0px rgba(0,0,0,0.3); background-color: #fff;
                     border: 1px solid #dddddd;margin-bottom:20px;margin-top:20px; width: 132px; cursor: pointer;">
                    <p style="margin:0px; color: #989696;font-size: 20px; float: left;">
                    <?php if(''. $_SERVER['REQUEST_URI'] == '/dashboard'){ ?>
                        Year
                     <?php } else { ?>
                        <?php echo $urlYear; ?>
                        <?php } ?>
                </P> <i style="font-size: 24px; margin: 2px 10px 2px 30px; color: #6D6D6D;"class="fa fa-calendar" aria-hidden="true"></i>
            </div>

            <div class="year_box" id="modal_Box">
                    <div style="width: 400px; max-height:85px; overflow-y: auto;">
                    <?php if(count($year) > 0): ?>
                        <ul class="year_ul">
                                <?php echo join(' ',$year); ?>
                    </ul>
                    <?php endif;
                    ?>
                    </div>
                    <a style="color: #4123d0; text-decoration: underline #C5C5C5;" href="javascript:void(0)" onclick="return totalYear()">Clear selection</a>
            </div>
            <div id="totalBox">
                <!-- total summary count start -->
                <div class="col-12 col-sm-6 col-md-6">
                    <div class="info-box">
                        <div class="info-box-content" style="width:100%;">
                           <div class="info_img">
                           <img src="https://img1.digitallocker.gov.in/nad/assets/images/Lodged.png" alt="Total Awards Lodged"> 
                           </div>
                           <div class="info_tex">
                            <div style="width:100%;margin-top:-10px;">
                                <span class="info-box-number">
                                    <span class="bxtxtnum">
                                        <?php echo !empty($total_summary_count)?$total_summary_count:0; ?>
                                    </span>
                                </span>
                            </div>
                            <span class="info-box-text" style="padding-top:5px;">Total Awards Lodged</span>
                           </div>
                        </div>
                    </div>
                </div>
                <!-- total summary count end -->

                   <!-- total diploma count start -->
              <?php if($total_process_diploma) { ?>     
            <div class="col-12 col-sm-6 col-md-6">
                <div class="info-box">
                    <div class="info-box-content" style="width:100%;">
                        <span class="info-box-text" style="padding-top:5px;">Total Diploma</span>
                        <div style="width:100%;margin-top:-10px;">
                            <span class="info-box-number">
                                <img src="https://img1.digitallocker.gov.in/nad/assets/images/degree.png" alt="awards" style="float:left;padding-top:15px;"/>
                                <span class="bxtxtnum" style="text-align:right !important;">
                                    <?php echo $total_process_diploma; ?>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
<!-- total diploma count end -->
<!-- total degree count start -->
            <?php } if($total_process_degree) { ?>
                <div class="col-12 col-sm-6 col-md-6">
                    <div class="info-box">
                        <div class="info-box-content" style="width:100%;">
                        <div class="info_img">
                            <img src="https://img1.digitallocker.gov.in/nad/assets/images/degree.png" alt="Total Degree">
                        </div>
                        <div class="info_tex">
                            <div style="width:100%;margin-top:-10px;">
                                <span class="info-box-number">
                                    <span class="bxtxtnum" style="text-align:right !important;">
                                        <?php echo $total_process_degree; ?>
                                    </span>
                                </span>
                            </div>
                            <?php $recordSearchUrl = 'recordsearch/records/'.$urlYear.'/DGCER/'; ?>
                            <span class="info-box-text" style="padding-top:5px;"><a href='<?php echo base_url($recordSearchUrl); ?>'>Total Degree</a></span>
                        </div>

                        </div>
                    </div>
                </div>

<!-- total degree count end -->
<!-- total marksheet count start -->
            <?php } if($total_process_marksheet) { ?>
            <div class="col-12 col-sm-6 col-md-6">
                <div class="info-box">
                    <div class="info-box-content" style="width:100%;">
                    <div class="info_img">
                        <img src="https://img1.digitallocker.gov.in/nad/assets/images/marksheets.png" alt="Total Degree">
                    </div>
                    <div class="info_tex">
                    <div style="width:100%;margin-top:-10px;">
                            <span class="info-box-number">
                                <span class="bxtxtnum" style="text-align:right !important;">
                                    <?php echo $total_process_marksheet; ?>
                                </span>
                            </span>
                        </div>
                        <?php $recordSearchUrl = 'recordsearch/records/'.$urlYear.'/DGMST/'; ?>
                        <span class="info-box-text" style="padding-top:5px;"><a href='<?php echo base_url($recordSearchUrl); ?>'>Total Marksheet </a></span>
                    </div>
                    </div>
                </div>
            </div>
            <?php }?>
            <!-- Added check for IndianNavy -->
            <?php if ($UniBoard != 'BOARD' && $UniBoard != 'IndianNavy'): ?>
            <div class="col-12 col-sm-6 col-md-6">
                    <div class="info-box">
                        <div class="info-box-content" style="width:100%;">
                        <div class="info_img">
                                 <img src="https://img1.digitallocker.gov.in/nad/assets/images/courses.png" alt="Courses">
                             </div>
                             <div class="info_tex">
                             <div style="width:100%;margin-top:-10px;">
                                <span class="info-box-number">
                                    <span class="bxtxtnum" style="text-align:right !important;">
                                        <?php echo isset($totalpulldoc) ? $totalpulldoc : '0'; ?>
                                    </span>
                                </span>
                            </div>
                            <span class="info-box-text" style="padding-top:5px;">Awards Fetched</span>
                             </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
<!-- total degree count end -->
       <div id="yearbox">
       <?php if ($COURSE_NAME) { ?>
                    <div class="col-12 col-sm-6 col-md-6">
                        <div class="info-box">
                            <div class="info-box-content" style="width:100%;">
                            <div class="info_img">
                                        <img src="https://img1.digitallocker.gov.in/nad/assets/images/courses.png" alt="Courses">
                            </div>
                                <div class="info_tex">
                                <div style="width:100%;">
                                    <span class="info-box-number">
                                        <span class="bxtxtnum" style="text-align:right !important;">
                                            <?php echo !empty($KeySections[$UniBoard]['COURSE_NAME']) ? count($KeySections[$UniBoard]['COURSE_NAME']) : 0; ?>
                                        </span>
                                    </span>
                                    <span class="info-box-text" style="padding-top:5px;">Courses</span>
                                    <span style="margin-top:-5px;float:right;font-size:12px;text-align:right !important;cursor: pointer;" data-bs-toggle="modal" data-bs-target="#courseschart">Details</span>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <?php } if ($STREAM) {?>
                    <div class="col-12 col-sm-6 col-md-6">
                        <div class="info-box">
                            <div class="info-box-content" style="width:100%;">
                            <div class="info_img">
                                        <img src="https://img1.digitallocker.gov.in/nad/assets/images/streams.png" alt="streams">
                            </div>
                            <div class="info_tex">
                            <div style="width:100%;">
                                    <span class="info-box-number">
                                        <span class="bxtxtnum">
                                            <?php echo !empty($KeySections[$UniBoard]['STREAM']) ? count($KeySections[$UniBoard]['STREAM']) : 0; ?>
                                        </span>
                                    </span>
                                </div>
                                <span class="info-box-text" style="padding-top:5px;">Streams</span>
                                <span style="margin-top:-5px;float:right;font-size:12px;text-align:right !important;cursor: pointer;" data-bs-toggle="modal" data-bs-target="#streamschart">Details</span>
                            </div>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <?php } ?>
                    <div class="col-12 col-sm-6 col-md-6">
                        <div class="info-box">
                            <div class="info-box-content" style="width:100%;">
                            <div class="info_img">
                                            <img src="https://img1.digitallocker.gov.in/nad/assets/images/awards.png" alt="awards">
                                </div>
                                <div class="info_tex">
                                    <div style="width:100%;margin-top:-10px;">
                                        <span class="info-box-number">
                                            <span class="bxtxtnum" style="text-align:right !important;">
                                                <?php echo $TotalAwards; ?>
                                            </span>
                                        </span>
                                    </div>
                                    <span class="info-box-text" style="padding-top:5px;">Awards</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- start degree count for year -->
<?php if($degree): ?>
    <div class="col-12 col-sm-6 col-md-6">
    <div class="info-box">
        <div class="info-box-content" style="width:100%;">
        <div class="info_img">
                           <img src="https://img1.digitallocker.gov.in/nad/assets/images/degree.png" alt="degree"> 
             </div>
             <div class="info_tex">
                <div style="width:100%;margin-top:-10px;">
                    <span class="info-box-number">
                        <span class="bxtxtnum" style="text-align:right !important;">
                            <?php echo $degree; ?>
                        </span>
                    </span>
                </div>
            <span class="info-box-text" style="padding-top:5px;">Degree</span>
             </div>
        </div>
    </div>
</div>
<!-- end degree count for year     -->
<?php endif; ?>
<!-- start degree count for year -->
<?php if($marksheet):?>
    <div class="col-12 col-sm-6 col-md-6">
    <div class="info-box">
        <div class="info-box-content" style="width:100%;">
        <div class="info_img">
                           <img src="https://img1.digitallocker.gov.in/nad/assets/images/marksheets.png" alt="marksheets"> 
        </div>
        <div class="info_tex">
        <div style="width:100%;margin-top:-10px;">
                <span class="info-box-number">
                    <span class="bxtxtnum" style="text-align:right !important;">
                        <?php echo $marksheet; ?>
                    </span>
                </span>
            </div>
            <span class="info-box-text" style="padding-top:5px;">Marksheet</span>
        </div>
        </div>
    </div>
</div>
<!-- end degree count for year     -->
<?php endif; ?>
<!-- start degree count for year -->
<?php if($diploma):?>
    <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
        <div class="info-box-content" style="width:100%;">
        <div class="info_img">
                           <img src="https://img1.digitallocker.gov.in/nad/assets/images/marksheets.png" alt="marksheets"> 
        </div>
        <div class="info_tex">
        <div style="width:100%;margin-top:-10px;">
                <span class="info-box-number">
                    <span class="bxtxtnum" style="text-align:right !important;">
                        <?php echo $diploma; ?>
                    </span>
                </span>
            </div>
            <span class="info-box-text" style="padding-top:5px;">Diploma</span>
        </div>
        </div>
    </div>
</div>
<!-- end diploma count for year     -->
<?php endif; ?>
                <?php if ($UniBoard != 'BOARD'): ?>
                    <!-- <div class="col-12 col-sm-6 col-md-3"></div> -->
<!-- <div class="col-12 col-sm-6 col-md-3"></div> -->
                    <!-- <div class="col-12 col-sm-6 col-md-6">
                        <div class="info-box">
                            <div class="info-box-content" style="width:100%;">
                            <div class="info_img">
                                 <img src="../../../../assets/images/passed.png" alt="passed"> 
                             </div>
                             <div class="info_tex">
                             <div style="width:100%;margin-top:-10px;">
                                    <span class="info-box-number">
                                        <span class="bxtxtnum" style="text-align:right !important;">
                                        <?php// echo !empty($RESULT['PASSED']) ? array_sum($RESULT['PASSED']) : 0; ?>
                                        </span>
                                    </span>
                                </div>
                                <span class="info-box-text" style="padding-top:5px;">Passed</span>
                             </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="col-12 col-sm-6 col-md-6">
                        <div class="info-box">
                            <div class="info-box-content" style="width:100%;">
                            <div class="info_img">
                                 <img src="../../../../assets/images/passed.png" alt="Failed"> 
                             </div>
                             <div class="info_tex">
                             <div style="width:100%;margin-top:-10px;">
                                    <span class="info-box-number">
                                        <span class="bxtxtnum" style="text-align:right !important;">
                                            <?php// echo !empty($RESULT['FAIL']) ? array_sum($RESULT['FAIL']) : 0; ?>
                                        </span>
                                    </span>
                                </div>
                                <span class="info-box-text" style="padding-top:5px;">Failed</span>
                             </div>  
                            </div>
                        </div>
                    </div> -->
<!--
                    <div class="col-12 col-sm-6 col-md-6">
                    <div class="info-box">
                        <div class="info-box-content" style="width:100%;">
                        <div class="info_img">
                                 <img src="https://img1.digitallocker.gov.in/nad/assets/images/courses.png" alt="Courses"> 
                             </div>
                             <div class="info_tex">
                             <div style="width:100%;margin-top:-10px;">
                                <span class="info-box-number">
                                    <span class="bxtxtnum" style="text-align:right !important;">
                                        <?php //echo isset($totalpulldoc) ? $totalpulldoc : '0'; ?>
                                    </span>
                                </span>
                            </div>
                            <span class="info-box-text" style="padding-top:5px;">Awards Fetched</span>
                             </div>
                        </div>
                    </div>
                </div> -->
               
<?php if($total_record_only_upload) { ?>
    <div class="col-12 col-sm-6 col-md-6">
      <div class="info-box">
          <div class="info-box-content" style="width:100%;">
          <div class="info_img">
                                 <img src="https://img1.digitallocker.gov.in/nad/assets/images/passed.png" alt="Records Only Uploads"> 
                             </div>
              <div class="info_tex">
              <div style="width:100%;margin-top:-10px;">
                  <span class="info-box-number">
                      <span class="bxtxtnum" style="text-align:right !important;">
                          <?php echo $total_record_only_upload; ?>
                      </span>
                  </span>
              </div>
              <span class="info-box-text" style="padding-top:5px;">Records Only Uploads</span>
              </div>
          </div>
      </div>
  </div>
  <!-- total diploma count end -->
<?php } ?>

                <?php endif; if($UniBoard == 'BOARD') : ?>
 <!-- <div class="col-12 col-sm-6 col-md-6">
                        <div class="info-box">
                            <div class="info-box-content" style="width:100%;">
                            <div class="info_img">
                                 <img src="../../../../assets/images/Passed.png" alt="Passed">
                             </div>
                             <div class="info_tex">
                                <div style="width:100%;margin-top:-10px;">
                                    <span class="info-box-number">
                                    <?php //echo !empty($RESULT['PASSED']) ? array_sum($RESULT['PASSED']) : 0; ?>
                                        </span>
                                    </span>
                                </div>
                                <span class="info-box-text" style="padding-top:5px;">Passed</span>
                             </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="col-12 col-sm-6 col-md-6">
                        <div class="info-box">
                            <div class="info-box-content" style="width:100%;">
                            <div class="info_img">
                                 <img src="../../../../assets/images/Passed.png" alt="Passed">
                             </div>
                             <div class="info_tex">
                             <div style="width:100%;margin-top:-10px;">
                                    <span class="info-box-number">
                                        <i class="fa fa-thumbs-o-down boxicons" style="float:left;padding-top:6px;"></i>

                                        <span class="bxtxtnum" style="text-align:right !important;">
                                            <?php// echo !empty($RESULT['FAIL']) ? array_sum($RESULT['FAIL']) : 0; ?>
                                        </span>
                                    </span>
                                </div>
                                <span class="info-box-text" style="padding-top:5px;">Failed</span>
                             </div>
                               
                            </div>
                        </div>
                    </div> -->
                    <div class="col-12 col-sm-6 col-md-6">
                    <div class="info-box">
                        <div class="info-box-content" style="width:100%;">
                        <div class="info_img">
                                 <img src="https://img1.digitallocker.gov.in/nad/assets/images/passed.png" alt="Passed">
                             </div>
                             <div class="info_tex">
                             <div style="width:100%;margin-top:-10px;">
                                <span class="info-box-number">
                                    <span class="bxtxtnum" style="text-align:right !important;">
                                        <?php echo isset($totalpulldocsuccess) ? $totalpulldocsuccess: '0'; ?>
                                    </span>
                                </span>
                            </div>
                            <span class="info-box-text" style="padding-top:5px;">Pulled Request</span>
                             </div>
                            
                            <!-- <div class="pull-right" style="float:right;width:100%;margin-top:-10px;">
                                <span data-toggle="tooltip" title="Pulled with User Error <?php //echo isset($pulluserfail) ? $pulluserfail : '0'; ?>,&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; Pulled with API error <?php //echo isset($pullapifail) ? $pullapifail : '0'; ?>"><span style="font-weight:lighter;font-size:14px;color:red;text-align:right !important;float:right;"> <?php //echo isset($totalpulldocfail) ? $totalpulldocfail : '0'; ?></span></span><span style="font-weight:lighter;color:#7B8C92 !important;float:right;">/</span><span style="font-weight:lighter;font-size:14px;color:green;text-align:right !important;float:right;"> <?php// echo isset($totalpulldocsuccess) ? $totalpulldocsuccess : '0'; ?></span>
                                
                                </div> -->
                        </div>
                    </div>
                </div>

<!-- <div class="col-12 col-sm-6 col-md-6">
                        <div class="info-box">
                            <div class="info-box-content" style="width:100%;">
                            <div class="info_img">
                                 <img src="https://img1.digitallocker.gov.in/nad/assets/images/doc.png" alt="Passed">
                             </div>
                             <div class="info_tex">
                             <div style="width:100%;margin-top:-10px;">
                                    <span class="info-box-number">
                                        <img src="<?php //echo $this->cdn_path; ?>theme/assets/img/male_icon_40.png" alt="awards" style="width:40px;float:left;padding-top:5px;"/>

                                        <span class="bxtxtnum" style="text-align:right !important;">
                                        <?php //echo !empty($Gender['MALE']) ? array_sum($Gender['MALE']) : 0; ?>
                                        </span>
                                    </span>
                                </div>
                                <span class="info-box-text" style="padding-top:5px;">Male</span>
                             </div> 
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <div class="info-box-content" style="width:100%;">
                            <div class="info_img">
                                 <img src="https://img1.digitallocker.gov.in/nad/assets/img/doc.png" alt="Passed">
                             </div>
                             <div class="info_tex">
                             <div style="width:100%;margin-top:-10px;">
                                    <span class="info-box-number">
                                        <img src="<?php// echo $this->cdn_path; ?>theme/assets/images/female_icon_40.png" alt="awards" style="width:40px;float:left;padding-top:5px;"/>                            

                                        <span class="bxtxtnum" style="text-align:right !important;">
                                            <?php// echo !empty($Gender['FEMALE']) ? array_sum($Gender['FEMALE']) : 0; ?>
                                        </span>
                                    </span>
                                </div>
                                <span class="info-box-text" style="padding-top:5px;">Female</span>
                             </div> 
                            </div>
                        </div>
                    </div> --> 
                <?php endif; ?>
                </div>
                <?php  else: ?>
                    <style>
                        .col-md-7{
                            margin-top: 80px;
                        }
                    </style>
                <h1 style="font-size: 30px; text-align: center; font-weight: 500; color: #004582; line-height: 32px;"> This Account is now <span style="color:#69ba19 !important;">Verified</span>!</h1>
                 <p style="font-size: 21px; color: #004582; width: 435px; text-align: center; margin: 0 auto;">Start your NAD Journey by uploading and processing records.</p>
                <div style="width: 500px; margin: 0px auto; text-align: center; margin: 0 auto;"> <img src="https://img1.digitallocker.gov.in/nad/assets/images/notData.png" alt="Verified Image"> </div>
               <?php endif; 
                } elseif ($this->session->userdata['is_Approved'] == "N") { ?>
                    <style>
                        .col-md-7{
                            margin-top: 80px;
                        }
                    </style>
                <h1 style="font-size: 30px; text-align: center; font-weight: 500; color: #004582; line-height: 32px;"> Verification of this account is <span style="color:#f9ae16 !important;">Pending</span>!</h1>
                 <p style="font-size: 18px; color: #004582; text-align: center; margin: 0 auto;">In the meantime, you can explore the portal, select suitable templates and upload student records.</p>
                <div style="width: 500px; text-align: center; margin: 0 auto;"> <img src="https://img1.digitallocker.gov.in/nad/assets/images/notData.png" alt="Pending Image"> </div>
                <?php }?>
            </div>


                 <div class="col-md-5" id="notifications" style="margin-top: 60px; padding-top:20px">
                    <div class="Notification_box">
                         <h1>Notifications</h1>
                            <div class="noti_box"><img style="float: left;" src="https://img1.digitallocker.gov.in/nad/assets/images/icard.png" alt="name match image"><P style="float: left; margin-left: 20px;"> <?php echo $notifications['nameMatchRequestsReceived']; ?> New Details Approval request</P>
                            <div style="clear: both;"></div>
                            </div>
                            <div class="noti_box"><img style="float: left;" src="https://img1.digitallocker.gov.in/nad/assets/images/file_up.png" alt="records upload"><P style="float: left;"> <?php echo $notifications['recordsUploadFailed']; ?> Record uploading failed</P>
                            <div style="clear: both;"></div>
                            </div>
                            <div class="noti_box"><i style="float: left;" class="fa fa-picture-o" aria-hidden="true"></i><P style="float: left;"> <?php echo $notifications['photosUploadFailed']; ?> Photos uploading failed</P>
                            <div style="clear: both;"></div>
                            </div>

                    </div>
                    <div class="Notification_box">
                         <h1>Activity</h1>
                         <ul class="activity_ul">
                         <?php foreach ($activities as $activitieKey => $activitieData) {  ?>
                            <?php if(isset($activitieData['photosUploaded'])){ ?>
                              <li> <?php echo $activitieData['photosUploaded']; ?> photos uploaded in <?php echo $activitieData['YearUploaded']; ?> folder <?php if(!empty($activitieData['nameUploaded'])) {?>by <?php echo $activitieData['nameUploaded']; }?> </li>
                             <?php } ?>
							 <?php if($activitieData['recordsUploaded']){
							 if($activitieData['showVerifyNow']) {?>
								 <li> <?php echo $activitieData['recordsUploaded']; ?> records uploaded <?php echo $activitieData['nameUploaded']; ?>
									 <a style="float: right; font-size: 14px; font-weight: 600; padding-top: 5px; color: #004582;" href="academicrepoengine/UploadCsv/menu2">Verify now</a>

									 <div style="clear: both;"></div>
								 </li>
							 <?php }else{ ?>
							 <li> <?php echo $activitieData['recordsUploaded']; ?> records processed <?php echo $activitieData['nameUploaded']; ?>
								 <?php }
							 }
								 } ?>
						 </ul>
                    </div>
                </div>
            </div>
        </section>
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->


<!-- Modal Starts-->
<div id="streamschart" class="modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal" style="margin-right: -8px;font-size: 35px; margin-top: -13px; color:#afafaf; opacity: 1;">&times;</button>
            </div>
            <div class="modal-body">
                <figure class="highcharts-figure">
                    <div id="container1"></div>
                </figure>
            </div>
        </div>

    </div>
</div>
<!-- Modal Starts-->
<div id="courseschart" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom:none;">
                <button type="button" class="close" data-bs-dismiss="modal" style="margin-right: -8px;font-size: 35px; margin-top: -10px; color:#afafaf; opacity: 1;">&times;</button>
            </div>
            <div class="modal-body">
                <figure class="highcharts-figure">
                    <div id="container"></div>
                </figure>
            </div>
        </div>
    </div>
</div>
<!-- Modal Ends -->
<div class="modal" id="StatsMoreData" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="StatsTitle"></h5>
            </div>
            <div class="modal-body" id='statsBody'></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(window).on('load', function () {
        if("<?php echo $issuer_id?>"){
            $(".loader-section").show();
            $('.abc_popup').css({
                'transform':'translateY(0)',
                'z-index':'999'
            });
        }else {
            $(".loader-section").hide();
        }

        <?php if(''. $_SERVER['REQUEST_URI'] == '/dashboard'){ ?>
            $("#totalBox").show();
           <?php } else { ?>
            $("#yearbox").show();
                <?php } ?>
    });

    $(".btn_time").click(function(){
    $(".loader-section").hide();
    });

    function totalYear(){
        location.href = '<?php echo site_url("dashboard"); ?>';   
    }

    function gotoYear(year)
    {
        if (year == null || year == '')
        {
            location.href = '<?php echo site_url("dashboard"); ?>';
        } else {
            location.href = '<?php echo site_url("dashboard?Year="); ?>' + year;
            
        }
    }

    function MoreStats(stats)
    {
        var MoreData = $('#' + stats).val();
        var getStats = JSON.parse(MoreData);
        $('#StatsTitle').html(stats);
        var tabtr = '<table class="table table-border">';
        tabtr += '<tbody>';
        for (var i = 0; i < getStats.length; i++)
        {
            if (getStats[i]._id == null || getStats[i]._id == '') {
                continue;
            }
            tabtr += '<tr><td><strong>' + getStats[i]._id + '</strong></td><td>' + getStats[i].total + '</td></tr>';
        }
        tabtr += '</tbody>';
        tabtr += '</table>';
        $('#statsBody').html(tabtr);
    }

    //Show More data in table button
    //  $("#moredatatable").hide();
    $("#viewless").click(function () {
        $("#moredatatable").hide();
    });

    $("#moredatabtn").click(function () {
        $("#moredatatable").show();
    });


//     $("#moredatabtn").click(function(){
//   $("li").removeClass("hidden");
//   $("li").addClass("disblock");
// });
function moredatabtn() {
  $('.toggle').toggleClass('hidden disblock');
  $('.more_less').toggleClass('hidden disblock');
};



//$("#stremsdeatilinchart").hide();
//$("#streamschart").click(function(){
//  $("#stremsdeatilinchart").show();
//});

$("#year_modal").click(function(){
    $("#modal_Box").toggle();
  });

</script>
<script type="text/javascript">
    var STREAM = '<?php echo json_encode($STREAM); ?>';
    var COURSE_NAME = '<?php echo json_encode($COURSE_NAME); ?>';
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Courses'
        },
        subtitle: {
            text: ''
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'No. of Students'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: false,
                    format: '{point.y:.1f}'
                }
            }
        },
        tooltip: {
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> of total<br/>'
        },

        series: [
            {
                name: "",
                colorByPoint: true,
                data: JSON.parse(COURSE_NAME)
            }
        ]
    });



// Create the chart
    Highcharts.chart('container1', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Streams'
        },
        subtitle: {
            text: ''
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'No. of Students'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: false,
                    format: '{point.y:.1f}'
                }
            }
        },

        tooltip: {
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> of total<br/>'
        },
        series: [
            {
                name: "",
                colorByPoint: true,
                data: JSON.parse(STREAM)
            }
        ]
    });
    
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});

</script> 


<!-- by junmoni -->
<script>

    // $(document).one('ready', function () {    
$("document").ready(function () {
        var intro = new Anno([
          {
            target: "#upload-buttons",
            content: `<div style="display:flex;">
                          <div>
                              <img src="https://img1.digitallocker.gov.in/nad/assets/images/upload_button_image.png" style="width:171px">
                          </div>
                          <div>
                              <p style="color:white; padding: 15px;">Use these options as a shortcut to Upload Records and Photos.</p>
                          </div>
                      </div>`,
            buttons: [
              {
                text: "Skip",
                className: "anno-btn-skip",
                click: function (anno, evt) {
                  anno.hide();
                  //$('#dialog').modal('show');
                },
              },
              AnnoButton.NextButton,
            ],
            className: "first-popup",
          },
          {
            target: ".navbar-right",
            position: 'left',
            content: `<div style="display:flex;">
                          <div>
                              <img src="https://img1.digitallocker.gov.in/nad/assets/images/user_tour_image.png" style="width:189px">
                          </div>
                          <div>
                              <p style="color:white; padding: 10px;">Use User Profile to add and edit Institution details and Manage Users.</p>
                          </div>
                      </div>`,
            buttons: [
              {
                text: "Skip",
                className: "anno-btn-skip",
                click: function (anno, evt) {
                  anno.hide();
                  //$('#dialog').modal('show');
                },
              },
              AnnoButton.NextButton,
            ],          
            className: "second-popup",          
          },
          {
            target: "#notifications",
            position: 'left',
            content: `<div style="display:flex;">
                          <div>
                              <img src="https://img1.digitallocker.gov.in/nad/assets/images/notification_tour.png" style="width:189px; padding-top: 10px;">
                          </div>
                          <div>
                              <p style="color:white; padding: 10px;">Notifications give alerts and tasks to be done. Activities give the updates and action to be taken.</p>
                          </div>
                      </div>`,
            buttons: [
              {
                text: "Skip",
                className: "anno-btn-skip",
                click: function (anno, evt) {
                  anno.hide();
                // $(".anno-overlay").css("z-index", "1");
                },
              },
              AnnoButton.NextButton
            ],    
            className: "third-popup",
          },
          {
            onShow: function (anno, $target, $annoElem) {
                $(".anno-overlay").css("z-index", "1");
            },  
            target: ".left-side",
            position: 'left',
            content: `<div style="display:flex;">
                          <div>
                              <img src="https://img1.digitallocker.gov.in/nad/assets/images/sidebar_tour.png" style="width:189px; padding-top: 10px;">
                          </div>
                          <div>
                              <p style="color:white; padding: 10px;">Side menu bar helps in easy access to different tabs and features of the website.</p>
                          </div>
                      </div>`,
            buttons: [
              {
                text: "Finish",
                click: function (anno, evt) {
                  anno.hide();
                },
              }
            ],    
            className: "fourth-popup",
          },
        ]);
        intro.show();
      });


</script>
<!-- by junmoni ends -->

<!-- by junmoni -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script> -->
<!-- <script src="https://rawgit.com/iamdanfox/anno.js/gh-pages/dist/anno.js" type="text/javascript"></script> -->
<!-- <script src="https://rawgit.com/litera/jquery-scrollintoview/master/jquery.scrollintoview.js" type="text/javascript"></script> -->
<!-- <link href="https://rawgit.com/iamdanfox/anno.js/gh-pages/dist/anno.css" rel="stylesheet" type="text/css"/> -->
<!-- by junmoni ends -->
