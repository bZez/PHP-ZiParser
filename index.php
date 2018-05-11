<?php
$dir = "extracted";
$handle = opendir($dir);
$folders = 0;
$files = 0;

$projectName='TEST';

foreach (scandir($dir) as $file) {
    if ($file != '.' && $file != '..') {
        if (is_dir($dir . '/' . $file)) {
            foreach (glob($dir . '/' . $file . '/*') as $f) {
                $filename = substr($f, strrpos($f, '/') + 1);
                copy($f, $dir . '/' . $filename);
                unlink($f);
            }
            rmdir($dir . '/' . $file);
        } else {
            $files++;
        }
    }
    $fName = strtok($file, '.');
    $fExt = substr($file, strpos($file, ".") + 1);
    $zip = new ZipArchive();
    $ret = $zip->open($dir . '/' . $fName . '.zip', ZipArchive::CREATE);
    if ($ret !== TRUE) {
        //....???!!!!####@
    } else {
        $options = array('remove_all_path' => TRUE);
        $zip->addGlob($dir . '/' . $fName . '{.shp,.dbf,.prj}', GLOB_BRACE, $options);
        $zip->close();
    }
    if ($fExt != 'zip' && $file !== '.' && $file !== '..') {
        unlink($dir . '/' . $file);
    }
}
$totalZip = new ZipArchive();
$ret = $totalZip->open($dir . '/' . $projectName . '.zip', ZipArchive::CREATE);
$totalZip->addGlob($dir . '/*.zip', GLOB_BRACE, $options);
$totalZip->close();

echo '<br>';
echo 'Number of folders: ' . $folders;
echo '<br />';
echo '<br />';
echo 'Number of files: ' . $files;
?>