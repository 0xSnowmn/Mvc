<?php
namespace Mvc\Lib;

class FileUpload {
    private $name;
    private $size;
    private $type;
    private $error;
    private $File_ex;
    private $tmp_name;
    private $maxSize = 104;
    private $ex_allowed = [
        'jpg', 'png', 'gif'
    ];

    public function __construct(array $file) {
        $this->name = $file['name'];
        $this->size = $file['size'];
        $this->type = $file['type'];
        $this->error = $file['error'];
        $this->tmp_name = $file['tmp_name'];
        $this->name();
    }

    private function getType() {
        $ex = strtolower($this->name);
        $ex = explode('.',$this->name);
        $ex = end($ex);
        $this->File_ex = $ex;
        return $ex;
    }

    public function isImage() {
        return preg_match('/image/i', $this->type);
    }

    public function getFileName() {
        return $this->name;
    }

    private function name() {
        // TODO:: Make a function to genrate a random 25 letter
        $name = base64_encode($this->name . rand() . time());
        $name = strtolower(substr($name,0,24));
        $this->name = $name . '.' . $this->getType();
    }

    private function isAllowType() {
        return in_array($this->File_ex,$this->ex_allowed);
    }

    private function isAllowSize() {
        preg_match_all('/(\d+)([MG])$/i', MAX_SIZE_UPLOAD, $m);
        $maxFileSizeToUpload = $m[1][0];
        $sizeUnit = $m[2][0];
        $currentFileSize = ($sizeUnit == 'M') ? ($this->size / 1024 / 1024) : ($this->size / 1024 / 1024 / 1024);
        $currentFileSize = ceil($currentFileSize);
        return (int) $currentFileSize > (int) $this->maxSize;
    }

    public function upload() {
        if($this->error != 0) {
            throw new \Exception('Sorry file didn\'t upload successfully');
        } elseif(!$this->isAllowType()) {
            throw new \Exception('Sorry files of type ' . $this->File_ex .  ' are not allowed');
        } elseif ($this->isAllowSize()) {
            throw new \Exception('Sorry the file size exceeds the maximum allowed size');
        } else {
            $uploadFolder = $this->isImage() ? IMAGE_FOLDER : DOCUMENT_FOLDER;
            if(is_writable($uploadFolder)) {
                move_uploaded_file($this->tmp_name,$uploadFolder . $this->name);
            } else {
                throw new \Exception('Sorry the destination folder is not writable');
            }
        }

    }
}