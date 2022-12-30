<section class="createAuthorForm">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <form action="" method="post">
                    <!--<p>-->
                    <div class="text-center mb-4 mt-7">
                        <img class="mb-1" src="/../../public/images/logo.png" alt="Jean Forteroche">
                        <h1 class="h2 mb-3 font-weight-normal border-left border-info text-warning"><?php echo $title ?></h1>
                    </div>
                    <?php   if(isset($form)):
                                echo $form;
                    endif; ?>
                    <div id="preview"><img src="<?php if(isset($image)):echo $image; endif;?>" /></div><br>
                    <button type= "submit" class="btn btn-primary btn-round btn-lg btn-block">Valider</button>
                    <!--</p>-->
                </form>

                <a class="text-primary" href="<?php echo $url ?>"><?php echo $p ?></a>
                <a class="text-primary border-left" href="/">Retour vers le blog</a>
            </div>
        </div>
    </div>
</section>
