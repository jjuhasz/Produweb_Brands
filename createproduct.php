<html>
<body>
<style>
    html > body {
        white-space: pre-line;
    }

</style>
<?php
ob_start();
echo "**************************************************\n* Product Generator : \n**************************************************\n\n";
ob_flush();
flush();

function slug($string, $maxLength=255) {
    $table = array(
        'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'Č' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c',
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
        'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
        'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
        'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
        'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b',
        'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r',
    );

    $string = strtr($string, $table);
    $string = strtolower($string);
    $string = preg_replace("/[^a-z0-9\s-]/", "", $string);
    $string = trim(preg_replace("/[\s-]+/", " ", $string));
    $string = trim(substr($string, 0, $maxLength));
    $string = preg_replace("/\s/", "-", $string);

    return $string;
}

require_once 'app/Mage.php';
Mage::app('admin')->setIsSingleStoreModeAllowed(false)->setCurrentStore(1);
Mage::init();



error_reporting(E_ALL);
$titles = explode(' ', "Poterit difficilisque quorum specie tenus suppliciter quod consularem tenus adfore suppliciter rectore causas multas poterit statuit victu suppliciter disponi metum invito disponi rectore plebi haec obsecranti prope provinciis prope adesset difficilisque aerumnis Antiochensi poterit quae dispelleret vel multitudini adsidue medetur Antiochensi per multitudini ultima est iam prope adsidue obsecranti multas conterminis subinde quae Theophilum diffusa specie ultima vel adfore tenus localibus difficilisque Theophilum rectore adesset quod adfore multitudini prope quicquam provinciis victu dedit statuit localibus mos nullus alimenta quae aerumnis suppliciter victu Theophilum sperabatur Antiochensi multas adfore adfore rectore metuenti dedit principibus tenus dispelleret");
$titles_count = count($titles);
$productIds = array();

$path = Mage::getBaseDir('media') . DS . 'import';

$images = array();
if ($handle = opendir($path)) {
    /* This is the correct way to loop over the directory. */
    while (false !== ($file = readdir($handle))) {
        if (!empty($file) && $file != '.' && $file != '..' && $file != '.DS_Store') {
            $images[] = $file;
            echo $file . "\n";
        }
    }

    closedir($handle);
}
$images_count = count($images);


if (isset($_GET['DELETE']) && $_GET['DELETE'] == 1) {
    echo "**************************************************\n* Delete : \n";

    $deleted_category_ids = array();
    $category_collection = Mage::getModel('catalog/product')->getCollection();
    $size = $category_collection->getSize();
    foreach ($category_collection as $cat) {
        $deleted_category_ids[] = $cat->getId();
    }
    echo "* IDS : " . implode(', ', $deleted_category_ids) . "\n* Number : " . $size . "\n";
    Mage::getModel('catalog/product')->getCollection()->delete();

    if (isset($_GET['RESET']) && $_GET['RESET'] == 1) {
        echo "* RESET ID ! \n";

        $resource = Mage::getSingleton('core/resource');
        $tableName = $resource->getTableName('catalog_product_entity');
        $connection = $resource->getConnection();
        $connection->exec("ALTER TABLE $tableName AUTO_INCREMENT = 1;");
    }

    echo "**************************************************\n\n";
}

$category_ids = array();
$category_collection = Mage::getResourceModel('catalog/category_collection')
    ->addAttributeToSelect('name','level')
    ->addAttributeToFilter('level', array('gteq'=>3));

foreach ($category_collection as $category) {
    echo $category->getId() . " - " . $category->getLevel() . " - " . $category->getName() . "\n";
    $category_ids[$category->getId()] = $category->getId();
}

$chunk = intval(count($category_ids) / 3);

$attributeInfo = Mage::getResourceModel('eav/entity_attribute_collection')
    ->setCodeFilter('manufacturer')->getFirstItem();
$manufactures = Mage::getResourceModel('eav/entity_attribute_option_collection')
    ->setPositionOrder('asc')
    ->setAttributeFilter($attributeInfo->getAttributeId())
    ->setStoreFilter(Mage::app()->getStore()->getId());
$manufactureIds = array();
foreach ($manufactures as $manufacture) {
    $manufactureIds[] = array('id' => $manufacture->getData('option_id'), 'name' => $manufacture->getData('default_value'));
}
//var_dump($manufactures ->toArray());die;


