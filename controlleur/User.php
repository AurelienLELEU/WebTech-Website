<?php // permet de gerer UN User specifiquement
class User{

    private int $id;
    private string $username;
    private string $password;
    private string $email;

    public function __construct(array $datas){
        $this->hydrate($datas);
    }

    public function hydrate(array $datas){
        foreach($datas as $key => $value){
            $method = "set".ucfirst($key);
            if(method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }

    public function getId(){
        return $this->id;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setId($id){
        $id = (int)$id;
        if ($id > 0) {
            $this->id = $id;
        }
    }

    public function setUsername($username){
        if(is_string($username)){
            $this->username = $username; 
        }
    }

    public function setPassword($password){
        if(is_string($password)){
            $this->password = $password;
        }
    }

    public function setEmail($email){
        if(is_string($email)){
            $this->email = $email;
        }
    }
}