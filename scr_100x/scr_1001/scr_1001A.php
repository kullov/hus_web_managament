<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "student") {
  header("location: ../../");
  exit;
}



  // Include config file
  require "../../config.php";
// Define variables and initialize with empty values
$code = $request_id = $start_date = $end_date = $status = "";
$request_id_err = $start_date_err = $end_date_err = $status_err = "";
$student_id = $_SESSION["id"];
// Prepare a select statement
// Câu SQL lấy danh sách
// $sql = "SELECT id, first_name, last_name, email, phone, date_of_birth, class_name, join_date, avatar, description FROM intern_profile WHERE code = ?";
 
// if ($stmt = mysqli_prepare($link, $sql)) {
  
//   // Bind variables to the prepared statement as parameters
//   mysqli_stmt_bind_param($stmt, "s", $username);

//   // Attempt to execute the prepared statement
//   if (mysqli_stmt_execute($stmt)) {
//     // Store result
//     mysqli_stmt_store_result($stmt);
//     // Check if username exists, if yes then verify password
//     if (mysqli_stmt_num_rows($stmt) == 1) {
//       // Bind result variables
//       mysqli_stmt_bind_result($stmt, $id, $first_name, $last_name, $email, $phone, $date_of_birth, $class_name, $join_date, $avatar, $description);
//       mysqli_stmt_fetch($stmt);
//     }
//   } else {
//     echo "Oops! Something went wrong. Please try again later.";
//   }
//   // Close statement
//   mysqli_stmt_close($stmt);
// }



// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Validate request_id
  if (empty(trim($_POST["request_id"]))) {
    $request_id_err = "Please choose the request id!";
  } else {
    $request_id = trim($_POST["request_id"]);
  }
  
  // Validate start_date
  if (empty(trim($_POST["start_date"]))) {
    $start_date_err = "Please enter your start date!";
  } else {
    $start_date = trim($_POST["start_date"]);
  }

  // Validate end date
  if (empty(trim($_POST["end_date"]))) {
    $end_date_err = "Please enter your end date!";
  } else {
    $end_date = trim($_POST["end_date"]);
  }

  // Validate status
  if (empty(trim($_POST["status"]))) {
    $status_err = "Please choose status!";
  } else {
    $status = trim($_POST["status"]);
  }
  // $code = trim($_POST["code"]);

  // Prepare an insert statement
  $sql = " INSERT INTO `request_assignment` (`request_id`, `intern_id`, `start_date`, `end_date`, `status`) VALUES (?, ?, ?, ?, ?);";

  if ($stmt = mysqli_prepare($link, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "sssss", $request_id, $student_id, $start_date, $end_date, $status);
    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
      // Redirect to login page
      header("location: scr_1001.php");
    } else {
      echo "Something went wrong. Please try again later.";
    }
    mysqli_stmt_close($stmt);
  }
  // Close connection
  mysqli_close($link);
}


?>
<!DOCTYPE html>
<html>
<title>Đăng ký phiếu yêu cầu</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  body,
  h1,
  h2,
  h3,
  h4,
  h5,
  h6 {
    font-family: "Raleway", Arial, Helvetica, sans-serif
  }

  .mySlides {
    display: none
  }
</style>

