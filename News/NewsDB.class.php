<?php
require_once 'INewsDB.class.php';
class NewsDB implements INewsDB
{

    const DB_NAME = 'news.db';
    private $_db;
    public function __construct()
    {
        $this->_db = new PDO('sqlite:' . self::DB_NAME);
        $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (filesize(self::DB_NAME) === 0) {
            try {
                $sql = 'CREATE TABLE msgs(
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    title TEXT,
                    category INTEGER,
                    description TEXT,
                    source TEXT,
                    datetime INTEGER
                )';
                $this->_db->exec($sql);

                $sql = 'CREATE TABLE category(
                    id INTEGER,
                    name TEXT
                )';
                $this->_db->exec($sql);

                $sql = "INSERT INTO category(id, name)
                        SELECT 1 as id, 'Политика' as name
                        UNION SELECT 2 as id, 'Культура' as name
                        UNION SELECT 3 as id, 'Спорт' as name ";
                $this->_db->exec($sql);
            } catch (PDOException $e) {
                echo $e->getCode() . ":" . $e->getMessage();
            }
        }
    }
    function __destruct()
    {
        unset($this->_db);
    }
    function saveNews($title, $category, $description, $source)
    {
        $db = $this->_db;
        $datetime = time();
        $sql = "insert into msgs (title, category, description, source, datetime)
        values ('$title', $category, '$description', '$source', $datetime)";
        try {
            $db->exec($sql);
            return TRUE;
        } catch (PDOException $e) {
            echo $e->getCode() . ":" . $e->getMessage();
            return false;
        }
    }
    function strFilter($str)
    {
        return trim(strip_tags((string)$str));
    }

    function intFilter($int)
    {
        return abs((int)$int);
    }
    function getNews()
    {
        $sql = "SELECT
        msgs.id as id, title, category.name as category, description,
        source, datetime FROM msgs, category WHERE category.id =
        msgs.category ORDER BY msgs.id DESC";
        $res = $this->_db->query($sql);
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }
    function showNews($id)
    {
        $sql = "SELECT
        msgs.id as id, title, category.name as category, description,
        source, datetime FROM msgs, category WHERE category.id =
        msgs.category WHERE msgs.id=$id ORDER BY msgs.id DESC";
        $res = $this->_db->query($sql);
        return $res->fetch(PDO::FETCH_ASSOC);
    }
}
