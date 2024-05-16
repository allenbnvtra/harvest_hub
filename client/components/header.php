<header>
    <div class="header-container">
        <div class="upper">
            <div>
                <ul class="upper-part-nav">
                    <li><a href="/project/client/pages/seller-login.php"><span
                                class="material-symbols-outlined">storefront</span>Seller Center</a></li>
                    <li><a href="#"><span class="material-symbols-outlined">
                                help
                            </span>About us</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="middle">
            <a href="/project/client/" class="logo">
                <h1>Harverst</h1>
                <span>hub</span>
            </a>

            <form action="/project/client/" method="POST" class="search">
                <input placeholder="Search..." type="search" name="search" id="search">
                <button type="submit"><span class="material-symbols-outlined">search</span></button>
            </form>

            <?php
            if(isset($_SESSION['customerUsername'])){
            ?>
            <div class="logged-in">
                <a href="/project/client/pages/cart.php">
                    <span style="font-size: 35px; font-weight: 500; cursor: pointer;" class="material-symbols-outlined">
                        shopping_cart
                    </span>
                </a>
                <div class="profile-container">
                    <span style="font-size: 35px; font-weight: 500; cursor: pointer;"
                        class="material-symbols-outlined profile-icon">
                        account_circle
                    </span>
                    <div class="dropdown-menu">
                        <ul>
                            <li><a style="display: flex; gap: 5px;" href="/project/client/pages/profile.php"><span
                                        class="material-symbols-outlined">
                                        person
                                    </span>Profile</a></li>
                            <li><a style="display: flex; gap: 5px;" href="/project/client/pages/orders.php"><span
                                        class="material-symbols-outlined">
                                        shopping_bag
                                    </span>Orders</a></li>
                            <li><a style="display: flex; gap: 5px; color: red; font-weight: 600;"
                                    href="/project/logout.php"><span class="material-symbols-outlined">
                                        logout
                                    </span>Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
                }else{
                ?>
            <div class="login-status">
                <a class="signup-button" href="/project/client/pages/signup.php">Sign Up</a>
                <a class="login-button" href="/project/client/pages/login.php">Login</a>
            </div>
            <?php } ?>
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

document.addEventListener("DOMContentLoaded", function() {
    var profileIcon = document.querySelector(".profile-icon");
    var dropdownMenu = document.querySelector(".dropdown-menu");

    profileIcon.addEventListener("click", function() {
        dropdownMenu.classList.toggle("show");
    });

    // Close dropdown when clicking outside
    document.addEventListener("click", function(event) {
        if (!dropdownMenu.contains(event.target) && !profileIcon.contains(event.target)) {
            dropdownMenu.classList.remove("show");
        }
    });
});
</script>