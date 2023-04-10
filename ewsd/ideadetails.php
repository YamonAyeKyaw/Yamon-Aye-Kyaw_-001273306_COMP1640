<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';
session_start();
include 'likeserver.php';
include 'connect.php';

if (isset($_POST['txtanonymous'])) {
    $txtanonymous = $_POST['txtanonymous'];
}
else{
    $txtanonymous = "false";
}

if (isset($_POST['btnComment'])) {
    $Comment=$_POST['txtcomment'];
    $CommentedOn=$_POST['txtideaid'];
    $CommentedBy=$_POST['txtuserid'];
    $ToAuthor=$_POST['txtuseremail'];

    $query="INSERT INTO comment(Comment,CommentedTime,CommentedBy,CommentedOn,CisAnonymous) VALUES ('$Comment',CURRENT_TIMESTAMP(),'$CommentedBy','$CommentedOn','$txtanonymous')";
    $result=mysqli_query($connection,$query);

    if ($result) {
        $mail = new PHPMailer(true);
        
        // $mail->SMTPDebug = 2;                                  
        $mail->isSMTP();                                           
        $mail->Host       = 'smtp.gmail.com;';                   
        $mail->SMTPAuth   = true;                            
        $mail->Username   = 'testewsd@gmail.com';                
        $mail->Password   = 'mdcqlhyszybrkogz';                       
        $mail->SMTPSecure = 'tls';                             
        $mail->Port       = 587;

        $mail->setFrom('testewsd@gmail.com', 'TestEWSD');          
        $mail->addAddress($ToAuthor);
              
        $mail->isHTML(true);                                 
        $mail->Subject = 'New message from UOG website';
        $mail->Body    = '<p>Dear user,</p>
        <p>We would like to inform you that a new comment has been posted on the idea you are following. Please log in to view and respond to this comment.</p>
        <p>Your participation and feedback are critical to the success of our innovation efforts, and we appreciate your continued involvement.</p>
        <p>Best regards.</p>';
        // $mail->AltBody = 'Body in plain text for non-HTML mail clients';
        $mail->send();
        // echo "Mail has been sent successfully!";
        echo "<script>window.alert('Comment is successfully uploaded.')</script>";
        echo "<script>window.location='allideas_staff.php'</script>";
    }
    else
    {
        echo "<p>Something went wrong in Comment Upload!" . mysqli_error($connection) .  "</p>";
    }
    
} 

if(isset($_REQUEST['IdeaID']))
{
	$IdeaID=$_REQUEST['IdeaID'];
	$select="SELECT * 
             FROM idea 
             INNER JOIN academicyear ON academicyear.AcademicYearID=idea.AcademicYearID
             INNER JOIN category ON category.CategoryID=idea.CategoryID
             INNER JOIN user ON user.UserID=idea.UploadedBy
             WHERE idea.IdeaID='$IdeaID'";
	$query=mysqli_query($connection,$select);
	$count=mysqli_num_rows($query);
	if($count>0)
	{
		$data=mysqli_fetch_array($query);
        $IdeaID=$data['IdeaID'];
		$Year=$data['Year'];
        $Term=$data['Term'];
		$CategoryName=$data['CategoryName'];
		$IdeaTitle=$data['IdeaTitle'];
        $IdeaDetails=$data['IdeaDetails'];
        $AttachmentFile=$data['AttachmentFile'];
        $isAnonymous=$data['isAnonymous'];
        $UploadedBy=$data['Name'];
        $UploadedOn=$data['UploadedOn'];
        $Views=$data['Views'];
        $AuthorEmail=$data['Email'];
	}
}

$vquery="SELECT * 
         FROM idea 
         WHERE IdeaID=$IdeaID";
$vresult=mysqli_query($connection,$vquery);
$updateviews="UPDATE idea 
              SET Views=Views+1 
              WHERE IdeaID=$IdeaID";
