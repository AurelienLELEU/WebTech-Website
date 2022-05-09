<?php // permet d'interagir avec un user de la base de données users
class UsersManager
{
    private $db;

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

    public function add(User $user)
    {
        $req = $this->db->prepare("INSERT INTO `user` (username, password, email) VALUES (:username, :password, :email)");

        $req->bindValue(":username", $user->getUsername(), PDO::PARAM_STR);
        $req->bindValue(":password", $user->getpassword(), PDO::PARAM_STR);
        $req->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);
        $req->execute();
    }

    public function update(User $user)
    {
        $req = $this->db->prepare("UPDATE `user` SET username = :username, password = :password, email = :email WHERE id = :id");

        $req->bindValue(":id", $user->getId(), PDO::PARAM_INT);
        $req->bindValue(":username", $user->getUsername(), PDO::PARAM_STR);
        $req->bindValue(":password", $user->getpassword(), PDO::PARAM_INT);
        $req->bindValue(":email", $user->getEmail(), PDO::PARAM_INT);

        $req->execute();
    }

    public function get(int $id)
    {
        $req = $this->db->prepare("SELECT * FROM `user` WHERE id = :id");
        $req->bindValue(":id", $id, PDO::PARAM_INT);
        $req->execute();

        $donnees = $req->fetch();
        if ($donnees) {
            $user = new User($donnees);
        }
        return $user;
    }

    public function getIdwithusername($username)
    {
        $req = $this->db->prepare("SELECT * FROM `user` WHERE username = :username");
        $req->bindValue(":username", $username, PDO::PARAM_INT);
        $req->execute();

        $donnees = $req->fetch();
        $user = new User($donnees);
        return $user->getId();
    }

    public function getAll(): array
    {
        $users = [];
        $req = $this->db->query("SELECT * FROM `User`");
        $req->execute();

        $donnees = $req->fetchAll();
        foreach ($donnees as $donnee) {
            $users[] = new User($donnee);
        }
        return $users;
    }

    public function delete(int $id): void
    {
        $req = $this->db->prepare("DELETE FROM `User` WHERE id = :id");
        $req->bindValue(":id", $id, PDO::PARAM_INT);
        $req->execute();
    }
}