foreach (range(1, intval($_GET['NUMBER'])) as $k => $v) {
    echo "*";
    shuffle($category_ids);
    $category_ids_rand_chunked = array();

    foreach (range(1, rand(1, 4)) as $i => $cat)
        $category_ids_rand_chunked[$i] = $category_ids[$i];

    shuffle($titles);
    $title = array();
    foreach (range(0, rand(1, 5)) as $nb_word) {
        $title_id = rand(1, $titles_count);
        $title[] = $titles[$title_id];
    }
    $title = ucfirst(implode(' ', $title));

    $title_slugged = slug($title);

    shuffle($titles);
    $small_description = '';
    $small_description_array = array();
    foreach (range(0, rand(1, 2)) as $nb_paraf) {
        foreach (range(0, rand(6, 15)) as $nb_word) {
            $title_id = rand(1, $titles_count);
            $small_description_array[] = $titles[$title_id];
        }
        $small_description .= '<p>' . ucfirst(implode(' ', $small_description_array)) . '.</p>';
    }

    shuffle($titles);
    $description = '';
    $description_array = array();
    foreach (range(0, rand(2, 3)) as $nb_paraf) {
        foreach (range(0, rand(15, 30)) as $nb_word) {
            $title_id = rand(1, $titles_count);
            $description_array[] = $titles[$title_id];
        }
        $description .= '<p>' . ucfirst(implode(' ', $description_array)) . '.</p>';
    }

    //// créer un produit simple
    /**
     * @var $product Mage_Catalog_Model_Product
     */
    $product = Mage::getModel('catalog/product');
//  $product = new Mage_Media_Model_Image();
//  var_dump($product->toArray()); die;
//  var_dump($product->toArray()); die;
    // récupérer l'id du type d'entité

    $typeId = Mage::getResourceModel('catalog/product')->getTypeId();
    // récupérer l'id du jeu d'attributs par défaut des produits
    $setName = 'Default';
    $sets = Mage::getModel('eav/entity_attribute_set')
        ->getCollection()
        ->addFieldToFilter('entity_type_id', $typeId)
        ->addFieldToFilter('attribute_set_name', $setName);
    $setId = $sets->getFirstItem()->getId();

//  $typeId = "simple";
//  $setId = 4;
// préparer les attributs
    $price = rand(200, 2000);


    $tierPrices = array();
    $tierPrices[] = array(
        'website_id' => 'all',
        'cust_group' => 'all',
        'price_qty' => number_format(10, 4, '.', ''),
        'price' => $price - ($price * (15 / 100))
    );

    $tierPrices[] = array(
        'website_id' => 'all',
        'cust_group' => 'all',
        'price_qty' => number_format(50, 4, '.', ''),
        'price' => $price - ($price * (20 / 100))
    );

    $tierPrices[] = array(
        'website_id' => 'all',
        'cust_group' => 'all',
        'price_qty' => number_format(100, 4, '.', ''),
        'price' => $price - ($price * (30 / 100))
    );

    $data = array(
        'type_id' => 'simple',
        'entity_type_id' => $typeId,
        'attribute_set_id' => $setId,
        'sku' => substr($title_slugged, 0, 55) . '-' . $k,
        'price' => $price,
        'msrp' => $price - ($price * (rand(10, 30) / 100)),
        'weight' => 12.00,
        'name' => $title,
        'description' => $description,
        'status' => 1,
        'tax_class_id' => 1,
        'visibility' => 4,
        'is_in_stock' => 1,
        'tier_price' => $tierPrices,
    );

    if (rand(0, 3) == 3)
        $data['mon_attribut'] = true;


    if (rand(0, 3) == 3 && $cpt_slide++ <= 15)
        $data['slideshow'] = true;

    $type = '';
    $typeChoise = intval(rand(1, 3));
    if ($typeChoise == 1) {
        $newProductData = array(
            'news_from_date' => date('Y-m-d', strtotime(rand(1, 27) . '-' . rand(1, 12) . '-' . rand(2000, 2011))),
            'news_to_date' => date('Y-m-d', strtotime(rand(1, 27) . '-' . rand(1, 12) . '-' . rand(2012, 2030))),
        );

        $data = array_merge($data, $newProductData);
        $type = 'new';
    } elseif ($typeChoise == 2) {
        $promoProductData = array(
            'special_from_date' => date('Y-m-d', strtotime(rand(1, 27) . '-' . rand(1, 12) . '-' . rand(2000, 2010))),
            'special_to_date' => date('Y-m-d', strtotime(rand(1, 27) . '-' . rand(1, 12) . '-' . rand(2012, 2030))),
            'special_price' => $price - rand(10, 200),
        );
        $data = array_merge($data, $promoProductData);
        $type = 'promo';
    }
    $product->setData($data);
    // affecter les attributs au nouveau produit
//  $product = new Mage_Catalog_Model_Product();
//  new Mage_Catalog_Model_Resource_Product_Relation();

    $count_product_id = count($productIds);
    if ($count_product_id > 10)
        $count_product_id = 10;
    $max = rand(0, $count_product_id);

    shuffle($productIds);
    $cross_sell = array();
    for ($i = 0; $i < $max; $i++) {
        $cross_sell[$productIds[$i]] = array('position' => $i);
    }
    if (count($cross_sell))
        $product->setCrossSellLinkData($cross_sell);
//
    shuffle($productIds);
    $up_sell = array();
    for ($i = 0; $i < $max; $i++) {
        $up_sell[$productIds[$i]] = array('position' => $i);
    }
    if (count($up_sell))
        $product->setUpSellLinkData($up_sell);

    shuffle($productIds);
    $related = array();
    for ($i = 0; $i < $max; $i++) {
        $related[$productIds[$i]] = array('position' => $i);
    }
    if (count($related))
        $product->setRelatedLinkData($related);
//  $product->getLinkInstance()->useRelatedLinks();



    $product->setWebsiteIDs(array(1));
    $product->setStoreIDs(array(0, 1, 2));

    $product->setShortDescription($small_description);

    $product->setCategoryIds($category_ids_rand_chunked);
    $product->setTaxClassId('2');

    $selectedManufacture = $manufactureIds[rand(0, count($manufactureIds) - 1)];
    $product->setData('manufacturer', intval($selectedManufacture['id']));
    $product->setCreatedAt(date('Y-m-d', strtotime(rand(1, 27) . '-' . rand(1, 12) . '-' . rand(2010, 2012))));

    /**
     *  IMAGE !!
     */
    $visibility = array(
        'thumbnail',
        'small_image',
        'image'
    );
    try {


        $product->setMediaGallery(array('images' => array(), 'values' => array()));
        if (file_exists($source = realpath(Mage::getBaseDir('media') . DS . 'import' . DS . $images[rand(0, $images_count - 1)]))) {
            $product->addImageToMediaGallery($source, array('image'), false, false);
        }
        if (file_exists($source = realpath(Mage::getBaseDir('media') . DS . 'import' . DS . $images[rand(0, $images_count - 1)]))) {
            $product->addImageToMediaGallery($source, array('small_image'), false, false);
        }
        if (file_exists($source = realpath(Mage::getBaseDir('media') . DS . 'import' . DS . $images[rand(0, $images_count - 1)]))) {
            $product->addImageToMediaGallery($source, array('thumbnail'), false, false);
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }





    // également possible d'utiliser les setters
    $product->validate(); // valider les valeurs des attributs !
    // sauver le nouveau produit (insère en base de données)

    try {
        $product->save();
        $productIds[] = $product->getId();
    } catch (Exception $e) {
        echo $e->getMessage();
        continue;
        //handle your error
    }

    $stockItem = Mage::getModel('cataloginventory/stock_item');
    $stockItem->assignProduct($product);
    $stockItem->setData('is_in_stock', 1);
    $stockItem->setData('stock_id', 1);
    $stockItem->setData('store_id', 1);
    $stockItem->setData('manage_stock', 1);
    $stockItem->setData('qty', rand(2,10));
    $stockItem->setData('use_config_manage_stock', 0);
    $stockItem->setData('min_sale_qty', 0);
    $stockItem->setData('use_config_min_sale_qty', 0);
    $stockItem->setData('max_sale_qty', 1000);
    $stockItem->setData('use_config_max_sale_qty', 0);
    $stockItem->save();


    echo "**************************************************\n* " . $product->getName() . "\n";
    echo '* ID : ' . $product->getId() . "\n";
    echo '* SKU : ' . $product->getSku() . "\n";
    if (file_exists($source)) {
        echo '* image Source : ' . $source . "\n";
        echo '* <img src="' . Mage::helper('catalog/image')->init($product, 'small_image')->resize(30) . '"/> <br />';
        echo '* Image name : ' . $product->getData('image') . "\n";
    }
    echo '* Category IDS : ' . implode(', ', $category_ids_rand_chunked) . "\n";
    echo '* cross_sell : ' . implode(', ', array_keys($cross_sell)) . "\n";
    echo '* up_sell : ' . implode(', ', array_keys($up_sell)) . "\n";
    echo '* Related : ' . implode(', ', array_keys($related)) . "\n";
    echo '* Brand : ' . $selectedManufacture['name'] . "\n";


    if ($product->getData('mon_attribut'))
        echo " * MON ATTRIBUT \n";

    echo '* Type : ' . $type . "\n";
    echo '* CreatedAt : ' . $product->getCreatedAt() . "\n";
    if ($type == 'promo') {
        echo '* getSpecialFromDate : ' . $product->getSpecialFromDate() . "\n";
        echo '* getSpecialtoDate   : ' . $product->getSpecialtoDate() . "\n";
        echo '* getSpecialPrice    : ' . $product->getSpecialPrice() . "\n";
    }
    echo "**************************************************\n\n";
    echo '<script type="text/javascript">dh=document.body.scrollHeight;ch=document.body.clientHeight;if(dh>ch){moveme=dh-ch;window.scrollTo(0,moveme);}</script>';
    ob_flush();
    flush();
}


echo '<script type="text/javascript">dh=document.body.scrollHeight;ch=document.body.clientHeight;if(dh>ch){moveme=dh-ch;window.scrollTo(0,moveme);}</script>';
ob_flush();
flush();
?>


>>>>>>>>>> DONE
<br />
</body>
</html>