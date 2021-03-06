<?php
session_start();
include_once "php/config.php";

?>


<?php //撈資料
$sql = "SELECT * FROM users ORDER BY  uid DESC";
$query = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($query)) {
  $apply = mysqli_fetch_all($query, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SpeaCup有話直說</title>
  <link href="CSS/style.css" rel="stylesheet" />
  <link rel="icon" type="image/x-icon" href="assets/fav.ico" />
  <script src="JS/scripts.js"></script>
  <script src="js/jquery-3.6.0.js"></script>

  <!-- 外部匯入樣式 -->

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://kit.fontawesome.com/993da95711.js" crossorigin="anonymous"></script>
  <script language="javascript">
    function changeImageString(TargetID, FildAddres) {
      document.images[TargetID].src = FildAddres;
    }
  </script>
</head>




<body class="body">
  <header>
    <?php
    //個人資料
    $unique_id = mysqli_real_escape_string($conn, $_GET['unique_id']); //抓取連結過來的unique_id以取得對應資料
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id =  $unique_id ORDER BY  uid DESC");
    if ($$unique_id === "") {
      header("location: login.php");
    }
    if (mysqli_num_rows($sql) > 0) {
      $row = mysqli_fetch_assoc($sql);
    } else {
      header("location: apply.php");
    }

    //已發表文章
    $sql5 = "SELECT * FROM users INNER JOIN posts ON posts.unique_id = users.unique_id  WHERE posts.unique_id = $unique_id ORDER BY aid DESC";
    $query1 = mysqli_query($conn, $sql5);
    $output = "";
    if (mysqli_num_rows($query1) == 0) {
      $output .= "<p class=\"ml-5\">還沒有文章喔!</p>";
    } elseif (mysqli_num_rows($query1) > 0) {
      while ($row5 = mysqli_fetch_assoc($query1)) {

        $title_result = $row5['title'];
        (strlen($title_result) > 40) ? $title =  mb_substr($title_result, 0, 40, 'utf-8') . '...' : $title = $title_result;
     
        $content_result = $row5['content'];
        //(strlen($content_result) > 70) ? $content =  substr($content_result, 0, 100) . '...' : $content = $content_result;
        (strlen($content_result) > 32) ? $content =  mb_substr($content_result, 0, 32, 'utf-8') . '...' : $content = $content_result;
     
        $sql2 = "SELECT board_name FROM posts INNER JOIN board_Categories ON posts.cid = board_Categories.cid WHERE aid = '$row5[aid]'";
        $query2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($query2);
     
        $sql3 = "SELECT COUNT(*) AS likes FROM like_dislike 
             WHERE post_id = '$row5[aid]' AND rating_action='like'";
        $query3 = mysqli_query($conn, $sql3);
        $row3 = mysqli_fetch_assoc($query3);
     
        $sql4 = "SELECT COUNT(*) AS dislikes FROM like_dislike 
             WHERE post_id = '$row5[aid]' AND rating_action='dislike'";
        $query4 = mysqli_query($conn, $sql4);
        $row4 = mysqli_fetch_assoc($query4);
     
        //文章內容&格式
        $output .= '  
                        
                         <div id="c1" class="m-3 mb-3">
                            <div id="c1" class="row mb-2 ml-5 ">
                               <span style="font-size:20px;">' . $row2['board_name'] . '</span>
                               <img src="php/images/' . $row5['img'] . '"  alt=""  width="6%" height="6%" ">
                          
                                <span style="font-size:20px;">' . $row5['nickname'] . '</span>
                         
                                <div style="position:relative; border:0; min-width:60%; max-width:60%; ";>  
                                <span style="position:absolute; right: -10%;">' . $row5['created'] . '</span>
                                </div>
                            </div>
     
                          <a style="text-decoration:none" href="post.php?aid=' . $row5['aid'] . '">
                            <div id="c1" class="mt-4 ml-5">
                             <h2 style="color:black;">'. $title . '</h2>
                             <p style="font-size:20px; color:gray;">'.  $content . '</p> 
     
                             <i class="fa fa-thumbs-up like-btn" style="font-size: 0.8em; color:gray"
                                data-id=' .  $row5['aid'] . '"> 
                             </i>
                             <span class="likes" style="font-size: 1em; color:gray">' . $row3['likes'] . '</span>
     
                             &nbsp;&nbsp;&nbsp;&nbsp;
     
                             <i class="fa fa-thumbs-down dislike-btn" style="font-size: 0.8em; color:gray"
                                data-id=' .  $row5['aid'] . '"> 
                             </i>
                             <span class="dislikes" style="font-size: 1em; color:gray">' . $row4['dislikes'] . '</span>
                           
                            </div>
                         </div>
                        
                          </a>
                       <hr class="hr">';
     }
     
    }
    

    ?>


  </header>

  <!-- navbar -->
  <nav class="navbar fixed-top navbar-expand-md navbar-dark mr-1">
    <div clss="col-3">
      <a class="navbar-brand" href="index.php">
        <img src="assets/img/有話 直說 (1).png" width="35" height="35" class="d-inline-block align-top">
        <img src="assets/img/SpeaCup.png" width="150" height="35" class="d-inline-block align-top">
      </a>
    </div>

    <button class="navbar-toggler navbar-left" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="nav-navbar collapse navbar-collapse navbar-right " id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto pl-1">
        <form class="form-inline">
          <input class="form-control mr-sm-1" type="search" placeholder="SpeaCup" aria-label="Search">
          <button class="btn btn-outline-danger my-2 my-sm-0 " type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
        <li class="nav-item pl-5 mr-5">
        <li><a href=""><i class="fa-solid fa-bell">&ensp;&ensp;</i></a></li>
        <li><a href="login.php" title="會員中心"><i class="fa-solid fa-user">&ensp;&ensp;</i></a></li>
        </li>
    </div>


  </nav>

  <div id="siderbarleft" class="siderbarleft">
    <div id="sidebar">
      <button type="button" id="collapse" class="collapse-btn">
        <i class="fas fa-align-left"></i>
      </button>
      <ul class="list-unstyled p-1 ">
        <li>
          <a href="member.php" calss="m-2">基本資料<i class="fas mt-1 fa-solid fa-user-check"></i></i> </a>
        </li>
        <li>
          <a href="collections.php" calss="m-2">收藏文章<i class="fas mt-1 fa-solid fa-file-circle-plus"></i></i> </a>
        </li>
        <li>
          <a href="posts.php" calss="p-2">發表過文章<i class="fas mt-1 fa-regular fa-pen-to-square"></i></i> </a>
        </li>
        <li>
          <a href="friends.php" calss="m-2">好友列表<i class="fas mt-1  fa-solid fa-users"></i> </a>
        </li>
        <li>
          <a href="apply.php" calss="m-2">好友申請<i class="fas mt-1 fa-solid fa-user-pen"></i></i> </a>
        </li>
      </ul>
    </div>
  </div>


  <div id="siderbarindex">
    <div id="m-inform" class="mr-3 ml-3 mb-3">
      <h1 id="m-nickname-n" class="ml-5"><?php echo $row['nickname']; ?></h1>
      <h1 class="ml-5 text-dark display-5">基本資料</h1>
      <hr class="hr">
    </div>

    <div id="m-img " class="m-3 ">
      <h4 class="ml-5 text-muted">頭貼</h4>
      <div class="row">
        <input type="hidden" name="old_img" value="/<?php echo $row['img']; ?>" />
        <img src="php/images/<?php echo $row['img']; ?>" width="200px" height="200px" class="ml-5 col-3 rounded" alt="大頭貼">
        <hr class="hr">
      </div>
      <div id="m-bd" class="m-3">
        <h4 class="ml-5 text-muted">生日</h4>
        <label id="m-bd-b" class="ml-5"><?php echo $row['birth']; ?></label>
        <hr class="hr">
      </div>
    </div>


    <div id="m-index-p" class="m-3">
      <h1 class="ml-5 display-4">發表過文章 !!</h1>
    </div>
    <hr class="hr">

    <?php echo $output;  ?>

  <div id="siderbarright1">
    廣告
  </div>

  <div id="siderbarright2">
    聊天
  </div>




</body>


<script>


</script>

</html>