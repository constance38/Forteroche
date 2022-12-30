<div class="section-article">
    <div class="container">
        <div class="row">
           
<!-- Start blog post and comments-->
<!--Show post-->
            <div class="blog-post col-lg-9">
                <h2 class="blog-post-title"><?= htmlspecialchars($post->getSubject())?></h2>
                <p class="blog-post-meta"><?= $post->getCreateDate()->format('d-m-Y') ?> par Jean Forteroche</p>
                <img class="card-img" src="<?= htmlspecialchars($post->getImage())?>" alt="image article">
                <p><?= $post->getContent() ?></p>
                
<!--Show comment from the post -->
                <div class="comments">
                    <h2>Commentaires</h2>
                    <?php if(!empty($comments)):
                        foreach ($comments as $comment):?>
                        <div class="media mt-3">
                            <img src="<?php echo htmlspecialchars($comment->originalData->image) ?>" class="align-self-start mr-3 img-thumbnail" alt="image 1" width="100" height="50">
                            <div class="media-body">
                                <button class="reportComment" id=<?php echo $comment->getId() ?>>Signaler à l'administrateur</button>
                                <h5 class="mt-0"><?php echo htmlspecialchars($comment->getSubject()) ?> par <?php echo htmlspecialchars($comment->originalData->firstname) ?> <?php echo htmlspecialchars($comment->originalData->surname) ?></h5>
                                <p><?php echo $comment->getCreateDate()->format('d-m-Y') ?></p>
                                <p><?php echo htmlspecialchars($comment->getCommentContent()) ?></p>

                                <?php if(isset($_SESSION['authorId'])):
                                        if($comment->getIdAuthor() == $_SESSION['authorId']): ?>
                                            <a href="/article&id=<?php echo $post->getId() ?>&idcomment=<?php echo $comment->getId() ?>" class="btn btn-primary btn-round btn-lg btn-block" role="button">Modifier</a>
                                            <form action="/deletecomment&id=<?php echo $post->getId() ?>&idcomment=<?php echo $comment->getId() ?>" method="post">
                                                <input type = "submit" class="btn btn-primary btn-round btn-lg btn-block" name="delete" value="Supprimer"/>
                                            </form>
                                        <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach;
                    else: ?>
                    <p>Il n'y a pas de commentaire sur cette page, allez à la page précédente ou écrivez un nouveau commentaire</p>
                    <?php endif; ?>
                </div> 
<!--End of comments-->

<!--paginate comments-->
                <nav aria-label="...">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="/article&id=<?= $post->getId() ?>&page=<?php echo $previouslink ?>" tabindex="-1">Précédent</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="/article&id=<?= $post->getId() ?>&page=1">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="/article&id=<?= $post->getId() ?>&page=2">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="/article&id=<?= $post->getId() ?>&page=3">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="/article&id=<?= $post->getId() ?>&page=<?php echo $nextlink ?>">Suivant</a>
                        </li>
                    </ul>
                </nav>
<!--End paginate comments-->

<!--Form-->
                <div class="form mb-4">
                    <h5>Laissez votre commentaire</h5>
                        <?php if (isset($form)): ?>
                            <form action="" method="post">
                                <!--<p>-->
                                <div class="text-center mb-4">
                                    <h1 class="h2 mb-3 font-weight-normal border-left border-info text-warning"><?php echo $title ?></h1>
                                </div>
                                    <?php echo $form ?>
                                <input type="hidden" id="newFile" name="idpost" value="<?php echo $post->getId() ?>"/>
                                <input type = "submit" class="btn btn-primary btn-round btn-lg btn-block" name="validate" value="Valider"/>
                                <!--</p>-->
                            </form>
                        <?php else: ?>
                            <p>Vous devez vous inscrire pour écrire un commentaire</p>
                        <?php endif; ?>
                </div>
<!-- End form --> 
            </div>
<!-- /.blog-post and comments --> 
             
<!--Lasts posts-->
            <div class="col-lg-3 ml-auto">
                <aside class="sidebar">
                    <h4>Les derniers chapitres</h4>
                    <?php foreach ($lastsposts as $post): ?>
                        <div class="card mb-4">
                            <div class="overlay-image">
                                <img src="<?= $post->getImage()?>" class="card-img-top" alt="image 1">
                                <div class="overlay-item-caption smoothie"></div>
                                <div class="hover-item-caption smoothie">
                                    <h3 class="text"><a href="/article&id=<?= $post->getId() ?>&page=1" class="stretched-link" title="view article">View</a></h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($post->getSubject())?></h5>
                            </div>
                        </div>
                    <?php endforeach;?>         
                </aside>
                
<!--social networks-->
                <aside class="sidebar">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Suivez moi</h4>
                            <!--Facebook-->
                            <a class="fb-ic ml-0">
                                <i class="fab fa-facebook white-text mr-4"> </i>
                            </a>
                            <!--Twitter-->
                            <a class="tw-ic">
                                <i class="fab fa-twitter white-text mr-4"> </i>
                            </a>
                            <!--Google +-->
                            <a class="vkon-ic">
                                <i class="fab fa-vk white-text mr-4"> </i>
                            </a>
                            <!--Linkedin-->
                            <a class="li-ic">
                                <i class="fab fa-linkedin white-text mr-4"> </i>
                            </a>
                            <!--Instagram-->
                            <a class="ins-ic">
                                <i class="fab fa-instagram white-text mr-lg-4"> </i>
                            </a>
                        </div>
                    </div><!-- /.card -->
                </aside>

<!--New books-->
                <aside class="sidebar">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Les nouveautés</h4>
                        </div>
                        <img src="/../../public/images/livre.png" class="card-img-bottom" alt="image 3">
                    </div><!-- /.card -->
                </aside>
            </div>
            
        </div>
    </div>
</div>

