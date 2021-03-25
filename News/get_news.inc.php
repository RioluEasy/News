<?php
$arr = $news->getNews();
if (!$arr) {
    $errMsg = "Произошла ошибка при выводе новостной ленты";
} else {
    echo 'Всего новостей: ' . count($arr);
    foreach ($arr as $row) {
?>
        <h2><?= $row['title']; ?></h2>
        <P><?= date("d-m-Y h:m:i", $row['datetime']); ?></P>
        <P><?= $row['category']; ?></P>
        <p><?= $row['description']; ?></p>
        <P><a href="show-news.php?id=<?= $row['id']; ?>">Читать полностью</a></P>
        <hr>

<?php
    }
}
