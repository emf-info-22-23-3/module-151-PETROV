<?php
    class Equipe implements implements JsonSerializable{
        private $nom;
        private  $id
        public function __construct( $id,  $nom) {
            $this->$id = $id;
            $this->$nom = $nom;
        }
        public function getId(){
            return $this->$id;
        }
        public function getNom(){
            return $this->$nom;
        }
        public function jsonSerialize():mixed {
            $vars = get_object_vars($this);
            return $vars;
        }
    }
?>
