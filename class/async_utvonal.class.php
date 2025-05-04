<?php

class Utvonal{
    private $teljesUrl;
    private $erkezettAdatok;

    public function __construct($URL){
        $this->teljesUrl = explode('/',$URL);
        $this->erkezettAdatok = json_decode(file_get_contents('php://input'), false);
    }
    
    public function utvonalVizsgalat(){
        switch (end($this->teljesUrl)) {
            case 'foglalas':
                $mozi = new Mozi();
                echo $mozi->foglalas_rogzites($this->erkezettAdatok->userid, $this->erkezettAdatok->vetitid, $this->erkezettAdatok->szekszam, $this->erkezettAdatok->jegytipus);
                break;
            case 'eddigfoglalt':
                $mozi = new Mozi();
                echo $mozi->eddigi_foglalas($this->erkezettAdatok->vetitid,$this->erkezettAdatok->szekszam);
                break;
            case 'torles':
                $mozi = new Mozi();
                echo $mozi->foglalas_torles($this->erkezettAdatok->vetitid);
                break;
            case 'ossz_rendezo':
                $mozi = new Mozi();
                echo $mozi->ossz_rendezo();
                break;
            case 'ossz_mufaj':
                $mozi = new Mozi();
                echo $mozi->ossz_mufaj();
                break;
            case 'ossz_besorolas':
                $mozi = new Mozi();
                echo $mozi->ossz_besorolas();
                break;
            case 'kereses_kriterium':
                $mozi = new Mozi();
                echo $mozi->kereses_kriterium($this->erkezettAdatok->criteria);
                break;
            case 'admin_torles_ellenorzes_foglalas':
                $mozi = new Mozi();
                echo $mozi->admin_torles_ellenorzes_foglalas($this->erkezettAdatok->filmid);
                break;
            case 'admin_torles_ellenorzes_vetites':
                $mozi = new Mozi();
                echo $mozi->admin_torles_ellenorzes_vetites($this->erkezettAdatok->filmid);
                break;
            case 'admin_torles_foglalas':
                $mozi = new Mozi();
                echo $mozi->admin_torles_foglalas($this->erkezettAdatok->filmid);
                break;
            case 'admin_torles_vetites':
                $mozi = new Mozi();
                echo $mozi->admin_torles_vetites($this->erkezettAdatok->filmid);
                break;
            case 'admin_torles_film':
                $mozi = new Mozi();
                echo $mozi->admin_torles_film($this->erkezettAdatok->filmid);
                break;
            case 'admin_torles_ellenorzes_foglalas_v':
                $mozi = new Mozi();
                echo $mozi->admin_torles_ellenorzes_foglalas_v($this->erkezettAdatok->vetitid);
                break;
            case 'admin_torles_foglalas_v':
                $mozi = new Mozi();
                echo $mozi->admin_torles_foglalas_v($this->erkezettAdatok->vetitid);
                break;
            case 'admin_torles_vetites_v':
                $mozi = new Mozi();
                echo $mozi->admin_torles_vetites_v($this->erkezettAdatok->vetitid);
                break;
            case 'choosen_film':
                $mozi = new Mozi();
                echo $mozi->choosen_film($this->erkezettAdatok->filmid);
                break; 
            case 'admin_film_modositas':
                $mozi = new Mozi();
                echo $mozi->admin_film_modositas($this->erkezettAdatok->cim,$this->erkezettAdatok->leiras,$this->erkezettAdatok->hossz,$this->erkezettAdatok->url,$this->erkezettAdatok->rendezoid,$this->erkezettAdatok->mufajid,$this->erkezettAdatok->besorolasid,$this->erkezettAdatok->ev,$this->erkezettAdatok->filmid);
                break;
            case 'admin_film_mar_letezike':
                $mozi = new Mozi();
                echo $mozi->admin_film_mar_letezike($this->erkezettAdatok->filmcim);
                break; 
            case 'admin_ujfilm':
                $mozi = new Mozi();
                echo $mozi->admin_ujfilm($this->erkezettAdatok->cim,$this->erkezettAdatok->leiras,$this->erkezettAdatok->hossz,$this->erkezettAdatok->url,$this->erkezettAdatok->rendezoid,$this->erkezettAdatok->mufajid,$this->erkezettAdatok->besorolasid,$this->erkezettAdatok->ev);
                break;
            case 'choosen_vetites':
                $mozi = new Mozi();
                echo $mozi->choosen_vetites($this->erkezettAdatok->vetitesid);
                break;
            case 'admin_vetites_modositas':
                $mozi = new Mozi();
                echo $mozi->admin_vetites_modositas($this->erkezettAdatok->vetitesid,$this->erkezettAdatok->datum,$this->erkezettAdatok->ido);
                break;
            case 'ossz_terem':
                $mozi = new Mozi();
                echo $mozi->ossz_terem();
                break;
            case 'ossz_film':
                $mozi = new Mozi();
                echo $mozi->ossz_film();
                break;
            case 'admin_vetites_mar_letezike':
                $mozi = new Mozi();
                echo $mozi->admin_vetites_mar_letezike($this->erkezettAdatok->filmid,$this->erkezettAdatok->datum,$this->erkezettAdatok->ido);
                break;
            case 'admin_ujvetites':
                $mozi = new Mozi();
                echo $mozi->admin_ujvetites($this->erkezettAdatok->filmid,$this->erkezettAdatok->datum,$this->erkezettAdatok->ido,$this->erkezettAdatok->teremid);
                break;
            case 'vetitesek':
                $mozi = new Mozi();
                echo $mozi->vetitesek($this->erkezettAdatok->vetitesdatum);
                break;
            case 'admin_user_torles':
                $mozi = new Mozi();
                echo $mozi->admin_user_torles($this->erkezettAdatok->userid);
                break;
            case 'admin_user_foglal_ellenorzes':
                $mozi = new Mozi();
                echo $mozi->admin_user_foglal_ellenorzes($this->erkezettAdatok->userid);
                break;
            case 'admin_user_foglalasok_torles':
                $mozi = new Mozi();
                echo $mozi->admin_user_foglalasok_torles($this->erkezettAdatok->userid);
                break;
            case 'admin_rendezo_mar_letezike':
                $mozi = new Mozi();
                echo $mozi->admin_rendezo_mar_letezike($this->erkezettAdatok->rendezonev);
                break;
            case 'admin_ujrendezo':
                $mozi = new Mozi();
                echo $mozi->admin_ujrendezo($this->erkezettAdatok->rendezonev);
                break;
            case 'admin_vetites_terem_idosav':
                $mozi = new Mozi();
                echo $mozi->admin_vetites_terem_idosav($this->erkezettAdatok->datum,$this->erkezettAdatok->ora,$this->erkezettAdatok->teremid);
                break;
        
            default:
                echo 'halo';
                break;
        }
    }
}


?>