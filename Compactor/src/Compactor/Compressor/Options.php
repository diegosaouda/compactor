<?php

/**
 * Classe de configuração do compressor
 * @author Diego Saouda <diego.saouda@gmail.com>
 * @package Common
 * @subpackage Compressor
 */

namespace Compactor\Compressor;
use RuntimeException;

class Options
{
	/**@var bool*/
	private $combine;
	
	/**
	 * Nome do arquivo usado para combinar os css/js
	 * @var string
	 */
	private $combinedFilename;
	
	/**@var string*/
	private $tempDirectory;
	
	/**
	 * Caminho do compressor
	 * @var string;
	 */
	private $yuicompressor;
	
	/**
	 * @param array $options
	 */
	public function __construct(array $options = array())
	{
		if (count($options) > 0) {
			$this->exchangeArray($options);
		}
	}
	
	/**
	 * @param array $options
	 */
	public function exchangeArray(array $options)
	{
		$this->setCombinedFilename($options['combined_filename']);
		$this->setYuiCompressor($options['yuicompressor']);
		$this->setTempDirectory($options['temp_directory']);
		$this->setCombine($options['combine']);
	}
	
	/**
	 * Nome do arquivo combinado
	 * @param string $combinedFilename
	 * @return Options
	 */
	public function setCombinedFilename($combinedFilename)
	{
		$this->combinedFilename = $combinedFilename;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getCombinedFilename()
	{
		return $this->combinedFilename;
	}
	
	/**
	 * Seta o compressor
	 * @param string $yuicompressor
	 * return Options
	 */
	public function setYuiCompressor($yuicompressor)
	{
		$this->yuicompressor = $yuicompressor;
		return $this;
	}
	
	/**
	 * Get o Compressor Yui
	 * return string
	 */
	public function getYuiCompressor()
	{
		return $this->yuicompressor;
	}
	
	/**
	 * Seta o diretório dos min
	 * @param string $dir
	 * @return Options
	 */
	public function setTempDirectory($dir)
	{
		if (!is_dir($dir)) {
			if (@mkdir($dir, 0777, true)) {
				throw new RuntimeException('Diretório não pode ser criado');
			}
		}
		
		$this->tempDirectory = $dir;
		return $this;
	}
	
	/**
	 * Retorna o diretório temporário de gravação do arquivo
	 * @return string
	 */
	public function getTempDirectory()
	{
		return $this->tempDirectory;
	}
	
	
	
	/**
	 * Deve combinar os arquivos ?
	 * @param bool $bool
	 * @return Compressor
	 */
	public function setCombine($bool = true)
	{
		$this->combine = $bool;
		return $this;
	}
	
	/**
	 * Tem que combinar os arquivos ?
	 * @return bool
	 */
	public function hasCombine()
	{
		return $this->combine;
	}
	
	
	
}