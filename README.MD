# PHOTOGRAPHY WEBSITE
### UPLOAD YOUR IMAGES TO THIS APPLICATION FOR ALL TO SEE

###### Current Features:
* Adminsistrators are able to upload photos, edit photos, delete photos, delete photo comments, add more administrators, along with all other Users features listed below.

* Users are able to register, login, logout, comment on photos, edit their details, delete their own photo comments.

###### How To Use:
* Download the repo to your web directory
* In the core directory, create a file called 'config.php' and copy and paste the following:

$_CONFIG = [
    'server' => [
        'host' => 'YOUR SERVER SETTINGS',
        'username' => 'YOUR SERVERS USERNAME',
        'password' => 'YOUR SERVERS PASSWORD',
        'db_name' => 'gallery'
    ]
];

* Go to phpmyadmin and create a database called 'gallery'
* Import the gallery.sql file in to the newly created gallery database
* On PHPMYADMIN, in your users table, insert an administrator in to the table:
INSERT INTO users(email, first_name, last_name, pass, member_type, reg_date)VALUES('YOUR EMAIL', 'YOUR FIRST NAME', 'YOUR LAST NAME', SHA1('PASSWORD'), 1, NOW())



###### Versions and Upcoming Features List
Current version = 1.0.0
With this upcoming version = 1.1.1




Needed Features for version 1.1.1:

allow users/administrators to delete comments ------ COMPLETED

allow administrators to delete pictures - making sure to be able to navigate through database fluidly with no gaps ----- COMPLETED

show contact information in footer ----- COMPLETED

allow administrators to edit title and description of images ---- COMPLETED.

allow users to traverse the gallery when in view.html ----- COMPLETED

add tool tips to all links ------ COMPLETED

Display pictures in gallery the same size - either crop or set fixed height and width via css ------ COMPLETED

Turn off php errors when live on server ------ COMPLETED

Only display relevant scripts on web directory ------ COMPLETED

exit from all scripts which catch an error ------ COMPLETED

test long/skinny and wide and narrow photos in mobile view and ensure they dont look stretched ------ COMPLETED

footer styling needs adjusting for mobile view ----- COMPLETED

copy server directory structure as different to local dir, local dir structure as is will not work on server ----- COMPLETED

Go through catch blocks and ensure error messages provide a link to a previous page ------ COMPLETED

MASSIVE BUG - Users can manually type a different id on edit.php to see other users details!!!***** ----- COMPLETED

add SSL certificate and .htdocs to access https ------ COMPLETED




Bug Fixes for version 1.1.2

Apply DRY using functions for errors ----- COMPLETED

Increased SEO ------- COMPLETED

Add comments at the top of each script explaining what it does ------- COMPLETED

Test all catch blocks -------- COMPLETED



Bug fixes for version 1.1.3

Look in to minifying scripts

Download fonts instead of using CDN link

Add notifications functionality

Add emailing functions - to the user when a user registers, to administrator when a photo gets a comment, to the user when a photo they have commented on also gets commented on

Add logo to browser tab

Bug - Delete all posts associated with a photo when a photo is deleted






Features for version 1.2:
Make administrator able to create albums, delete full albums, delete numerous pictures at once, move pictures to different albums

use sass for CSS and improve overall styling of website

Add a like/favourite button to pictures

