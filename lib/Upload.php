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
     * Uploaded file size, in bytes
     *
     * @access private
     * @var double
     */
    private $file_src_size;

    /**
     * Uploaded file size, in bytes
     *
     * @access private
     * @var array
     */
    private $file_src_errors = array();

    /**
     * File source temp
     * @var string 
     */
    private $file_src_temp;

    /**
     * Set this variable to change the maximum size in bytes for an uploaded file
     *
     * Default value is the value <i>upload_max_filesize</i> from php.ini
     *
     * @access private
     * @var double
     */
    private $get_file_max_size = 8000000;

    /**
     * 
     * @param type $img
     * @return boolean
     */
    public function __construct($img) {
        $file = $_FILES[$img];

        if (!isset($file)) {
            $this->error = 'image can not be loaded, Please check the input name if it is equal to the constructor parameter of the class or check for the tag in the form enctype="multipart/form-data"';
            $this->was_uploaded = false;
            return false;
        }

        // extract info from file uploaded
        $this->file_src_name = $file["name"];
        $this->file_src_temp = $file["tmp_name"];
        $this->file_src_size = $file["size"];
        $this->file_src_errors = $file['error'];
        $this->file_src_name_ext = pathinfo($file["name"], PATHINFO_EXTENSION);
        $this->was_uploaded = true;
        return true;
    }

    /**
     * Run application
     * @return boolean
     */
    public function run() {

        $path = $this->upload_to . $this->file_src_name;

        $this->check_size_max();
        $this->PathValid();
        $this->check_exist($path);

        if ($this->was_uploaded) {
            if (move_uploaded_file($this->file_src_temp, $path)) {
                return true;
            } else {
                $this->was_uploaded = false;
                $this->error = 'was not possible to send the file.';
                return false;
            }
        }
    }

    /**
     * which the permission of the directory
     * @return boolean
     */
    private function PathValid() {
        clearstatcache();
        $permission = substr(sprintf('%o', fileperms($this->upload_to)), -4);

        if ($permission !== '0777') {
            $this->was_uploaded = false;
            $this->error = 'Permission denied, permission required 0777 to the directory, current permission is ' . $permission;
            return false;
        }
        return true;
    }

    /**
     * Check exist file
     * @return boolean
     */
    private function check_exist($path) {
        if (file_exists($path)) {
            $this->was_uploaded = false;
            $this->error = $this->file_src_name . ' already exists. Please change the file name';
            return false;
        }
        return true;
    }

    /**
     * Checks the maximum file size allowed
     * @return boolean
     */
    private function check_size_max() {
        if ($this->file_src_size > $this->get_file_max_size) {
            $this->error = 'File too big Original Size : ' . $this->file_src_size . ' File size limit : ' . $this->get_file_max_size;
            $this->was_uploaded = false;
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
     * Define file max size allowed
     * @param int $size Size in Bytes
     * @return \Upload
     */
    public function file_max_size($size) {
        $this->get_file_max_size = (int) $size;
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
