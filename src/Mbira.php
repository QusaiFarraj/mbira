<?php

namespace Qusai;


use \FancyService\Client;


class Mbira
{
	public function retriveProduct($upc)
	{
		$client = new Client(\Mbira\Config::get('FancyService'));
		return $client->submit($upc);
	}

	public function saveReceivedProduct($product)
	{
		$pdo = \Mbira\DbConnection::getInstance();

		$stmt = $pdo->prepare('INSERT INTO fancyservice_product_info(upc, name, description, created_at) values (:upc, :name, :description, :created_at)');

        $objDateTime = new DateTime('NOW');
        $currentTime = $objDateTime->format('c');

        $result = $stmt->execute([$upc, $product['prod_name'], $product['prod_desc'], $currentTime]);

        return $result;
	}
}