<?




/**
 * load_users_data
 *
 * @param  mixed $user_ids
 * @return array
 */
function load_users_data ($user_ids) : array {

    ///строго строка, ограничения: id до 6 чисел и максмум 51 id-шников
    if(is_string($user_ids) and preg_match('/^(\d{1,6},){1,50}\d{1,6}$/',$user_ids)) {

        
        $link = mysqli_connect("localhost", "root", "123123", "database");

        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit;
        }
        $query = "SELECT id as user_id, name FROM users WHERE id in ($user_ids)";
           
        if($result = mysqli_query($db, $query)){

            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

            mysqli_free_result($result);

            mysqli_close($con);

            return $data;
 
        }


    }

    return [];
}
// Как правило, в $_GET['user_ids'] должна приходить строка
// с номерами пользователей через запятую, например: 1,2,17,48
$data = load_users_data($_GET['user_ids']??'');
foreach ($data as $k => $item) {
    echo "<a href=\"/show_user.php?id=".$item['user_id']."\">".$item['name']."</a>";
}

//Уязвимости и недоработки


function load_users_data($user_ids) {
    // нет валидации перед использованием
    $user_ids = explode(',', $user_ids);
    foreach ($user_ids as $user_id) {
        //коннект к дб должен происходить только один раз, 
        // вслучае фатальной ошибки, засветим доступы, но в php теперь можно и фатальные ошибки перехватывать
        $db = mysqli_connect("localhost", "root", "123123", "database");
        // опасно!! SQL инъекция 
        $sql = mysqli_query($db, "SELECT * FROM users WHERE id=$user_id");
        //не процедурные методы mysqli
        while($obj = $sql->fetch_object()){
            $data[$user_id] = $obj->name;
        }
        mysqli_close($db);
    }
    return $data;
}
// Как правило, в $_GET['user_ids'] должна приходить строка
// с номерами пользователей через запятую, например: 1,2,17,48
$data = load_users_data($_GET['user_ids']);// нет проверки на существование ключа
foreach ($data as $user_id=>$name) {
    echo "<a href=\"/show_user.php?id=$user_id\">$name</a>"; //избыточность в echo, но работать будет
}








