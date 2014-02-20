<?php

/**
 * Auxilia no Min de Css e Js usando a ferramento YUI Compressor
 * @author Diego Saouda <diego.saouda@gmail.com>
 * @package Compactor
 */

namespace Compactor;

use Compactor\Compressor\Options;
use InvalidArgumentException;

class Compressor
{
	/**@var array*/
	private $files = array();
	
	/**@var Options*/
	private $options;
	
	/**
	 * Seta as configurações
	 * @param Options $options
	 */
	public function __construct(Options $options)
	{
		$this->options = $options;
	}
	
	/**
	 * Recebe os arquivos a serem minificados
	 * @param string $filename
	 * @return Compressor
	 */
	public function addFile($filename) 
	{
		$realpath = realpath($filename);
		
		if (! $realpath) {
			throw new InvalidArgumentException(sprintf(
				'Arquivo não é valido: %s', $filename));
		}
		
		$md5Path = md5($realpath);
		if (array_key_exists($md5Path, $this->files)) {
			throw new InvalidArgumentException('Arquivo duplicado');
		}
		
		$this->files[$md5Path] = $realpath;
		return $this;
	}
	
	/**
	 * Compress realiza o trabalho de minificação
	 */
	public function compress()
	{
		foreach ($this->files as $file) {
			$basename = basename($file);
			$compress = "{$this->options->getTempDirectory()}/$basename";
			
			echo "\ncompress: {$file}";
			echo `java -jar {$this->options->getYuiCompressor()} $file -o $compress`;
			
			if ($this->options->hasCombine()) {
				$this->runCombine($basename, $compress);
				unlink($compress); //deleta arquivo já combinado
			}
			
			echo " [finish]";
		}
	}
	
	/**
	 * @param string $basename Nome do arquivo que foi compressado
	 * @param string $compress Path Arquivo compress
	 */
	private function runCombine($basename, $compress)
	{
		$extension = strrchr($basename, '.');
		echo " [combine]";

		$content = file_get_contents($compress);
		file_put_contents(
			"{$this->options->getTempDirectory()}/{$this->options->getCombinedFilename()}{$extension}"
			, PHP_EOL . $content
			, FILE_APPEND
		);
		
	}
	
}