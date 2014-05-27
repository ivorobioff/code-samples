<?php
require_once 'stdlib.php';
$model = new DeviceModel();
$data = $model->getAll();
?>
<html>
	<head>
		<title>Sockets</title>
		<!-- CSS goes in the document HEAD or added to your external stylesheet -->
		<style type="text/css">
			table.gridtable {
				font-family: verdana,arial,sans-serif;
				font-size:11px;
				color:#333333;
				border-width: 1px;
				border-color: #666666;
				border-collapse: collapse;
			}
			table.gridtable th {
				border-width: 1px;
				padding: 8px;
				border-style: solid;
				border-color: #666666;
				background-color: #dedede;
			}
			table.gridtable td {
				border-width: 1px;
				padding: 8px;
				border-style: solid;
				border-color: #666666;
				background-color: #ffffff;
			}
		</style>
	</head>
	<body>
		<table class="gridtable">
			<tr>
				<th>Device ID</th>
				<th>Online</th>
				<th>Last seen</th>
			</tr>
			<?php
				if ($data)
				{
					foreach ($data as $row)
					{
					?>
						<tr>
							<td><?=htmlspecialchars($row['device_id'])?></td>
							<td><?=$row['online'] ? 'Yes' : 'No'?></td>
							<td><?=$row['last_seen']?></td>
						</tr>
					<?php
					}
				}
				else
				{
					echo '<tr><td colspan="3">No data found</td></tr>';
				}
			?>
		</table>
	</body>
</html>
 