<!--side bar navigation-->


<nav id="sidebar">
    
    <div id="sidebar_left" class="sidebar-left">
        <a class="sidebar-left-icon" id="hide_menu"><i class="fas fa-bars"></i></a>
    </div>
    
    
    <div id="sidebar_right" class="sidebar-right">
        <div class="nav-title"><a href="index.php" class="header-font">AX PHOTOGRAPHY</a></div>
        <ul id="sidebar-nav">

            <li>
                <a href="index.php" class="sidebar-link"><i class="fas fa-home"></i> Home</a>
            </li>
            
            <li>
                <a href="gallery.php" class="sidebar-link"><i class="fas fa-images"></i> Gallery</a>
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
            <?php if(isset($user)){echo '<a href="account.php" class="sidebar-link" title="profile"><i class="fas fa-user"></i> ' . $user->getUsername() . '</a>';}else{echo '<a href="login.php" class="sidebar-link" title="login/register"><i class="fas fa-clipboard-list"></i> Login/Register</a>';} ?>
            </li>
            
        </ul>
    </div>
    
    
</nav>