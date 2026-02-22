<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to TU Brokers</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>

</head>

<body>
    <div class="main_wrapper">
        <header>
            <div class="logo">
                <a class="logo_group" href="index.php?action=homepage">
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
                        <a class="nav_link" href="index.php?action=buy_rent">Buy/Rent</a>
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
        <div class="relative_container">
            <div class="background_overlay">
                <img src="images/home_hero.png" class="media_fill">
                <div class="hero_gradient_overlay"></div>
            </div>
            <div class="hero_content_container">
                <h1 class="hero_title">Find Your Dream Sanctuary</h1>
                <p class="hero_subtitle">Exceptional properties, expert service. Discover the finest real
                    estate listings in the most exclusive neighborhoods.</p>
            </div>
        </div>
        <section class="content_section">
            <div class="container_center">
                <div style="text-align:center">
                    <h2 class="section_title">Why Choose TU Estates</h2>
                    <p class="section_description">We provide a seamless real estate experience with a focus on
                        trust, expertise, and personalized service.</p>
                </div>
                <div class="properties_grid">
                    <div class="property_card">
                        <picture>
                            <source srcset="images/verified_dark.png" media="(prefers-color-scheme: dark)">
                            <img class="service_icon_container" src="images/verified.png">
                        </picture>

                        <h3>Trusted Expertise</h3>
                        <p class="card_description">Our agents are top-tier professionals with deep market knowledge
                            and a proven track record of success.</p>
                    </div>
                    <div class="property_card">
                        <picture>
                            <source srcset="images/globe_dark.png" media="(prefers-color-scheme: dark)">
                            <img class="service_icon_container" src="images/globe.png">
                        </picture>

                        <h3>Global Reach</h3>
                        <p class="card_description">We connect buyers and sellers from around the world, ensuring your property gets maximum exposure.</p>
                    </div>
                    <div class="property_card">
                        <picture>
                            <source srcset="images/sup_dark.png" media="(prefers-color-scheme: dark)">
                            <img class="service_icon_container" src="images/sup.png">
                        </picture>

                        <h3>Personalized Service</h3>
                        <p class="card_description">We connect buyers and sellers from around the world, ensuring
                            your property gets maximum exposure.</p>
                    </div>
                </div>
            </div>
        </section>
        <footer class="footer_container">
            <div class="footer_grid">
                <div class="flex_column_gap">
                    <div class="flex_center_row">
                        <picture>
                            <source srcset="images/broker_logo_dark.png" media="(prefers-color-scheme: dark)">
                            <img class="icon_box" src="images/broker_logo_light.png" alt="TU Brokers Logo">
                        </picture>
                        <h3 class="footer_primary">TU Estates</h3>
                    </div>
                    <p class="footer_bio">Providing unparalleled real estate services for the most
                        discerning clients. Your dream home awaits.</p>
                </div>

                <div>
                    <h3 class="footer_label">Контакт</h3>
                    <ul class="contact_list">
                        <li class="contact_item align_start">
                            <picture>
                                <source srcset="images/location_dark.png" media="(prefers-color-scheme: dark)">
                                <img class="footer_icon" src="images/location.png" alt="TU Brokers Logo">
                            </picture>
                            <span>ТУ Варна<br>гр. Варна, 9000</span>
                        </li>
                        <li class="contact_item align_center">
                            <picture>
                                <source srcset="images/phone_dark.png" media="(prefers-color-scheme: dark)">
                                <img class="footer_icon" src="images/phone.png" alt="TU Brokers Logo">
                            </picture>
                            <span>+359 89 *** ****</span>
                        </li>
                        <li class="contact_item align_center">
                            <picture>
                                <source srcset="images/email_dark.png" media="(prefers-color-scheme: dark)">
                                <img class="footer_icon" src="images/email.png" alt="TU Brokers Logo">
                            </picture>
                            <span>TU.Estates@gmail.com</span>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>