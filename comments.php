<div id="comments">
  <?php if ( have_comments() ) { 
    echo '<h3>Espace Commentaires:</h3>
    <p>Une question ? Pose la en commentaire afin que l\'on te repponde.</p>
    <ul class="comments-list">';

    wp_list_comments( array(
        'style'       => 'ul',
        'short_ping'  => true,
        'avatar_size' => 50,
    ) );

    echo'</ul>';
    }?>
</div>
 



  <?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) {
    echo '<p>Les commentaires sont fermés.</p>';
  }?>

  <?php
    $comments_args = array(
      'title_reply'          => 'Laisser un commentaire',
      'logged_in_as'         => '<p class="logged-in-as">Connecté·e en tant que '. $user_identity . '</p>',
      'label_submit'         => 'Publier un commentaire',
    );
    comment_form( $comments_args );
  ?>
</div>
