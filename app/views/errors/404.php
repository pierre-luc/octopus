<?php
namespace octopus\app\views\errors;
use octopus\app\Debug;
?>
<p class="lead">Oups! Une erreur est survenue</p>
<blockquote>Le serveur a retourné une erreur "<?php echo $message; ?>".</blockquote>
<blockquote>
    <?php
        Debug::debug( array(
            'Le controller ' . $request->getControllerName()
            . ' n\'existe pas', $request, true
        ));
    ?>
</blockquote>