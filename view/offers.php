<form href="/?action=offers" method="get">
	<label for="vendor">VENDOR:</label>
	<input type="hidden" name="action" value="offers" />
	<select name="vendor[]" id="vendor" multiple="multiple" size="5">
		<? foreach ( $vendors as $vendor ) { ?>
			<option value="<?=$vendor?>" <?=($_GET['vendor'] && in_array($vendor, $_GET['vendor']) ? "selected=\"selected\"" : "")?>><?=$vendor?></option>
		<? } ?>
	</select>
	
	<input type="submit" value="Применить" />
</form>

<table>
	<tbody>
		<tr>
			<th>ID</th>
			<th>AVAILABLE</th>
			<th>URL</th>
			<th>PRICE</th>
			<th>OPTPRICE</th>
			<th>CATEGORYID</th>
			<th>PICTURE</th>
			<th>NAME</th>
			<th>ARTICUL</th>
			<th>VENDOR</th>
			<th>DESCRIPTION</th>
			<th>extprops_season</th>
			<th>extprops_name</th>
			<th>statusAction</th>
			<th>statusNew</th>
			<th>statusTop</th>
		</tr>
		<? foreach ($offers as $offer) { ?>
			<tr>
				<? foreach ($offer as $value) { ?>
					<td><?=$value?></td>
				<? } ?>
			</tr>
		<? } ?>
	</tbody>
</table>

<p><a href="/">Главная</a></p>