<div class="offer">
    <span class="offer-title"><?= $title; ?></span>
    <span class="small-text"><?= $society; ?></span>
    <span class="mt-05">Compétences requises :</span>
    <ul class="offer-skills-list flex-1">
        <?php foreach($skills as $skill): ?>
            <li class="offer-skill"><?= $skill; ?></li>
        <?php endforeach; ?>
    </ul>

    <div class="offer-footer flex-1">
        <span class="small-text mt-05">Durée : <?= $duration ?> semaines</span>
        <button class="btn-primary">En savoir plus</button>
    </div>
</div>