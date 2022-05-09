<?php // permet de gerer UN commentaire specifiquement

class Commentaire
{
    private $id;
    private int $id_article;
    private $title;
    private $content;
    private $created_at;
    private $author;


    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    public function hydrate(array $donnees)
    {
        foreach ($donnees as $cle => $valeur) {
            $methode = 'set' . ucfirst($cle);
            if (method_exists($this, $methode)) {
                $this->$methode($valeur);
            }
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if ($id > 0) {
            $this->id = $id;
            return $this;
        }
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        if (is_string($title)) {
            $this->title = $title;
            return $this;
        }
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        if (is_string($content)) {
            $this->content = $content;
            return $this;
        }
    }

    public function getCreated_at()
    {
        return $this->created_at;
    }

    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getAuthor()
    {       
        return $this->author;
    }

    public function setAuthor($author)
    {
        if (is_string($author)) {
            $this->author = $author;
            return $this;
        }
    }

    public function getId_commentaire()
    {
        return $this->id_commentaire;
    }

    public function setId_commentaire($id_commentaire)
    {
        $this->id_commentaire = $id_commentaire;

        return $this;
    }

    public function getId_article()
    {
        return $this->id_article;
    }

    public function setId_article($id_article)
    {
        $this->id_article = $id_article;

        return $this;
    }
}
