<?php
use Cocur\Slugify\Slugify;

abstract class AbstractManager
{
    protected PDO $db;

    public function __construct()
    {
        $connexion = "mysql:host=".$_ENV["DB_HOST"].";port=3306;charset=".$_ENV["DB_CHARSET"].";dbname=".$_ENV["DB_NAME"];
        $this->db = new PDO(
            $connexion,
            $_ENV["DB_USER"],
            $_ENV["DB_PASSWORD"]
        );
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function slugify(string $string):string{
        $slugify = new Slugify();
        return $slugify->slugify($string);
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
}