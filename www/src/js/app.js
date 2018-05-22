/*GLOBAL FUNCTIONS*/

/*prompt user to confirm their decision
use this function when user is choosing to update account details
or delete their account*/
function confirm_choice(e){
    let response = confirm('Are you sure?'); //store answer to confirm() prompt
    if(!response){ //if answer is to decline confirmation, then prevent firing
        e.preventDefault();
    }
}






/*CLASSES*/

//client side form validation class
class Validation{
    
    isStrValid(str){ //checks if string input is valid or not
        if(!str){
            return false;
        }else{
            return true;
        }
    }   
}









/*PAGE SPECIFIC FUNCTIONS*/


/*header, navigation and footer specific*/
function header_footer(){
    
    let sidebar = document.getElementById('sidebar_wrapper');
    let sidebar_left = document.getElementById('sidebar_left'); //left hand side of navigation column
    let sidebar_right = document.getElementById('sidebar_right'); //right hand side of navigation column

    let content_wrapper = document.getElementById('content_wrapper'); //rest of page
    let hide_menu_btn = document.getElementById('hide_menu'); //button which will be used to toggle menu when clicked


    sidebar_right.style.display = 'none'; //hide sidebar right at startup
    //toggle menu when btn pressed
    hide_menu_btn.addEventListener('click', function() {
        if(sidebar_right.style.display !== 'none'){
            sidebar_right.style.display = 'none';
        }else{
            sidebar_right.style.display = 'block';
        }
    })

    //hide menu when content hovered over
    content_wrapper.addEventListener('mouseover',function(e){
        sidebar_right.style.display = 'none';
    })
    
}











/*accounts page*/
function account(){
    let logout = document.getElementById('logout');
    logout.addEventListener('click', function(e){confirm_choice(e);}) //ask whether user is sure they wish to log out
}















/*edit details page*/
function edit_details(){
    
    let delete_btn = document.getElementById('delete'); //delete account 
    delete_btn.addEventListener('click', function(e){confirm_choice(e);}); //ask user to confirm when deleting account
    
    
    
    //client side form validation
    let validate = new Validation();
    let form = document.getElementById('edit_form');
    let elements = form.elements;
    
    //inform user if invalid data passed
    for(let i = 0; i<elements.length-3; i++){ //-3 to remove submit btn, and passwords from elements list
        elements[i].addEventListener('blur', function(){
            if(!validate.isStrValid(this.value)){ //if input value is invalid, alert user
                
                if(this.nextSibling){ // remove error message if previously mentioned
                    this.nextSibling.remove();
                }
                
                let error_msg = "<span class='dark' style='margin-left:10px; font-weight:bold; font-style:italic;'>This field is required</span>"; //error message to display
                this.insertAdjacentHTML('afterend', error_msg); //attach next to input field
            }else{ //remove previous error, if one
                if(this.nextSibling){
                    this.nextSibling.remove();  
                }
            }
        })
    }
    
    //check if all elements have values before allowing user submit changes
    form.addEventListener('submit', function(e){
        for(let i = 0; i<elements.length - 3; i++){ //-3 to not include submit btn, and passwords
            if(!validate.isStrValid(elements[i].value)){ //if invalid data in input boxes, prevent form firing
                e.preventDefault();
                return;
            }
        }
        confirm_choice(); //ask user to confirm changes
    })
    
}








/*admin panel page*/
function admin_panel(){
    
    let delete_btn = document.getElementById('delete'); //delete admin user account button
    
    //alert user for confirmation as to whether to delete administrators account or not
    delete_btn.addEventListener('click', function(e){confirm_choice(e);});
}












/*file upload page*/
function file_upload(){
    
    let input, file, upload_btn, file_message;
    

    //get file size of uploaded img
    function showFileSize(){
        //return function if fileReader not supported by browser
        if(!window.FileReader){
            return;
        }

        input = document.getElementById('file');

        if(!input){ //return if no file uploaded
            return;
        }else{
            file = input.files[0];
            return file.size; //return file size
        }
    }
    
    upload_btn = document.getElementById('upload');
    file_message = document.getElementById('file_message'); //DOM location to display client side error message, if one

    //prevent form firing if uploaded file is greater than 2MB and inform user
    upload_btn.addEventListener('click', function(e){
        let file_size = showFileSize();
        if(file_size > 2000000){ //file larger than 2mb
            e.preventDefault();
            file_message.textContent = "Oops, your file is too big! The maximum size file we can accept is 2MB.";
        }
    });
 
}













