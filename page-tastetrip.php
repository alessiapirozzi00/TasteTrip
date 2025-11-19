<?php
/**
 * Template Name: TasteTrip

 */
get_header();
?>




<style>
    body {
        background-image: url('http://localhost:8000/wp-content/uploads/2025/11/sfondo-mama.png');
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center;
    }

    body::before {
        content: "";
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background-color: rgba(255, 255, 255, 0.6); /* bianco trasparente */
        z-index: -1;
    }

</style>


<style>
    #tasteTripApp {
        font-family: 'Comic Sans MS', cursive, sans-serif;
        background-color: #fff8e1;
        padding: 30px;
        border-radius: 20px;
        max-width: 700px;
        margin: 40px auto;
        box-shadow: 0 0 15px #fbc02d;
        text-align: center;
    }

    #tasteTripApp h1 {
        color: #ff7043;
        font-size: 2.5em;
        margin-bottom: 20px;
    }

    #tasteTripApp select,
    #tasteTripApp button,
    #tasteTripApp input,
    #tasteTripApp textarea {
        font-family: inherit;
        font-size: 1em;
        padding: 10px;
        margin: 10px 0;
        border-radius: 10px;
        border: 1px solid #ccc;
        width: 80%;
        max-width: 400px;
    }

    #tasteTripApp button {
        background-color: #ff7043;
        color: white;
        border: none;
        cursor: pointer;
        transition: transform 0.2s, background-color 0.3s;
    }

    #tasteTripApp button:hover {
        transform: scale(1.05);
        background-color: #ff5722;
    }

    #recipe img {
        border-radius: 10px;
        margin-top: 15px;
        animation: bounce 1.5s infinite;
    }

    @keyframes bounce {
        0% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0); }
    }

    #ingredients {
        list-style-type: none;
        padding: 0;
    }

    #ingredients li {
        background-color: #ffe0b2;
        margin: 5px auto;
        padding: 8px 12px;
        border-radius: 8px;
        max-width: 300px;
    }


</style>

<div id="tasteTripApp">

    <h1>🌍</h1>

    <label for="country" style="display: block; margin: 10px auto;">Choose a Country:</label>
    <select id="country" style="display: block; margin: 10px auto; width: 80%; max-width: 400px;">
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
<div id="tasteTripApp">
    <?php if(is_user_logged_in()): ?>
        <h2>Share your recipe</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="recipe_name" placeholder="Recipe name" required><br>
            <textarea name="story" placeholder="Story or anecdotes" required></textarea><br>
            <input type="file" name="recipe_image" accept="image/*"><br>
            <textarea name="ingredients" placeholder="Ingredients separated by commas" required></textarea><br>
            <textarea name="instructions" placeholder="Instructions" required></textarea><br>
            <button type="submit">Send recipe</button>
        </form>
    <?php else: ?>
        <p>You have to log in to share your recipe.</p>
    <?php endif; ?>

    <h3>Created by: <?php the_author(); ?></h3>
    <p><?php echo get_post_meta(get_the_ID(), 'story', true); ?></p>
    <img src="<?php echo wp_get_attachment_url(get_post_meta(get_the_ID(), 'recipe_image', true)); ?>" width="300">

    <button class="like-btn" data-id="<?php the_ID(); ?>">👍 Like</button>
    <span class="like-count"><?php echo get_post_meta(get_the_ID(), 'likes', true) ?: 0; ?></span>
</div>

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

<!-- Bottone per tornare alla home -->
<div style="text-align:center; margin-top:50px;">
    <a href="<?php echo home_url('/'); ?>"
       class="btn"
       style="display:inline-block; padding:15px 30px; background:#ffcc80; color:#4e342e; border-radius:10px; text-decoration:none; font-family:'Comic Sans MS', cursive; font-size:18px; font-weight:bold;">
        🏠 Torna alla Home
    </a>
</div>




<?php get_footer(); ?>

