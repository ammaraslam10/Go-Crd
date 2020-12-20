<style type="text/css">
	.tab_emailtemplate {
		border:1px solid #c1c1c1;
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
		padding:10px;
	}
	.tab_emailtemplate tbody {
		padding:20px;
	}
	.tab_emailtemplate tbody > tr {
		padding:20px;
	}
</style>
<table width="600px" align="center" class="tab_emailtemplate">
<tbody style="padding:20px;">
	<tr>
		<td><img src="[@url]templates/Email_Templates/logo.png" alt="[@name]"><br><br></td>
	</tr>
	<tr>
		<td>
			<center>
					<h3>Hello, [@email]</h3>
					<h5>You are invited to join our wallet by one of your contacts.</h5>
					<h5><a href="[@url]register/?invite=[@email]">Register Now!</a></h5>
					<p>If this email was not requested by you, please ignore it.</p>
					<br><br>
				Regards,
				[@name]
			</center>
		</td>
	</tr>
</tbody>
</table>