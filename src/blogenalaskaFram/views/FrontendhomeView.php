<header class="head" id="head">
    <div class="container-fluid">   
        <div class="row">
            <img src="/../../public/images/jean.jpg" class="img-fluid w-100" alt="Responsive image">
        </div>
    </div>
</header>

<section class="services-section pb-4" id="lastnews">
    <div class="container">
        <div class="row mb-4">
            <?php foreach ($lastsposts as $post): ?>
            <div class="col-lg-4">
                <div class="services-item p-2">
                    <img class="card-img-top img-responsive w-100" src="<?= htmlspecialchars($post->getImage())?>" alt="Card image cap">
                    <strong class="d-inline-block mb-2 text-danger">Derniers chapitres</strong>
                    <h3><?= htmlspecialchars($post->getSubject())?></h3>
                    <p><?php if(strlen($post->getContent()) <= 400):
                                echo $post->getContent();
                        else:
                            //Returns the portion of string specified by the start and length parameters.
                            $debut = substr($post->getContent(), 0, 400);
                            $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';

                            echo $debut;
                        endif;?>
                        
                    <a href="/article&id=<?=$post->getId() ?>&page=1" class="text-danger">Lire la suite</a></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="container pb-4 mb-4" id="allchapters">   
    <div class="row">
        <div class="col-lg-12">
            <div class="row mb-2">
                <div class="col-lg-12">
                    <h2 class="display-4 font-italic">Tous les chapitres</h2>
                </div>
            </div>

            <div class="row mb-4">
                <?php if(empty($posts)): ?>
                    <p>Il n'y a pas d'article sur cette page, allez à la page précédente</p>
                <?php else:          
                    foreach($posts as $post): ?>
                    <div class="col-lg-4">
                        <div class="cards h-100">
                            <div class="overlay-image">
                                <img class="card-img-top img-responsive w-100" src="<?=htmlspecialchars($post->getImage())?>" alt="Card image cap">
                                <div class="overlay-item-caption smoothie"></div>
                                <div class="hover-item-caption smoothie">
                                    <h3 class="text"><a href="/article&id=<?= $post->getId() ?>&page=1" class="stretched-link" title="view article">View</a></h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <strong class="d-inline-block mb-2 text-danger"><?= htmlspecialchars($post->getSubject())?></strong>
                                <h3 class="card-title">
                                    <strong><?php if(strlen($post->getContent()) <= 350):
                                                    echo $post->getContent();
                                                else:
                                                    //Returns the portion of string specified by the start and length parameters.
                                                    $debut = substr($post->getContent(), 0, 350);
                                                    $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';

                                                    echo $debut;
                                                endif;?>
                                    </strong></h3>
                                <div class="mb-1 text-muted"><?=htmlspecialchars($post->getCreateDate()->format('d-m-Y'))?> Posté par Jean Forteroche</div>
                            </div>
                        </div>  
                    </div>
                    <?php endforeach;
                endif; ?>
            </div>
            <div class="row justify-content-center">
                <nav aria-label="...">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link text-danger" href="/articles&page=<?php echo htmlspecialchars($previouslink)?>">Précédent</a></li>
                        <li class="page-item"><a class="page-link text-danger" href="/articles&page=1">1</a></li>
                        <li class="page-item" aria-current="page"><a class="page-link text-danger" href="/articles&page=2">2</a></li>
                        <li class="page-item"><a class="page-link text-danger" href="/articles&page=3">3</a></li>
                        <li class="page-item"><a class="page-link text-danger" href="/articles&page=<?php echo htmlspecialchars($nextlink)?>">Suivant</a></li>
                    </ul>
                </nav>
            </div>
        </div>    
    </div>
</section>

<section class="librairie pb-4">
    <div class="jumbotron jumbotron-fluid mb-4 " id="jumbotron">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-12">
                    <h2 class="display-4 font-italic text-white bg-danger">Vous aimerez aussi</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="cards h-100">
                        <img class="card-img-top img-responsive" src="/../../public/images/livre.png" alt="Card image fluid" >
                        <div class="card-body bg-white">
                            <div class="mb-1 text-muted">Tourisme littéraire</div>
                            <h3 class="card-title"><strong>Conseils camping pour la montagne</strong></h3>
                            <a href="" class="stretched-link">Acheter</a>
                        </div>
                    </div> 
                </div>
                <div class="col-lg-4">
                    <div class="cards h-100">
                        <img class="card-img-top img-responsive w-100" src="/../../public/images/livre2.jpg" alt="Card image cap">
                        <div class="card-body bg-white">
                            <div class="mb-1 text-muted">Tourisme littéraire</div>
                            <h3 class="card-title"><strong>Voyage au coeur de la montagne</strong></h3>
                            <a href="" class="stretched-link">Acheter</a>
                        </div>
                    </div> 
                </div>
                <div class="col-lg-4">
                    <div class="cards h-100">
                        <img class="card-img-top img-responsive w-100" src="/../../public/images/livre3.jpg" alt="Card image cap">
                        <div class="card-body bg-white">
                            <div class="mb-1 text-muted">Tourisme littéraire</div>
                            <h3 class="card-title"><strong>Conseils photo pour voyageurs</strong></h3>
                            <a href="" class="stretched-link">Acheter</a>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact pb-4" id="contact">
    <div class="container rounded mb-4 ">
        <div class="row justify-content-center">
            <div class="col-lg-6 pb-4">
                <form action="/sendEmail" method="post" enctype="multipart/form-data">
                    <h2 class="display-4 font-italic">Contactez nous</h2>
                    <div class="form-group">
                        <label for="inputSubject">Sujet</label>
                        <input type="text" class="form-control" id="subject">
                    </div>
                    <div class="form-group">
                        <label for="textareaMessage">Message</label>
                        <textarea type='text' class="form-control" id="message"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            </div>
            <aside class="col-lg-6 col-md-12 col-sm-12 blog-sidebar">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <p>Du lundi au vendredi</p>
                    </div>
                    <div class="col-lg-4">
                        <p>9h00 - 18h00</p>
                    </div>
                    <div class="col-lg-4">
                        <p>+41 23 40 19</p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d16282291.90687623!2d-176.5259279963209!3d60.121384562730476!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5400df9cc0aec01b%3A0xbcdb5e27a98adb35!2sAlaska%2C%20%C3%89tats-Unis!5e0!3m2!1sfr!2sfr!4v1588862030775!5m2!1sfr!2sfr" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                </div>
            </aside>
        </div>
    </div>
</section>