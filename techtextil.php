<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>texTIMZ</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="icon" href="../assets/favicon.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="author" content="texTIMZ">
    <link rel="stylesheet" type="text/css" href="../css/welcome.css">
    <link rel="stylesheet" type="text/css" href="../css/app.css">
    <link rel="stylesheet" type="text/css" href="../css/index_.css">
    <link rel="stylesheet" type="text/css" href="../css/m.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <!-- bxSlider Javascript file -->
    <script src="js/jquery.bxslider.min.js"></script>
    <!-- bxSlider CSS file -->
    <link href="lib/jquery.bxslider.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../css/pure-drawer.css">
    <link rel="stylesheet" type="text/css" href="../css/card.css">
    <link rel="stylesheet" type="text/css" href="techtextil.css">
    <link rel="stylesheet" type="text/css" href="../css/list_card.css">
    <link rel="stylesheet" type="text/css" href="../css/thumb.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700' rel='stylesheet' type='text/css'>
</head>
<body>
<!--DRAWER MAMLA-->
<div class="pure-container" data-effect="pure-effect-reveal">
    <input type="checkbox" id="pure-toggle-left" class="pure-toggle" data-toggle="left">
    <label class="pure-toggle-label" for="pure-toggle-left" data-toggle-label="left">
        <span class="pure-toggle-icon"></span>
    </label>
    <div class="pure-drawer" data-paosition="left">
        <div class="row collapse">
            <div class="large-12 columns">
                <ul class="nav-primary" style="list:style=none;text-align: left">
                    <li><a href="../pages/career.php">Careers</a></li>
                    <li><a href="../pages/contact.php">Contact Us</a></li>
                    <li><a href="../pages/terms.php">Terms of Use</a></li>
                    <li><a href="../pages/team.php">Team</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="pure-pusher-container">
        <div class="pure-pusher">
            <div class="head">
                <a href="#">
                    <div class=" logo_tex"></div>
                </a>
            </div>
            <div class = page_wrapper>
                <div class = contact-container>
                    <div class = uote>
                        Get Invited to the global platform generating business.<br><br>
                        <img class="banner-txt" src="banner.jpg">
                    </div>
                    <div class="form-container">
                        <form method="post">
                            <div class="group">
                                <input type="email" name="Email" required>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label class="form-input">Email</label>
                            </div>
                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
                            <script type="javascript"> $("#button").click(function (e) {
                                    $(".scali").removeClass("animate");
                                    if (!$(".scali").height() && !$(".scali").width()) {
                                        var d = Math.max($("#button").outerWidth(), $("#button").outerHeight());
                                        $(".scali").css({ height: d, width: d });
                                    }
                                    var x = e.pageX - $("#button").offset().left - $(".scali").width() / 2;
                                    var y = e.pageY - $("#button").offset().top - $(".scali").height() / 2;
                                    $(".scali").css({ top: y + 'px', left: x + 'px' }).addClass("animate");

                                });</script>
                            <div id="button">
                                <span class="scali"></span>
                                <span class="clicki"><a>INVITE ME!</a></span>
                            </div>



                        </form>


                    </div>
                    <div class="footer">
                        <div class="copywrite">&copytexTIMZ 2016<br>
                            <a href="http://madewithlove.org.in" target="_blank">Made with <span style="color: #e74c3c">&hearts;</span> in India</a>
                        </div>
                    </div>
                    <div class="drawer">
                    </div>
                    <label class="pure-overlay" for="pure-toggle-left" data-overlay="left"></label>
                </div>
</body>
</html>

<?php
require_once ("../config.php");

if (isset($_POST['Email'])) {
    $email = $_POST['Email'];
    $stmt = $conn->prepare("INSERT INTO t_techTextile_invite (email) VALUES (:email)");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
}
?>
