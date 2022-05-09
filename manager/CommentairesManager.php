<?php // permet d'interagir avec un commentaire de la base de données commentaires
class CommentairesManager
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

    public function getLastCommentId()
    {
        $req = $this->db->query("SELECT id FROM `commentaire` ORDER BY id DESC");
        $req->execute();

        $donnees = $req->fetch();
        $commentaire = new Commentaire($donnees);
        return $commentaire->getId();
    }

    public function setDb($db)
    {
        $this->db = $db;
        return $this;
    }

    public function add(Commentaire $commentaire)
    {
        $req = $this->db->prepare("INSERT INTO `commentaire` (id_article, title, content, created_at, author) VALUES(:id_article, :title, :content, :created_at, :author)");
        $req->bindValue(":id_article", $commentaire->getId_article(), PDO::PARAM_INT);
        $req->bindValue(":title", $commentaire->getTitle(), PDO::PARAM_STR);
        $req->bindValue(":content", $commentaire->getContent(), PDO::PARAM_STR);
        $req->bindValue(":created_at", $commentaire->getCreated_at(), PDO::PARAM_STR);
        $req->bindValue(":author", $commentaire->getAuthor(), PDO::PARAM_STR);

        $req->execute();
    }

    public function update(Commentaire $commentaire)
    {
        $req = $this->db->prepare("UPDATE `commentaire` SET id_article = :id_article, title = :title, content = :content, created_at = :created_at, author = :author WHERE id = :id");

        $req->bindValue(":id", $commentaire->getId(), PDO::PARAM_INT);
        $req->bindValue(":id_article", $commentaire->getId_article(), PDO::PARAM_INT);
        $req->bindValue(":title", $commentaire->getTitle(), PDO::PARAM_STR);
        $req->bindValue(":content", $commentaire->getContent(), PDO::PARAM_STR);
        $req->bindValue(":created_at", $commentaire->getCreated_at(), PDO::PARAM_STR);
        $req->bindValue(":author", $commentaire->getAuthor(), PDO::PARAM_STR);

        $req->execute();
    }

    public function get(int $id)
    {
        $req = $this->db->prepare("SELECT * FROM `commentaire` WHERE id = :id");
        $req->bindValue(":id", $id, PDO::PARAM_INT);
        $req->execute();

        $donnees = $req->fetch();
        if ($donnees) {
            $commentaire = new Commentaire($donnees);
        }
        return $commentaire;
    }

    public function getAll(): array
    {
        $commentaire = [];
        $req = $this->db->query("SELECT * FROM `commentaire`");
        $req->execute();

        $donnees = $req->fetchAll();
        foreach ($donnees as $donnee) {
            $commentaire[] = new Commentaire($donnee);
        }

        return $commentaire;
    }

    public function delete(int $id): void
    {
        $req = $this->db->prepare("DELETE FROM `commentaire` WHERE id = :id");
        $req->bindValue(":id", $id, PDO::PARAM_INT);
        $req->execute();
    }
}
