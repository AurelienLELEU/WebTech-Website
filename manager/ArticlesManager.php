<?php // permet d'interagir avec un article de la base de données articles

class ArticlesManager
{
    private PDO $db;

    public function __construct()
    {
        $dbName = 'blog';
        $port = 3306;
        $username = 'root';
        $password = '';
        try {
            $this->setDb(new PDO("mysql:host=localhost;dbname=$dbName;port=$port", $username, $password));
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    public function setDb($db)
    {
        $this->db = $db;
        return $this;
    }

    public function add(Article $article)
    {
        $req = $this->db->prepare("INSERT INTO `article` (id_image, title, content, created_at, author) VALUES(:id_image, :title, :content, :created_at, :author)");
        $req->bindValue(":id_image", $article->getId_image(), PDO::PARAM_INT);
        $req->bindValue(":title", $article->getTitle(), PDO::PARAM_STR);
        $req->bindValue(":content", $article->getContent(), PDO::PARAM_STR);
        $req->bindValue(":created_at", $article->getCreated_at(), PDO::PARAM_STR);
        $req->bindValue(":author", $article->getAuthor(), PDO::PARAM_STR);

        $req->execute();
    }

    public function update(Article $article)
    {
        $req = $this->db->prepare("UPDATE `article` SET title = :title, content = :content, created_at = :created_at, author = :author WHERE id = :id");

        $req->bindValue(":id", $article->getId(), PDO::PARAM_INT);
        $req->bindValue(":title", $article->getTitle(), PDO::PARAM_STR);
        $req->bindValue(":content", $article->getContent(), PDO::PARAM_STR);
        $req->bindValue(":created_at", $article->getCreated_at(), PDO::PARAM_STR);
        $req->bindValue(":author", $article->getAuthor(), PDO::PARAM_STR);

        $req->execute();
    }

    public function get(int $id)
    {
        $req = $this->db->prepare("SELECT * FROM `article` WHERE id = :id");
        $req->bindValue(":id", $id, PDO::PARAM_INT);
        $req->execute();

        $donnees = $req->fetch();
        if ($donnees) {
            $article = new Article($donnees);
            return $article;
        }
        
    }

    public function getAll($filter): array
    {
        $articles = [];
        $req = $this->db->query("SELECT * FROM `article` WHERE title LIKE '%$filter%' OR content LIKE '%$filter%' OR author LIKE '%$filter%' ORDER BY created_at ");
        $req->execute();

        $donnees = $req->fetchAll();
        foreach ($donnees as $donnee) {
            $articles[] = new Article($donnee);
        }

        return $articles;
    }

    public function getAllTitle($filter): array
    {
        $articles = [];
        $req = $this->db->query("SELECT * FROM `article` WHERE title LIKE '%$filter%' OR content LIKE '%$filter%' OR author LIKE '%$filter%' ORDER BY title");
        $req->execute();

        $donnees = $req->fetchAll();
        foreach ($donnees as $donnee) {
            $articles[] = new Article($donnee);
        }

        return $articles;
    }

    public function delete(int $id): void
    {
        $req = $this->db->prepare("DELETE FROM `article` WHERE id = :id");
        $req->bindValue(":id", $id, PDO::PARAM_INT);
        $req->execute();
    }
}