<body class="w3-light-grey w3-content" style="max-width:1600px">
  <?php include("../../navigation.php"); ?>
  <div>
    <!-- Sidebar/menu -->
    <nav class="w3-sidebar w3-light-grey w3-collapse w3-top" style="z-index:3;width:300px;margin-top: 55px;" id="mySidebar">
      <div class="w3-container w3-display-container w3-padding-16 w3-margin-bottom">
        <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright"></i>
        <h3 class="w3-center">PHIẾU ĐĂNG KÝ</h3>
        <p class="w3-center"><i>Sinh viên đăng ký nguyện vọng thực tập vào doanh nghiệp.</i></p>
        <form action="scr_1001A.php" method="post">
          <div class="form-group <?php echo (!empty($request_id_err)) ? 'has-error' : ''; ?>">
            <p><label><i class="fa fa-qrcode"></i> Mã phiếu yêu cầu</label></p>
            <select class="w3-select w3-border" name="request_id" required value="<?php echo $request_id; ?>">
              <option value="" disabled selected>Chọn mã phiếu</option>
              <option value="0" >1000</option>
              <option value="1" >1001</option>
              <option value="2" >1002</option>
            </select>
            <span class="w3-text-red"><?php echo $request_id_err; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($start_date_err)) ? 'has-error' : ''; ?>">
            <p><label><i class="fa fa-calendar-check-o"></i> Ngày bắt đầu</label></p>
            <input class="w3-input w3-border" type="date" placeholder="DD MM YYYY" name="start_date" required value="<?php echo $start_date; ?>">
            <span class="w3-text-red"><?php echo $start_date_err; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($end_date_err)) ? 'has-error' : ''; ?>">
            <p><label><i class="fa fa-calendar-o"></i> Ngày kết thúc</label></p>
            <input class="w3-input w3-border" type="date" placeholder="DD MM YYYY" name="end_date" required value="<?php echo $end_date; ?>">
            <span class="w3-text-red"><?php echo $end_date_err; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($status_err)) ? 'has-error' : ''; ?>">
            <p><label><i class="fa fa-hourglass-start"></i> Trạng thái</label></p>
            <select class="w3-select w3-border" name="status" required value="<?php echo $status; ?>">
              <option value="" disabled selected>Chọn trạng thái</option>
              <option value="0">Đang chờ</option>
              <option value="1">Đang thực hiện</option>
              <option value="2">Đã thực hiện xong</option>
            </select>
            <span class="w3-text-red"><?php echo $status_err; ?></span>
          </div>
          <p>
            <button type="submit" class="w3-button w3-dark-grey w3-block">Đăng ký</button>
          </p>
        </form>
        <p class="w3-center">
          <a href="scr_1001.php" onclick="w3_close()" class="w3-bar-item w3-button w3-margin-bottom">TRỞ VỂ</a>
        </p>
      </div>
    </nav>

    <!-- Top menu on small screens -->
    <header class="w3-bar w3-top w3-hide-large w3-black w3-xlarge">
      <span class="w3-bar-item">Rental</span>
      <a href="javascript:void(0)" class="w3-right w3-bar-item w3-button" onclick="w3_open()"><i class="fa fa-bars"></i></a>
    </header>

    <!-- Overlay effect when opening sidebar on small screens -->
    <div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

    <!-- !PAGE CONTENT! -->
    <div class="w3-main w3-white" style="margin-left:300px; margin-top: 55px;">

      <!-- Push down content on small screens -->
      <div class="w3-hide-large" style="margin-top:80px"></div>

      <!-- Slideshow Header -->
      <div class="w3-container" id="space">
        <h1 class="w3-text-green">Java Job</h1>
        <h6>Mã phiếu: <b>1012</b></h6>
        <hr>
        <h4><strong>KHÔNG GIAN</strong></h4>
        <div class="w3-display-container mySlides">
          <img src="https://we25.vn/media/images/anh3(13).jpg" style="width:100%;height:420px;margin-bottom:-6px">
          <div class="w3-display-bottomleft w3-container w3-black">
            <p>Công ty của chúng tôi</p>
          </div>
        </div>
        <div class="w3-display-container mySlides">
          <img src="https://file4.batdongsan.com.vn/resize/745x510/2019/06/10/20190610085624-b7e0_wm.jpg" style="width:100%;height:420px;margin-bottom:-6px">
          <div class="w3-display-bottomleft w3-container w3-black">
            <p>Công ty của chúng tôi</p>
          </div>
          </div>
        <div class="w3-display-container mySlides">
          <img src="https://cogo.vn/2018_cogo_contents/images/SYL_7995.jpg" style="width:100%;height:420px;margin-bottom:-6px">
          <div class="w3-display-bottomleft w3-container w3-black">
            <p>Công ty của chúng tôi</p>
          </div>
        </div>
        <div class="w3-display-container mySlides">
          <img src="https://znews-photo.zadn.vn/w660/Uploaded/wyhktpu/2018_05_10/image007.jpg" style="width:100%;height:420px;margin-bottom:-6px">
          <div class="w3-display-bottomleft w3-container w3-black">
            <p>Công ty của chúng tôi</p>
          </div>
        </div>
      </div>
      <div class="w3-row-padding w3-section">
        <div class="w3-col s3">
          <img class="demo w3-opacity w3-hover-opacity-off" src="https://we25.vn/media/images/anh3(13).jpg" style="width:100%;height:106px;cursor:pointer" onclick="currentDiv(1)" title="Living room">
        </div>
        <div class="w3-col s3">
          <img class="demo w3-opacity w3-hover-opacity-off" src="https://cogo.vn/2018_cogo_contents/images/SYL_7995.jpg" style="width:100%;height:106px;cursor:pointer" onclick="currentDiv(3)" title="Bedroom">
        </div>
        <div class="w3-col s3">
          <img class="demo w3-opacity w3-hover-opacity-off" src="https://znews-photo.zadn.vn/w660/Uploaded/wyhktpu/2018_05_10/image007.jpg" style="width:100%;height:106px;cursor:pointer" onclick="currentDiv(4)" title="Second Living Room">
        </div>
        <div class="w3-col s3">
          <img class="demo w3-opacity w3-hover-opacity-off" src="https://file4.batdongsan.com.vn/resize/745x510/2019/06/10/20190610085624-b7e0_wm.jpg" style="width:100%;height:106px;cursor:pointer" onclick="currentDiv(2)" title="Dining room">
        </div>
      </div>
      <div id="about" class="w3-container">
        <br>
        <br>
        <h4><strong>THÔNG TIN</strong></h4>
        <div class="w3-row w3-large">
          <div class="w3-col s6">
            <p><i class="fa fa-fw fa-male"></i> Chúng tôi cần: <b>30</b> người</p>
            <p><i class="fa fa-fw fa-check-square"></i> Số lượng đã đăng ký: 62</p>
            <p><i class="fa fa-fw fa-clock-o"></i> Check In: 8:30 AM</p>
            <p><i class="fas fa-map-marker-alt"></i> Địa điểm làm việc: 334 Nguyễn Trãi, Thanh Xuân, Hà Nội</p>
          </div>
          <div class="w3-col s6">
            <p><i class="fa fa-fw fa-check"></i> Trạng thái: Còn hiệu lực</p>
            <p><i class="fas fa-check-double"></i> Đã được phân công: 10</p>
            <p><i class="fa fa-fw fa-clock-o"></i> Check Out: 5:30 PM</p>
            <p><i class="fas fa-calendar-alt"></i> Hình thức làm việc: Fulltime</p>
          </div>
        </div>
        <hr>
        
        <h4><strong>Mô tả công việc</strong></h4>
        <p>• Tham gia triển khai dự án nền tảng ngân hàng số, trực tiếp lập trình và hỗ trợ các thành viên trong nhóm lập trình (Java/JavaScripts)</p>
        <p>• Tiếp nhận chuyển giao công nghệ từ nhà cung cấp giải pháp</p>
        <p>• Chủ động cập nhật các xu hướng, công nghệ, giải pháp mới nhằm đề xuất những ứng dụng đáp ứng tốt hơn nhu cầu của Khách hàng và các bộ phận trong Ngân hàng</p>
        <hr>

        <h4><strong>Phúc lợi</strong></h4>
        <div class="w3-row w3-large">
          <div class="w3-col s6">
            <p><i class="fa fa-fw fa-shower"></i> Playing</p>
            <p><i class="fa fa-fw fa-wifi"></i> WiFi</p>
            <p><i class="fa fa-fw fa-tv"></i> TV</p>
          </div>
          <div class="w3-col s6">
            <p><i class="fa fa-fw fa-cutlery"></i> Kitchen</p>
            <p><i class="fa fa-fw fa-thermometer"></i> Heating</p>
            <p><i class="fa fa-fw fa-wheelchair"></i> Accessible</p>
          </div>
        </div>
        <div>
          <h4>Ngoài ra, bạn sẽ được hưởng:</h4>
          <p>• Mức lương hỗ trợ từ 3 triệu VND trở lên</p>
          <p>• Môi trường làm việc chuyên nghiệp</p>
          <p>• Có cơ hội thăng tiến, đào tạo</p>
        </div>
      </div>
      <hr>
      
      <!-- Yêu cầu -->
      <div class="w3-container" id="require">
        <br><br>
        <h2>YÊU CẦU</h2>
        <p>• Tốt nghiệp Đại học nước ngoài hoặc tốt nghiệp hệ kỹ sư tài năng các trường Đại học chính quy như ĐH Quốc Gia Hà Nội, ĐH Bách Khoa, ĐH Khoa học tự nhiên, Đại học FPT…</p>
        <p>• Có kinh nghiệm lập trình về <b>Java</b></p>
        <p>• Có thể làm việc bằng tiếng Anh với người nước ngoài – tương đương TOEFL iBT 85 điểm trở lên</p>
        <p>• Có kỹ năng làm việc nhóm, có tinh thần trách nhiệm cao.</p>
        <p>• Ưu tiên kinh nghiệm với AngularJS (từ 2 trở lên), CSS (SASS), HTML5, Bootstrap</p>
        <p>• Ưu tiên kinh nghiệm với Java 8, Spring Boot, Hibernate, Rest APIs, Micro services, design patterns và TDD</p>
        <p>• Cam kết thực tập tối thiểu 3 tháng</p>
      </div>
      <!-- Contact -->
      <div class="w3-container" id="contact" style="margin-bottom:120px">
        <br><br>
        <h2>LIÊN HỆ</h2>
        <i class="fa fa-map-marker" style="width:30px"></i> 334 Nguyễn Trãi, Thanh Xuân, Hà Nội<br>
        <i class="fa fa-phone" style="width:30px"></i> Phone: 0349.749.393<br>
        <i class="fa fa-envelope" style="width:30px"> </i> Email: tranthanhnga_t61@hus.edu.vn<br>
        <p>Bạn có câu hỏi? Hãy để lại thông tin:</p>
        <form action="/action_page.php" target="_blank">
          <p><input class="w3-input w3-border" type="text" placeholder="Tên của bạn" required name="Name"></p>
          <p><input class="w3-input w3-border" type="text" placeholder="Email" required name="Email"></p>
          <p><input class="w3-input w3-border" type="text" placeholder="Hãy phản hồi cho chúng tôi" required name="Message"></p>
        <button type="submit" class="w3-button w3-green w3-third" >Gửi phản hồi</button>
        </form>
      </div>
      
      <footer class="w3-container w3-padding-16" style="margin-top:32px">Powered by 
        <a href="/web_management/" title="Origen" target="_blank" class="w3-hover-text-green">Origen</a>
        <a href="scr_1001.php" class="w3-button w3-green w3-right" onclick="document.getElementById('subscribe').style.display='block'">Trở về</a>
      </footer>

    <!-- End page content -->
    </div>

    <script>
    // Script to open and close sidebar when on tablets and phones
    function w3_open() {
      document.getElementById("mySidebar").style.display = "block";
      document.getElementById("myOverlay").style.display = "block";
    }
    
    function w3_close() {
      document.getElementById("mySidebar").style.display = "none";
      document.getElementById("myOverlay").style.display = "none";
    }

    // Slideshow Apartment Images
    var slideIndex = 1;
    showDivs(slideIndex);

    function plusDivs(n) {
      showDivs(slideIndex += n);
    }

    function currentDiv(n) {
      showDivs(slideIndex = n);
    }

    function showDivs(n) {
      var i;
      var x = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("demo");
      if (n > x.length) {slideIndex = 1}
      if (n < 1) {slideIndex = x.length}
      for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
      }
      for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" w3-opacity-off", "");
      }
      x[slideIndex-1].style.display = "block";
      dots[slideIndex-1].className += " w3-opacity-off";
    }
    </script>
  </div>
</body>

</html>