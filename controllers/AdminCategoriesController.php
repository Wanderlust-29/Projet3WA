<?php

class AdminCategoriesController extends AbstractController
{
    /**
     * Renders the page displaying all categories.
     */
    public function categories(): void
    {
        $cm = new CategoryManager();
        $categories = $cm->findAll();
        $this->render("admin/admin-categories.html.twig", [
            'categories' => $categories,
        ]);
    }

    /**
     * Renders the page displaying a single category based on ID.
     * @param int $id The ID of the category to display.
     */
    public function category(int $id): void
    {
        $cm = new CategoryManager();
        $category = $cm->findOne($id);

        $this->render("admin/admin-category.html.twig", [
            'category' => $category,
        ]);
    }

    /**
     * Renders the page for creating a new category.
     */
    public function newCategory(): void
    {
        $this->render("admin/admin-new-category.html.twig", []);
    }

    /**
     * Handles the insertion of a new category into the database.
     * Redirects to the new category page upon success.
     */
    public function addCategory(): void
    {
        if (isset($_POST['name']) && isset($_POST['description'])) {
            $slug = $this->slugify($_POST['name']);
            $cm = new CategoryManager();
            $category = new Category($_POST['name'], $_POST['description'], $slug);
            $insert = $cm->insert($category);
            if (!$insert) {
                $type = 'error';
                $text = "Un problème est survenu lors de la mise à jour 😞";
                $url = url('newCategory');
            } else {
                $type = "success";
                $text = "La mise à jour a bien été effectuée 😃";
                $url = url('category', ['id' => $insert]);
            }
        } else {
            $type = 'error';
            $text = "Il manque des champs 🙄";
            $url = url('newCategory');
        }

        $this->notify($text, $type);
        $this->redirect($url);
    }

    /**
     * Handles the update of an existing category in the database.
     * Redirects to the updated category page upon success.
     */
    public function updateCategory(): void
    {
        $id = (int) $_POST['id'];
        if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['description']) && isset($_POST['slug'])) {
            $category = new Category($_POST['name'], $_POST['description'], $_POST['slug']);
            $category->setId($_POST['id']);
            $cm = new CategoryManager();
            $update = $cm->update($category);
            if (!$update) {
                $type = 'error';
                $text = "Un problème est survenu lors de la mise à jour 😞";
            } else {
                $type = "success";
                $text = "La mise à jour a bien été effectuée 😃";
            }
        } else {
            $type = 'error';
            $text = "Il manque des champs 🙄";
        }

        $this->notify($text, $type);
        $this->redirect(url('category', ['id' => $id]));
    }
}
