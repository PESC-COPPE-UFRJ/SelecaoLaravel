<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	
	protected function checkValidExtension ($extension)
	{		
		$extension = strtolower($extension);
		if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'pdf')
		{			
			return true;
		}
		return false;		
	}
	
	protected function checkValidFileExtension ($file)
	{		
		$extension = $file->getClientOriginalExtension(); // getting image extension
		return $this->checkValidExtension($extension);
	}
	
	protected function uploadImage($img, $folder)
	{		
		
		$upload_success = false;
		
		if ($this->checkValidFileExtension($img))
		{		
			//$destinationPath = public_path() . '/uploads/hoteis/';
			$destinationPath = "uploads/$folder";

			if (!file_exists($destinationPath))
			{
				mkdir($destinationPath, 0755, true);
			}

			// se último caracter não for uma barra, insere uma
			if (substr($destinationPath, -1) != '/')
				$destinationPath = $destinationPath . '/';

			$filename = $img->getClientOriginalName();
			$originalname = $filename;

			// Se arquivo existe renomeia com número sequencial
			$i = 1;
			while(file_exists($destinationPath . $filename))
			{
				$filename = $i . '_' . $originalname;
				$i++;
			}

			$upload_success = $img->move($destinationPath, $filename);
		}

        if ($upload_success) 
        {
	        return array('filename' => $filename, 'destinationPath' => $destinationPath);
        }
        else
        {
        	return false;
        }
	}
	
	/// Apaga diretório e todos arquivos e sub-diretórios recursivamente
	protected function deleteDirectory($dir)
	{
    	if (!file_exists($dir))
		{
        	return true;
    	}

    	if (!is_dir($dir))
		{
        	return unlink($dir);
    	}

    	foreach (scandir($dir) as $item)
		{
        	if ($item == '.' || $item == '..')
			{
            	continue;
        	}

        	if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item))
			{
            	return false;
        	}
    	}
		
    	return rmdir($dir);
	}	

}
