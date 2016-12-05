<?php

// Debug: Display ALL errors
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

?>

<html>
	<form action="" method="POST">
		<select name="plop[]" multiple>
			<option value='1' selected>Plop</option>
			<option value='2' selected="selected">Hi</option>
			<option value='3'>Hello</option>
		</select>
		<input type="submit">
	</form>
</html>

<?php
echo date('d-m-Y H:i:s');

?>