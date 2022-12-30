<nav class="navbar fixed-top navbar-expand-lg navbar-light" id="navbar">
    <!--bg-transparent-->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">
        <img src="/../../../public/images/logo.png" width="30" height="30" class="d-inline-block align-top" alt="logo">
        Jean Forteroche
    </a>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="/">Blog <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/backoffice">Accueil <span class="sr-only">(current)</span></a>
            </li>
            <li>
                <a class="nav-link" href="/createpost">Ecrire un article</a>
            </li>
            <li>
                <a class="nav-link" href="/rendercommentspage">Commentaires</a>
            </li>
            <?php 
            if (isset($_SESSION['status'])):
                if ($_SESSION['status']==='admin'): ?>
                    <div class="navbar-test d-inline-block .align-middle">Connecté en tant que <?php echo $_SESSION['authorUsername'] ?></div>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Profil</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/updateuser&id=<?php echo $_SESSION['authorId']?>">Modifier son profil</a>
                            <a class="dropdown-item" href="/deleteuser&id="<?php echo $_SESSION['authorId']?>>Supprimer son profil</a>
                            <form class="nav-item active pr-1" method="post" action = "/logout">
                                <button class="btn btn-outline-success my-2 my-sm-0">Se déconnecter</button>
                            </form>
                        </div>
                    </li>
                <?php endif; ?>
            <?php else: ?>
                    <li>
                        <a class="nav-link" href="/connectform">Connexion</a>
                    </li>
            <?php endif; ?>
        </ul>
            <form  action="/searchPosts" method="post" class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" name="userSearch" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
    </div>
</nav>
<!--</header>-->
