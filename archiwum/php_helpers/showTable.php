<?php
function humanFileSize($size, $unit = "")
{
    if ((! $unit && $size >= 1 << 30) || $unit == "GB")
        return number_format($size / (1 << 30), 2) . "GB";
    if ((! $unit && $size >= 1 << 20) || $unit == "MB")
        return number_format($size / (1 << 20), 2) . "MB";
    if ((! $unit && $size >= 1 << 10) || $unit == "KB")
        return number_format($size / (1 << 10), 2) . "KB";
    return number_format($size) . " bytes";
}

function getFiles($path)
{
    // open directory
    $directory = opendir($path);
    // get each entry
    while ($entryName = readdir($directory)) {
        $items[] = $entryName;
    }
    closedir($directory);
    sort($items);
    return $items;
}

function drawTable($path)
{
    echo "<table>\n";
    echo "<thead><tr><th style=\"text-align: right\">Data</th> <th> Zadania: </th> <th>Rozwiązania:</th> <th>Komentarz:</th> </tr> </thead>\n";
    echo "<tbody>\n";

    // open file list:
    if (($handle = fopen($path . "/files_informations.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // todo: wyrzuc error
            echo "<tr>";
            echo "<td> $data[0]</td>";
            echo "<td> <a href=\"$data[1]\"> $data[3]</a></td>";
            if ($data[2] != "") {
                echo "<td> <a href=\"$data[2]\"> $data[3] rozw </a></td>";
            } else {
                echo "<td> brak</td>";
            }
            $coment =strip_tags($data[4]);
            echo "<td>$coment </td>";
            echo "</tr>";
        }
        fclose($handle);
    }
    echo "</tbody></table>\n";
    $nazwa = hash('ripemd160', $path . "/");
    if (isset($_POST["submit_" . $nazwa])) { // check if form was submitted
        $result = getFilesUpload($path . "/", $nazwa . "_id", "roz_" . $nazwa . "_id");
        $_POST = array();
        if ($result) {
            exit(header("Location: thank_you"));
        }
    }
    echo "<br>";//.$_SESSION["zalogowany"];
   	if(isset($_SESSION["zalogowany"]) && $_SESSION["zalogowany"]){
    	printForm($nazwa);
    }
}

function wypiszPrzedmiot($pdfDirectory)
{
    $year = getFiles($pdfDirectory);
    echo "<ul class=\"collapse\">\n";

    for ($index = 0; $index < count($year); $index ++) {
        if (substr("$year[$index]", 0, 1) != "." && is_dir($pdfDirectory . "/" . $year[$index])) {
            echo "<li>$year[$index]<ul>";
            $subjects = getFiles($pdfDirectory . "/" . $year[$index]);
            for ($j = 0; $j < count($subjects); $j ++) {
                if (substr("$subjects[$j]", 0, 1) != "." && is_dir($pdfDirectory . "/" . $year[$index] . "/" . $subjects[$j])) {
                    echo "<li>$subjects[$j]<ul>";
                    drawTable($pdfDirectory . "/" . $year[$index] . "/" . $subjects[$j]);
                    echo "</ul></li>";
                }
            }
            echo "</ul></li>";
        }
    }
    echo "</ul>";
}
?>
