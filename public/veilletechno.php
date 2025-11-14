<?php
include '../includes/header.php';
require_once '../includes/supabase.php';
$articles = getDB()->query("SELECT * FROM public.article")->fetchAll();
?>

<link rel="stylesheet" href="../assets/css/veilletechno.css">

<div class="veille-n8n"> 
    <h1>Mes outils de Veille Technologique</h1>
    <img src="../assets/images/veille/n8n_Agent.png" alt="Mon agent N8N que j'utilise pour ma veille technologique">

</div>

<div class="veille">
    <h2>Articles récupérés depuis la base de données Supabase</h2>
    <?php foreach ($articles as $article): ?>
        <div class="article">
            <h3><?php echo htmlspecialchars($article['name']); ?></h3>
            <p><?php echo nl2br(htmlspecialchars($article['description'])); ?></p>
            <span class="date">Publié le : <?php echo htmlspecialchars($article['date']); ?></span>
            <?php if ($article['publisher']): ?>
                <span class="date">Publié par : <?php echo htmlspecialchars($article['publisher']); ?></span>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>


<?php
include '../includes/footer.php';
?>