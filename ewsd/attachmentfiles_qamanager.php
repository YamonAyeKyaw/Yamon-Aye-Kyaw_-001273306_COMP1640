<?php
include('connect.php');
include('downloadeachfile.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/uog-logo2.png" type="image/icon type">
    <title>University of Greenwich | Ideas & Attachment Files</title>

    <!-- CSS links -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- bootstrap cdn link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
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
                        <a href="home_qamanager.php" class="nav_link">
                            <i class="uil uil-estate icon"></i>
                            <span class="link-name">Home</span>
                        </a>
                    </li>
                    <li class="list">
                        <a href="allideas_qamanager.php" class="nav_link">
                            <i class="uil uil-lightbulb-alt icon"></i>
                            <span class="link-name">All Ideas</span>
                        </a>
                    </li>
                    <li class="list">
                        <a href="latestideas_qamanager.php" class="nav_link">
                            <i class="uil uil-newspaper icon"></i>
                            <span class="link-name">Lastest Ideas</span>
                        </a>
                    </li>
                    <li class="list">
                        <a href="mostpopularideas_qamanager.php" class="nav_link">
                            <i class="uil uil-analysis icon"></i>
                            <span class="link-name">Most Popular Ideas</span>
                        </a>
                    </li>
                    <li class="list">
                        <a href="mostviewedideas_qamanager.php" class="nav_link">
                            <i class="uil uil-eye icon"></i>
                            <span class="link-name">Most Viewed Ideas</span>
                        </a>
                    </li>
                    <li class="list">
                        <a href="tags_qamanager.php" class="nav_link">
                            <i class="uil uil-tag icon"></i>
                            <span class="link-name">Tags</span>
                        </a>
                    </li>
                    <li class="list">
                        <a href="attachmentfiles_qamanager.php" class="nav_link active">
                            <i class="uil uil-paperclip icon"></i>
                            <span class="link-name">Attachment Files</span>
                        </a>
                    </li>
                    <li class="list">
                        <a href="category_qamanager.php" class="nav_link">
                            <i class="uil uil-list-ol icon"></i>
                            <span class="link-name">Category</span>
                        </a>
                    </li>
                    <li class="list">
                        <a href="department_qamanager.php" class="nav_link">
                            <i class="uil uil-building icon"></i>
                            <span class="link-name">Department</span>
                        </a>
                    </li>
                    
                </ul>

                <div class="bottom-content">
                    <ul>
                        <li class="list">
                            <a href="updateuserbyself_qamanager.php" class="nav_link">
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

            <div class="tablepage-header">
                <div class="pt-3">
                    <h4>Ideas & Attachment Files</h4>
                </div>
                <div class="th-btns" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                    <div class="btnCSV">
                        <a href="exportidea.php" type="submit" id="export_csv_data" name='export_csv_data' value="Export to CSV" class="btn-modal" style="text-decoration: none;">Export to CSV</a>
                    </div>
                    
                    <button type="button" class="btn-modal">
                        <a href="downloadfunction/downloadfile.php" style="text-decoration: none; color: #FFFFFF;">
                        <i class='bx bxs-download mr-2' style="align-items: center; justify-content: center; vertical-align: middle;"></i>Download All Files in ZIP File
                    </a>
                    </button>
                </div>
            </div>

<?php
$query="SELECT * 
        FROM idea
        INNER JOIN academicyear ON academicyear.AcademicYearID=idea.AcademicYearID
        INNER JOIN category ON category.CategoryID=idea.CategoryID";
$result=mysqli_query($connection,$query);
$count=mysqli_num_rows($result);

if ($count < 1) {
    echo "<p>No File Found.</p>";
}
else{
    ?>
    <div class="table-container">
                <table class="table">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Year</th>
                        <th>Term</th>
                        <th>Category</th>
                        <th>IdeaTitle</th>
                        <th>IdeaDetails</th>
                        <th>Download File</th>
                        <th>Download as ZIP File</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        for($i=0;$i<$count;$i++){
                            $rows=mysqli_fetch_array($result);

                        $IdeaID=$rows['IdeaID'];
                        $Year=$rows['Year'];
                        $Term=$rows['Term'];
                        $Category=$rows['CategoryName'];
                        $IdeaTitle=$rows['IdeaTitle'];
                        $IdeaDetails=$rows['IdeaDetails'];
                        $AttachmentFile=$rows['AttachmentFile'];

                        echo "<tr>";
                        echo "<td>$IdeaID</td>";
                        echo "<td>$Year</td>";
                        echo "<td>$Term</td>";
                        echo "<td>$Category</td>";
                        echo "<td>$IdeaTitle</td>";
                        echo "<td>$IdeaDetails</td>";
                        // echo "<td>" . $rows['AttachmentFile'] . "</td>";
                        echo "<td>
                            <button type='button' style='outline: none; border: none; border-radius: 6px; cursor: pointer; padding: 5px; color: #FFFFFF; background-color: #000080;'>
                                <a style='text-decoration: none; color: #FFFFFF;' href='$AttachmentFile' download>
                                <i class='bx bxs-download p-1 align-items-center justify-content-center align-middle'></i></a>
                            </button>
                        </td>";
                        echo "<td>
                            <button type='button' style='outline: none; border: none; border-radius: 6px; cursor: pointer; padding: 5px; color: #FFFFFF; background-color: #000080;'>
                                <a style='text-decoration: none; color: #FFFFFF;' href='attachmentfiles_qamanager.php?IdeaID=$IdeaID'>
                                <i class='bx bxs-download p-1 align-items-center justify-content-center align-middle'></i></a>
                            </button>
                        </td>";

                        // echo "<td><a href='$AttachmentFile' download>Download</a></td>";
                        // echo "<td><a href='idealist.php?IdeaID=$IdeaID'>Download</a></td>";
                        echo "</tr>";
                        }
                        ?>
                    </tbody>
                  </table>
            </div>
<?php
}
?>
       
        </div>
    </main>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
</script>
</html>