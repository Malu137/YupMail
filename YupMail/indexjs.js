function toggleSidebar(){
    document.getElementById('sidebar').classList.toggle('active');
    
    }
function to_profile(){
    location.replace("index.php?page=profile");
}

function to_change(){
    location.replace("index.php?page=changepw");
}

function to_compose(){
    location.replace("index.php?page=compose_mail");
}

function to_address(){
    location.replace("index.php?page=addressbk_CL");
}
function to_logout(){
    location.replace("logout.php");
}
