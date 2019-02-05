<?
	require_once('./model.php');
	$data = new Data();
	require_once('./view/header.php');
	if ($_GET['action'] == 'parser') {
		$data->parserXml();
		$data->insertCategoriesTable();
		$data->insertOffersTable();
		require_once('./view/parser.php');
	} elseif ($_GET['action'] == 'offers') {
		$offers = $data->getOffers('offers', $_GET['vendor']);
		$vendors = $data->getVendors();
		require_once('./view/offers.php');
	} else {
		require_once('./view/main.php');
	}
	require_once('./view/footer.php');
?>