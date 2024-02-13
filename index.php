<?php include('inc/head.php'); ?>

<?php
if (isset($_POST['contenu'])) {
    $fichier = $_POST['file'];
    $file = fopen($fichier, 'w');
    fwrite($file, $_POST['contenu']);
    fclose($file);
}
?>

<?php

function delete($file)
{
    unlink($file);
}

function listerFichiers($dir, $extensions)
{
    if (!is_dir($dir)) {
        return;
    }

    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $path = $dir . '/' . $file;
            if (is_dir($path)) {
                echo "<a href='deleteFile.php?path=" . urlencode($path) . "' onclick='return confirm(\"Are you sure you want to delete?\");'>Delete  </a>";
                echo "Dossier : " . $path . "<br>";
                listerFichiers($path, $extensions); // Appel récursif pour lister le contenu du dossier
            } else {
                $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                echo "<a href='deleteFile.php?path=" . urlencode($path) . "' onclick='return confirm(\"Are you sure you want to delete?\");'>Delete  </a>";
                if (in_array($fileExtension, $extensions)) {
                    echo '<a href="?f=' . $path . '">';
                    echo "Fichier : " . $path . "<br>";
                    echo '</a>';
                } else {
                    echo "Fichier : " . $path . "<br>";
                }
            }
        }
    }
}

$extensions = array('html', 'txt');
listerFichiers("files", $extensions);
?>

<?php
if (isset($_GET['f'])) {
    $fichier = $_GET['f'];
    $contenu = file_get_contents($fichier);
}
?>

    <form method="POST" action="index.php">
        <textarea style="width:100%;height:200px" name="contenu">
        <?php echo $contenu; ?>
        </textarea>
        <input type="hidden" name="file" value="<?php echo $_GET['f'] ?>"/>
        <input type="submit" value="envoyer">

    </form>

<?php include('inc/foot.php'); ?>