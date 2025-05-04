<?php

class Mozi{
    
    public function foglalas_rogzites($userid, $vetitid, $szekszam, $jegytipus){
        $sqlMuvelet="INSERT INTO `foglalas`(`felhasznaloId`, `vetitesId`, `szekszam`, `jegytipus`) VALUES ('{$userid}','{$vetitid}','{$szekszam}','{$jegytipus}')";
        $sqlEredmeny = Adatbazis::Modosit($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function eddigi_foglalas($vetitid, $szekszam){
        $sqlMuvelet="SELECT * FROM `foglalas` WHERE vetitesId={$vetitid} AND szekszam={$szekszam}";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function foglalas_torles($vetitid){
        $sqlMuvelet="DELETE FROM `foglalas` WHERE id={$vetitid}";
        $sqlEredmeny = Adatbazis::Modosit($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function ossz_rendezo(){
        $sqlMuvelet="SELECT * FROM `rendezo` ORDER BY nev";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }
    
    public function ossz_mufaj(){
        $sqlMuvelet="SELECT * FROM `mufaj` ORDER BY nev";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function ossz_besorolas(){
        $sqlMuvelet="SELECT * FROM `besorolas` ORDER BY kor";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public static function kereses_kriterium($criteria) {
        $sqlMuvelet = "SELECT * FROM film WHERE 1=1";
        foreach ($criteria as $key => $value) {
            if ($value !== '-1') {
                $sqlMuvelet .= " AND $key = '$value'";
            }
        }
        $sqlMuvelet.=" ORDER BY cim";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function admin_torles_ellenorzes_foglalas($filmid){
        $sqlMuvelet="SELECT * FROM `foglalas` INNER JOIN vetites ON foglalas.vetitesId = vetites.id WHERE vetites.filmId = '{$filmid}';";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function admin_torles_ellenorzes_vetites($filmid){
        $sqlMuvelet="SELECT * FROM `vetites` WHERE filmId = '{$filmid}';";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function admin_torles_foglalas($filmid){
        $sqlMuvelet="DELETE foglalas FROM foglalas INNER JOIN vetites ON foglalas.vetitesId = vetites.id WHERE vetites.filmId = '{$filmid}';";
        $sqlEredmeny = Adatbazis::Modosit($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function admin_torles_vetites($filmid){
        $sqlMuvelet="DELETE vetites FROM `vetites` WHERE filmId='{$filmid}';";
        $sqlEredmeny = Adatbazis::Modosit($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function admin_torles_ellenorzes_foglalas_v($vetitid){
        $sqlMuvelet="SELECT * FROM `foglalas` WHERE vetitesId = '{$vetitid}';";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function admin_torles_foglalas_v($vetitid){
        $sqlMuvelet="DELETE foglalas FROM foglalas WHERE vetitesId = '{$vetitid}';";
        $sqlEredmeny = Adatbazis::Modosit($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function admin_torles_vetites_v($vetitid){
        $sqlMuvelet="DELETE vetites FROM `vetites` WHERE id='{$vetitid}';";
        $sqlEredmeny = Adatbazis::Modosit($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function admin_torles_film($filmid){
        $sqlMuvelet="DELETE FROM `film` WHERE id={$filmid};";
        $sqlEredmeny = Adatbazis::Modosit($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function choosen_film($filmid){
        $sqlMuvelet="SELECT rendezo.nev as rendezo, besorolas.kor as besorolas, mufaj.nev as mufaj, film.id as filmid, film.url AS kepurl, film.cim, film.leiras, film.hossz, film.ev FROM film INNER JOIN rendezo ON film.rendezoId=rendezo.id INNER JOIN besorolas ON film.besorolasId=besorolas.id INNER JOIN mufaj ON film.mufajId=mufaj.id WHERE film.id={$filmid}";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }
    
    public function admin_film_modositas($cim,$leiras,$hossz,$url,$rendezoid,$mufajid,$besorolasid,$ev,$filmid){
        $sqlMuvelet="UPDATE `film` SET `cim`='{$cim}',`leiras`='{$leiras}',`hossz`='{$hossz}',`url`='{$url}',`rendezoId`='{$rendezoid}',`mufajId`='{$mufajid}',`besorolasId`='{$besorolasid}',`ev`='{$ev}' WHERE id={$filmid};";
        $sqlEredmeny = Adatbazis::Modosit($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function admin_film_mar_letezike($filmcim){
        $sqlMuvelet="SELECT * FROM `film` WHERE cim='{$filmcim}'";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

     
    public function admin_ujfilm($cim,$leiras,$hossz,$url,$rendezoid,$mufajid,$besorolasid,$ev){
        $sqlMuvelet="INSERT INTO `film`(`cim`, `leiras`, `hossz`, `url`, `rendezoId`, `mufajId`, `besorolasId`, `ev`) VALUES ('{$cim}','{$leiras}','{$hossz}','{$url}','{$rendezoid}','{$mufajid}','{$besorolasid}','{$ev}')";
        $sqlEredmeny = Adatbazis::Modosit($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function choosen_vetites($vetitesid){
        $sqlMuvelet="SELECT vetites.id as vetitid,film.cim,datum,ido FROM `vetites` INNER JOIN film ON film.id=vetites.filmId WHERE vetites.id='{$vetitesid}'";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    
    public function admin_vetites_modositas($vetitesid,$datum,$ido){
        $sqlMuvelet="UPDATE `vetites` SET `datum`='{$datum}',`ido`='{$ido}' WHERE id={$vetitesid}";
        $sqlEredmeny = Adatbazis::Modosit($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function ossz_terem(){
        $sqlMuvelet="SELECT * FROM `terem` ORDER BY ferohely";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function ossz_film(){
        $sqlMuvelet="SELECT * FROM `film` ORDER BY cim";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function admin_vetites_mar_letezike($filmid,$datum,$ido){
        $sqlMuvelet="SELECT film.id,vetites.datum, vetites.ido FROM `vetites` INNER JOIN film ON vetites.filmId=film.id WHERE film.id='{$filmid}' AND datum='{$datum}' AND ido='{$ido}'";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function admin_ujvetites($filmid,$datum,$ido,$teremid){
        $sqlMuvelet="INSERT INTO `vetites`(`filmId`, `datum`, `ido`, `teremId`) VALUES ('{$filmid}','{$datum}','{$ido}','{$teremid}')";
        $sqlEredmeny = Adatbazis::Modosit($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function vetitesek($vetitesdatum){
        $sqlMuvelet="SELECT rendezo.nev as rendezo, besorolas.kor as besorolas, mufaj.nev as mufaj, film.id as filmid, film.cim, film.leiras, film.hossz, film.ev, film.url, vetites.id, vetites.datum, vetites.ido FROM vetites INNER JOIN film ON vetites.filmId=film.id INNER JOIN rendezo ON film.rendezoId=rendezo.id INNER JOIN besorolas ON film.besorolasId=besorolas.id INNER JOIN mufaj ON film.mufajId=mufaj.id WHERE datum='{$vetitesdatum}' ORDER BY vetites.datum,vetites.ido;";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function admin_user_torles($userid){
        $sqlMuvelet="DELETE FROM `felhasznalo` WHERE id='{$userid}'";
        $sqlEredmeny = Adatbazis::Modosit($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function admin_user_foglal_ellenorzes($userid){
        $sqlMuvelet="SELECT * FROM `foglalas` WHERE felhasznaloId='{$userid}'";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }
    
    public function admin_user_foglalasok_torles($userid){
        $sqlMuvelet="DELETE FROM `foglalas` WHERE felhasznaloId='{$userid}'";
        $sqlEredmeny = Adatbazis::Modosit($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }
    
    public function admin_rendezo_mar_letezike($rendezonev){
        $sqlMuvelet="SELECT * FROM `rendezo` WHERE nev='{$rendezonev}'";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function admin_ujrendezo($rendezonev){
        $sqlMuvelet="INSERT INTO `rendezo`(`nev`) VALUES ('{$rendezonev}')";
        $sqlEredmeny = Adatbazis::Modosit($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function admin_vetites_terem_idosav($datum,$ora,$teremid){
        $sqlMuvelet="SELECT * FROM `vetites` WHERE datum='{$datum}' AND vetites.ido BETWEEN CONCAT(EXTRACT(HOUR FROM '{$ora}')-2,':00:00') AND CONCAT(EXTRACT(HOUR FROM '{$ora}')+2,':00:00') AND teremId='{$teremid}'";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }
    
}



?>


