<script type="text/javascript" src="../js/jquery-2.0.3.js"></script>
<script type="text/javascript" src="../js/jquery-ui.js"></script>

<script type="text/javascript">
    //Creo la funzione per ajax che si attivi quando il documento è pronto
    $(document).ready(function() {
        
        //Avvio la validazione tramite ajax quando si preme il bottone per la conferma della registrazione
        $("#registration_button").click(function(event) {

            //Prevento l'esecuzione normale dell'evento
            event.preventDefault();

            
            //Serializzo i valori del form; il risultato sarà una stringa che conterrà tutti i valori e che sarà strutturata del tipo:
            //'username=ciao&password=&password2=prova&email='
            var form = $("#registration_form").serialize();
            

            //Avvio la funzione specifica per ajax
            $.ajax({
                //Specifico l'url
                url: "index.php?page=guest",
                type: "POST",
                
                //Specifico i dati da passare al server; in questo caso sono il comando per la validazione tramita ajax (processata nel GuesController)
                //e la stringa serializzata contenente i valori del form
                data: {
                  cmd: "registration_form_validation_ajax", 
                  form_fields: form
                },
                
                //Definisco il tipo di dato da ritornare
                dataType: 'json',
                
                //Definisco la funzione da chiamare in caso di successo
                success: function(data, state) {
                    showFormFieldValidation(data);
                },
                
                error: function(data, state, errorThrown) {
                    
                }
            });
        });


        //Funzione che si occupa di mostrare eventuali errori dovuti alla validazione o di eseguire il submit del form se era tutto ok
        function showFormFieldValidation(json)
        {
            //Il json ricevuto tramite ajax contiene un booleano che indica se il form era ok; in tal caso, faccio il submit del form
            if(json.isValidationOk)
                $("#registration_form").submit();
            //Altrimenti, procedo col mostare tutti gli errori
            else
            {
                //Se il messaggio di errore relativo a ciascun campo non è vuoto, allora vuol dire che non andava bene e quindi bisogna mostrare
                //il relativo messaggio di errore
                if(json.usernameMessage != '')
                {
                    //Coloro il relativo form di rosso
                    $('#form_username').css("background-color", "red");
                    
                    //Setto il messaggio di errore e lo mostro, qualora fosse invisibile
                    $('#validation_username_message').text(json.usernameMessage);
                    $('#validation_username_message').show();
                }
                //Se altrimenti il campo andava bene, lo coloro di verde e nascondo l'eventuale messaggio di errore che c'era prima
                else
                {
                    $('#form_username').css("background-color", "green");
                    
                    $('#validation_username_message').hide();
                }
                
                if(json.passwordMessage != '')
                {
                    $('#form_password').css("background-color", "red");
                    $('#form_password2').css("background-color", "red");
                    
                    $('#validation_password_message').text(json.passwordMessage);
                    $('#validation_password_message').show();
                }
                else
                {
                    $('#form_password').css("background-color", "green");
                    
                    $('#validation_password_message').hide();
                    
                    if(json.password2Message != '')
                    {
                        $('#form_password2').css("background-color", "red");
                        $('#validation_password2_message').text(json.password2Message);
                        $('#validation_password2_message').show();
                    }
                    else
                    {
                        $('#form_password2').css("background-color", "green");
                        
                        $('#validation_password2_message').hide();
                    }
                }
                
                if(json.emailMessage != '')
                {
                    $('#form_email').css("background-color", "red");
                    $('#validation_email_message').text(json.emailMessage);
                    $('#validation_email_message').show();
                }
                else
                {
                    $('#form_email').css("background-color", "green");
                    
                    $('#validation_email_message').hide();
                }
            }
            
        }     
    });
</script>


<div class="input-form">
    <h2 class="icon-title h-registration">Registrazione</h2>

    <form method="post" id="registration_form" action="index.php?page=guest&subpage=registration&cmd=register">
        <div class="username_form_div">
            <label for="form_username"><strong>Username: </strong></label>
            <input class="inputBar" type="text" name="username" id="form_username" value="<?= $username ?>"/>
            
            <p id="validation_username_message" hidden>
                
            </p>
        </div>
        
        <br>
        
        <div class="password_form_div">
            <label for="form_password"><strong>Password: </strong></label>
            <input class="inputBar" type="password" name="password" id="form_password"/> 
            
            <p id="validation_password_message" hidden>
                
            </p>
        </div>
        
        <br>
        
        <div class="password2_form_div">
            <label for="form_password2"><strong>Ripeti password: </strong></label>
            <input class="inputBar" type="password" name="password2" id="form_password2"/> 
            
            <p id="validation_password2_message" hidden>
                
            </p>
        </div>
        
        <br>
        
        <div class="email_form_div">
            <label for="form_email"><strong>Email: </strong></label>
            <input class="inputBar" type="email" name="email" id="form_email" value="<?= $email ?>" <?= $isReadOnly ?>/> 
            
            <p id="validation_email_message" hidden>
                
            </p>
        </div>

        <div class="buttonCenter" id="registration_button">
            <input class="buttonBigger saveChangesButton" type="submit" value="Registrati"/>
        </div>
    </form>
</div>
