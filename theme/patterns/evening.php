<?php
/**
 * Title: Zo verloopt een avond
 * Slug: tmhasselt/evening
 * Categories: tmhasselt
 * Inserter: yes
 *
 * @package tmhasselt
 */

$tmh_img = esc_url( get_template_directory_uri() . '/assets/img/corda.jpg' );
?>
<!-- wp:group {"className":"tmh-band tmh-band--soft","layout":{"type":"constrained"}} -->
<div class="wp-block-group tmh-band tmh-band--soft" id="verwachten">

<!-- wp:paragraph {"className":"tmh-kicker"} -->
<p class="tmh-kicker">Wat mag je verwachten</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2,"fontSize":"x-large"} -->
<h2 class="wp-block-heading has-x-large-font-size">Zo verloopt een avond</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"tmh-sec-lede","style":{"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|40"}}}} -->
<p class="tmh-sec-lede" style="margin-top:var(--wp--preset--spacing--20);margin-bottom:var(--wp--preset--spacing--40)">We starten om 20:00 en eindigen om 22:00. Kom een tiental minuten vroeger, dan verwelkomen we je even en leggen we uit hoe de avond in elkaar zit. En ja — we gebruiken echt groene, oranje en rode lichten voor de spreektijd.</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|40"}}}} -->
<div class="wp-block-columns">
<!-- wp:column {"width":"58%"} -->
<div class="wp-block-column" style="flex-basis:58%">
<!-- wp:html -->
<div class="tmh-runsheet">
	<div class="tmh-step">
		<div class="tmh-step__lampcol"><span class="tmh-lamp tmh-lamp--g"></span><span class="tmh-step__rail"></span></div>
		<div class="tmh-step__body">
			<h3>Voorbereide speeches</h3>
			<p class="tmh-step__when">3 à 4 speeches van 5 tot 7 minuten</p>
			<p>Leden brengen een speech die ze thuis voorbereid hebben. Het onderwerp kies je helemaal zelf — je job, een maatschappelijke kwestie, of het recept voor konijn met pruimen van je grootmoeder.</p>
		</div>
	</div>
	<div class="tmh-step">
		<div class="tmh-step__lampcol"><span class="tmh-lamp tmh-lamp--a"></span><span class="tmh-step__rail"></span></div>
		<div class="tmh-step__body">
			<h3>Evaluaties</h3>
			<p>Iemand vertelt je wat sterk was en wat beter kan. Anderen letten op je timing, je stopwoorden en je taalgebruik. Niet om je af te breken — om je scherper te maken.</p>
		</div>
	</div>
	<div class="tmh-step">
		<div class="tmh-step__lampcol"><span class="tmh-lamp tmh-lamp--n"></span><span class="tmh-step__rail"></span></div>
		<div class="tmh-step__body">
			<h3>Pauze en intermezzo</h3>
			<p>Een mop en een serieuze gedachte. Even ademhalen.</p>
		</div>
	</div>
	<div class="tmh-step">
		<div class="tmh-step__lampcol"><span class="tmh-lamp tmh-lamp--r"></span><span class="tmh-step__rail"></span></div>
		<div class="tmh-step__body">
			<h3>Table Topics</h3>
			<p class="tmh-step__when">1 à 2 minuten, onvoorbereid</p>
			<p>De improvisatieronde. Je krijgt een onderwerp en praat erover. Meestal iets ludieks — ooit moesten we uitleggen welk voorwerp in huis we waren. Een zetel, een wc-bril, een wasknijper. Gasten mogen, maar hoeven niet.</p>
		</div>
	</div>
	<div class="tmh-step">
		<div class="tmh-step__lampcol"><span class="tmh-lamp tmh-lamp--n"></span><span class="tmh-step__rail"></span></div>
		<div class="tmh-step__body">
			<h3>Napraten in de bar</h3>
			<p class="tmh-step__when">Vanaf 22:00, voor wie wil</p>
			<p>Pintjes en warme choco's. Voor veel leden is dit eerlijk gezegd het belangrijkste deel van de avond.</p>
		</div>
	</div>
</div>
<!-- /wp:html -->
</div>
<!-- /wp:column -->

<!-- wp:column {"width":"42%"} -->
<div class="wp-block-column" style="flex-basis:42%">
<!-- wp:image {"className":"tmh-photo tmh-photo--sticky"} -->
<figure class="wp-block-image tmh-photo tmh-photo--sticky"><img src="<?php echo $tmh_img; ?>" alt="Een spreker oefent buiten op de Corda Campus terwijl een kleine groep leden op de trappen toekijkt." width="1000" height="1333"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->
