<?php
/**
 * Template Name: TasteTrip
 * Description: Simple TasteTrip page template (no CSS). Displays a random recipe by country.
 */
get_header();
?>

<div id="tasteTripApp">
    <h1>TasteTrip 🌍</h1>

    <label for="country">Choose a Country:</label>
    <select id="country">
        <option value="">-- Select --</option>
        <option value="italy">Italy</option>
        <option value="china">China</option>
        <option value="mexico">Mexico</option>
        <option value="japan">Japan</option>
    </select>

    <button id="generate">Generate Recipe</button>

    <div id="recipe" style="display:none; margin-top:20px;">
        <h2 id="recipeName"></h2>
        <img id="recipeImg" alt="Recipe image" width="300">
        <h3>Ingredients</h3>
        <ul id="ingredients"></ul>
        <h3>Instructions</h3>
        <p id="instructions"></p>
    </div>
</div>

<script>
    const templateDir = "<?php echo get_template_directory_uri(); ?>";

    const recipes = {
        italy: [
            {
                name: "Spaghetti Carbonara",
                ingredients: ["Spaghetti", "Eggs", "Guanciale", "Pecorino Romano", "Black pepper"],
                instructions: "Cook the pasta. Fry the guanciale. Mix eggs and cheese, then combine off heat.",
                image: templateDir + "/images/carbonara.jpg"  // <-- percorso come stringa
            },
            {
                name: "Risotto alla Milanese",
                ingredients: ["Rice", "Saffron", "Butter", "Broth", "Parmesan cheese"],
                instructions: "Toast the rice, add broth and saffron, then stir with butter and cheese.",
                image: templateDir + "/images/risottomilanese.jpg"  // <-- percorso come stringa
            }
        ],
        china: [
            {
                name: "Fried Rice",
                ingredients: ["Rice", "Eggs", "Vegetables", "Soy sauce"],
                instructions: "Stir-fry all ingredients and mix with cooked rice and soy sauce.",
                image: templateDir + "/images/fried_rice.jpg"
            }
        ],
        mexico: [
            {
                name: "Tacos",
                ingredients: ["Tortillas", "Meat", "Tomatoes", "Onion", "Cilantro"],
                instructions: "Fill the tortillas with meat and your favorite toppings.",
                image: templateDir + "/images/tacos.jpg"
            }
        ],
        japan: [
            {
                name: "Sushi",
                ingredients: ["Rice", "Nori", "Fish", "Soy sauce"],
                instructions: "Roll sushi with rice and nori, fill with fish, serve with soy sauce.",
                image: templateDir + "/images/sushi.jpg"
            }
        ]
    };
    document.getElementById("generate").addEventListener("click", () => {
        const country = document.getElementById("country").value;
        const recipeDiv = document.getElementById("recipe");

        if (!country || !recipes[country]) {
            alert("Please select a valid country!");
            return;
        }

        const recipe = recipes[country][Math.floor(Math.random() * recipes[country].length)];

        document.getElementById("recipeName").textContent = recipe.name;
        document.getElementById("recipeImg").src = recipe.image;
        document.getElementById("ingredients").innerHTML =
            recipe.ingredients.map(i => `<li>${i}</li>`).join("");
        document.getElementById("instructions").textContent = recipe.instructions;

        recipeDiv.style.display = "block";
    });
</script>
<?php if(is_user_logged_in()): ?>
    <h2>Share your recipe</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="recipe_name" placeholder="Nome ricetta" required><br>
        <textarea name="story" placeholder="Racconto o aneddoti" required></textarea><br>
        <input type="file" name="recipe_image" accept="image/*"><br>
        <textarea name="ingredients" placeholder="Ingredienti separati da virgola" required></textarea><br>
        <textarea name="instructions" placeholder="Istruzioni" required></textarea><br>
        <button type="submit">Invia ricetta</button>
    </form>
<?php else: ?>
    <p>You have to log in to share your recipe.</p>
<?php endif; ?>

<h3>Created by: <?php the_author(); ?></h3>
<p><?php echo get_post_meta(get_the_ID(), 'story', true); ?></p>
<img src="<?php echo wp_get_attachment_url(get_post_meta(get_the_ID(), 'recipe_image', true)); ?>" width="300">

<button class="like-btn" data-id="<?php the_ID(); ?>">👍 Like</button>
<span class="like-count"><?php echo get_post_meta(get_the_ID(), 'likes', true) ?: 0; ?></span>

<script>
    document.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const postId = btn.dataset.id;
            fetch('<?php echo admin_url("admin-ajax.php"); ?>?action=like_recipe&post_id=' + postId)
                .then(response => response.json())
                .then(data => {
                    btn.nextElementSibling.textContent = data.likes;
                });
        });
    });
</script>



<?php get_footer(); ?>

