<?php
/*
 * ©2013, Lead Pepelats ( http://lead-pepelats.ru/ )
 */

class NicEdit {

	private $docRoot;
	private $path = '';
	private $file;
	private $error = '';
	private $imgTypes = array(1 => 'GIF', 2 => 'JPG', 3 => 'PNG', 6 => 'BMP');
	private $imgs = array('image/jpeg' => 'jpg', 'image/pjpeg' => 'jpg', 'image/x-png' => 'png', 'image/png' => 'png', 'image/gif' => 'gif', 'image/bmp' => 'bmp');
	private $uploadErr = array(
		1 => 'Размер принятого файла изображения превысил максимально допустимый размер, который задан директивой upload_max_filesize конфигурационного файла php.ini',
		2 => 'Размер загружаемого файла изображения превысил значение MAX_FILE_SIZE, указанное в HTML-форме',
		3 => 'Загружаемый файл изображения был получен только частично',
		4 => 'Файл изображения не был загружен',
		5 => 'Отсутствует временная папка',
		6 => 'Не удалось записать файл изображения на диск'
	);

	public function __construct($docRoot = false) {
		$this->docRoot = trim($docRoot);
	}
	
	public function imanager() {
		if (!$this->docRoot)
			return false;
		if (@$_POST['path'])
			$this->path = str_replace(str_replace('\\', '/', $this->docRoot), '', str_replace('\\', '/', realpath($this->docRoot . '/' . $_POST['path']))) . '/';
		$this->file = @$_FILES['nicImage'];
		if ($this->file)
			return $this->upload();
		elseif ($this->path)
			return $this->getImgList();
	}

	private function upload() {
		if ($this->file['error'] && $this->file['error'] != 4)
			$this->error = $this->uploadErr[$this->file['error']];
		if (!$this->file['error'] && !isset($this->imgs[$this->file['type']]))
			$this->error = 'Неподдерживаемый формат файла для изображения';
		if (!$this->error && !$this->file['error']) {
			$tmp = split("\.", $this->file['name']);
			$ext = strtolower($tmp[sizeof($tmp) - 1]);
			unset($tmp[sizeof($tmp) - 1]);
			$file_name = $this->translit(implode('.', $tmp)) . '.' . $ext;
			if (!move_uploaded_file($this->file['tmp_name'], $this->docRoot . $this->path . '/' . $file_name))
				$this->error = 'Не удалось переместить загруженный файл';
		}
		$result = "{\r\n";
		$result .= '	status: "' . ($this->error ? 'error' : 'successful') . '",' . "\r\n";
		$result .= '	message: "' . ($this->error ? $this->error : 'Файл `' . htmlspecialchars($file_name) . '` успешно загружен') . '"' . "\r\n";
		$result .= "}";
		return print($result);
	}

	private function getImgList() {
		$folders = array();
		$files = array();
		$path_full = realpath($this->docRoot . '/' . $this->path);
		if (is_dir($path_full)) {
			$dh = opendir($path_full);
			while ($fn = readdir($dh)) {
				if (is_file($path_full . '/' . $fn)) {
					$imgInfo = @getimagesize($path_full . '/' . $fn);
					if (isset($this->imgTypes[$imgInfo[2]]))
						$files[] = array($fn, strtolower($this->imgTypes[$imgInfo[2]]));
				} elseif ($fn != '.' && $fn != '..' && is_dir($path_full . '/' . $fn))
					$folders[] = $fn;
				elseif ($fn == '..' && $this->path && $this->path != '/')
					$folders[] = $fn;
			}
			closedir($dh);
			sort($folders);
			sort($files);
			$items = array();
			foreach ((array) $folders as $v) {
				$item = '		{' . "\r\n";
				$item .= '			type: "folder",' . "\r\n";
				$item .= '			name: "' . $v . '"' . "\r\n";
				$item .= '		}';
				$items[] = $item;
			}
			foreach ((array) $files as $v) {
				$item = '		{' . "\r\n";
				$item .= '			type: "file",' . "\r\n";
				$item .= '			name: "' . $v[0] . '",' . "\r\n";
				$item .= '			ext: "' . $v[1] . '"' . "\r\n";
				$item .= '		}';
				$items[] = $item;
			}
			$json = '{' . "\r\n";
			$json .= '	error: "' . $this->error . '",' . "\r\n";
			$json .= '	path: "' . str_replace('\\', '/', $this->path) . '",' . "\r\n";
			$json .= '	items: [' . "\r\n";
			$json .= implode(",\r\n", $items) . "\r\n";
			$json .= '	]' . "\r\n";
			$json .= '}';
			return print($json);
		}
	}

	private function translit($st) {
		$a = array_merge(array_combine(preg_split('//u', "абвгдеёзийклмнопрстуфхцьыэАБВГДЕЁЗИЙКЛМНОПРСТУФХЦЬЫЭabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_"), preg_split('//u', "abvgdeeziyklmnoprstufhc'ieABVGDEEZIYKLMNOPRSTUFHC'IEabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_")), array("ж" => "zh", "ч" => "ch", "ш" => "sh", "щ" => "shch", "ъ" => "", "ю" => "yu", "я" => "ya", "Ж" => "Zh", "Ч" => "Ch", "Ш" => "Sh", "Щ" => "Shch", "Ъ" => "", "Ю" => "Yu", "Я" => "Ya"));
		$r = preg_split('//u', $st);
		$out = '';
		foreach ($r as $v) {
			if (isset($a[$v]))
				$out .= $a[$v];
		}
		return $out;
	}

}

?>