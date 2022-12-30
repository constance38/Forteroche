<div class="listOfSearch pt-7">
    <p>Le résultat de la racherche donne les articles suivants: </p>
    <?php if (!empty($mySearchResults)): ?>
            <?php foreach ($mySearchResults as $mySearchResult): ?>    
                        <p> <a href="/article&id=<?php echo $mySearchResult->getId()?>">,<?php echo htmlspecialchars($mySearchResult->getSubject())?></a></p>
                        <?php echo htmlspecialchars($mySearchResult->getCreatedate()->format('d-m-Y'))?>
            <?php endforeach; ?>
        <?php else: ?>
                <p>pas d'articles trouvés</p>
        <?php endif; ?>
</div>

