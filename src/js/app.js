window.addEventListener('load', function() {

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
    
})