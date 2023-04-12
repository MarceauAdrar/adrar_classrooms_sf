<?php

namespace App\DataFixtures;

use App\Entity\Chapitres;
use App\Entity\Cours;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CoursFixtures extends Fixture
{
    public int $counter1 = 1;
    public int $counter2 = 1;

    public function load(ObjectManager $manager): void
    {
        $cours = $this->createCourse("Introduction à l'HTML", "Ce cours est une introduction au langage de balisage HTML (HyperText Markup Language).", 1, 60, "default.jpg", new DateTimeImmutable(), 1, $manager);
        $this->createChapter($cours, "Introduction", "<h2>Introduction</h2><p>HTML (HyperText Markup Language) est un langage de balisage utilisé pour créer des pages Web. Il permet de structurer le contenu d'une page en utilisant des balises HTML.</p>", 1, $manager);
        $this->createChapter($cours, "Structure", "<h2>Structure d'une page HTML</h2>
        <p>Une page HTML est composée de plusieurs éléments, tels que :</p>
        <ul>
            <li>La balise &lt;!DOCTYPE&gt; qui indique la version de HTML utilisée</li>
            <li>La balise &lt;html&gt; qui enveloppe tout le contenu de la page</li>
            <li>La balise &lt;head&gt; qui contient des informations sur la page (titre, liens vers des fichiers CSS ou JS, etc.)</li>
            <li>La balise &lt;body&gt; qui contient le contenu principal de la page (texte, images, vidéos, etc.)</li>
        </ul>", 2, $manager);
        $this->createChapter($cours, "Balises", "<h2>Les balises HTML</h2>
        <p>Les balises HTML permettent de structurer le contenu d'une page en utilisant des éléments tels que :</p>
        <ul>
            <li>&lt;h1&gt; à &lt;h6&gt; pour les titres</li>
            <li>&lt;p&gt; pour les paragraphes</li>
            <li>&lt;a&gt; pour les liens</li>
            <li>&lt;img&gt; pour les images</li>
            <li>&lt;ul&gt; et &lt;ol&gt; pour les listes</li>
        </ul>", 3, $manager);
        $this->createChapter($cours, "Mise en page", "<h2>Mise en page avec CSS</h2>
        <p>CSS (Cascading Style Sheets) permet de définir la présentation visuelle d'une page HTML. Il permet de modifier les couleurs, les tailles, les polices de caractères, les marges, etc.</p>", 4, $manager);
        
        $cours = $this->createCourse("Introduction au PHP", "Le PHP est un langage de programmation côté serveur qui est utilisé pour créer des sites web dynamiq", 2, 140, "default.jpg", new DateTimeImmutable(), 1, $manager);
        $this->createChapter($cours, "Introduction", '<?php
        // Exemple de code PHP
        $prenom = "Jean";
        $nom = "Dupont";
        $age = 30;
        
        echo "<p>Bonjour, je m\'appelle $prenom $nom et j\'ai $age ans.</p>";
        ?>
      
        <p>Le code PHP est placé à l\'intérieur de balises PHP : <code>&lt;?php</code> et <code>?&gt;</code>. Tout le code PHP doit être écrit à l\'intérieur de ces balises.</p>', 1, $manager);
        $this->createChapter($cours, "Les variables", '<h2>Les variables</h2>

        <p>En PHP, les variables sont utilisées pour stocker des valeurs. Une variable est créée en utilisant le signe <code>$</code> suivi d\'un nom de variable.</p>
        
        <?php
          // Exemple d\'utilisation de variables en PHP
          $prix = 10.99;
          $quantite = 5;
          $total = $prix * $quantite;
          
          echo "<p>Le total de votre commande est de $total euros.</p>";
        ?>
        
        <p>En PHP, les variables sont automatiquement typées, ce qui signifie que le type de la variable est déterminé en fonction de la valeur qu\'elle contient.</p>', 2, $manager);
        $this->createChapter($cours, "Les boucles", '<h2>Les boucles</h2>

        <p>Les boucles permettent de répéter une section de code plusieurs fois. En PHP, il existe plusieurs types de boucles, notamment la boucle <code>for</code> et la boucle <code>while</code>.</p>
        
        <?php
          // Exemple d\'utilisation d\'une boucle en PHP
          for ($i = 1; $i <= 5; $i++) {
            echo "<p>$i</p>";
          }
        ?>
        
        <p>La boucle <code>for</code> est utilisée pour répéter une section de code un nombre déterminé de fois. Dans cet exemple, la boucle affiche les nombres de 1 à 5.</p>', 3, $manager);
        $this->createChapter($cours, "Les fonctions", '<h2>Les fonctions</h2>

        <p>Les fonctions sont des blocs de code réutilisables qui effectuent une tâche spécifique. En PHP, les fonctions sont définies en utilisant le mot-clé <code>function</code>.</p>
        
        <?php
          // Exemple d\'une fonction en PHP
          function calculerPrixTotal($prix, $quantite) {
            $total = $prix * $quantite;
            return $total;
          }
          
          echo "<p>Le total de votre commande est de " . calculerPrixTotal(10.99, 5) . " euros.</p>";
        ?>
        
        <p>La fonction <code>calculerPrixTotal</code> prend deux paramètres : le prix et la quantité, et calcule le total en multipliant les deux valeurs. La fonction renvoie ensuite le total.</p>', 4, $manager);
        
        $manager->flush();
    }

    public function createCourse(string $sTitre, string $sSynopsis, int $iNiveau, int $iTempsEstime, string $sImage, DateTimeImmutable $dDate, bool $bCree, ObjectManager $manager): Cours {
        $cours = new Cours();
        $cours->setTitre($sTitre);
        $cours->setSynopsis($sSynopsis);
        $cours->setNiveau($iNiveau);
        $cours->setTempsEstime($iTempsEstime);
        $cours->setImage($sImage);
        $cours->setDate($dDate);
        $cours->setCree($bCree);
        
        $manager->persist($cours);
        // Cette méthode héritée va permettre de mémoriser les utilisateurs pour nous en resservir dans d'autres Fixtures
        $this->addReference('cours-' . $this->counter1, $cours);
        $this->counter1++;

        return $cours;
    }

    public function createChapter(Cours $cCours, string $sTitre, string $sContenu, int $iPosition, ObjectManager $manager): Chapitres {
        $chapitre = new Chapitres();
        $chapitre->setCours($cCours);
        $chapitre->setTitre($sTitre);
        $chapitre->setContenu($sContenu);
        $chapitre->setPosition($iPosition);
        
        $manager->persist($chapitre);
        // Cette méthode héritée va permettre de mémoriser les utilisateurs pour nous en resservir dans d'autres Fixtures
        $this->addReference('chapitre-' . $this->counter2, $chapitre);
        $this->counter2++;

        return $chapitre;
    }

}
