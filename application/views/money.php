<!doctype html>
<html>
	<head>
		<title>Money Management</title>
		<link rel="stylesheet" href="/~carlos/note/css/smoothness/jquery-ui.css" />
		<script src="/~carlos/note/js/jquery.js"></script>
		<script src="/~carlos/note/js/jquery-ui.js"></script>
		<script src="/~carlos/note/js/jquery.flot.js"></script>
		<script>
			$(function(){
				$('#date').datepicker({dateFormat: 'yy-mm-dd'});
				//$('#itembox').draggable();
				//$('#daily-plot').draggable();
				
				$.post('/~carlos/note/index.php/money/get_Item', function(data){
					var tmp = $('#itemlist');
					var obj = {}, dt;
					var series = [];
					var options = {
						xaxis: {
 							mode: "time",
							timeformat: "%m/%d"
						}
					};
					for(var i = 0; i < data.length; i++)
					{
						tmp.append('<tr>')
						   .append('<td>' + data[i].date + '</td>')
						   .append('<td>' + data[i].name + '</td>')
						   .append('<td>' + data[i].cost + '</td>')
						   .append('</tr>');
						   
						dt = new Date(data[i].date).getTime()
						if(obj[dt])
							obj[dt] += parseInt(data[i].cost);
						else
							obj[dt] = parseInt(data[i].cost);
					}
					for(var date in obj)
					{
						series.push([date, obj[date]]);
					}
					console.log(series);
					
					$.plot($('#daily-plot'), [series], options);
					
				}, 'json');
				
			});
		</script>
		<style>
			body {
				background: #C7B7B7;
			}
			#warning {
				color: red;
			}
			#add_box {
			}
			#itembox {
				width: 400px;
				border-style: groove;
				float: left;
				margin: 10px;
			}
			#daily-plot {
				width: 600px;
				height: 400px;
				float: left;
				margin: 10px;
			}
			table {	
				text-align: left;
			}
			
			nav {
				width: 100%;
				background: #333;
				color: #fff;
				clear: both;
				padding: 10px;
			}
			nav a {
                text-align: center;
                color: inherit;
                text-decoration: none;
                padding: 10px;
           }
           nav a:hover{
           		color: red;
           }
		</style>
	</head>
	<body>
		<nav>
			<a href="">Money Management</a>
			<a href="">Weight Management</a>
			<a href="">Logout</a>
		</nav>
		<section>
		<div id="add_box">
			<table>
				<tr>
					<td>Date</td>
					<td>Item</td>
					<td>Cost</td>
				</tr>
				<tr>
					<?=form_open('money/add_Item')?>
						<td><input type="text" name="date" id="date" class="date" /></td>
						<td><input type="text" name="item" id="item" /></td>
						<td><input type="text" name="cost" id="cost" /></td>
						<td><input type="submit" value="add" /></td>
					</form>
				</tr>
			</table>
			<div id="warning">
				<?=validation_errors()?>
			</div>
		</div>
		<hr />
		<div id="itembox">
			<table cellpadding="5px">
				<tbody id="itemlist">
					<tr>
						<th>Date</th>
						<th>Item</th>
						<th>Cost</th>
					</tr>
				</tbody>
			</table>
		</div>
		<div id="daily-plot">
		</div>
		</section>
	</body>
</html>
