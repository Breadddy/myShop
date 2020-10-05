<?php 
include "dbconnect.php";
class shop 
{   
    
    public $mysqli; 

    function __construct()
    {
        $this->mysqli = new mysqli(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);
        $this->mysqli->set_charset("utf8");
    }
    function addProduct($name, $description, $price, $available)
    {
        if ($stmt = $this->mysqli->prepare("INSERT INTO Products (name, description, price, available) VALUES (?, ?, ?, ?)")) {
            /* связываем параметры с метками */
            $stmt->bind_param("ssis", $name, $description, $price, $available);
            /* запускаем запрос */
            $stmt->execute();
            /* закрываем запрос */
            if (!empty($stmt->error))
                { //echo $stmt->error;
                  $stmt->close();
                  return false;
                }
            $id = $stmt->insert_id;
            $stmt->close();
        }
        return $id;
    }
    function updateProduct($name, $description, $price, $available, $id)
    {
        if ($stmt = $this->mysqli->prepare("UPDATE Products SET `name`=?, `description`=?, `price`=?, `available`=? WHERE id=?")) {
            /* связываем параметры с метками */
            $stmt->bind_param("ssiis", $name, $description, $price, $available, $id);
            /* запускаем запрос */
            $stmt->execute();
            /* закрываем запрос */
            if (!empty($stmt->error))
                { //echo $stmt->error;
                  $stmt->close();
                  return false;
                }
            $stmt->close();
        }
        return true;
    }
    function receiveImage2($product_id)
        {
            if( substr($_FILES['image']['type'], 0, 5)=='image' ) 
                {
                    // Читаем содержимое файла
                    $image = file_get_contents( $_FILES['image']['tmp_name'] );
                    // Экранируем специальные символы в содержимом файла
                    $image = $this->mysqli->escape_string( $image );
                    // Формируем запрос на добавление файла в базу данных
                    if(!$this->ImageExists($product_id))
                        $query="INSERT INTO `images` VALUES(NULL, '".$image."', $product_id)";
                    else
                        $query="UPDATE images SET `image`='".$image."' WHERE product_id=$product_id";
                    // После чего остается только выполнить данный запрос к базе данных
                    if($this->mysqli->query( $query ))
                        return true;
                    else
                        return false;
                }
        }
        function ImageExists($product_id)
        {
            $quest = "SELECT COUNT(*) FROM images WHERE product_id=$product_id"; 
            $result = mysqli_fetch_array($this->mysqli->query($quest));
            $result = $result[0];
            if($result)
                return true;
            else
                return false;
        }
        function selectFirstNProducts(int $start, int $n) //взять первые несколько товаров, начиная с start из бд
        {
            $quest = "SELECT id, name, description, price, available FROM Products ORDER BY available DESC LIMIT $start,$n";
            if(!$result = $this->mysqli->query($quest))
                return false;
            $items = mysqli_fetch_all($result, MYSQLI_ASSOC); 
            mysqli_free_result($result);
            return $items;
        }
        function countProducts()
        {
            $quest = "SELECT COUNT(*) FROM Products";
            if(!$result = $this->mysqli->query($quest))
                return false;
            $r = mysqli_fetch_array($result);
            $count = $r[0];
            return $count;
        }
        function SelectProductsByID(string $IDs)
        {
            $quest = "SELECT * FROM Products WHERE id IN ($IDs)";
            if(!$result = $this->mysqli->query($quest))
                return false;
            $arr = [];
            while($row = mysqli_fetch_assoc($result)){
                $arr[] = $row;
                }
            //mysqli_free_result($result);
            return $arr;
        }
        function selectImages($product_id)
        {
            $quest = "SELECT `image` FROM `images` WHERE `product_id` = $product_id";
            if(!$result = $this->mysqli->query($quest))
                return false;
            $images = mysqli_fetch_array($result);
            mysqli_free_result($result);
            return $images['image'];
        }
        function FieldExists($value, $fieldName)
        {
            if ($fieldName == 'login' || $fieldName == 'email')
            $quest = "SELECT COUNT(*) FROM users WHERE $fieldName='$value'"; 
            $result = mysqli_fetch_array($this->mysqli->query($quest));
            $result = $result[0];
            if($result)
                return true;
            else
                return false;
        }
        function addUser($login, $email, $password)
        {
            if ($stmt = $this->mysqli->prepare("INSERT INTO users (login, email, password) VALUES (?, ?, ?)")) 
            {
                /* связываем параметры с метками */
                $stmt->bind_param("sss", $login, $email, $password);
                /* запускаем запрос */
                $stmt->execute();
                /* закрываем запрос */
                if (!empty($stmt->error))
                    { //echo $stmt->error;
                      $stmt->close();
                      return false;
                    }
                $id = $stmt->insert_id;
                $stmt->close();
            }
            return $id;
        }
        function updateUser($user_id,$field, $fieldName)
        {
            if($fieldName=="password")
                $quest="UPDATE users SET `password`=? WHERE user_id=?";
            else if($fieldName=="email")
                $quest="UPDATE users SET `email`=? WHERE user_id=?";
            if ($stmt = $this->mysqli->prepare($quest)) {
                /* связываем параметры с метками */
                $stmt->bind_param("si", $field, $user_id);
                /* запускаем запрос */
                $stmt->execute();
                /* закрываем запрос */
                if (!empty($stmt->error))
                    { //echo $stmt->error;
                      $stmt->close();
                      return false;
                    }
                if($stmt->affected_rows)
                {   $stmt->close();
                    return true;
                }
                else
                {   $stmt->close();
                    return false;
                }
            }
            return false;
        }
        function searchUserByLogin(string $login)
        {
            $quest = "SELECT user_id, login, password, email
                      FROM users
                      WHERE login='$login'";
            if(!$result = $this->mysqli->query($quest))
                return false;
            $user = mysqli_fetch_assoc($result);
            return $user;
        }
        function searchUserById(string $id)
        {
            $quest = "SELECT user_id, login, password, email
                      FROM users
                      WHERE user_id='$id'";
            if(!$result = $this->mysqli->query($quest))
                return false;
            $user = mysqli_fetch_assoc($result);
            return $user;
        }
        function searchUserByEmail(string $email)
        {
            $quest = "SELECT user_id, login, password, email
                      FROM users
                      WHERE email='$email'";
            if(!$result = $this->mysqli->query($quest))
                return false;
            $user = mysqli_fetch_assoc($result);
            return $user;
        }
        function clearString($string)
        {
            return $this->mysqli->escape_string(strip_tags(trim($string)));
        }
        function addOrder($surname, $name, $patronymic, $email, $phone, $address, $time, $wantTalking, $orderedProducts)
        {
            if ($stmt = $this->mysqli->prepare("INSERT INTO orders (surname, name, patronymic, email, phone, address, time, want_talking, ordered_products) VALUES (?, ?, ?,?,?,?,?,?,?)")) 
            {
                /* связываем параметры с метками */
                $stmt->bind_param("ssssssiis", $surname, $name, $patronymic, $email, $phone, $address, $time, $wantTalking, $orderedProducts);
                /* запускаем запрос */
                $stmt->execute();
                /* закрываем запрос */
                if (!empty($stmt->error))
                    { //echo $stmt->error;
                      $stmt->close();
                      return false;
                    }
                $id = $stmt->insert_id;
                $stmt->close();
            }
            return $id;
        }
        function selectFirstNOrders(int $start, int $n, $parameters='all') 
        {
            $currentTime=time();
            switch($parameters){
                case 'wantTalking': {$quest = "SELECT order_id,surname, name, patronymic, email, phone, address, time, want_talking, ordered_products FROM orders WHERE $currentTime-time<86400 and want_talking=1 ORDER BY time LIMIT $start, $n"; break;}
                case 'actual': {$quest = "SELECT order_id,surname, name, patronymic, email, phone, address, time, want_talking, ordered_products FROM orders WHERE $currentTime-time<86400 ORDER BY time LIMIT $start, $n"; break;}
                case 'all': {$quest = "SELECT order_id,surname, name, patronymic, email, phone, address, time, want_talking, ordered_products FROM orders ORDER BY time LIMIT $start, $n"; break;}
            }
            if(!$result = $this->mysqli->query($quest))
                return false;
            $items = mysqli_fetch_all($result, MYSQLI_ASSOC); 
            mysqli_free_result($result);
            return $items;
        }
        function searchOrdersByEmail($email) 
        {
            $quest = "SELECT order_id,surname, name, patronymic, phone, address, time, want_talking, ordered_products FROM orders WHERE `email`='$email' ORDER BY time";
            if(!$result = $this->mysqli->query($quest))
                return false;
            $items = mysqli_fetch_all($result, MYSQLI_ASSOC); 
            mysqli_free_result($result);
            return $items;
        }
        function countOrders($parameters='all')
        {
            $currentTime=time();
            switch($parameters){
                case 'wantTalking': {$quest = "SELECT COUNT(*) FROM orders WHERE $currentTime-time<86400 and want_talking=1"; break;}
                case 'actual': {$quest = "SELECT COUNT(*) FROM orders WHERE $currentTime-time<86400"; break;}
                case 'all': {$quest = "SELECT COUNT(*) FROM orders"; break;}
            }
            if(!$result = $this->mysqli->query($quest))
                return false;
            $r = mysqli_fetch_array($result);
            $count = $r[0];
            return $count;
        }
        function addUserInformation($user_id,$surname, $name, $patronymic, $phone, $address)
        {
            if($this->searchUserById($user_id))
            if ($stmt = $this->mysqli->prepare("INSERT INTO user_information (user_id,surname, name, patronymic, phone, address) VALUES (?, ?, ?,?,?,?)")) 
            {
                /* связываем параметры с метками */
                $stmt->bind_param("isssss", $user_id,$surname, $name, $patronymic, $phone, $address);
                /* запускаем запрос */
                $stmt->execute();
                /* закрываем запрос */
                if (!empty($stmt->error))
                    { //echo $stmt->error;
                      $stmt->close();
                      return false;
                    }
                $id = $stmt->insert_id;
                $stmt->close();
            }
            return $id;
        }
        function SearchUserInformationById($user_id)
        {
            $quest = "SELECT surname, name, patronymic, phone, address
            FROM user_information
            WHERE user_id='$user_id'";
            if(!$result = $this->mysqli->query($quest))
                return false;
            $user = mysqli_fetch_assoc($result);
            return $user;
        }
        function updateUserInformation($user_id,$surname, $name, $patronymic, $phone, $address)
        {
            if($this->SearchUserInformationById($user_id))
            if ($stmt = $this->mysqli->prepare("UPDATE user_information SET `surname`=?, `name`=?, `patronymic`=?, `phone`=?,`address`=? WHERE user_id=?")) {
                /* связываем параметры с метками */
                $stmt->bind_param("sssssi", $surname, $name, $patronymic, $phone, $address, $user_id);
                /* запускаем запрос */
                $stmt->execute();
                /* закрываем запрос */
                if (!empty($stmt->error))
                    { //echo $stmt->error;
                      $stmt->close();
                      return false;
                    }
                if($stmt->affected_rows)
                {   $stmt->close();
                    return true;
                }
                else
                {   $stmt->close();
                    return false;
                }
            }
            return false;
        }
}
$minimarket = new shop;
session_start(['cookie_lifetime' => 86400, ]);
?>