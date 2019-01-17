<?php
/**
 * User: utku
 * Date: 17.11.2017
 * Web : http://www.utkukutlu.com
 */

namespace system\helper;


class Upload {

    private $dir, $size, $type, $inputName;


    public function setInputName($inputName) {
        $this->inputName = $inputName;
        return $this;
    }

    public function setDir($dir = "") {
        $this->dir = $dir;
        return $this;
    }

    public function setSize($size = 1) {
        $this->size = $size * 1024;
        return $this;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function upload() {
        $target_dir = UPLOAD_DIR . "/" . $this->dir . "/";
        $target_dir = str_replace("/", DIRECTORY_SEPARATOR, $target_dir);
        $target_file = $target_dir . basename($_FILES[$this->inputName]["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (file_exists($target_file)) {
            $uploadOk = 0;
            return "file already exists.";
        }
        if ($_FILES[$this->inputName]["size"] > $this->size) {
            $uploadOk = 0;
            return "max Upload File Size:" . $this->size / 1024 . "KB .";
        }
        if (strlen(array_search($fileType, $this->type)) === 0) {
            echo "only " . implode(" , ", $this->type) . " files are allowed.";
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            return "not uploaded";
        } else {
            if (move_uploaded_file($_FILES[$this->inputName]["tmp_name"], $target_file)) {
                return true;
            } else {
                return false;
            }
        }
    }

}
