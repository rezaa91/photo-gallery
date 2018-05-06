<!--side bar navigation-->


<nav id="sidebar">
    
    <div id="sidebar-left">
        <a href="#"><i class="fas fa-bars"></i></a>
    </div>
    
    
    <div id="sidebar-right">
        <div class="nav-title"><a href="index.php">AX PHOTOGRAPHY</a></div>
        <ul id="sidebar-nav">

            <li>
                <a href="index.php"><i class="fas fa-home"></i> Home</a>
            </li>

            <li>
                <a href="about.php"><i class="fas fa-book"></i> About</a>
            </li>

            <li>
                <a href="gallery.php"><i class="fas fa-images"></i> Gallery</a>
            </li>

            <li>
                <a class="bottom" href="contact.php"><i class="fas fa-phone"></i> Contact</a>
            </li>

        </ul>
        <ul>
            <!--if a user is in session, display account name, otherwise show 'login'-->
            <li id="user-link">
            <?php if(isset($user)){echo '<a href="account.php"><i class="fas fa-user-alt"></i> ' . $user->username . '</a>';}else{echo '<a href="login.php"><i class="fas fa-clipboard-list"></i> Login/Register</a>';} ?>
            </li>
        </ul>
    </div>
    
    
</nav>