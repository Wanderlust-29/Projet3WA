<?php
use Cocur\Slugify\Slugify;
use Twig\Extra\Intl\IntlExtension;
use Carbon\Carbon;

abstract class AbstractController
{
    private \Twig\Environment $twig;
    
    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('templates');
        $twig = new \Twig\Environment($loader,[
            'debug' => true,
        ]);
        $session = isset($_SESSION["user"]) ? $_SESSION["user"] : null;
        
        $slugify = new Slugify();

        $cart = isset($_SESSION["cart"]["articles"]) ? $_SESSION["cart"]["articles"] : null;
        $count = 0;
        if (!is_null($cart)) {
            foreach ($cart as $article) {
                if ($article['quantity']) {
                    $count += $article['quantity'];
                }
            }
        }

        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $twig->addExtension(new IntlExtension());
        $twig->addGlobal("session", $session);
        $twig->addGlobal("count", $count);
        $twig->addGlobal("cart", $cart);
        $twig->addGlobal("slugify", $slugify);
        $twig->addGlobal('csrf_token', $_SESSION["csrf-token"]);
        

        $this->twig = $twig;
    }

    public function interpolateQuery($query, $params) {
        $keys = array();
        $values = $params;
    
        # build a regular expression for each parameter
        foreach ($params as $key => $value) {
            if (is_string($key)) {
                $keys[] = '/:'.$key.'/';
            } else {
                $keys[] = '/[?]/';
            }
    
            if (is_string($value))
                $values[$key] = "'" . $value . "'";
    
            if (is_array($value))
                $values[$key] = "'" . implode("','", $value) . "'";
    
            if (is_null($value))
                $values[$key] = 'NULL';
        }
    
        $query = preg_replace($keys, $values, $query);
    
        return $query;
    }

    protected function niceDate($date) :string {
        $carbon = new Carbon($date);
        $carbon->locale('fr_FR');
        $result = ucfirst($carbon->isoFormat('dddd DD MMMM YYYY'));
        return $result;
    }

    protected function diffDate($date) :string {
        $carbon = new Carbon($date);
        $carbon->locale('fr_FR');
        return $carbon->diffForHumans();
    }


    protected function notify(string $text, string $type = 'success') : void
    {
        unset($_SESSION['notify']);
        $_SESSION['notify'] = [
            'text' => $text,
            'type' => $type
        ];
    }

    protected function slugify(string $string) : string
    {
        $slugify = new Slugify();
        return $slugify->slugify($string);
    }


    protected function render(string $template, array $data) : void
    {
        if(isset($_SESSION['notify'])){
            $data['notify'] = $_SESSION['notify'];
            unset($_SESSION['notify']);
        }
        echo $this->twig->render($template, $data);
    }
    protected function redirect(string $route) : void
    {
        header("Location: $route");
    }
    protected function renderJson(array $data) : void
    {
        echo json_encode($data);
    }



}
