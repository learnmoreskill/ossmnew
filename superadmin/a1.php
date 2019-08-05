<!DOCTYPE html>
<html>
<head>
	<title>Firebase Web Basics</title>
</head>
<body>

	<div id="content_div" class="mainDiv" style="display: none;" align="center" >
		<h1 align="center">Add school in firebase</h1>
		<input type="text" id="schoolName" name="schoolName" placeholder="enter school name" >
		<input type="text" id="dbName" name="dbName" placeholder="enter dbname without 'db'" >
		<button onclick="submitClick();"></button>

		<div id="table_div">
			<h1>All school</h1>
			<table>
				<thead>
					<tr>
						<td>Name</td>
						<td>Email</td>
						<td>Action</td>
					</tr>
				</thead>

				<tbody id="table_body">
					
				</tbody>

			</table>
		</div>
	</div>




		<!-- Firebase App is always required and must be first -->
		<script src="https://www.gstatic.com/firebasejs/5.4.2/firebase-app.js"></script>
		<!-- Add additional services that you want to use -->
		<script src="https://www.gstatic.com/firebasejs/5.4.2/firebase-auth.js"></script>
		<script src="https://www.gstatic.com/firebasejs/5.4.2/firebase-database.js"></script>

		<script src="js/f_hackster.js"></script>
		<script src="js/checklogin.js"></script>

		<script src="https://code.jquery.com/jquery-3.1.0.js" type="text/javascript"></script>

		<script src="js/save.js"></script>

</body>
</html>