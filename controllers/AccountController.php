<?php

class AccountController extends AbstractController
{
    public function account() : void
    {
        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;
        $session = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

        $sessionId = null;
        $orders = [];
        $ordersArticles = [];
    
        if(isset($_SESSION["user"]) && $_SESSION["user"] instanceof User) {
            $sessionId = $_SESSION["user"]->getId();
            $om = new OrderManager();
            $orders = $om->findByUserId($sessionId);
            $ordersArticles = [];
    
            foreach ($orders as $order) {
                $orderId = $order->getId();
                $oAm = new OrderArticleManager();
                $orderArticles = $oAm->findByOrderId($orderId);
                $ordersArticles[$orderId] = $orderArticles;
            }
        }
    
        $this->render("account/account.html.twig", [
            'error' => $error,
            'orders' => $orders,
            'ordersArticles' => $ordersArticles,
            'session' => $session
        ]);
    }
    
    public function updateUserProfile() : void
    {
        if(isset($_SESSION['user']))
        {
            $currentUser = $_SESSION['user'];
            
            if(password_verify($_POST["password"], $currentUser->getPassword())) 
            {
                $_SESSION["error-message"] = "Le mot de passe ne peut pas être le même que l'ancien";
            }
            else
            {
                if($_POST["password"] === $_POST["confirm-password"])
                {  
                    $password_pattern = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';
    
                    if (preg_match($password_pattern, $_POST["password"]))
                    {   
                        $currentUser->setFirstName(htmlspecialchars($_POST["firstName"]));
                        $currentUser->setLastName(htmlspecialchars($_POST["lastName"]));
                        $currentUser->setEmail(htmlspecialchars($_POST["email"]));
                        $currentUser->setPassword(password_hash($_POST["password"], PASSWORD_BCRYPT));
                        $currentUser->setAddress(htmlspecialchars($_POST["address"]));
                        $currentUser->setCity(htmlspecialchars($_POST["city"]));
                        $currentUser->setPostalCode(htmlspecialchars($_POST["postalCode"]));
                        $currentUser->setCountry(htmlspecialchars($_POST["country"]));
            
                        $um = new UserManager();
                        $um->update($currentUser);
            
                        $_SESSION["user"] = $currentUser;
                        unset($_SESSION["error-message"]);
                        $this->redirect("index.php");
            
                    }
                    elseif($_POST["password"] !== null)
                    {
                        $currentUser->setFirstName(htmlspecialchars($_POST["firstName"]));
                        $currentUser->setLastName(htmlspecialchars($_POST["lastName"]));
                        $currentUser->setEmail(htmlspecialchars($_POST["email"]));
                        $currentUser->setAddress(htmlspecialchars($_POST["address"]));
                        $currentUser->setCity(htmlspecialchars($_POST["city"]));
                        $currentUser->setPostalCode(htmlspecialchars($_POST["postalCode"]));
                        $currentUser->setCountry(htmlspecialchars($_POST["country"]));
            
                        $um = new UserManager();
                        $um->update($currentUser);
            
                        $_SESSION["user"] = $currentUser;
                        unset($_SESSION["error-message"]);
                        $this->redirect("index.php");
                    }
                    else 
                    {
                        $_SESSION["error-message"] = "Le mot de passe doit contenir au moins 8 caractères, comprenant au moins une lettre majuscule, un chiffre et un caractère spécial.";
                    }
                }
                else
                {
                    $_SESSION["error-message"] = "Les mots de passe ne correspondent pas";
                }
            }
        }
        else
        {
            $_SESSION["error-message"] = "L'utilisateur n'est pas connecté.";
        }
    
        $this->redirect("index.php?route=account");
    }

    function accountAdmin(){
        
        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;
        $session = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

        $um = new UserManager();
        $am = new ArticleManager();
        $om = new OrderManager();

        $articles = $am->findAll();
        $users = $um->findAll();
    
        $orders = $om->findAll();
        $ordersArticles = [];
    
        foreach ($orders as $order) {
            $orderId = $order->getId();
            $oAm = new OrderArticleManager();
            $orderArticles = $oAm->findByOrderId($orderId);
            $ordersArticles[$orderId] = $orderArticles;
        }
    
        $this->render("account/accountAdmin.html.twig", [
            'error' => $error,
            'session' => $session,
            'articles' => $articles,
            'users' => $users,
            'orders' => $orders,
            'ordersArticles' => $ordersArticles,
        ]);
    }

