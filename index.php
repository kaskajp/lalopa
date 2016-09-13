<?php
require('db/db.php');

if($_POST['removeteam']) {
	$id = db_quote($_POST['id']);

	db_query("DELETE FROM clubtable WHERE id = $id");
}
elseif($_POST['clubupdate']) {
	$id = db_quote($_POST['id']);
	$club = db_quote($_POST['club']);
	$playername = db_quote($_POST['playername']);
	$team = db_quote($_POST['team']);
	$backupteam = db_quote($_POST['backupteam']);

	db_query("UPDATE clubtable SET club = $club, playername = $playername, team = $team, backupteam = $backupteam WHERE id = $id");
}
elseif($_POST['addnewteam']) {
	if($_POST['club'] && $_POST['playername'] && $_POST['team'] && $_POST['backupteam']) {
		$club = db_quote($_POST['club']);
		$playername = db_quote($_POST['playername']);
		$team = db_quote($_POST['team']);
		$backupteam = db_quote($_POST['backupteam']);

		db_query("INSERT INTO clubtable (club, playername, team, backupteam) VALUES ($club, $playername, $team, $backupteam)");
	}
}
elseif($_POST['id']) {
	if($_POST['pl']) {
		$id = db_quote($_POST['id']);
		$pl = db_quote($_POST['pl']);

		db_query("UPDATE clubtable SET pl = $pl WHERE id = $id");
	}
	elseif($_POST['w']) {
		$id = db_quote($_POST['id']);
		$w = db_quote($_POST['w']);

		db_query("UPDATE clubtable SET w = $w WHERE id = $id");
	}
	elseif($_POST['d']) {
		$id = db_quote($_POST['id']);
		$d = db_quote($_POST['d']);

		db_query("UPDATE clubtable SET d = $d WHERE id = $id");
	}
	elseif($_POST['l']) {
		$id = db_quote($_POST['id']);
		$l = db_quote($_POST['l']);

		db_query("UPDATE clubtable SET l = $l WHERE id = $id");
	}
}

$table = db_select("SELECT * FROM clubtable ORDER BY pts");
?>
<!DOCTYPE html>
<!--[if IE 7 ]>		<html lang="sv-SE" class="ie7">		<![endif]-->
<!--[if IE 8 ]>		<html lang="sv-SE" class="ie8">		<![endif]-->
<!--[if IE 9 ]>		<html lang="sv-SE" class="ie9">		<![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="sv-SE"><!--<![endif]-->
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<title>Creative Loop</title>
		<link rel="stylesheet" type="text/css" href="lopa.css" />
		<script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
	</head>
	<body>
		<div class="header">
			<h1>La Lopa – September 2016 Tournament</h1>
		</div>
		<table class="lopa-table" id="lopatable">
			<thead>
				<tr>
					<th>POS</th>
					<th>CLUB</th>
					<th>PL</th>
					<th>W</th>
					<th>D</th>
					<th>L</th>
					<th>PTS</th>
				</tr>
			</thead>
			<tbody>
				<?php $pos = 0; ?>
				<?php foreach($table as $team): ?>
					<?php $pos++; ?>
					<tr>
						<td><?php echo $pos; ?></td>
						<td>
							<form action="" method="post">
								<input type="hidden" name="id" value="<?php echo $team['id']; ?>" />
								<input type="hidden" name="clubupdate" value="1" />
								<input class="clubname" type="text" name="club" value="<?php echo $team['club']; ?>" /><br />
								<input class="playername" type="text" name="playername" value="<?php echo $team['playername']; ?>" /><br />
								<div class="teamname"><span class="teamname">TEAM:</span><input class="teamname" type="text" name="team" value="<?php echo $team['team']; ?>" /></div>
								<div class="teamname"><span class="teamname">BACKUPTEAM:</span><input class="teamname" type="text" name="backupteam" value="<?php echo $team['backupteam']; ?>" /></div>
								<input type="submit" style="visibility: hidden;display:none;" />
							</form>
						</td>
						<td>
							<form action="" method="post">
								<input type="hidden" name="id" value="<?php echo $team['id']; ?>" />
								<input class="regular" type="text" name="pl" value="<?php echo $team['pl']; ?>" />
							</form>
						</td>
						<td>
							<form action="" method="post">
								<input type="hidden" name="id" value="<?php echo $team['id']; ?>" />
								<input class="regular" type="text" name="w" value="<?php echo $team['w']; ?>" />
							</form>
						</td>
						<td>
							<form action="" method="post">
								<input type="hidden" name="id" value="<?php echo $team['id']; ?>" />
								<input class="regular" type="text" name="d" value="<?php echo $team['d']; ?>" />
							</form>
						</td>
						<td>
							<form action="" method="post">
								<input type="hidden" name="id" value="<?php echo $team['id']; ?>" />
								<input class="regular" type="text" name="l" value="<?php echo $team['l']; ?>" />
							</form>
						</td>
						<td><?php echo ($team['w']*3) + $team['d']; ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<div class="addnewteam">
			<h2>Add a new team</h2>
			<form action="" method="post">
				<input type="hidden" name="addnewteam" value="1" />
				<input type="text" name="club" value="" placeholder="Club name" />
				<input type="text" name="playername" value="" placeholder="Player name" />
				<input type="text" name="team" value="" placeholder="First choice team" />
				<input type="text" name="backupteam" value="" placeholder="Backup team" />
				<input type="submit" value="Add" />
			</form>
		</div>

		<div class="addnewteam">
			<h2>Remove a team</h2>
			<form action="" method="post">
				<input type="hidden" name="removeteam" value="1" />
				<input type="text" name="id" value="" placeholder="Team id" />
				<input type="submit" value="Remove" />
			</form>
		</div>

		<script type="text/javascript">
			jQuery(document).ready(function($){
				function MemberInfo(playerid,played,gd,pts){
					this.PlayerId = playerid;
					this.Played = played;
					this.GD = gd;
					this.PTS = pts;
				}

				var arr=[];
				$("#lopatable").find('tbody tr').each(function(index,item){
					var playerid = $(item).find('td').eq(1).attr('data-id');
					var played = $(item).find('td').eq(2).text();
					var gd = $(item).find('td').eq(3).text();
					var pts = $(item).find('td').eq(4).text();
					arr.push(new MemberInfo(playerid,played,gd,pts));
				});
				localStorage.setItem("lopa",JSON.stringify(arr));

				console.log(JSON.parse(localStorage.getItem('lopa')));
			});
		</script>
	</body>