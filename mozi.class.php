<?php

class Mozi{
    private $db;

    public function __construct() {
        $this->db = new Adatbazis();
    }

    public function login($email) {
        return $this->db->adatokLekerese("SELECT * FROM felhasznalo WHERE email = '{$email}'");
    }

    public function register($name,$email,$pass){
        return $this->db->Modosit("INSERT INTO `felhasznalo`(`nev`, `email`, `jelszo`, `admin`) VALUES ('{$name}','{$email}',SHA2('{$pass}', 256), false)");
    }

    public function email_check($email){
        return $this->db->adatokLekerese("SELECT * FROM `felhasznalo` WHERE email='{$email}'");
    }

    public function filmek(){
        return $this->db->adatokLekerese("SELECT * FROM `film` ORDER BY cim");
    }

    public function arazas(){
        return $this->db->adatokLekerese("SELECT * FROM `arazas`");
    }

    public function user_foglalasok($user){
        return $this->db->adatokLekerese("SELECT film.cim,vetites.datum as datum1,vetites.ido,foglalas.id as fogid, foglalas.datum as datum2,foglalas.szekszam,arazas.ar,vetites.teremId FROM `film` INNER JOIN vetites ON film.id=vetites.filmId INNER JOIN foglalas ON vetites.id=foglalas.vetitesId INNER JOIN felhasznalo ON foglalas.felhasznaloId=felhasznalo.id INNER JOIN arazas ON foglalas.jegytipus=arazas.id WHERE felhasznaloId={$user} ORDER BY datum2 DESC");
    }

    public function vetitesek(){
        return $this->db->adatokLekerese("SELECT rendezo.nev as rendezo, besorolas.kor as besorolas, mufaj.nev as mufaj, film.id as filmid, film.cim, film.leiras, film.hossz, film.ev, film.url, vetites.id, vetites.datum, vetites.ido FROM vetites INNER JOIN film ON vetites.filmId=film.id INNER JOIN rendezo ON film.rendezoId=rendezo.id INNER JOIN besorolas ON film.besorolasId=besorolas.id INNER JOIN mufaj ON film.mufajId=mufaj.id ORDER BY vetites.datum");
    }

    public function choosen_vetites($vetit_id){
        return $this->db->adatokLekerese("SELECT film.cim, vetites.datum, vetites.ido, vetites.id, terem.ferohely FROM `film` INNER JOIN vetites ON vetites.filmId=film.id INNER JOIN terem ON vetites.teremId=terem.id WHERE vetites.id={$vetit_id}");
    }

    public function choosen_film($film_id){
        return $this->db->adatokLekerese("SELECT rendezo.nev as rendezo, besorolas.kor as besorolas, mufaj.nev as mufaj, film.id as filmid, film.cim, film.leiras, film.hossz, film.ev, film.url FROM film INNER JOIN rendezo ON film.rendezoId=rendezo.id INNER JOIN besorolas ON film.besorolasId=besorolas.id INNER JOIN mufaj ON film.mufajId=mufaj.id WHERE film.id={$film_id}");
    }

    public function vetites_foglalas_dbszam($vetit_id){
        return $this->db->adatokLekerese("SELECT COUNT(id) AS osszdb FROM `foglalas` WHERE vetitesId={$vetit_id}");
    }

    public function mar_foglalt($vetit_id){
        return $this->db->adatokLekerese("SELECT szekszam FROM `foglalas` WHERE vetitesId={$vetit_id} ORDER BY szekszam");
    }

    public function foglalas_rogzites($userid, $vetitid, $szekszam, $jegytipus){
        return $this->db->Modosit("INSERT INTO `foglalas`(`felhasznaloId`, `vetitesId`, `szekszam`, `jegytipus`) VALUES ('{$userid}','{$vetitid}','{$szekszam}','{$jegytipus}')");
    }

    public function osszes_filmadat(){
        return $this->db->adatokLekerese("SELECT film.id,film.url,cim,leiras,hossz,rendezo.nev as rendezo,mufaj.nev as mufaj,besorolas.kor as besorolas,ev FROM `film` INNER JOIN rendezo ON film.rendezoId=rendezo.id INNER JOIN mufaj ON film.mufajId=mufaj.id INNER JOIN besorolas ON film.besorolasId=besorolas.id ORDER BY cim");
    }

    public function osszes_felhasznalo(){
        return $this->db->adatokLekerese("SELECT * FROM `felhasznalo` WHERE admin=0");
    }

    public function osszes_rendezo(){
        return $this->db->adatokLekerese("SELECT * FROM `rendezo`");
    }
    
    public function user_db(){
        return $this->db->adatokLekerese("SELECT COUNT(id) as db FROM `felhasznalo`");
    }

    public function film_db(){
        return $this->db->adatokLekerese("SELECT COUNT(id) as db FROM `film`");
    }

    public function vetites_db(){
        return $this->db->adatokLekerese("SELECT COUNT(id) as db FROM `vetites`");
    }

    public function foglalas_db(){
        return $this->db->adatokLekerese("SELECT COUNT(id) as db FROM `foglalas`");
    }

    public function akt_vetitesek_admin(){
        return $this->db->adatokLekerese("SELECT film.cim, film.ev, film.url, vetites.id, vetites.datum, vetites.ido FROM vetites INNER JOIN film ON vetites.filmId=film.id INNER JOIN rendezo ON film.rendezoId=rendezo.id INNER JOIN besorolas ON film.besorolasId=besorolas.id INNER JOIN mufaj ON film.mufajId=mufaj.id WHERE datum >= CURDATE() ORDER BY vetites.datum,vetites.ido");
    }

    public function elozo_vetitesek_admin(){
        return $this->db->adatokLekerese("SELECT film.cim, film.ev, film.url, vetites.id, vetites.datum, vetites.ido FROM vetites INNER JOIN film ON vetites.filmId=film.id INNER JOIN rendezo ON film.rendezoId=rendezo.id INNER JOIN besorolas ON film.besorolasId=besorolas.id INNER JOIN mufaj ON film.mufajId=mufaj.id WHERE datum < CURDATE() ORDER BY vetites.datum DESC,vetites.ido DESC");
    }
}

?>