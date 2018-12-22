<?php
namespace Mvc\Controllers;

use Mvc\Lib\FileUpload;
use Mvc\Lib\Helper;
use Mvc\Lib\InputFilter;
use Mvc\Lib\Messenger;
use Mvc\Lib\Validate;
use Mvc\Models\PrivilegeModel;
use Mvc\Models\ProductCategoryModel;
use Mvc\Models\UserGroupModel;
use Mvc\Models\UserGroupPrivilegeModel;

class ProductCategroiesController extends AbstractController
{
    use InputFilter;
    use Helper;
    use Validate;
    private $_createActionRoles =
        [
        'Name' => 'req|alphanum|between(3,30)'
    ];
    public function defaultAction()
    {
        $this->language->load('productcategroies|default');
        $this->data['categories'] = ProductCategoryModel::getAll();
        $this->_view();
    }
    public function createAction()
    {
        $this->language->load('productcategroies|create');
        $this->language->load('productcategroies|labels');
        $this->language->load('productcategroies|messages');
        $this->language->load('validation|error');
        $uploadError = false;
        // TODO:: explain a better solution to check against file type
        // TODO:: explain a better soution to secure the upload folder
        if (isset($_POST['submit']) && $this->valid($this->_createActionRoles, $_POST)) {
            $category = new ProductCategoryModel();
            $category->Name = $this->filt_str($_POST['Name']);
            if (!empty($_FILES['image']['name'])) {
                $uploader = new FileUpload($_FILES['image']);
                $uploader->upload();
                try {
                    $uploader->upload();
                    $category->Image = $uploader->getFileName();
                } catch (\Exception $e) {
                    $this->messenger->add($e->getMessage(), MESSAGE_ERROR);
                    $uploadError = true;
                }
            }
            if ($uploadError === false && $category->save()) {
                $this->messenger->add($this->language->get('message_create_success'));
                $this->Redirect('/productcategroies');
            } else {
                $this->messenger->add($this->language->get('message_create_failed'), MESSAGE_ERROR);
            }
        }
        $this->_view();
    }
    public function editAction()
    {
        $id = $this->filt_int($this->params[0]);
        $category = ProductCategoryModel::getByPK($id);
        if ($category === false) {
            $this->Redirect('/productcategroies');
        }
        $this->language->load('productcategroies|edit');
        $this->language->load('productcategroies|labels');
        $this->language->load('productcategroies|messages');
        $this->language->load('validation|error');
        $this->data['category'] = $category;
        $uploadError = false;
        if (isset($_POST['submit'])) {
            $category->Name = $this->filt_str($_POST['Name']);
            if (!empty($_FILES['image']['name'])) {
                // Remove the old image
                if ($category->Image !== '' && file_exists(IMAGES_UPLOAD_STORAGE | DS | $category->Image) && is_writable(IMAGES_UPLOAD_STORAGE)) {
                    unlink(IMAGES_UPLOAD_STORAGE | DS | $category->Image);
                }
                // Create a new image
                $uploader = new FileUpload($_FILES['image']);
                try {
                    $uploader->upload();
                    $category->Image = $uploader->getFileName();
                } catch (\Exception $e) {
                    $this->messenger->add($e->getMessage(), MESSAGE_ERROR);
                    $uploadError = true;
                }
            }
            if ($uploadError === false && $category->save()) {
                $this->messenger->add($this->language->get('message_create_success'));
                $this->Redirect('/productcategroies');
            } else {
                $this->messenger->add($this->language->get('message_create_failed'), MESSAGE_ERROR);
            }
        }
        $this->_view();
    }
    public function deleteAction()
    {
        $id = $this->filt_int($this->_params[0]);
        $category = ProductCategoryModel::getByPK($id);
        if ($category === false) {
            $this->Redirect('/productcategroies');
        }
        $this->language->load('productcategroies|messages');
        if ($category->delete()) {
            // Remove the old image
            if ($category->Image !== '' && file_exists(IMAGES_UPLOAD_STORAGE | DS | $category->Image)) {
                unlink(IMAGES_UPLOAD_STORAGE | DS | $category->Image);
            }
            $this->messenger->add($this->language->get('message_delete_success'));
        } else {
            $this->messenger->add($this->language->get('message_delete_failed'));
        }
        $this->Redirect('/productcategroies');
    }
}