<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(isset($_POST['submit']))
{
$tdate=$_POST['tdate'];
$thour=$_POST['thour'];
$nbchl=$_POST['nbchl'];
$nbadl=$_POST['nbadl'];
$tmessage=$_POST['tmessage'];
$useremail=$_SESSION['login'];
$tstatus=0;
$tid=$_GET['tid'];
$sql="INSERT INTO  tbltbooking(userEmail,tourid,bdate,b_houre,nb_chl,nb_adl,message,status) VALUES(:useremail,:tid,:tdate,:thour,:nbchl,:nbadl,:tmessage,:tstatus)";
$query = $dbh->prepare($sql);
$query->bindParam(':useremail',$useremail,PDO::PARAM_STR);
$query->bindParam(':tid',$tid,PDO::PARAM_STR);
$query->bindParam(':tdate',$tdate,PDO::PARAM_STR);
$query->bindParam(':thour',$thour,PDO::PARAM_STR);
$query->bindParam(':nbchl',$nbchl,PDO::PARAM_STR);
$query->bindParam(':nbadl',$nbadl,PDO::PARAM_STR);
$query->bindParam(':tmessage',$tmessage,PDO::PARAM_STR);
$query->bindParam(':tstatus',$tstatus,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
echo "<script>alert('Booking successfull.');</script>";
}
else
{
echo "<script>alert('Something went wrong. Please try again');</script>";
}

}

?>


<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="keywords" content="">
<meta name="description" content="">
<title>Bike Rental Port | Tour Details</title>
<!--Bootstrap -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<!--Custome Style -->
<link rel="stylesheet" href="assets/css/styles.css" type="text/css">
<!--OWL Carousel slider-->
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<!--slick-slider -->
<link href="assets/css/slick.css" rel="stylesheet">
<!--bootstrap-slider -->
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<!--FontAwesome Font Style -->
<link href="assets/css/font-awesome.min.css" rel="stylesheet">

<!-- SWITCHER -->
		<link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all" data-default-color="true" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="assets/images/favicon-icon/24x24.png">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
</head>
<body>

<!-- Start Switcher -->
<?php include('includes/colorswitcher.php');?>
<!-- /Switcher -->

<!--Header-->
<?php include('includes/header.php');?>
<!-- /Header -->

<!--Listing-Image-Slider-->

