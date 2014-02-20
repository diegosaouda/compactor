<?php

/**
 * Geração do Json em Array
 * @author Diego Saouda <diego.saouda@gmail.com>
 * @package Compactor
 * @subpackage Common
 */

namespace Compactor\Common;

use \InvalidArgumentException;

class Json
{
	
	/**
	 * @param string $file
	 */
	public static function decodeToArray($file)
	{
		$json = json_decode(@file_get_contents($file));
		if (!$json) {
			throw new InvalidArgumentException("{$file} não é válido");
		}
		
		return (array) $json;
	}
	
	
	
}