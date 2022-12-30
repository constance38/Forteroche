<p>Réservé à l'admin</p>
<section class="createAuthorForm">
    <div class="container">
        <div class="row justify-content-center mt-7">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <form action="" method="post" enctype="multipart/form-data">
                    <!--<p>-->
                    <div class="text-center mb-4">
                        <h1 class="h2 mb-3 font-weight-normal border-left border-info text-warning"><?php echo $title ?></h1>
                    </div>
                    <?php if(isset($form)):
                                echo $form;
                    endif; ?>
                    <div id="preview"><img src="<?php echo $image ?>" /></div><br>
                    <input type = "submit" class="btn btn-primary btn-round btn-lg btn-block" name="validate" value="Valider"/>
                    <input type = "submit" class="btn btn-primary btn-round btn-lg btn-block" name="save" value="Sauvegarder"/>
                    <!--</p>-->
                </form>
            </div>
        </div>
    </div>
</section>