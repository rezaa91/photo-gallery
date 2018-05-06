<!--side bar navigation-->


<nav id="sidebar">
    
    <div class="nav-title"><a href="index.php">AX PHOTOGRAPHY</a></div>
    <ul id="sidebar-nav">
        
        <li>
            <a href="index.php">HOME</a>
        </li>
        
        <li>
            <a href="about.php">ABOUT</a>
        </li>
        
        <li>
            <a href="gallery.php">GALLERY</a>
        </li>
        
        <li>
            <a href="contact.php">CONTACT</a>
        </li>
        
    </ul>
    <ul>
        <!--if a user is in session, display account name, otherwise show 'login'-->
        <li id="user-link">
        <?php if(isset($user)){echo '<a href="account.php">' . $user->username . '</a>';}else{echo '<a href="login.php">Login/Register</a>';} ?>
        </li>
    </ul>
    
    
</nav>