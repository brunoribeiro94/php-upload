<?php

class Upload {

    /**
     * Indicates if the file has been uploaded properly
     * 
     * @var boolean
     */
    var $was_uploaded;

    /**
     * Holds eventual error message in plain english
     *
     * @access public
     * @var string
     */
    var $error;

    /**
     * filename
     * @var string 
     */
    private $file_src_name;

    /**
     * file extension
     * @var string 
     */
    private $file_src_name_ext;

    /**
     * File size
     * @var int 
     */
    private $file_src_size;

    /**
     * File source temp
     * @var string 
     */
    private $file_src_temp;

    /**
     * 
     * @param type $img
     * @return boolean
     */
    public function __construct($img) {
        $file = $_FILES[$img];

        if (!isset($file)) {
            $this->error = 'image field not loaded.';
            $this->was_uploaded = false;
            return false;
        }
        // extract info from file uploaded
        $this->file_src_name = $file["name"];
        $this->file_src_temp = $file["tmp_name"];
        $this->file_src_size = $file["size"];
        $this->file_src_name_ext = pathinfo($file["name"], PATHINFO_EXTENSION);
        return true;
    }

    /**
     * Run application
     * @return boolean
     */
    public function run() {
        if ($this->was_uploaded) {
            self::check_size_max();
            self::check_exist();
            if (move_uploaded_file($this->file_src_temp, $this->upload_to . $this->file_src_name)) {
                return true;
            } else {
                $this->was_uploaded = false;
                $this->error = 'was not possible to send the file.';
                return false;
            }
        }
    }

    /**
     * Check exist file
     * @return boolean
     */
    private static function check_exist() {
        if (file_exists($this->upload_to . basename($this->file_src_name))) {
            $this->was_uploaded = false;
            $this->error = $this->file_src_name . ' already exists. Please change the file name';
            return true;
        }
        return false;
    }

    /**
     * Checks the maximum file size allowed
     * @return boolean
     */
    private static function check_size_max() {
        if ($this->file_src_name > $this->file_max_size) {
            $this->was_uploaded = false;
            $this->error = 'File too big';
            return false;
        }
        return true;
    }

    /**
     * Final name of the uploaded file.
     * @param string $file_name filename
     * @return \Upload
     */
    public function file_name($file_name) {
        $this->file_name = $file_name;
        return $this;
    }

    /**
     * File max size allowed
     * @param int $size Size in MB
     * @return \Upload
     */
    public function file_max_size($size = 8) {
        $this->file_max_size = (int) $size;
        return $this;
    }

    /**
     * set path location
     * @param string $path Path location of the uploaded file, with an ending slash
     * @return \Upload
     */
    public function upload_to($path) {
        $this->upload_to = $path;
        return $this;
    }

}
