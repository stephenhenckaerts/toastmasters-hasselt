<?php
/**
 * Title: Wie je er tegenkomt
 * Slug: tmhasselt/belonging
 * Categories: tmhasselt
 * Inserter: yes
 *
 * @package tmhasselt
 */

$tmh_img = esc_url( get_template_directory_uri() . '/assets/img/bar.jpg' );
?>
<!-- wp:group {"className":"tmh-band tmh-band--blue tmh-grain","backgroundColor":"blue","layout":{"type":"constrained"}} -->
<div class="wp-block-group tmh-band tmh-band--blue tmh-grain has-blue-background-color has-background">

<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|40"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center">
<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
<!-- wp:paragraph {"className":"tmh-kicker"} -->
<p class="tmh-kicker">Wie je er zal tegenkomen</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2,"fontSize":"x-large"} -->
<h2 class="wp-block-heading has-x-large-font-size">Gewone mensen die graag beter willen leren spreken</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"tmh-sec-lede","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}}} -->
<p class="tmh-sec-lede" style="margin-top:var(--wp--preset--spacing--20)">Van mensen die nog nooit voor een groep stonden tot leden die al jaren meedraaien. Niemand is hier omdat hij het al kan.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
<!-- wp:image {"className":"tmh-photo"} -->
<figure class="wp-block-image tmh-photo"><img src="<?php echo $tmh_img; ?>" alt="Leden van Toastmasters Hasselt heffen samen het glas in de bar na een clubavond." width="1200" height="900" loading="lazy" decoding="async"/><figcaption class="wp-element-caption">Na de meeting, in de bar naast de bowling.</figcaption></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->
