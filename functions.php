<?php
/***************************************************************/
/*************************Hook**********************************/
/***************************************************************/
// Hook pour rediriger a la deconexion
add_action( 'wp_logout', 'logout_redirect' );
// Hook a la connexion
add_action( 'wp_login', 'connection_redirect' );
//hook admin submenu
add_action('admin_menu', 'membership_directory_admin');

/***************************************************************/
/*************************Fonction******************************/
/***************************************************************/


function connexion_utilisateur() {
	if ( is_user_logged_in() ) {
		// Afficher le menu pour les utilisateurs connectés
		wp_nav_menu( 		
			array(
				'menu' => 'menu-connecter',
				'cotainer' => '',
				'theme_location' => 'menu-connecter',
				'items_wrap' => '<ul id="" class="nav-links">%3$s<li></li></ul>'
			) 
		);
	} else {
		// Afficher le menu pour les utilisateurs non connectés
		wp_nav_menu(
			array(
				'menu' => 'menu-deconnecter',
				'cotainer' => '',
				'theme_location' => 'menu-deconnecter',
				'items_wrap' => '<ul id="" class="nav-links">%3$s<li></li></ul>'
			)
		);
	}
}

function logout_redirect() {	
    	
	wp_redirect( home_url() );
    exit();    
}
function connection_redirect() {

	if(!is_user_admin()){	
    	wp_redirect( home_url() );
    	exit();    
	}
}


function registration_form( $username, $email, $email_check, $password, $password_check ) {
    echo '
	<form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
		<div id="login-box">
			<div class="left">
				<h1>S\'inscrire</h1>

				
				<input type="text" class="text" name="username" placeholder="Pseudo*" />
				<input type="text" class="text" name="email" placeholder="E-mail*" />
				<input type="text" class="text" name="email_check" placeholder="E-mail vérification*" />
				<input type="password" name="password" placeholder="Mot De Passe*" />
				<input type="password" name="password_check" placeholder="Verification Du Mot De Passe*" />
				<p class="star"/>Veuillez Remplire tous les champs contenant une *.</p>
                <h2 class="have-acount"> Vous avez deja un compte, cliquer <a href="https://www.projet.local/wp-login.php?action=login" class="click-here">Ici</a> pour vous connectez.
				
				<input type="submit" class="submit" name="submit" value="Valider" />
			</div>
		</div>
	</form>';
    
}

 /*Fonction pour check les erreurs et faire un retour à l'utilisateur */
 function registration_validation(  $username, $email, $email_check, $password, $password_check )  {
    global $reg_errors;
    $reg_errors = new WP_Error;
	/*var_dump($username);
	var_dump($email);
	var_dump( $email_check);
	var_dump( $password);
	var_dump($password_check);
	die;*/
   if (  empty( $username ) || empty( $email ) || empty( $email_check ) || empty( $password ) || empty( $password_check ) ) {
    $reg_errors->add('field', 'Veuillez remplir tous les champs avec *');
   }
   if ( 5 > strlen( $password ) ) {
    $reg_errors->add( 'password', 'Le mot de passe doit avoir au moins 5 caractères' );
   }
   if ( !is_email( $email ) ) {
    $reg_errors->add( 'email_invalid', 'Email invalide' );
   }
   if ( email_exists( $email ) ) {
    $reg_errors->add( 'email', 'Email deja utilisé' );
   }
   if ($email != $email_check){
    $reg_errors->add( 'email_different', 'Veuillez saisir deux adresses identique.' );
   }
   if ($password != $password_check) {
    $reg_errors->add( 'password_different', 'Veuillez saisir deux mot de passe identique.' );
   }
 
	if ( is_wp_error( $reg_errors ) ) {
        echo '<div id="error-box">
              <h1 class="title_error">Ereur:</h1>';
		foreach ( $reg_errors->get_error_messages() as $error ) {
            echo '
                <h2 class="error">                
                 '. $error .'<br><br>
                </h2> 
                ';
			/*echo '<div>';
			echo '<strong>ERREUR</strong>:';
			echo $error . '<br/>';
			echo '</div>';*/
			
		}
        echo '</div>';
 
    }  
	
}
 /*Fonction d'enregistrement de l'utilisateur */
 function complete_registration() {
    global $reg_errors, $username, $email, $email_check, $password, $password_check;

    if ( 1 > count( $reg_errors->get_error_messages() ) ) {

       $userdata = array(
        'user_login'        =>   $username,
        'user_email'        =>   $email,
        'user_pass'         =>   $password
        );

        $user = wp_insert_user( $userdata );

         // mail à envoyer au client
         $to = $email;
         $subject = 'Validation de votre compte';
         $message = 'Bonjour, Votre compte a été accepté vous pouvez desormais vous connecter et ajoute votre colier ! <a href="'. get_admin_url('https://www.projet.local/') .'">Cliquez ici</a> pour vous rendres sur le site.';
         $headers = array('Content-Type: text/html; charset=UTF-8');
         wp_mail( $to, $subject, $message, $headers);
         echo '<div id="valid-box">';
          _e( '<h2 class="valid">Nous vous remercions pour votre inscription ! </h2><br>
               <h2 class="connexion-after-inscription"> Cliquer <a href="https://www.projet.local/wp-login.php?action=login" class="click-here">Ici</a> pour vous connectez.'); 
          echo '</div>';

    }       
 }
 
 function custom_registration_function() {
    if ( isset($_POST['submit'] ) ) {
        registration_validation(
        $_POST['username'],
        $_POST['email'],
        $_POST['email_check'],
        $_POST['password'],
        $_POST['password_check'],
        );
         
        // sanitize user form input
        global $organization,  $username, $email, $email_check, $password, $password_check;
        $username              =   sanitize_text_field( $_POST['username'] );
        $email                 =   sanitize_email( $_POST['email'] );
        $email_check           =   sanitize_email( $_POST['email_check'] );
        $password              =   esc_attr( $_POST['password'] );
        $password_check        =   esc_attr( $_POST['password_check'] );
        
        // Appel la fonction complete_registration pour créer l'utilisateur
        // Seulement si il n'y a pas d'erreure dans le formulaire
        complete_registration(
        $username,
        $email,
        $email_check,
        $password,
        $password_check,
        );
        
	}

    registration_form(
        $username,
        $email,
        $email_check,
        $password,
        $password_check,
        );
}



?>