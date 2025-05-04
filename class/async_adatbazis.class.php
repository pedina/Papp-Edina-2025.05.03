<?php

    class Adatbazis{
        private static $kiszolgalo = 'localhost';
        private static $felhasznalo = 'root';
        private static $jelszo = '';
        private static $tabla = 'mozi';
        private static $db;

        public static function adatLekeres($muvelet){
            self::$db = new mysqli(self::$kiszolgalo, self::$felhasznalo, self::$jelszo, self::$tabla);
            if(self::$db->connect_errno==0){
                $eredmeny = self::$db->query($muvelet);
                if(self::$db->errno == 0){
                    if($eredmeny->num_rows>0){
                        $adatok = $eredmeny->fetch_all(MYSQLI_ASSOC);
                    }
                    else{
                        $adatok = array('valasz'=>'Nincs talalat');
                    }
                }
                else
                {
                    $adatok = self::$db->error;
                }
            }
            else{
                $adatok = self::$db->connect_error;
            }
            return $adatok;
        }

        public static function Modosit($muvelet){
            self::$db = new mysqli(self::$kiszolgalo, self::$felhasznalo, self::$jelszo, self::$tabla);
            if(self::$db->connect_errno==0){
                $eredmeny = self::$db->query($muvelet);
                if(self::$db->errno==0){
                    if(self::$db->affected_rows>0){
                        $valasz = 'Sikeres művelet';
                    }
                    else{
                        $valasz = 'Sikertelen';
                    }
                }
                else{
                    $valasz = self::$db->error;
                }
            }
            else{
                $valasz = self::$db->connect_error;
            }
            return $valasz;
        }
        

    }


?>