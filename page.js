let flag=true;
function show(){
    if(flag)
    {
        document.getElementById('signup').style.display="block";
        flag=false;
    }
    else{
        document.getElementById('signup').style.display="none";
        flag=true;
    }
}
