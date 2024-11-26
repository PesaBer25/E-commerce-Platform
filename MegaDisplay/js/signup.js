let input = document.querySelector('.password2').addEventListener('input',(e)=>{
    let password = document.querySelector('.password1').value;
    if(e.target.value == password){
        document.querySelector('.password').innerHTML = "";
        document.querySelector('.btn').disabled = false;
    }else{
        document.querySelector('.password').innerHTML = "Password Mismatch!";
        document.querySelector('.btn').disabled = true;
    }
})