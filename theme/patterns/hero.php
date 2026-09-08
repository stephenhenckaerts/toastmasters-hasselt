<?php
/**
 * Title: Hero — leer spreken voor publiek
 * Slug: tmhasselt/hero
 * Categories: tmhasselt
 * Inserter: yes
 *
 * @package tmhasselt
 */

$tmh_img = esc_url( get_template_directory_uri() . '/assets/img/zaal.jpg' );
?>
<!-- wp:group {"className":"tmh-hero","backgroundColor":"blue","layout":{"type":"default"}} -->
<div class="wp-block-group tmh-hero has-blue-background-color has-background" id="top">

<!-- wp:group {"className":"tmh-hero__top tmh-reveal","layout":{"type":"default"}} -->
<div class="wp-block-group tmh-hero__top tmh-reveal">

<!-- wp:group {"className":"tmh-hero__copy","layout":{"type":"default"}} -->
<div class="wp-block-group tmh-hero__copy">
<!-- wp:heading {"level":1,"fontSize":"huge"} -->
<h1 class="wp-block-heading has-huge-font-size">Leer spreken voor publiek. In het Nederlands, in Hasselt.</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"tmh-lede","fontSize":"large","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}}} -->
<p class="tmh-lede has-large-font-size" style="margin-top:var(--wp--preset--spacing--20)">Twee keer per maand oefenen we samen presenteren. Geen opleiding met slides en een lesgever — gewoon spreken, en eerlijke feedback van mensen die het zelf ook leren.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"tmh-only","style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}}}} -->
<p class="tmh-only" style="margin-top:var(--wp--preset--spacing--30)"><strong>De enige volledig Nederlandstalige Toastmasters-club in Vlaanderen.</strong> Antwerpen, Gent en Leuven werken tweetalig. Bij ons is alles Nederlands.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--30)">
<!-- wp:button {"className":"tmh-btn-guest is-style-fill"} -->
<div class="wp-block-button tmh-btn-guest is-style-fill"><a class="wp-block-button__link wp-element-button" href="#kom-langs">Kom langs als gast</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"tmh-btn-out"} -->
<div class="wp-block-button tmh-btn-out"><a class="wp-block-button__link wp-element-button" href="#verwachten">Wat gebeurt er op zo'n avond?</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- wp:image {"className":"tmh-hero__media"} -->
<figure class="wp-block-image tmh-hero__media"><img src="<?php echo $tmh_img; ?>" alt="Een volle zaal met tientallen lachende deelnemers van Toastmasters Hasselt, velen met de duim omhoog." width="1280" height="720"/></figure>
<!-- /wp:image -->

</div>
<!-- /wp:group -->

<!-- wp:group {"className":"tmh-hero__rest","layout":{"type":"constrained"}} -->
<div class="wp-block-group tmh-hero__rest">

<!-- wp:group {"className":"tmh-next","layout":{"type":"default"}} -->
<div class="wp-block-group tmh-next">
<!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group">
<!-- wp:paragraph {"className":"tmh-next__lab"} -->
<p class="tmh-next__lab">Volgende meeting</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"tmh-next__val","metadata":{"bindings":{"content":{"source":"tmhasselt/meeting","args":{"key":"next_date"}}}}} -->
<p class="tmh-next__val">datum volgt</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"tmh-next__sub","metadata":{"bindings":{"content":{"source":"tmhasselt/meeting","args":{"key":"next_sub"}}}}} -->
<p class="tmh-next__sub">om 20:00</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group">
<!-- wp:paragraph {"className":"tmh-next__lab"} -->
<p class="tmh-next__lab">Waar</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"tmh-next__val"} -->
<p class="tmh-next__val">Sportcentrum Olympia</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"tmh-next__sub"} -->
<p class="tmh-next__sub">Kuringersteenweg 242, Hasselt</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group">
<!-- wp:paragraph {"className":"tmh-next__lab"} -->
<p class="tmh-next__lab">Wat kost een bezoek</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"tmh-next__val"} -->
<p class="tmh-next__val">Niets</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"tmh-next__sub"} -->
<p class="tmh-next__sub">Kom vrijblijvend kijken, zo vaak je wil</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group">
<!-- wp:paragraph {"className":"tmh-next__lab"} -->
<p class="tmh-next__lab">Moet je spreken?</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"tmh-next__val"} -->
<p class="tmh-next__val">Nee</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"tmh-next__sub"} -->
<p class="tmh-next__sub">Je mag gewoon achteraan zitten en kijken</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"tmh-cadence","metadata":{"bindings":{"content":{"source":"tmhasselt/meeting","args":{"key":"cadence"}}}},"style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}}} -->
<p class="tmh-cadence" style="margin-top:var(--wp--preset--spacing--20)">We komen samen op de eerste en derde dinsdag van elke maand, om 20:00.</p>
<!-- /wp:paragraph -->

</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->
