<?php
/**
 * Template Name: Home TasteTrip
 */
get_header();
?>

<div class="homepage" style="text-align:center; padding:50px;">
    <h1>Benvenuta su TasteTrip 🌍</h1>
    <p>Scopri ricette da tutto il mondo e divertiti con il nostro generatore!</p>

    <!-- Link diretto alla pagina con template TasteTrip -->
    <a href="<?php echo get_permalink( get_page_by_path('tastetrip') ); ?>"
       class="btn"
       style="display:inline-block; margin-top:20px; padding:15px 30px; background:#ff7043; color:#fff; border-radius:10px; text-decoration:none;">
        Vai al Generatore di Ricette
    </a>
</div>