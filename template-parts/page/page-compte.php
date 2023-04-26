<?php /*get_header() ?>

<h1>test</h1>

<?php get_footer() */?>
<?php
if (is_user_logged_in()) {
    get_header();
    echo '<h1>connecter</h1>';
    get_footer();
}else {
    get_header();
    echo '
    <div id="acount-box">
        <h1>Erreur:</h1>
        <p class="inscription"> Afin de pouvoir avoir accès à cette page merci de vous connecter en cliquant<a href="https://www.projet.local/wp-login.php?action=login"> ICI</a>.
        <br>Si vous n\'avez pas de compte vous pouvez vous inscrire en cliquant <a href="https://www.projet.local/inscription/"> ICI</a>.
        <br><br> Cette page une fois connecter vous permeteras d\'enregistrer votre collier et vous pourrez avoir accès donc à la localisation de votre animal.</p>
    </div>';
    get_footer();
}

?>