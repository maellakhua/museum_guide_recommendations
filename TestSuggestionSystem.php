<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Test Suggestion System</title>
    </head>
    <body>
        <?php
            require_once('Suggest.php');
            require_once('Museum.php');
            
            // Create dummy objects for test
            $museumList[] = new Museum('Acropoli', 100, 4, 9, 1);
            $museumList[] = new Museum('Kikladikis Texnis', 1000, 3, 12, 23);
            $museumList[] = new Museum('Μουσείο Μπενάκη ', 10, 5, 10, 3);
            $museumList[] = new Museum('Εθνική Πινακοθήκη', 534, 2, 14, 6);
            $museumList[] = new Museum('War Museum', 2, 2, 9, 4);
            
            $suggestObj = new Suggest($museumList);
            
            // Create a list of indexes for every suggestion method of Suggest 
            $byDistance = $suggestObj->distance()->getIndices();
            $byTime = $suggestObj->time()->getIndices();
            $byRating = $suggestObj->rating()->getIndices();
            $byCombined = $suggestObj->combined(false, true, true)->getIndices();
            $byRecommended = $suggestObj->recommend();
            
            
            $count = count($byDistance);
            
            echo "<h1>Recommendations Algorithm Tester";
            
            echo "<h2>Initial List</h2>";
            foreach ($museumList as $museum) {
                echo "<p>{$museum->getMuseumId()}</p>";
            }
            
            echo "<br><h1>suggestions</h1><br>";
            echo "<h2>By Distance</h2>";        
            for ($i=0 ; $i<$count ; ++$i) {
                echo "<p>{$museumList[$byDistance[$i]]->getMuseumId()}</p>";
            }
            
            echo "<h2>By Time</h2>";  
            for ($i=0 ; $i<$count ; ++$i) {
                echo "<p>{$museumList[$byTime[$i]]->getMuseumId()}</p>";
            }
            
            echo "<h2>By Rating</h2>";  
            for ($i=0 ; $i<$count ; ++$i) {
                echo "<p>{$museumList[$byRating[$i]]->getMuseumId()}</p>";
            }
            
            echo "<h2>By Combined (Distance-Time)</h2>";  
            for ($i=0 ; $i<$count ; ++$i) {
                echo "<p>{$museumList[$byCombined[$i]]->getMuseumId()}</p>";
            }
            
            echo "<h2>By Recommended</h2>";  
            for ($i=0 ; $i<$count ; ++$i) {
                echo "<p>{$museumList[$byRecommended[$i]]->getMuseumId()}</p>";
            }
        ?>
    </body>
</html>
