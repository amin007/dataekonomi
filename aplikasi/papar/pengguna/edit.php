<div class="container">
<h1>User: Edit</h1>

<?php
/*
print_r($this->user);
echo 'id:' . $this->user[0]['id'] .
'|login:' . $this->user[0]['login'] .
'|role:' . $this->user[0]['role'];
*/

$user['id'] = $this->user[0]['id'];
$user['login'] = $this->user[0]['login'];
$user['role'] = $this->user[0]['role'];


?>

<form method="post" action="<?php echo URL;?>pengguna/editSave/<?php echo $user['id']; ?>">
	<label>Login</label><input type="text" name="login" value="<?php echo $user['login']; ?>" /><br />
	<label>Password</label><input type="text" name="password" /><br />
	<label>Role</label>
		<select name="role">
		<?php
$senaraiRole = array('default','admin','owner');
foreach ($senaraiRole as $key => $papar)
{
?><option value="<?php echo $papar ?>" <?php 
	if($user['role'] == $papar) echo 'selected'; ?>><?php 
	echo ucfirst(strtolower($papar)) ?></option><?php

	echo "\r\t";

}
?>		</select><br />
	<label>&nbsp;</label><input type="submit" />
</form>

</div><!--container-->