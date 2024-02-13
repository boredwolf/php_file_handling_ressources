<?php
function delete($path)
{
    // Perform deletion based on $path
    if (is_file($path)) {
        unlink($path); // Delete file
    } elseif (is_dir($path)) {
        // Delete directory and its contents recursively
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($files as $fileinfo) {
            $action = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
            $action($fileinfo->getRealPath());
        }
        rmdir($path);
    }

    // Return a response
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

// Check if the 'path' parameter is set
if (isset($_GET['path'])) {
    $path = $_GET['path'];
    echo delete($path); // Call the delete function with the specified path
}
?>
