<?php
require_once 'head.php';
?>
<br>
<br>
<form action="signpro.php" method="post" autocomplete="off">
  <div class="container-form">
    <h1>Register</h1>
    <p>Please fill in this form to create an account.</p>
    <br>
    <br>
    <input type="text" placeholder="Enter fullname" name="fullname" id="fullname" required>
    <br>
    <input type="text" placeholder="Enter UserName" name="uid" id="uid" required>
    <br>
    <input type="email" placeholder="Enter Email" name="mail" id="mail" required>
    <br>
    <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
    <br>
    <input type="password" placeholder="Repeat Password" name="pwdrepeat" id="pwdrepeat" required>
    <br>
    <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
    <button type="submit" class="registerbtn">Register</button>
    <br>
    <p>Already have an account? <a href="#">Sign in</a>.</p>
  </div>
</form>
<style>
    * {box-sizing: border-box}

/* Add padding to containers */
.container-form {
    padding: 20px 16px;
  justify-self: center;
  text-align: center;
  font-weight:10px;
  margin-top:60px;
}
b{
    float left;
}
/* Full-width input fields */
input[type=text], input[type=password], input[type=email] {
  width: 30%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
  border-radius: 10px;

}
input[type=text]:focus, input[type=password]:focus, input[type=email]:focus {
  background-color: white;
  border: 1px solid #f1f1f1;
  width:32%;
}

/* Overwrite default styles of hr */
hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
  width: 30%;
  border-radius:10px;
}

/* Set a style for the submit/register button */
.registerbtn {
  background-color: #04AA6D;
  color: white;
  padding: 16px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100px;
  opacity: 0.9;
  border-radius: 10px;
}

.registerbtn:hover {
  opacity:1;
  width:10%;
}

/* Add a blue text color to links */
 p a {
  color: dodgerblue;
}

/* Set a grey background color and center the text of the "sign in" section */
.signin {
  
  text-align: center;
}
@media (max-width: 425px) {
  input[type=text], input[type=password], input[type=email] {
  width: 70%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
  border-radius: 10px;
}
.registerbtn {
  background-color: #04AA6D;
  color: white;
  padding: 16px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 50%;
  opacity: 0.9;
  border-radius: 10px;
}
}
@media (max-width: 768px) {
  input[type=text], input[type=password], input[type=email] {
  width: 70%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
  border-radius: 10px;
}
.registerbtn {
  background-color: #04AA6D;
  color: white;
  padding: 16px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 30%;
  opacity: 0.9;
  border-radius: 10px;
}
}
</style>