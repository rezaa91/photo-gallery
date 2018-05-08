<!--side bar navigation-->


<nav id="sidebar">
    
    <div class="sidebar-left">
        <a href="#" class="sidebar-left-icon"><i class="fas fa-bars"></i></a>
    </div>
    
    
    <div class="sidebar-right">
        <div class="nav-title"><a href="index.php" class="brand-font">AX PHOTOGRAPHY</a></div>
        <ul id="sidebar-nav">

            <li>
                <a href="index.php" class="sidebar-link"><i class="fas fa-home"></i> Home</a>
            </li>

            <li>
                <a href="about.php" class="sidebar-link"><i class="fas fa-book"></i> About</a>
            </li>

            <li>
                <a href="gallery.php" class="sidebar-link"><i class="fas fa-images"></i> Gallery</a>
            </li>

            <li>
                <a class="sidebar-link bottom" href="contact.php"><i class="fas fa-phone"></i> Contact</a>
            </li>

        </ul>
        <ul>
            <!--if a user is in session, display account name, otherwise show 'login'-->
            <li id="user-link">
            <?php if(isset($user)){echo '<a href="account.php" class="sidebar-link"><i class="fas fa-user-alt"></i> ' . $user->username . '</a>';}else{echo '<a href="login.php" class="sidebar-link"><i class="fas fa-clipboard-list"></i> Login/Register</a>';} ?>
            </li>
        </ul>
    </div>
    
    
</nav>