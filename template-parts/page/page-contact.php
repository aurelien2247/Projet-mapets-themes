<?php get_header() ?>

<?php
if(isset($_POST['mailform']))
{
    if(!empty($_POST['nom']) && !empty($_POST['object']) && !empty($_POST['mail']) && !empty($_POST['message']))
    {
        $nom          = $_POST['nom'];
        $object       = $_POST['object'];
        $mail         = $_POST['mail'];
        $message_send = $_POST['message'];
        

        // mail à envoyer à l'admin
        $to = get_bloginfo('admin_email');
        $subject = $object;
        $message = 'Bonjour, <br>vous venez de recevoir un mail de'. $nom .', on vous demande:  <br>'. $message_send .'.';
        $headers = array('Content-Type: text/html; charset=UTF-8');
        wp_mail( $to, $subject, $message, $headers);

        echo '<div id="valid-mail-box">';
        _e( '<h2 class="valid-mail">Nous vous remercions pour votre E-mail ! </h2><br>
             <h2 class="connexion-after-inscription"> Nous vous réponderons au plus vites.'); 
        echo '</div>';

    }
    else
    {
        _e('<div id="error-mail-box">
            <h2> 
               <h1 class="title_error">Ereur:</h1>
               Tous les champs doivent être complétés !
            </h2>
            </div>');
    }
}
?>
<form  action="" id="EmailForm" method="POST" enctype="multipart/form-data">
        
    <div id="contact-box">
        <h1>Envoyer un mail</h1>

        <input type="hidden" name="action" value="submit">
        <input type="text" name="nom" class="name" type="text" placeholder="Nom"value="<?php if(isset($_POST['nom'])) { echo $_POST['nom']; } ?>"/><br>
        <input type="text" name="object" class="object" type="text" placeholder="Objet du mail"value="<?php if(isset($_POST['object'])) { echo $_POST['object']; } ?>"/><br>
        <input type="email" name="mail" class="email" type="text" class="input" placeholder="Email"value="<?php if(isset($_POST['mail'])) { echo $_POST['mail']; } ?>" /><br>
        <textarea name="message" class="message" placeholder="Votre message"><?php if(isset($_POST['message'])) { echo $_POST['message']; } ?></textarea><br>
        <input name="mailform" class="btn" type="submit" value="Envoyer !" id="envoyer"/><br><br>

    </div>

</form>

<?php get_footer() ?>
