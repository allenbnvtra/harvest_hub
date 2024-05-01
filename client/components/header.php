<header>
    <div class="header-container">
        <div class="upper">
            <div>
                <ul class="upper-part-nav">
                    <li><a href="#"><span class="material-symbols-outlined">storefront</span>Be
                            a seller</a></li>
                    <li><a href="#"><span class="material-symbols-outlined">local_shipping</span>Track my
                            order</a>
                    </li>
                    <li><a href="#"><span class="material-symbols-outlined">
                                help
                            </span>About us</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="middle">
            <a href="/project/client/" class="logo">
                <!-- <img src="../assets/plant.webp" alt="l"> -->
                <h1>Harverst</h1>
                <span>hub</span>
            </a>
            <div class="search">
                <input placeholder="Search..." type="search" name="" id="">
                <button><span class="material-symbols-outlined">
                        search
                    </span></button>
            </div>

            <div class="login-status">
                <a class="signup-button" href="/project/client/pages/signup.php">Sign Up</a>
                <a class="login-button" href="/project/client/pages/login.php">Login</a>
            </div>
        </div>

        <div class="lower">
            <h5>Categories: </h5>
            <div class="category">
                <h5 class="active-category">All</h5>
                <h5>Fruits</h5>
                <h5>Vegetables</h5>
                <h5>Seedlings</h5>
                <h5>Meats</h5>
                <h5>Poultry</h5>
                <h5>Fish</h5>
            </div>
        </div>
    </div>
</header>

<script>
document.querySelectorAll(".category h5").forEach((item) => {
    item.addEventListener("click", (event) => {
        document.querySelectorAll(".category h5").forEach((item) => {
            item.classList.remove("active-category");
        });
        event.target.classList.add("active-category");
    });
});
</script>