/*views page*/
function view(){
    
    let body = document.getElementsByTagName('body')[0];
    
    //allow user to traverse pictures using arrow keys
    let next_page = document.getElementById('next_page'); //37
    let previous_page = document.getElementById('previous_page'); //39
    
    body.addEventListener('keydown', function(e){
        let next = 39; //key code for right arrow btn
        let previous = 37; //key code for left arrow btn
        let currentUrl = window.location.href;
        let id = currentUrl.match(/id=\d$/); //find the id
        id = id[0].substr(3); //get only the number from the id
        id = parseInt(id); //convert to int from str
        
        
        //display next page if next button is on screen
        if(next_page && e.keyCode === next){
            
            window.location.href = 'view.php?id='+ (id+1);
            
        }else if(previous_page && e.keyCode === previous){ //display previous page if previous button is on screen
            
            window.location.href = 'view.php?id='+ (id-1);
        }
        
    })
    
    
    
    
    
    /*
    All code below on the views page is for users and administrators only
    */
    if(!document.getElementById('submit')){
        return; //return function if user is not logged in
    }
    
    //prevent user from trying to submit an empty comment
    let submit, comment;
    submit = document.getElementById('submit');
    comment = document.getElementById('comment');
    
    submit.classList.add('disabled'); //add disable button styling
    submit.disabled = true; //disable button
    
    //prevent form firing if no value in comment box
    submit.addEventListener('click', function(e){
        if(!comment.value){
            e.preventDefault();
            this.classList.add('disabled'); //disable btn styling
            submit.disabled = true;
        }else{
            this.classList.remove('disabled'); //enable button styling
            submit.disabled = false; //enable button
        }
    })
    
    //enable button if comment has a value
    comment.addEventListener('keyup', function(){
        if(this.value){
            submit.classList.remove('disabled'); //enable button styling if comment has value
            submit.disabled = false; //enable button
        }else{
            submit.classList.add('disabled'); //disable button styling if no value
            submit.disabled = true;
        }
    })
    
    
    
    
    
    /*
    Below code is relevant to administrators only
    */
    if(!document.getElementById('cog-btn')){
        return; //return user if not administrator
    }
    
    
    //display and hide admin settings when clicked
    let cog_btn = document.getElementById('cog-btn');
    let dropdown = document.getElementsByClassName('dropdown')[0];
    let delete_btn = document.getElementById('delete');
    
    
    dropdown.style.display = 'none'; //set dropdown menu to hidden
    
    //if cog btn pressed, display drop down menu, else hide it
    body.addEventListener('click', function(e){
        if( (e.target.id==='cog-btn' || e.target.id === 'dropdown') && (dropdown.style.display === 'none') ){ //display dropdown menu if currently hidden
            dropdown.style.display = 'inline-block';
        }else{
            dropdown.style.display = 'none';
        }
    })
    
    //if delete button pressed, prompt user to confirm
    delete_btn.addEventListener('click', function(e){
        let confirmation = confirm('Are you sure you want to delete this photo?');
        if(!confirmation){
            e.preventDefault();
        }
    })
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //get confirmation from user to delete picture comment
    let delete_comment_btn = document.getElementsByClassName('delete_comment'); //store all trash cans/delete comment buttons
    
    for(let i = 0; i<delete_comment_btn.length; i++){ //loop through all trash cans in order to add a click event
        //alert user to ask whether they are sure they want to delete comment
        delete_comment_btn[i].addEventListener('click', function(e){
            let response = confirm('Are you sure you want to delete this comment?');
            if(!response){ //prevent comment being deleted if cancelled pop up box
                e.preventDefault();
            }
        })
    }
}




