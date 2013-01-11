<?php /********************************************

		Image Resizer for Fuel PHP
		by: Maiko Gabriel Kinzel Engelke
		date: 2013-11-01

		Usage:
        	echo \Uri::base().'images/<argument>/<path/to.file>';
			Ex: http://localhost/site/public/images/h500/img/layout/logo.png


		Default variables:
			$base_path = 'assets/';
			$cache_path = 'img/cache/';
			Which will create images at site/public/assets/img/cache/<size>/<path/to/file.jpg>
											(It is fixed for jpg, but it's not hard to change it)
		
		Argument:
			Height: h<numeric value>
				ex: h200. h530, h1024;
			Width: w<numeric value>
				ex: w240. w480, w720;

***************************************************/
class Controller_Images extends Controller
{

	private $base_path = 'assets/';
	private $cache_path = 'img/cache/';

	public function action_index()
	{
    	$arg = func_get_args();

		$size = $arg[0];
		unset($arg[0]);

		$path = implode($arg,'/');

		$this->cache_path .= $size.'/';

		if(file_exists($this->base_path.$this->cache_path.'/'.$path.'.jpg')){
			Image::load($this->base_path.$this->cache_path.'/'.$path.'.jpg')
				 ->output();
		} else {
			$ext = array('jpg','png','gif');
			$extension = false;
			//$path = str_replace('/', '\\', $path);
			for($i=0;$i<3;++$i){
				if(file_exists($this->base_path.$path.'.'.$ext[$i])){
					$extension = $ext[$i];
					break;
				}
			}
			if(!$extension){
				die('file not found');
			}

			$sizes = Image::load($this->base_path.$path.'.'.$extension)->sizes();

			$this->calculate_size($size,$sizes);

			$path = $this->check_path($this->base_path.$this->cache_path.$path.'.jpg');
			Image::save($path)
				 ->load($path)
				 ->output('jpg');
			
		}
	}
	private function check_path($path){
		$justPath = implode('/',explode('/',$path,-1));

		if(!file_exists($justPath)){
			if(!mkdir($justPath,0775,true)){
				die('Folder couldn\'t be created');
			}
		}
		return $path;
	}
	private function calculate_size($parameter,$current){
		switch(substr($parameter, 0,1)){
			case 'w':
				$size['width'] = intval(substr($parameter,1));
				if($size['width'] > $current->width)
					$size['width'] = $current->width;
				Image::resize($size['width']);
				//$size['width'] = intval(substr($parameter,1));
				//$size['height'] = ceil(($size['width'] * $current->height) / $current->width);
			break;
			case 'h':
				$size['height'] = intval(substr($parameter,1));
				if($size['height'] > $current->height)
					$size['height'] = $current->height;
				Image::resize(null,$size['height']);
				//$size['height'] = intval(substr($parameter,1));
				//$size['width'] = ceil(($size['height'] * $current->width) / $current->height);

			break;
			default:
				die("incorrect arguments");
		}
		//return $size;
	}
}