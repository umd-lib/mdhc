<?php 	header("Content-type: text/html; charset=utf-8"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
	<head>
		<title>Add a new code</title>
		<link rel="stylesheet" type="text/css" href="includes/admin.css">
		<script type="text/javascript" src="http://www.lib.umd.edu/dcr/collections/mdhc/includes/mdhc.js"></script>
	</head>
	<body>
		<?php
			include("includes/setup.php");
			if (isset($_POST['addcode'])) {
				$code = $_POST['code'];
				$description = $_POST['description'];
				$createOrModify = $_POST['createmodify'];
				if ($createOrModify == "create") {
					$query = "insert into codes (ID, codes, description, essay) values ('NULL', '$code', '$description', 'NULL')";
				} else {
					$id = $_POST['id'];
					$query = "update codes set codes='$code', description='$description' where ID = '$id'";
				}
				$mysql = mysql_query("$query",$conn);
				if (!$mysql) {
					die('Invalid query: ' . mysql_error());
				} else {
		?>
			<p>Added new code.</p>
		<?php
				}
			} else if (isset($_POST['delete'])) {
				$id = $_POST['rowID'];
				$query3 = "delete from codes where ID='$id' limit 1";
				$mysql3 = mysql_query("$query3",$conn);
				$query4 = "delete from codelookup where CodeID='$id'";
				$mysql4 = mysql_query("$query4",$conn);
		?>
			<p>Deleted code.</p>
		<?php
			}
			if (isset($_POST['modify'])) {
				$modifyID = $_POST['rowID'];
				$query5 = "select * from codes where ID='$modifyID' limit 1";
				$mysql5 = mysql_query("$query5",$conn);
				while ($ary5 = mysql_fetch_assoc($mysql5)) {
					while (list($key5,$val5) = each($ary5)) {
						$$key5 = $val5;
					}
					$modifyCode = $codes;
					$modifyDesc = $description;
					$createOrModify = "modify";
				}
			} else {
				$modifyID = "";
				$modifyCode = "";
				$modifyDesc = "";
				$createOrModify = "create";
			}
		?>
		<form action="newcode.php" method="post" id="editcode">
			<fieldset>
				<legend>
					<?php
						if ($_POST['modify']) {
							echo "Modify category #$modifyID: $modifyDesc";
						} else {
							echo "Create a new bibliographic category";
						}
					?>
				</legend>
				<input type="hidden" name="createmodify" value="<?php echo "$createOrModify" ?>">
				<input type="hidden" name="id" value="<?php echo "$modifyID" ?>">
				<label for="description">Description:</label>
				<input type="text" name="description" id="description" value="<?php echo "$modifyDesc" ?>">
				<br>
				<label for="code">Code:</label>
				<input type="text" name="code" id="code" maxlength="2" value="<?php echo "$modifyCode" ?>">
				<br>
				<input type="submit" name="addcode" id="addcode" value="submit">
			</fieldset>
		</form>
		<table class="bibcodes">
			<tr>
				<th><a href="newcode.php?sort=ID">ID</a></th>
				<th><a href="newcode.php?sort=description">Description</a></th>
				<th>Delete</th>
				<th>Modify</th>
			</tr>
			<?php
				if ($_GET['sort'] == "ID" || $_GET['sort'] == "description") {
					$sort = $_GET['sort'];
				} else {
					$sort = "ID";
				}
				$query2 = "select * from codes order by $sort";
				$mysql2 = mysql_query("$query2",$conn);
				while ($ary2 = mysql_fetch_assoc($mysql2)) {
					while (list($key2,$val2) = each($ary2)) {
						$$key2 = $val2;
					}
			?>
			<tr id="row<?php echo "$ID"?>">
				<td class="id">
					<?php echo "$ID" ?>
				</td>
				<td class="description">
					<?php echo "$description" ?>
				</td>
				<td class="delete">
					<form action="newcode.php" method="post">
						<div>
							<input type="hidden" name="rowID" value="<?php echo "$ID" ?>">
							<input type="submit" name="delete" value="delete">
						</div>
					</form>
				</td>
				<td class="modify">
					<form action="newcode.php" method="post">
						<div>
							<input type="hidden" name="rowID" value="<?php echo "$ID" ?>">
							<input type="submit" name="modify" value="modify">
						</div>
					</form>
				</td>
			</tr>
			<?php
				}
			?>
		</table>
	</body>
</html>
