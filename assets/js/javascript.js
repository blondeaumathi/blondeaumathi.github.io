// affichage.js
import { supabase } from './authSupabase.js' // On importe la connexion créée juste avant

async function chargerArticles() {
    const container = document.getElementById('liste-articles');

    // Récupération des données via l'instance importée
    const { data: article, error } = await supabase
        .from('article')
        .select('*')

    if (error) {
        console.error("Erreur:", error);
        container.innerHTML = `<p style="color:red">Erreur : ${error.message}</p>`;
        return;
    }

    if (!article || article.length === 0) {
        container.innerHTML = "<p>Aucun article trouvé.</p>";
        return;
    }

    // Nettoyage et boucle d'affichage
    container.innerHTML = '';
    
    article.forEach(article => {
        const htmlArticle = `
            <div class="article">
                <h3>${article.name}</h3>
                <p>${article.description}</p>
                <span>Publié le : ${article.date}</span>
                <script> if (article.publisher != null) { </script>    
                <span>Auteur : ${article.publisher}</span>
                <script> } </script>
                <a href="${article.lien}" target="_blank">Lire l'article complet</a>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', htmlArticle);
    });
}

// On lance la fonction
chargerArticles();
