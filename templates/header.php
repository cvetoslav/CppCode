<div class="w3-top w3-card-2 w3-teal">
	<div class="w3-bar">
		
		<a href="/" class="w3-bar-item w3-border-teal w3-bottombar" style="margin-right: 50px">CppCode.ml</a>
		<a href="/tasks" class="w3-bar-item w3-button w3-teal w3-hover-green w3-border-teal w3-bottombar w3-hover-border-lime">Tasks</a>
		<a href="/competitions" class="w3-bar-item w3-button w3-teal w3-hover-green w3-border-teal w3-bottombar w3-hover-border-lime">Competitions</a>
		<a href="/standings" class="w3-bar-item w3-button w3-teal w3-hover-green w3-border-teal w3-bottombar w3-hover-border-lime">Standings</a>
		
		<?php
			if($user == null) echo "
				<a href=\"/acc/login\" class=\"w3-right w3-bar-item w3-button w3-teal w3-hover-green w3-border-teal w3-bottombar w3-hover-border-lime\">Login</a>
				<a href=\"/acc/register\" class=\"w3-right w3-bar-item w3-button w3-teal w3-hover-green w3-border-teal w3-bottombar w3-hover-border-lime\">Register</a>";
			else echo "
				<a href=\"/acc/logout\" class=\"w3-right w3-bar-item w3-button w3-teal w3-hover-green w3-border-teal w3-bottombar w3-hover-border-lime\">Logout</a>
				<a href=\"/acc\" class=\"w3-right w3-bar-item w3-button w3-teal w3-hover-green w3-border-teal w3-bottombar w3-hover-border-lime\">$_SESSION[uname]</a>";
		?>
	</div>
</div>

<?php
	
	if(isset($_SESSION['status']))
	{
		
		if($_SESSION['status'] == 'ok')
		{
			echo "
				<div class=\"w3-container w3-round w3-display-topright w3-opacity-min w3-green\" style=\"margin-top: 50px; margin-right: 20px\">
					<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-button w3-red w3-large w3-display-topright\">&times;</span>
					<br><p>".$_SESSION['message']."</p>
				</div>
			";
		}
		else if($_SESSION['status']=='error')
		{
			echo "
				<div class=\"w3-container w3-round w3-display-topright w3-opacity-min w3-red\" style=\"margin-top: 50px; margin-right: 20px\">
					<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-button w3-red w3-large w3-display-topright\">&times;</span>
					<br><p>".$_SESSION['message']."</p>
				</div>
			";
		}
		else if($_SESSION['status']=='info')
		{
			echo "
				<div class=\"w3-container w3-round w3-display-topright w3-opacity-min w3-blue\" style=\"margin-top: 50px; margin-right: 20px\">
					<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-button w3-red w3-large w3-display-topright\">&times;</span>
					<br><p>".$_SESSION['message']."</p>
				</div>
			";
		}
		else if($_SESSION['status']=='warning')
		{
			echo "
				<div class=\"w3-container w3-round w3-display-topright w3-opacity-min w3-yellow\" style=\"margin-top: 50px; margin-right: 20px\">
					<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-button w3-red w3-large w3-display-topright\">&times;</span>
					<br><p>".$_SESSION['message']."</p>
				</div>
			";
		}
		unset($_SESSION['status']);
		unset($_SESSION['message']);
		
	}

?>