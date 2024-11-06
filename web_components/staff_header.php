<div class="horizontal-container">
            <!-- Logo + Sign Up title -->
            <div class="logo">
                <a href="index.php">
                    <img src="images/logo_light.png"/> <!-- add this to img for testing -> style="border: 1px solid blue" -->
                </a>
            </div>
            <!-- Navigation links -->
            <nav class="navbar">
                <button id="navbtn">Scan Items</button>
                <a href="index.php">Overview</a>
                <a href="managestocks.php">Manage Stocks</a>
                <a href="ordersandvendors.php">Orders & Vendors</a>
            </nav>

            <!-- Settings button -->
            <i id="settingsBtn" class="fa fa-gear" style="font-size: 60px; margin-top: 1.4%; position: relative; left: 5.7%;" onclick="handleSettingsClick()"></i>

            <div id="settingsDropdown" class="settings-dropdown">
                <li class="">
                    <ul style="border-bottom: 1px solid grey;">Account Details</ul>
                    <a href="db/logout_db.php">
                        <ul style="color: red;">Log Out</ul>
                    </a>
                </li>
            </div>
        </div>

        <!-- Divider line -->
        <hr id="header-ln">


        <script>
            const settingsBtn = document.getElementById('settingsBtn');
            const settingsDropdown = document.getElementById('settingsDropdown');

            // reveal panel when settings button is clicked
            function handleSettingsClick() {
                if (settingsDropdown.style.visibility == 'hidden') {
                    settingsDropdown.style.visibility = 'visible';
                } else {
                    settingsDropdown.style.visibility = 'hidden';
                }
            }

            // close panel when clicking anywhere outside the panel
            document.addEventListener('click', (event) => {
                // note: .target is a property of the event object. 'event.target' refers to anything that is clicked within the DOM
                if (!settingsDropdown.contains(event.target) && event.target !== settingsBtn) {
                    settingsDropdown.style.visibility = 'hidden';
                }
            });
        </script>