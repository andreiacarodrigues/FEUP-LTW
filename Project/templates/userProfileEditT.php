<section id="Main" >
    <img src="vaiBuscarBD.jpg" alt="User photo">
    <br>
    <label>Change Profile Picture:
        <input type="file" name="profilePic" id="profilePic">
    </label>
</section>
<section id="dashboard" >
    <ul>   <!-- vao ser colocadas com php -->
        <li id="UserInformations">
            <div>
                <form>
                    <label>Username:
                        <input type="text" name="username" placeholder="..">
                    </label>
                    <br>
                    <label>My information:
                        <textarea name="info" cols="40" rows="5"></textarea>
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
                    <a href="#ChangePassword">Mudar Pass</a>   <!-- ainda nao sei como isto fica -->
                    <input type="submit" value="Send">
                    <input type="button" value="Cancel">
                </form>
            </div>
        </li>
        <li id="ChangePassword">
            <div>
                <form>  <!-- mudar isto, talvez? -->
                    <label>Password:
                        <input type="password" name="password" placeholder="Insert your password..">
                    </label>
                    <br>
                    <label>Confirm Password:
                        <input type="password" name="confirmPassword" placeholder="Insert your password..">
                    </label>
                    <br>
                    <input type="submit" value="Send">
                    <input type="button" value="Cancel">
                </form>
            </div>
        </li>
    </ul>           <!-- vai ser mudadado pela bd -->
</section>