mysqli_query($connection,$updateviews);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/uog-logo2.png" type="image/icon type">
    <title>University of Greenwich | Idea Details</title>

    <!-- CSS links -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!-- bootstrap cdn link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
    <nav class="navi-bar">
        <div class="logo">
            <i class="uil uil-bars menu-icon"></i>
            <img src="img/uog-logo.png" alt="University of Greenwich Logo">
        </div>

        <div class="sidebar">
            <div class="logo">
                <i class="uil uil-bars menu-icon"></i>
                <img src="img/uog-logo.png" alt="University of Greenwich Logo">
            </div>
            <div class="sidebar-content">
                <ul class="lists">
                    <li class="list">
                        <a href="allideas_staff.php" class="nav_link">
                            <i class="uil uil-lightbulb-alt icon"></i>
                            <span class="link-name">All Ideas</span>
                        </a>
                    </li>
                    <li class="list">
                        <a href="latestideas_staff.php" class="nav_link">
                            <i class="uil uil-newspaper icon"></i>
                            <span class="link-name">Lastest Ideas</span>
                        </a>
                    </li>
                    <li class="list">
                        <a href="mostpopularideas_staff.php" class="nav_link">
                            <i class="uil uil-analysis icon"></i>
                            <span class="link-name">Most Popular Ideas</span>
                        </a>
                    </li>
                    <li class="list">
                        <a href="mostviewedideas_staff.php" class="nav_link">
                            <i class="uil uil-eye icon"></i>
                            <span class="link-name">Most Viewed Ideas</span>
                        </a>
                    </li>
                    <li class="list">
                        <a href="tags_staff.php" class="nav_link">
                            <i class="uil uil-tag icon"></i>
                            <span class="link-name">Tags</span>
                        </a>
                    </li>
                    <li class="list">
                        <a href="uploadidea.php" class="nav_link">
                            <i class="uil uil-upload icon"></i>
                            <span class="link-name">Upload Idea</span>
                        </a>
                    </li>
                </ul>

                <div class="bottom-content">
                    <ul>
                        <li class="list">
                            <a href="updateuserbyself_staff.php" class="nav_link">
                                <i class="uil uil-user-circle icon"></i>
                                <span class="link-name">Account</span>
                            </a>
                        </li>
                        <li class="list">
                            <a href="logout.php" class="nav_link">
                                <i class="uil uil-signout icon"></i>
                                <span class="link-name">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <section class="overlay"></section>
    <main>
        <div class="container" style="margin-top: 100px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="allideas_staff.php">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Idea Details</li>
                </ol>
              </nav>

            <div class="tag-idea-container">
                <div class="row mb-5">
                    <div class="col-lg-12">
                        <div class="idea-post w-100">
                            <div class="idea-time text-right">
                                <small class="mb-0"><?php echo $UploadedOn;?></small>
                            </div>
                            <hr>
                            <span class="badge rounded-pill bg-light text-dark text-wrap mb-2 tags active" style="font-size: 14px; font-weight: 500;">#<?php echo $CategoryName?></span>
                            <div class="about-idea">
                                <h6 class="my-2"><?php echo $IdeaTitle?></h6>
                                <p><?php echo $IdeaDetails?></p>
                            </div>
                            <div class="idea-author my-3 text-right">
                                <small>Idea uploaded by <b>
                                    <?php 
                                    if ($data['isAnonymous']=="false") 
                                    {
                                        echo $UploadedBy = $data['Name'];
                                    }
                                    else
                                    {
                                        echo $UploadedBy = "Anonymous User";
                                    }
                                    ?>
                                    </b>
                                </small>
                            </div>

                            <hr>

                            <div class="like-cmt-container">
                                <div class="like-cmt-box">
                                    <span><i class="bx bx-like mr-2 align-items-center justify-content-center align-middle"></i>Thumb Up (<span class="like_count"><?php echo getLikes($data['IdeaID']) ?></span>)</span>
                                </div>
                                <div class="like-cmt-box">
                                    <span><i class="bx bx-dislike mr-2 align-items-center justify-content-center align-middle"></i>Thumb Down (<span class="dislike_count"><?php echo getDislikes($data['IdeaID']) ?></span>)</span>
                                </div>
                                <div class="like-cmt-box">
                                    <span><i class="uil uil-comment mr-2"></i>Comments (<?php
                                        $select="SELECT COUNT(*) AS CommentCount FROM comment WHERE CommentedOn=". $data['IdeaID'] ."";
                                        $query=mysqli_query($connection,$select);
                                        $rows=mysqli_fetch_array($query);
                                        $CommentCount = $rows['CommentCount'];
                                        echo $CommentCount;
                                        ?>)</span>
                                </div>
                                <div class="like-cmt-box">
                                    <span><i class="uil uil-eye mr-2"></i>Views (<?php echo $data['Views'] ?>)</span>
                                </div>
                            </div>

                            <hr>

                            <div class="like-unlike">
                                <!-- <span class="thumb thumb-up"> -->
                                    <i 
                                    <?php if (userLiked($data['IdeaID'])): ?>
                                        class="bx bxs-like like-btn mr-2"
                                    <?php else: ?>
                                        class="bx bx-like like-btn mr-2"
                                    <?php endif ?>
                                        data-id="<?php echo $data['IdeaID'] ?>" style="font-size: 20px; align-items: center; justify-content: center; vertical-align: middle;"></i>
                                <!-- </span> -->

                                <!-- <span class="thumb thumb-down"> -->
                                    <i 
                                    <?php if (userDisliked($data['IdeaID'])): ?>
                                        class="bx bxs-dislike dislike-btn mr-2"
                                    <?php else: ?>
                                        class="bx bx-dislike dislike-btn mr-2"
                                    <?php endif ?>
                                        data-id="<?php echo $data['IdeaID'] ?>" style="font-size: 20px; align-items: center; justify-content: center; vertical-align: middle;"></i>
                                <!-- </span> -->
                            </div>

                            <hr>

                            <?php
                                $select="SELECT * 
                                         FROM comment 
                                         INNER JOIN user ON user.UserID=comment.CommentedBy
                                         INNER JOIN idea ON idea.IdeaID=comment.CommentedOn
                                         WHERE comment.CommentedOn=$IdeaID";
                                $query=mysqli_query($connection,$select);
                                $count=mysqli_num_rows($query);
                            ?>

                            <div class="comment">
                                <div class="comment-title mb-3">
                                    <h5 style="font-weight: 600; font-size: 18px;">COMMENTS</h5>
                                </div>
                                <div class="comment-list mb-3">
                                    <?php
                                        for($i=0;$i<$count;$i++){
                                        $rows=mysqli_fetch_array($query);
                                        $CommentID=$rows['CommentID'];
                                        $Comment=$rows['Comment'];
                                        $CommentedBy=$rows['Name'];
                                        $CommentedTime=$rows['CommentedTime'];
                                    ?>
                                    <div class="others-comment">
                                        <p class="mb-0"><b>
                                            <?php 
                                                if ($rows['CisAnonymous']=="false") 
                                                {
                                                    echo $rows['Name'];
                                                }
                                                else
                                                {
                                                    echo "Anonymous User";
                                                }
                                            ?>
                                        </b></p>
                                        <small><?php echo $CommentedTime?></small>
                                        <p class="mt-3"><?php echo $Comment?></p>                                    
                                    </div>
                                    <hr>
                                    <?php
                                        }
                                    ?>
                                </div>

                                <?php 
                                $sql="SELECT * 
                                    FROM academicyear
                                    INNER JOIN idea ON idea.AcademicYearID=academicyear.AcademicYearID
                                    WHERE idea.IdeaID=$IdeaID";
                                $result=$connection->query($sql);

                                if($result->num_rows > 0){
                                    $row=$result->fetch_assoc();
                                    $FinalClosureDate=$row['FinalClosureDate'];
                                }
                                ?>

                                <script>
                                    $(document).ready(function(){
                                        var FinalClosureDate=new Date("<?php echo $FinalClosureDate;?>");
                                        var CurrentDate=new Date();

                                        if (CurrentDate > FinalClosureDate) {
                                            $("#comment-container").hide();
                                        }
                                    });
                                </script>

                                

                                <div class="comment-form mt-4" id="comment-container">
                                    <p class="mb-3" style="font-size: 14px; font-weight: 500;">ADD COMMENT</p>
                                    <form action="ideadetails.php" method="POST" enctype="multipart/form-data" class="form">
                                    <textarea class="mb-3 w-100 p-3" name="txtcomment" id="" cols="30" rows="4" required></textarea>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" name="txtanonymous" type="checkbox" value="false" id="checkbox1">
                                        <label class="form-check-label" for="checkbox1">Upload Anonymously</label>
                                    </div>

                                    <input type="hidden" name="txtideaid" class="form-control" value="<?php echo $IdeaID ?>">

                                    <div class="form-group">
                                        <?php
                                            if (isset($_SESSION['UserID'])) 
                                            {
                                                $UserID=$_SESSION['UserID'];
                                            }
                                        ?>
                                        <input type="hidden" name="txtuserid" class="form-control" value="<?php echo $UserID ?>">
                                    </div>

                                    <input type="hidden" name="txtuseremail" class="form-control" value="<?php echo $data['Email'] ?>">

                                    <!-- <div class="mb-2"> -->
                                        <input class="btn-comment" type="submit" value="Comment" name="btnComment">
                                    <!-- </div> -->
                                    </form>
                                </div>
                            
                            </div>

        
                        </div>
                    </div>   

                </div>
            </div>
        </div>
    </main>
</body>
<script src="likescript.js"></script>
<script>
    const navBar = document.querySelector("nav"),
          menuBtns = document.querySelectorAll(".menu-icon"),
          overlay = document.querySelector(".overlay");
    menuBtns.forEach(menuBtn => {
        menuBtn.addEventListener("click", () => {
            navBar.classList.toggle("open");
        });
    });

    overlay.addEventListener("click", () => {
        navBar.classList.remove("open");
    });

    $("#checkbox1").on('change', function() {
        if ($(this).is(':checked')) {
            $(this).attr('value', 'true');
        } 
        else {
            $(this).attr('value', 'false');
        }
    });

</script>
</html>