<?php
class AdminCategoriesController extends AbstractController
{
    // all categories
    public function categories()
    {
        $cm = new CategoryManager();
        $categories = $cm->findAll();
        $this->render("admin/admin-categories.html.twig", [
            'categories' => $categories,
        ]);
    }

    // Single category
    public function category(int $id){
        $cm = new CategoryManager();
        $category = $cm->findOne($id);

        $this->render("admin/admin-category.html.twig", [
            'category' => $category,
        ]);
    }

    // New category
    public function newCategory(){
        $this->render("admin/admin-new-category.html.twig",[]);
    }


    // Insert
    public function addCategory(){
        if(isset($_POST['name']) && isset($_POST['description'])){
            $slug = $this->slugify($_POST['name']);
            $cm = new CategoryManager();
            $categorie = new Category($_POST['name'], $_POST['description'], $slug);
            $insert = $cm->insert($categorie);
            if(!$insert){
                $type = 'error';
                $text = "Un problème est survenu lors de la mise à jour 😞";
                $url = url('newCategory');
            }else{
                $type= "success";
                $text = "La mise à jour a bien été effectuée 😃";
                $url = url('category',['id'=>$insert]);
            }
        }else{
            $type = 'error';
            $text = "Il manque des champs 🙄";
            $url = url('newCategory');
        }

        $this->notify($text,$type);
        $this->redirect($url);
    }

    // Update
    public function updateCategory(){
        $id = (int) $_POST['id'];
        if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['description']) && isset($_POST['slug'])){
            $cat = new Category($_POST['name'],$_POST['description'],$_POST['slug']);
            $cat->setId($_POST['id']);
            $cm = new CategoryManager();
            $update = $cm->update($cat);
            if(!$update){
                $type = 'error';
                $text = "Un problème est survenu lors de la mise à jour 😞";
            }else{
                $type= "success";
                $text = "La mise à jour a bien été effectuée 😃";
            }
        }else{
            $type = 'error';
            $text = "Il manque des champs 🙄";
        }

        $this->notify($text,$type);
        $this->redirect(url('category',['id'=>$id]));
    }

}
