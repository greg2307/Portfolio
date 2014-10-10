//Merci Oudam ;)
$(document).ready(function() {
    $("#submit_btn").click(function() { 
        //get input field values
        // récupération des champs
        var user_name       = $('input[name=name]').val(); 
        var user_email      = $('input[name=email]').val();
        var user_phone      = $('input[name=phone]').val();
        var user_message    = $('textarea[name=message]').val();
        
        // change simplement la couleur de border en rouge si un champ vide est utilisé. En utilisant .css()
        var proceed = true;
        if(user_name==""){ 
            $('input[name=name]').css('border-color','#ef5050'); 
            proceed = false;
        }
        if(user_email==""){ 
            $('input[name=email]').css('border-color','#ef5050'); 
            proceed = false;
        }
        if(user_phone=="") {    
            $('input[name=phone]').css('border-color','#ef5050'); 
            proceed = false;
        }
        if(user_message=="") {  
            $('textarea[name=message]').css('border-color','#ef5050'); 
            proceed = false;
        }

        // lancement du processus
        if(proceed) 
        {
            //les données qui doivent être envoyé au serveur
            post_data = {'userName':user_name, 'userEmail':user_email, 'userPhone':user_phone, 'userMessage':user_message};
            
            //Ajax post data to server
            //Ajax post data au serveur (PHP)
            $.post('contact_nous.php', post_data, function(response){  
                
                //load json data from server and output message
                //chargement données json du serveur et messages d'envoie     
                if(response.type == 'error')
                {
                    output = '<div class="error">'+response.text+'</div>';
                }else{
                
                    output = '<div class="success">'+response.text+'</div>';
                    
                    //reset values in all input fields
                    // réinitialisation des valeurs de chaque input
                    $('#contact_form input').val(''); 
                    $('#contact_form textarea').val(''); 
                }
                
                $("#result").hide().html(output).slideDown();
            }, 'json');
            
        }
    });
    
    //reset previously set border colors and hide all message on .keyup()
    //reset les bordures et cache les messages avec qq effets
    $("#contact_form input, #contact_form textarea").keyup(function() { 
        $("#contact_form input, #contact_form textarea").css('border-color',''); 
        $("#result").slideUp();
    });
    
});