<?php 
$myURL = 'http://bellescarpecod.altervista.org/mvc/index.php?page=guest&subpage=registration';
?>

<iframe src="http://www.facebook.com/plugins/registration.php?
             client_id=281784095318774&
             redirect_uri=<?= urlencode($myURL) ?>&
             fields=name,birthday,gender,location,email"
        scrolling="auto"
        frameborder="no"
        style="border:none"
        allowTransparency="true"
        width="100%"
        height="310px">
</iframe>



<?php 
//if ($_REQUEST['signed_request'])
//{
//    $response = parse_signed_request($_REQUEST['signed_request'], 'cec392f8e3d40ac5e66e366a85a3730f');//secret
//
//    if($response)
//    {
//        //Fields values
//        $email=$response['registration']['email'];
//        $name=$response['registration']['name'];
//        $gender=$response['registration']['gender'];
//        $user_fb_id=$response['user_id'];
//        $location=$response['registration']['location']['name'];
//        $bday = $response['registration']['birthday'];
//
//        //print entire array response
//        echo '<h3>Response Array</h3>';
//        echo '<pre>';
//        print_r($response);
//        echo '</pre>';
//
//        //print values
//        echo '<h3>Fields Values</h3>';
//        echo 'email: ' . $email . '<br />';
//        echo 'Name: ' . $name . '<br />';
//        echo 'Gender: ' . $gender . '<br />';
//        echo 'Facebook Id: ' . $user_fb_id . '<br />';
//        echo 'Location: ' . $location . '<br />';
//        echo 'Birthday: ' . $bday . '<br />';
//
//    }
//}
?> 

<?php
//function parse_signed_request($signed_request, $secret)
//{
//    list($encoded_sig, $payload) = explode('.', $signed_request, 2); 
//
//    // decode the data
//    $sig = base64_url_decode($encoded_sig);
//    $data = json_decode(base64_url_decode($payload), true);
//
//    if (strtoupper($data['algorithm']) !== 'HMAC-SHA256')
//    {
//        error_log('Unknown algorithm. Expected HMAC-SHA256');
//        return null;
//    }
//
//    // check sig
//    $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
//    if ($sig !== $expected_sig)
//    {
//        error_log('Bad Signed JSON signature!');
//        return null;
//    }
//
//    return $data;
//}
//
//function base64_url_decode($input)
//{
//    return base64_decode(strtr($input, '-_', '+/'));
//}
?>

<!--<div class="input-form">
    <h2 class="icon-title h-registration">Registrazione cliente</h2>

    <form method="post" action="visitor/registration_customer">
        <input type="hidden" name="cmd" value="register"/>
    
        <label for="form_username"><strong>Username: </strong></label>
        <input class="inputBar" type="text" name="username" id="form_username"/>
        
        <br>
        
        <label for="form_password"><strong>Password: </strong></label>
        <input class="inputBar" type="password" name="password" id="form_password"/> 
        
        <br>
        
        <label for="form_password2"><strong>Ripeti password: </strong></label>
        <input class="inputBar" type="password" name="password2" id="form_password2"/> 
        
        <br>

        <label for="form_name"><strong>Nome: </strong></label>
        <input class="inputBar" type="text" name="name" id="form_name"/>
        
        <br>
        
        <label for="form_surname"><strong>Cognome: </strong></label>
        <input class="inputBar" type="text" name="surname" id="form_surname"/> 
        
        <br>
        
        <label for="form_email"><strong>Email: </strong></label>
        <input class="inputBar" type="email" name="email" id="form_email"/> 
        
        <br>
        
        <label for="form_adress"><strong>Indirizzo: </strong></label>
        <input class="inputBar" type="text" name="adress" id="form_adress"/> 
        
        <br>
        
        <label for="form_civicNumber"><strong>Numero civico: </strong></label>
        <input class="inputBar" type="number" name="civicNumber" id="form_civicNumber"/> 
        
        <br>
        
        <label for="form_city"><strong>Citt&agrave;: </strong></label>
        <input class="inputBar" type="text" name="city" id="form_city"/> 
        
        <br>
        
        <label for="form_cap"><strong>Cap: </strong></label>
        <input class="inputBar" type="number" name="cap" id="form_cap"/> 
        
        <br>
        
        <label for="form_credit"><strong>Credito: </strong></label>
        <input class="inputBar" type="text" name="credit" id="form_credit"/> 
        
        <div class="buttonCenter">
            <input class="buttonBigger saveChangesButton" type="submit" value="Registrati"/>
        </div>
    </form>
</div>-->
