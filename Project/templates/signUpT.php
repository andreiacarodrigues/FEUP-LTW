<h2>SignUp</h2>
<div class="signUp">
    <form action="./index.php"><!-- isto depois não pode ser assim -->   <!--  <form action="upload.php" method="post" enctype="multipart/form-data">-->
        <label>Username:
            <input type="text" name="username" placeholder="..">
        </label>
        <br>
        <label>Name:
            <input type="text" name="name" placeholder="..">
        </label>
        <br>
        <label>Email:
            <input type="e-mail" name="email" placeholder="..">
        </label>
        <br>
        <label>PostCode:
            <input type="text" maxlength="4"  name="postCode1" placeholder=".."> <!-- javascript tem de ver se é numero -->
            <label> -
                <input type="text" maxlength="3" name="postCode2" placeholder="..">
            </label>
        </label>
        <br>
        <label>Birthdate:
            <input type="date" name="birthdate">
        </label>
        <br>
        <label>Password:
            <input type="password" name="password" placeholder="Insert your password..">
        </label>
        <br>
        <label>Confirm Password:
            <input type="password" name="confirmPassword" placeholder="Insert your password..">
        </label>
        <br>
        <label>Profile Picture:
            <input type="file" name="profilePic" id="profilePic">
        </label>
        <br>
        <input type="checkbox" name="remember_username" value="Remember_Username">Remember me
        <br>
        <input type="submit" value="Send">
        <input type="button" value="Cancel">
    </form>
</div>