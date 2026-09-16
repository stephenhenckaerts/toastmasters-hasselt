<?php
/**
 * Title: Voettekst
 * Slug: tmhasselt/footer
 * Categories: tmhasselt
 * Block Types: core/template-part/footer
 * Inserter: no
 *
 * @package tmhasselt
 */

$tmh_img = esc_url( get_template_directory_uri() . '/assets/img/ti-logo-band.jpg' );
?>
<!-- wp:group {"className":"tmh-footer","backgroundColor":"blue-deep","layout":{"type":"default"}} -->
<div class="wp-block-group tmh-footer has-blue-deep-background-color has-background">

<!-- wp:group {"className":"tmh-logoband","layout":{"type":"default"}} -->
<div class="wp-block-group tmh-logoband">
<!-- wp:image {"scale":"cover"} -->
<figure class="wp-block-image"><img src="<?php echo $tmh_img; ?>" alt="Toastmasters International" width="1500" height="484" loading="lazy" decoding="async"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40)">

<!-- wp:columns -->
<div class="wp-block-columns">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:heading {"level":2,"fontSize":"large"} -->
<h2 class="wp-block-heading has-large-font-size">Toastmasters Hasselt</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Sportcentrum Olympia<br>Kuringersteenweg 242, 3500 Hasselt<br><a href="mailto:hasselt.toastmasters@gmail.com">hasselt.toastmasters@gmail.com</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:heading {"level":2,"fontSize":"medium"} -->
<h2 class="wp-block-heading has-medium-font-size">Op deze site</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p><a href="/#verwachten">Wat mag je verwachten</a><br><a href="/#spreekangst">Spreekangst overwinnen</a><br><a href="/#praktisch">Praktisch en lidgeld</a><br><a href="/#vragen">Veelgestelde vragen</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:heading {"level":2,"fontSize":"medium"} -->
<h2 class="wp-block-heading has-medium-font-size">Club</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Club 1049050 &middot; District 59, Division B<br><a href="https://www.toastmasters.org/Find-a-Club/01049050-toastmastershasselt">Onze clubpagina bij Toastmasters International</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->

<!-- wp:group {"className":"tmh-legal","style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group tmh-legal" style="margin-top:var(--wp--preset--spacing--30)">
<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size">The information on this website is for the sole use of Toastmasters' members, for Toastmasters business only. It is not to be used for solicitation and distribution of non-Toastmasters material or information.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Toastmasters International. All rights reserved. Toastmasters International, the Toastmasters International logo, and all other Toastmasters International trademarks and copyrights are the sole property of Toastmasters International and may be used only with permission.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->
