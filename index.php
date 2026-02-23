<?php
// Načtení recenzí z JSON souboru
$reviewsFile = __DIR__ . "/reviews.json";
$reviews = [];

if (file_exists($reviewsFile)) {
    $json = file_get_contents($reviewsFile);
    $reviews = json_decode($json, true);
    if (!is_array($reviews)) $reviews = [];
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recenze</title>
    <link rel="stylesheet" href="/style/style.css"></link>
</head>
<body>

<header class="site-header">
    <h1>Recenze</h1>
</header>

<main class="container">
    <section class="card">
        <h2>Napiš recenzi</h2>

        <form class="form" action="/action_page.php" method="post">
            <label for="name">Jméno, Příjmení</label>
            <input type="text" id="name" name="name" placeholder="Jan Novák" required maxlength="60">

            <label for="comment">Komentář</label>
            <textarea id="comment" name="comment" placeholder="Napiš svůj názor..." required maxlength="500"></textarea>

            <button type="submit">Odeslat</button>
        </form>
    </section>

    <section class="card">
        <h3>Recenze:</h3>

        <?php if (empty($reviews)): ?>
            <p class="muted">Zatím tu nejsou žádné recenze.</p>
        <?php else: ?>
            <div class="reviews">
                <?php
                // nejnovější nahoře
                $reviewsReversed = array_reverse($reviews);
                foreach ($reviewsReversed as $r):
                ?>
                    <div class="review">
                        <div class="review-name"><?= htmlspecialchars($r["name"]) ?></div>
                        <div class="review-text"><?= nl2br(htmlspecialchars($r["comment"])) ?></div>
                        <div class="review-date"><?= htmlspecialchars($r["date"]) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</main>

<footer class="site-footer">
    <small>© <?= date("Y") ?></small>
</footer>

</body>
</html>