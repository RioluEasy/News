<?php
if(!empty($_POST['title']) and !empty($_POST['description']) and !empty($_POST['source'])) {
    $news = new NewsDB();
    $title = $news->strFilter($_POST['title']);
    $category = $news->intFilter($_POST['category']);
    $description = $news->strFilter($_POST['description']);
    $source = $news->strFilter($_POST['source']);

    if($news->saveNews($title, $category, $description, $source)) {
        header("LOCATION: ".$_SERVER['REQUEST_URI']);
    } else {
        $errMsg = "Не удалось сохранить новость";
    }
}