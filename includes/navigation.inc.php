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
                <a class="sidebar-link" href="contact.php"><i class="fas fa-phone"></i> Contact</a>
            </li>
            
            <?php
            //display administrative links if logged in user is an administrator
            if(isset($user) && $user->isAdmin()){
                echo 
                '
                <li>
                    <a href="admin.php" class="sidebar-link"><i class="fas fa-users"></i> Admin Panel</a>
                </li>
                <li>
                    <a href="upload.php" class="sidebar-link"><i class="fas fa-camera"></i> Upload Images</a>
                </li>
                ';
            }
            ?>

        </ul>
        <ul>
            <!--if a user is in session, display account name, otherwise show 'login'-->
            <li id="user-link">
            <?php if(isset($user)){echo '<a href="account.php" class="sidebar-link"><i class="fas fa-user"></i> ' . $user->getUsername() . '</a>';}else{echo '<a href="login.php" class="sidebar-link"><i class="fas fa-clipboard-list"></i> Login/Register</a>';} ?>
            </li>
            
        </ul>
    </div>
    
    
</nav>