    public function updateStock() : void
    {
        if(isset($_SESSION['user'])) {

            if (isset($_POST["article_id"]) && isset($_POST["stock"])) {
                $articleId = $_POST["article_id"];
                $newStock = htmlspecialchars($_POST["stock"]);

                $am = new ArticleManager();
                $article = $am->findOne($articleId);
    
                if ($article !== null) {

                    $article->setStock($newStock);
                    $am->update($article);
    
                    unset($_SESSION["error-message"]);
                    $this->redirect("index.php?route=accountAdmin");
                } else {
                    $_SESSION["error-message"] = "L'article n'existe pas.";
                }
            } else {
                $_SESSION["error-message"] = "Veuillez definir le nouveau stock.";
            }
        } else {
            $_SESSION["error-message"] = "L'administrateur n'est pas connecté.";
        }
        $this->redirect("index.php?route=accountAdmin");
    }

    public function createArticle(): void
    {
        if (
            isset($_POST["name"]) && isset($_POST["price"]) && isset($_POST["stock"])
            && isset($_POST["category"]) && isset($_POST["image"]) && isset($_POST["alt"])
            && isset($_POST["description"]) && isset($_POST["ingredients"]) && isset($_POST["age"])
        ) {
            $name = htmlspecialchars($_POST["name"]);
            $price = htmlspecialchars($_POST["price"]);
            $stock = htmlspecialchars($_POST["stock"]);
            $categoryId = htmlspecialchars($_POST["category"]);
            $url = htmlspecialchars($_POST["image"]);
            $alt = htmlspecialchars($_POST["alt"]);
            $description = htmlspecialchars($_POST["description"]);
            $ingredients = htmlspecialchars($_POST["ingredients"]);
            $age = htmlspecialchars($_POST["age"]);

            $imageTmpPath = $_FILES["image"]["tmp_name"];
            $uploadDirectory = 'media/';
            $uploadPath = $uploadDirectory . basename($_FILES["image"]["name"]);
    
            if (move_uploaded_file($imageTmpPath, $uploadPath)) {
                $url = 'https://ryanroudaut.sites.3wa.io/projet/' . $uploadPath;
    
                $cm = new CategoryManager();
                $category = $cm->findOne($categoryId);
    
                $mm = new MediaManager();
                $media = new Media($url, $alt);
                $mm->insert($media);
    
                $article = new Article($name, $price, $stock, $category, $media, $description, $ingredients, $age);
    
                $am = new ArticleManager();
                $am->insert($article);
    
                unset($_SESSION["error-message"]);
                $this->redirect("index.php?route=accountAdmin");
            } else {
                $_SESSION["error-message"] = "Une erreur s'est produite lors du téléchargement de l'image.";
                $this->redirect("index.php?route=accountAdmin");
            }
        } else {
            $_SESSION["error-message"] = "Champs manquants";
            $this->redirect("index.php?route=accountAdmin");
        }
    }
}
// public function upload(array $files, string $uploadField) : ?Media
// {
//     if(isset($files[$uploadField])){
//         try {
//             $file_name = $files[$uploadField]['name'];
//             $file_tmp =$files[$uploadField]['tmp_name'];

//             $tabFileName = explode('.',$file_name);
//             $file_ext=strtolower(end($tabFileName));

//             $newFileName = $this->gen->generate(8);

//             if(in_array($file_ext, $this->extensions) === false){
//                throw new Exception("Bad file extension. Please upload a JPG, PDF or PNG file.");
//             }
//             else
//             {
//                 $url = $this->uploadFolder."/".$newFileName.".".$file_ext;
//                 move_uploaded_file($file_tmp, $url);
//                 return new Media($file_name, $url);
//             }
//         }
//         catch(Exception $e)
//         {
//             echo $e->getMessage();
//             return null;
//         }

//     }

//     return null;
// }
// }