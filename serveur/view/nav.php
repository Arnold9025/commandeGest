<!-- BARRE DE NAVIGATION -->
<nav>
    <a href='index.php'>Acceuil</a>
    <a href='index.php?op=ProductList'>Product List</a>
    <a href='index.php?op=ProductCatalog'>Product Catalogue</a>
    <a href='index.php?op=50'>Telecharger</a>
    <a href='index.php?op=51'>Rediriger</a>
    <?php
    if (!isset($_SESSION['email'])) {
        echo '<a href="index.php?op=1">Se connecter</a>';
        echo "<a href='index.php?op=3'>S'inscrire</a>";
    } else {
        echo "<a href='index.php?op=200'>Commandes</a>";
        echo "<a href='index.php?op=1200'>Professeurs</a>";
        echo "<a href='index.php?op=5'>Se deconnecter</a>";
        echo "<p> User: " . $_SESSION['fullname'] . "</>";
    }

    ?>


</nav>