<?php
/**
 * Created by PhpStorm.
 * User: hy
 * Date: 2014/10/30
 * Time: 21:15
 */
    require_once 'database.php';

    error_reporting(E_ERROR | E_WARNING | E_PARSE);

    switch ($_REQUEST['action'])
    {
        case 'new':
            $name = $_POST['name'];
            $age = $_POST['age'];
            $gender = $_POST['gender'];
            $email = $_POST['email'];
            if (!$name || !$age || !$gender || !$email)
            {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Please fill in the form completely.'
                ));
                return;
            }
            $statement = $db->prepare(<<<QUERY
INSERT INTO `guests` (`name`, `age`, `gender`, `email`) VALUES (?, ?, ?, ?)
QUERY
            );
            $name = htmlspecialchars($name);
            $gender = htmlspecialchars($gender);
            $email = htmlspecialchars($email);
            $statement->bind_param("siss", $name, $age, $gender, $email);
            if (!$statement->execute())
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Submission failed: '.$statement->error
                ));
            else
                echo json_encode(array(
                    'success' => true
                ));
            break;
        case 'delete':
            $ids = $_POST['ids'];
            if (!$ids)
            {
                echo json_encode(array(
                    'success' => true
                ));
                return;
            }
            if (!is_array($ids))
                $ids = array($ids);
            $query = "DELETE FROM `guests` WHERE `id` in (";
            $first = true;
            foreach ($ids as $id)
            {
                if (is_numeric($id))
                {
                    if ($first)
                        $first = false;
                    else
                        $query .= ', ';
                    $query .= $id;
                }
            }
            $query .= ')';
            if (!$db->query($query))
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Operation failed: '.$db->error
                ));
            else
                echo json_encode(array(
                    'success' => true
                ));
            break;
        case 'get':
            if (!($result = $db->query('SELECT * FROM `guests` WHERE `joined_party` = 0')))
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Operation failed: '.$statement->error
                ));
            else
            {
                $table = '';
                foreach ($result->fetch_all(MYSQL_ASSOC) as $row)
                {
                    $table .= <<<TABLEROW
<tr>
<td><input type='checkbox' value='{$row['id']}' name='ids' data-validatefunc='dummy'></td>
<td>{$row['name']}</td>
<td>{$row['age']}</td>
<td>{$row['gender']}</td>
<td>{$row['email']}</td>
</tr>
TABLEROW
                    ;
                }
                echo json_encode(array(
                    'success' => true,
                    'tablerows' => $table
                ));
            }
            break;
    }