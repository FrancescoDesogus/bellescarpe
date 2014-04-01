<script type="text/javascript" src="../js/jquery-2.0.3.js"></script>
<script type="text/javascript" src="../js/jquery-ui.js"></script>

<script type="text/javascript">
    //Creo la funzione per ajax che si attivi quando il documento è pronto
    $(document).ready(function() {
        
        //Ogni volta che l'utente preme un tasto e lo molla, viene avviata la funzione
//        $("#registration_form").click(function(e) {
        $("#registration_button").click(function(e) {

            
            e.preventDefault();

            console.log("prevented default");
            
            var form = $("#registration_form").serialize();
            
                        
            //Recupero il testo presente nella barra al momento della pressione del tasto
//            username_text = $("#form_username").val(); 

            //Avvio la funzione specifica
            $.ajax({
                //Specifico l'url
                url: "index.php?page=guest",
                type: "POST",
                
                //Specifico i dati da passare al server; in questo caso sono
                //il comando per la ricerca ed il contenuto della search bar
                data: {
                  cmd: "username_validation_ajax", 
                  form_fields: form
                },
                
                //Definisco il tipo di dato da ritornare
                dataType: 'json',
                
                //Definisco la funzione da chiamare in caso di successo
                success: function(data, state) {

                    console.log($("#registration_form").serialize());
                    showFormFieldValidation(data);
                },
                
                error: function(data, state, errorThrown) {
                    
                }
            });
        });


        //Funzione che si occupa di mostrare i suggerimenti, ricevuti nella forma di json
        function showFormFieldValidation(json)
        {
            //Definisco il nuovo codice html da mostrare nel div situato sotto
            //la search bar. Il valore contenuto nel json è già pronto con
            //il codice html contenente i nomi ed i link ai rispettivi libri suggeriti
            
            
            
            if(json.isValidationOk)
            {
                $("#registration_form").submit();

//                window.location = "index.php?page=guest&subpage=registration&cmd=register";
            }
            else
            {
                if(json.usernameMessage != '')
                {
                    $('#form_username').css("background-color", "red");
                    $('#validation_username_message').text(json.usernameMessage);
                    $('#validation_username_message').show();
                }
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
