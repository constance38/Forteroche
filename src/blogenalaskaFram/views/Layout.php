<!DOCTYPE html>
   
<meta charset="utf-8" />
<title><?= $title ?? 'Jean Forteroche'?></title></>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="icon" type="image/png" href="/public/images/logo.png" />
<link rel="icon" type="image/png" href="images/logo.png" />

<!--CSS-->
<link href="/public/css/style.css" rel="stylesheet" />

<!--Jquery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!--Datatables-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>

<!--Tinymce-->
<script src="https://cdn.tiny.cloud/1/iltjhgipkk1yfx5qzzja1x5xo3g1cibyidyrg3hw1f4f1ob7/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript" src="/../../public/js/Tinymce.js"></script>

<!--Bootstrap-->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>     


<!--Logo fontawesome-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

<!--Police-->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,900" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Bad+Script&amp;subset=cyrillic" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=News+Cycle" rel="stylesheet">


<!--Upload-->
<script type="text/javascript" src="/../../public/js/UploadFile.js"></script>
<script type="text/javascript" src="/../../public/js/AuthorUploadFile.js"></script>

<!--Scroll nav-->
<script type="text/javascript" src="/../../public/js/scrollnav.js"></script>

<!--List of comments backend-->
<script type="text/javascript" src="/../../public/js/CommentsBackend.js"></script>

<!--Countclicks-->
<script type="text/javascript" src="/../../public/js/Countclicks.js"></script>

<!--Articles-->
<script type="text/javascript" src="/../../public/js/BackOffice.js"></script>

<body>
    <?php 
        if (isset($_SESSION['status']) &&($_SESSION['status'] === 'admin'))
        {
            require __DIR__.'/../views/AdminHeader.php';
        }
        else 
        {
            require __DIR__.'/../views/Header.php'; 
        }
    ?>

    <!--Main layout-->
    <main role="main" class="main">				
        <!--Main container-->
        <div id="spy" data-spy="scroll" data-target="#navbar" data-offset="0">
        <div class="container-fluid" id="main-container">
            <!-- flash message-->
            <?php if($session->get('success')): ?>
                <div class="alert alert-success mt-7" role="alert">
                    <?php echo $session->get('success'); ?>
                </div>   
            <?php
            elseif($session->get('error')): ?>
                <div id='#myAlert' class="alert alert-danger mt-7">
                <?php echo $session->get('error');
            endif;
            ?>
                </div>
            <?= $content ?> 
        </div>
        </div>
        <!--Main container-->				
    </main>
    <!--Main layout-->
    <?php require __DIR__.'/../views/Footer.php'; ?>
</body>



