<?
class Simple_Parser 
{
    var $parser;
    var $error_code;
    var $error_string;
    var $current_line;
    var $current_column;
    var $data = array();
    var $datas = array();
    
    function parse($data)
    {
        $this->parser = xml_parser_create('UTF-8');
        xml_set_object($this->parser, $this);
        xml_parser_set_option($this->parser, XML_OPTION_SKIP_WHITE, 1);
        xml_set_element_handler($this->parser, 'tag_open', 'tag_close');
        xml_set_character_data_handler($this->parser, 'cdata');
        if (!xml_parse($this->parser, $data))
        {
            $this->data = array();
            $this->error_code = xml_get_error_code($this->parser);
            $this->error_string = xml_error_string($this->error_code);
            $this->current_line = xml_get_current_line_number($this->parser);
            $this->current_column = xml_get_current_column_number($this->parser);
        }
        else
        {
            $this->data = $this->data['child'];
        }
        xml_parser_free($this->parser);
    }

    function tag_open($parser, $tag, $attribs)
    {
        $this->data['child'][$tag][] = array('data' => '', 'attribs' => $attribs, 'child' => array());
        $this->datas[] =& $this->data;
        $this->data =& $this->data['child'][$tag][count($this->data['child'][$tag])-1];
    }

    function cdata($parser, $cdata)
    {
        $this->data['data'] .= $cdata;
    }

    function tag_close($parser, $tag)
    {
        $this->data =& $this->datas[count($this->datas)-1];
        array_pop($this->datas);
    }
}

class Data {
	
	private $mysqli;
	private $hostname = "localhost";
	private $username = "root";
	private $password = "";
	private $database = "goods_bd";
	private $nameFile = 'goods.xml';
	private $structureXml;
	
	public function __construct() {
		$this->mysqli = new mysqli($this->hostname, $this->username, $this->password, $this->database);
		$this->mysqli->set_charset("utf8");
	}
	
	public function parserXml() {
		$xmlstr = file_get_contents($this->nameFile);
		$xml_parser = new Simple_Parser;
		$xml_parser->parse($xmlstr);
		$this->structureXml = $xml_parser->data;
	}
	
	public function getStructureXml() {
		return $this->structureXml;
	}
	
	public function clearTable($table) {
		$this->mysqli->query("TRUNCATE TABLE " . $table);
	}
	
	public function insertCategoriesTable() {	
		$this->clearTable('categories');
		foreach ($this->structureXml['YML_CATALOG'][0]['child']['SHOP'][0]['child']['CATEGORIES'][0]['child']['CATEGORY'] as $category) {
			$temp []= "('" . $category['attribs']['ID'] . "'," . "'" . ($category['attribs']['PARENTID'] ? $category['attribs']['PARENTID'] : 0) . "'," . "'" . $category['data'] . "')";
		}
		
		$query = "INSERT INTO categories (id, parentId, name) VALUES " . implode(", ", $temp) . ";";
		$this->mysqli->query($query);
	}
	
	public function insertOffersTable() {
		$this->clearTable('offers');		
		foreach ($this->structureXml['YML_CATALOG'][0]['child']['SHOP'][0]['child']['OFFERS'][0]['child']['OFFER'] as $offer) {
			$temp []= "('" . $offer['attribs']['ID'] 
					. "'," . "'" . $offer['attribs']['AVAILABLE']
					. "'," . "'" . $offer['child']['URL'][0]['data']
					. "'," . "'" . $offer['child']['PRICE'][0]['data']
					. "'," . "'" . $offer['child']['OPTPRICE'][0]['data']
					. "'," . "'" . $offer['child']['CATEGORYID'][0]['data']
					. "'," . "'" . $offer['child']['PICTURE'][0]['data']
					. "'," . "'" . $offer['child']['NAME'][0]['data']
					. "'," . "'" . $offer['child']['ARTICUL'][0]['data']
					. "'," . "'" . $offer['child']['VENDOR'][0]['data']
					. "'," . "'" . $offer['child']['DESCRIPTION'][0]['data']
					. "'," . "'" . $offer['child']['EXTPROPS'][0]['child']['SEASON'][0]['data']
					. "'," . "'" . $offer['child']['EXTPROPS'][0]['child']['NAME'][0]['data']
					. "'," . "'" . $offer['child']['STATUSNEW'][0]['data']
					. "'," . "'" . $offer['child']['STATUSACTION'][0]['data']
					. "'," . "'" . $offer['child']['STATUSTOP'][0]['data'] . "')";
		}
		
		$query = "INSERT INTO offers (id, available, url, price, optprice, categoryId, picture, name, articul, vendor, description, extprops_season, extprops_name, statusAction, statusNew, statusTop) VALUES " . implode(", ", $temp) . ";";
		$this->mysqli->query($query);
	}
	
	public function getOffers($table, $vendor = false) {
		$res = $this->mysqli->query("SELECT * FROM " . $table 
									. ($vendor ? " WHERE vendor IN ('" . implode("', '", $vendor) . "')" : ""));
		$array = array();
		while ( ($row = $res->fetch_assoc()) != false ) {
			$array[] = $row;
		}
		return $array;
	}
	
	public function getVendors() {
		$res = $this->mysqli->query("SELECT DISTINCT vendor FROM offers");	
		$array = array();
		while ( ($row = $res->fetch_assoc()) != false ) {
			$array[] = $row['vendor'];
		}
		sort($array);
		return $array;
	}
	
	public function __destruct() {
		if ($this->mysqli) $this->mysqli->close();
	}
	
}


?>