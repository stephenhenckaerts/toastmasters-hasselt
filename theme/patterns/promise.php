<?php
/**
 * Title: Belofte: je hoeft niets te zeggen
 * Slug: tmhasselt/promise
 * Categories: tmhasselt
 * Inserter: yes
 *
 * @package tmhasselt
 */

$tmh_img = esc_url( get_template_directory_uri() . '/assets/img/nicole-spreekt.jpg' );
?>
<!-- wp:group {"className":"tmh-band tmh-band--soft","layout":{"type":"constrained"}} -->
<div class="wp-block-group tmh-band tmh-band--soft" id="belofte">

<!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|40"}}}} -->
<div class="wp-block-columns">
<!-- wp:column {"width":"45%"} -->
<div class="wp-block-column" style="flex-basis:45%">
<!-- wp:image {"className":"tmh-photo"} -->
<figure class="wp-block-image tmh-photo"><img src="<?php echo $tmh_img; ?>" alt="Een spreker op het podium bij Toastmasters Hasselt houdt een hand achter haar oor terwijl het publiek toekijkt." width="1200" height="800" loading="lazy" decoding="async"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->

<!-- wp:column {"width":"55%"} -->
<div class="wp-block-column" style="flex-basis:55%">
<!-- wp:paragraph {"className":"tmh-kicker"} -->
<p class="tmh-kicker">Voor je iets durft te vragen</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"tmh-promise-big","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|30"}}}} -->
<p class="tmh-promise-big" style="margin-bottom:var(--wp--preset--spacing--30)">Je hoeft niets te zeggen. Kijken mag.</p>
<!-- /wp:paragraph -->
<!-- wp:list {"className":"tmh-checklist"} -->
<ul class="wp-block-list tmh-checklist">
<!-- wp:list-item -->
<li>Gasten worden aangemoedigd om mee te doen, maar <strong>nooit verplicht</strong>. Je mag gewoon achteraan zitten en toekijken.</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Kom zo vaak langs als je wil. Pas na drie keer sfeer proeven vragen we of je lid wil worden.</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Eén ding gebeurt wel: aan het begin vragen we kort hoe je ons gevonden hebt. Dertig seconden, meer niet.</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Je hoeft niets mee te brengen en er is geen dresscode. Kom zoals je bent.</li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->