<?php
$tid=intval($_GET['tid']);
$sql = "SELECT tbltours.*,tbltoursbrand.Brand_name,tbltoursbrand.id as bid  from tbltours join tbltoursbrand on tbltoursbrand.id=tbltours.tbrand where tbltours.id=:tid";
$query = $dbh -> prepare($sql);
$query->bindParam(':tid',$tid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{
$_SESSION['brndid']=$result->bid;
?>

<section id="listing_img_slider">
  <div><img src="admin/img/toursimages/<?php echo htmlentities($result->t_img1);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <div><img src="admin/img/toursimages/<?php echo htmlentities($result->t_img2);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <div><img src="admin/img/toursimages/<?php echo htmlentities($result->t_img3);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <div><img src="admin/img/toursimages/<?php echo htmlentities($result->t_img4);?>" class="img-responsive"  alt="image" width="900" height="560"></div>
 
</section>
<!--/Listing-Image-Slider-->


<!--Listing-detail-->
<section class="listing-detail">
  <div class="container">
    <div class="listing_detail_head row">
      <div class="col-md-9">
        <h2><?php echo htmlentities($result->Brand_name);?> , <?php echo htmlentities($result->tname);?></h2>
      </div>
      <div class="col-md-3">
        <div class="price_info">
          <p>$<?php echo htmlentities($result->tprice);?> </p>Per Hour

        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-9">
        <div class="main_features">
          <ul>

            <li> <i class="fa fa-calendar" aria-hidden="true"></i>
              <h5><?php echo htmlentities($result->duration);?></h5>
            </li>

            <li> <i class="fa fa-user-plus" aria-hidden="true"></i>
              <h5>Limited Places</h5>
            </li>
          </ul>
        </div>
        <div class="listing_more_info">
          <div class="listing_detail_wrap">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs gray-bg" role="tablist">
              <li role="presentation" class="active"><a href="#vehicle-overview " aria-controls="vehicle-overview" role="tab" data-toggle="tab">Tour Overview </a></li>

              <li role="presentation"><a href="#accessories" aria-controls="accessories" role="tab" data-toggle="tab">Includes</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
              <!-- vehicle-overview -->
              <div role="tabpanel" class="tab-pane active" id="vehicle-overview">

                <p><?php echo htmlentities($result->toverview);?></p>
              </div>


              <!-- Accessories -->
              <div role="tabpanel" class="tab-pane" id="accessories">
                <!--Accessories-->
                <table>
                  <thead>
                    <tr>
                      <th colspan="2">Includes</th>
                    </tr>
                  </thead>
                  <tbody>



 <div class="tab-content">
              <!-- vehicle-overview -->
              <div role="tabpanel" class="tab-pane active" id="vehicle-overview">

                <p><?php echo htmlentities($result->tincludes);?></p>
              </div>



                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
<?php }} ?>

      </div>

      <!--Side-Bar-->
      <aside class="col-md-3">

        <div class="share_vehicle">
          <p>Share: <a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a> </p>
        </div>
        <div class="sidebar_widget">
          <div class="widget_heading">
            <h5><i class="fa fa-envelope" aria-hidden="true"></i>Book Now</h5>
          </div>
          <form method="post">
            <div class="form-group">
              <input type="text" class="form-control" name="tdate" placeholder=" Date(dd/mm/yyyy)" required>
            </div>
             <div class="form-group">
              <input type="text" class="form-control" name="thour" placeholder=" Hour(hh/mm)" required>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="nbchl" placeholder="Children Number" required>
            </div><div class="form-group">
              <input type="text" class="form-control" name="nbadl" placeholder="Adults Number" required>
            </div>
            <div class="form-group">
              <textarea rows="4" class="form-control" name="tmessage" placeholder="Message" required></textarea>
            </div>
          <?php if($_SESSION['login'])
              {?>
              <div class="form-group">
                <input type="submit" class="btn"  name="submit" value="Book Now">
              </div>
              <?php } else { ?>
<a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal">Login For Book</a>

              <?php } ?>
          </form>
        </div>
      </aside>
      <!--/Side-Bar-->
    </div>

    <div class="space-20"></div>
    <div class="divider"></div>

    <!--Similar-Cars-->
    <div class="similar_cars">
      <h3>Similar Tours</h3>
      <div class="row">
<?php
$bid=$_SESSION['brndid'];
$sql="SELECT tbltours.tname,tbltours.duration,tbltoursbrand.Brand_name,tbltours.tprice,tbltours.toverview,tbltours.t_img1 from tbltours join tbltoursbrand on tbltoursbrand.id=tbltours.tbrand where tbltours.tbrand=:bid";
$query = $dbh -> prepare($sql);
$query->bindParam(':bid',$bid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{ ?>
        <div class="col-md-3 grid_listing">
          <div class="product-listing-m gray-bg">
            <div class="product-listing-img"> <a href="tour-details.php?tid=<?php echo htmlentities($result->id);?>"><img src="admin/img/toursimages/<?php echo htmlentities($result->t_img1);?>" class="img-responsive" alt="image" /> </a>
            </div>
            <div class="product-listing-content">
              <h5><a href="tour-details.php?tid=<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->Brand_name);?> , <?php echo htmlentities($result->tname);?></a></h5>
              <p class="list-price">$<?php echo htmlentities($result->tprice);?></p>

              <ul class="features_list">

             <li><i class="fa fa-user" aria-hidden="true"></i><?php echo htmlentities($result->duration);?> </li>
                <li><i class="fa fa-calendar" aria-hidden="true"></i>LimiTed Place</li>
              </ul>
            </div>
          </div>
        </div>
 <?php }} ?>

      </div>
    </div>
    <!--/Similar-Cars-->

  </div>
</section>
<!--/Listing-detail-->

<!--Footer -->
<?php include('includes/footer.php');?>
<!-- /Footer-->

<!--Back to top-->
<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
<!--/Back to top-->

<!--Login-Form -->
<?php include('includes/login.php');?>
<!--/Login-Form -->

<!--Register-Form -->
<?php include('includes/registration.php');?>

<!--/Register-Form -->

<!--Forgot-password-Form -->
<?php include('includes/forgotpassword.php');?>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/interface.js"></script>
<script src="assets/switcher/js/switcher.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>

</body>
</html>
