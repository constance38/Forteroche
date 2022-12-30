<p>Réservé à l'admin</p>
<section class="articles">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="text-center mb-4">
                    <h1>Articles</h1> 
                </div>
                
                <!--Buttons-->
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-success m-3" id="hideSaveDatas">Liste des articles publiés</button>
                    <button type="button" class="btn btn-primary m-3" id="hidePublishedDatas">Liste des articles sauvegardés</button>
                    <button type="button" class="btn btn-info m-3" id="listofpost">Liste compléte</button>
                </div>
                
                <!--Board-->
                <table id="displayarticles" class="cell-border compact stripe" style="width:100%">
                    <thead>
                        <tr>
                            <th class="all">Numéro</th>
                            <th class="all">Id</th>
                            <th class="all">Sujet</th>
                            <th class="all">Date de création</th>
                            <th class="all">Date de modification</th>
                            <th class="all">Status</th>
                            <th class="all">Supprimer/Modifier</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>