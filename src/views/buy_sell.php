<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to TU Brokers</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="main_wrapper">
        <header>
            <div class="logo">
                <a class="logo_group" href="#">
                    <picture>
                        <source srcset="images/broker_logo_dark.png" media="(prefers-color-scheme: dark)">
                        <img class="icon_box" src="images/broker_logo_light.png" alt="TU Brokers Logo">
                    </picture>
                    <h1 class="heading_primary">TU Estates</h1>
                </a>
            </div>
            <div class="desktop_search_container">
                <div class="relative_container">
                    <div class="input_icon_wrapper">
                        <img src="images/search_icon.png" alt="Search Icon">
                    </div>
                    <input class="input_field" placeholder="Address, City, Zip, or Neighborhood"
                        type="text">
                </div>
            </div>
            <div class="nav_wrapper">
                <button class="menu_toggle" id="menuToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="nav_container">
                    <nav class="nav_links">
                        <a class="nav_link" href="#">Buy/Rent</a>
                        <a class="nav_link" href="#">Sell</a>
                        <a class="nav_link" href="#">Agents</a>
                    </nav>
                    <div class="sing_in_btns">
                        <button class="btn_primary">Sign Up</button>
                        <button class="btn_secondary">Log In</button>
                    </div>
                </div>
            </div>
        </header>
    </div>
</body>
</html>