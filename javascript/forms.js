function formhash(){
//create a new element input this,  will be our hashed password field
var p =document.createElement("input");
//add the new element to our form

form.appendChild(p);
p.name="p";
p.type="hidden";
p.value=hex_sha512(password.value);

// make sure the password doesnt get sent

password.value="";

//finally submit the form
form.submit();

}
function regformhash(form, uid, email, password,conf){
	//check if each field has a value
	
	if (uid.value==''||
	email.value==''||
	password.value==''||
	 conf.value==''||){
		alert('you must provide all the requsted details. please try again]');
		return false;
		
	}
	
	//check the username
	
	re=/^\w+$/;
	if (!re.test(form.username.value)){
		alert("Username must contain only letters, numbers and underscores. Please try again");
		form.username.focus();
		return false;
		
	}
	//check that the password is sufficiently long
	//The check is duplicated below but this is to give the user more specific guidance
	
	
	if (password.value.length<6){
		alert('Passwords must be atleast  6 characters longs');
		form.password.focus;
		return false;
		
	}
	var re= /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
	if (re.test(password.value)){
	alert('passwords must contain atleast one number one lowercase and one uppercase letter.Please try again');
	
	return false;
	
	}

//check if password and confirmation are the same
 if (password.value !=conf.value){
	 alert ('your password and confirmation dont match please try again');
	 form.password.focus();
	 return false;
 }

//create a new element input, this will be our hashed password field
var p[ create] 
}