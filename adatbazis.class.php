<?php
    class Adatbazis{
        private static $kiszolgalo = 'localhost';
        private static $felhasznalo = 'root';
        private static $jelszo = '';
        private static $tabla = 'mozi';
        private $db;

    public function __construct() {
        $this->db = new mysqli(self::$kiszolgalo, self::$felhasznalo, self::$jelszo, self::$tabla);
    }

    public function adatokLekerese($muvelet) {
        $eredmeny = $this->db->query($muvelet);
        if ($this->db->errno == 0) {
            if ($eredmeny->num_rows > 0) {
                $valasz = $eredmeny->fetch_all(MYSQLI_ASSOC);
            } else {
                $valasz = 'Nincs találat';
            }
        } else {
            $valasz = $this->db->error;
        }
        return $valasz;
    }

    public function Modosit($muvelet) {
        $eredmeny = $this->db->query($muvelet);
        if ($this->db->errno == 0) {
            if ($this->db->affected_rows > 0) {
                $valasz = 'Sikeres művelet';
            } else {
                $valasz = 'Sikertelen';
            }
        } else {
            $valasz = $this->db->error;
        }
        return $valasz;
    }
}

?>