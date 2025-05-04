<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Voltaire&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="./logo/favicon.jpg">
    <title>Vetítések</title>
    <style>

@media only screen and (max-width: 1920px) {
    #tartalom {
        font-size: 15px;
    }

    .filmDoboz{
        min-width: 600px;
        margin-bottom:15px;
    }

    .kepek{
        width: 200px;
    }

    #vertical-line {
        margin-left: 20px;
    }

    .oraid{
        margin-left: -70px;
    }

    .filmcimForma{
        font-size:22px;
        margin:0px;
    }
}

@media only screen and (max-width: 720px) {
    #tartalom {
        font-size: 14px;
    }
    .filmDoboz{
        min-width: 250px;
    }
    .kepek{
        width: 150px;
    }
    #vertical-line {
        margin-left: 5px;
    }
    .oraid{
        margin-left: -55px;
    }
    .filmcimForma{
        font-size:17px;
    }
}

@media only screen and (max-width: 540px) {
    #tartalom {
        font-size: 12px;
    }
    .filmDoboz{
        min-width: 220px;
    }
    .kepek{
        width: 120px;
    }
    #vertical-line {
        margin-left: -10px;
    }
    .oraid{
        margin-left: -45px;
    }
    .filmcimForma{
        font-size:15px;
    }
}

    #kulsoTarolo{
        margin-top:20px;
      margin-left:70px;
      color: rgb(146, 146, 146);
    }

  #vertical-line {
    width: 1px;
    background-color: #929292;
    z-index: 1;
  }

  .circle {
  width: 16px;
  height: 16px;
  background-color: #e3dd81;
  border-radius: 50%;
  z-index: 2;
  margin-left:-7.5px;
  margin-top: -20px;
  align-items: center;
  }

  .orak{
    min-height: 50px;
  }

  .oraid{
    z-index: 3;
  }

  #kor{
    margin-top: 5px;
  }

  

  .filmcimForma{
        font-weight: bold;
    }

  </style>
</head>
<body>
    <?php
        session_start();

        if (!isset($_SESSION['user_id'])) {
            include './header_logout.php';
            $user_check=false;
        }
        else{
            include './header.php';
            $user_check=true;
        }

        include './mozi.class.php';
        include './adatbazis.class.php';

        

    ?>
    <div id="tartalom">
        <div id="main">
            <p id="info"></p>
            <div class="d-flex justify-content-end mx-5">
                <input type="date" id="datumMezo" min="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>">
                
            </div>
                <div id="kulsoTarolo">
                    <div id="vertical-line">
                    <div class="orak">
                        <div class="oraid">10:00</div>
                        <div class="circle"></div>
                        <div id="10" class="row"></div>
                    </div>
                    <div class="orak">
                        <div class="oraid">11:00</div>
                        <div class="circle"></div>
                        <div id="11" class="row"></div>
                    </div>
                    <div class="orak">
                        <div class="oraid">12:00</div>
                        <div class="circle"></div>
                        <div id="12" class="row"></div>
                    </div>
                    <div class="orak">
                        <div class="oraid">13:00</div>
                        <div class="circle"></div>
                        <div id="13" class="row"></div>
                    </div>
                    <div class="orak">
                        <div class="oraid">14:00</div>
                        <div class="circle"></div>
                        <div id="14" class="row"></div>
                    </div>
                    <div class="orak">
                        <div class="oraid">15:00</div>
                        <div class="circle"></div>
                        <div id="15" class="row"></div>
                    </div>
                    <div class="orak">
                        <div class="oraid">16:00</div>
                        <div class="circle"></div>
                        <div id="16" class="row"></div>
                    </div>
                    <div class="orak">
                        <div class="oraid">17:00</div>
                        <div class="circle"></div>
                        <div id="17" class="row"></div>
                    </div>
                    <div class="orak">
                        <div class="oraid">18:00</div>
                        <div class="circle"></div>
                        <div id="18" class="row"></div>
                    </div>
                    <div class="orak">
                        <div class="oraid">19:00</div>
                        <div class="circle"></div>
                        <div id="19" class="row"></div>
                    </div>
                    <div class="orak">
                        <div class="oraid">20:00</div>
                        <div class="circle"></div>
                        <div id="20" class="row"></div>
                    </div>
                    <div class="orak">
                        <div class="oraid">21:00</div>
                        <div class="circle"></div>
                        <div id="21" class="row"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include './footer.php'; ?>

    <script>
        async function megjelenit(){
            try{
                for (let i = 10; i < 22; i++) {
                    document.getElementById(i).innerHTML='';
                }
                document.getElementById('info').innerHTML='';
                if(document.getElementById('datumMezo').value != ''){
                    let eredmeny = await fetch('class/index.class.php/vetitesek', {
                            method : 'POST',
                            body: JSON.stringify({
                                'vetitesdatum': document.getElementById('datumMezo').value                               
                            })
                        });
                    let valasz = await eredmeny.json();
                    
                    if(valasz['valasz'] != 'Nincs talalat'){
                        for (var x of valasz) {
                            let ora = x['ido'].split(':')[0];
                            document.getElementById(ora).innerHTML+='<div id="'+x['id']+'F" class="row mx-5 filmDoboz"><div class="col col-md-5 col-sm-12"><a href="film.php?id='+x['filmid']+'"><img src="./img/'+x['url']+'" class="rounded border kepek" alt="'+x['cim']+'" title="'+x['cim']+'" width="200px"></a></div><div class="col col-md-7 col-sm-12"><a href="#" class="idoLink" id="L'+x['id']+'" onclick="stop('+x['id']+'); return false;"><p class="filmcimForma">'+x['cim']+'</p>'+x['ido']+'</a></div></div>';
                        }
                    }
                    else{
                        document.getElementById('info').innerHTML='Ezen a napon még nincs vetítés';
                    }

                }

                let datum = document.getElementById('datumMezo').value;
                var mai = new Date(datum);
                var maiDatum = mai.toISOString().slice(0,10);

                var date = new Date();
                var formattedDate = date.toISOString().slice(0,10);

                if(formattedDate == maiDatum)
                    var linkek = document.getElementsByClassName('idoLink');
                    for (const x of linkek) {
                        let ora = x.innerText.substring(x.innerText.length-8,x.innerText.length - 6);
                        let tobb = x.innerText.substring(x.innerText.length-6,x.innerText.length);
                        ora--;
                        ora=ora.toString();
                        if(ora.length==1){
                            ora='0'+ora;
                            console.log(ora);
                        }
                        var egybe = ora+''+tobb;
                        var oraResz = new Date(datum+'T'+egybe);

                        console.log(oraResz);
                        console.log(date);
                        if(oraResz<date){
                            var linkId = x.id;
                            var linkElem = document.getElementById(linkId);
                            linkElem.removeAttribute("href");
                            linkElem.onclick = function(event) {
                                event.preventDefault();
                            };
                            
                        }
                        
                    }
                    
                }
            catch(error){
                console.log(error);
            }
        }

        function stop(filmid){
            let proba = "<?php echo $user_check; ?>";
            if(proba!=1){
                alert('Jegyfoglaláshoz jelentkezzen be!');
            }
            else{
                window.location.href="vetites.php?id="+filmid;
            }
        }

        window.addEventListener('change',megjelenit);
        window.addEventListener('load',megjelenit);
    </script>
</body>
</html>