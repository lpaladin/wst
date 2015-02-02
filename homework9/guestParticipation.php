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
            $ids = $_POST['ids'];
            if (!$name || !$age || !$gender || !$email || !$ids)
            {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Please fill in the form completely.'
                ));
                return;
            }
            if (!is_array($ids))
                $ids = array($ids);
            $statement = $db->prepare(<<<QUERY
INSERT INTO `guests` (`name`, `age`, `gender`, `email`, `joined_party`) VALUES (?, ?, ?, ?, 1)
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
            {
                $guest_id = $db->insert_id;
                $query = "INSERT INTO `guest_party` (`guest_id`, `party_id`) VALUES ";
                $first = true;
                foreach ($ids as $id)
                {
                    if (is_numeric($id))
                    {
                        if ($first)
                            $first = false;
                        else
                            $query .= ', ';
                        $query .= "($guest_id, $id)";
                    }
                }
                if (!$db->query($query))
                    echo json_encode(array(
                        'success' => false,
                        'message' => 'Submission failed: '.$db->error
                    ));
                else
                    echo json_encode(array(
                        'success' => true
                    ));
            }
            break;
        case 'getParties':
            if (!($result = $db->query('SELECT * FROM `parties`')))
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
<td>{$row['time']}</td>
<td>{$row['location']}</td>
<td>{$row['host']}</td>
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
        case 'getParticipation':
            $name = $_GET['name'];
            $party = $_GET['party'];
            if ($name)
            {
                $name = '%' . $name . '%';
                $statement = $db->prepare(<<<FULLQUERY
SELECT `guests`.`name`, `guests`.`age`, `guests`.`gender`, `guests`.`email`,
`parties`.`host`, `parties`.`location`, `parties`.`time` , `parties`.`id`
FROM `guest_party` INNER JOIN `guests`, `parties`
WHERE `guests`.`name` LIKE ? AND `guests`.`id` = `guest_party`.`guest_id` AND `guest_party`.`party_id` = `parties`.`id`
 ORDER BY `party_id`
FULLQUERY
                );
                $statement->bind_param("s", $name);
                $result = $statement->execute();
            }
            else
            {
                $statement = $db->prepare(<<<FULLQUERY
SELECT `guests`.`name`, `guests`.`age`, `guests`.`gender`, `guests`.`email`,
`parties`.`host`, `parties`.`location`, `parties`.`time` , `parties`.`id`
FROM `guest_party` INNER JOIN `guests`, `parties`
WHERE `guests`.`id` = `guest_party`.`guest_id` AND `guest_party`.`party_id` = `parties`.`id`
 ORDER BY `party_id`
FULLQUERY
                );
                $result = $statement->execute();
            }
            if (!$result)
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Operation failed: '.$statement->error
                ));
            else
            {
                $table = '';
                $allRows = $statement->get_result()->fetch_all(MYSQL_ASSOC);
                $rowCount = count($allRows);
                $j = 0;
                for ($i = 0; $i < $rowCount; $i += $j)
                {
                    for ($j = 0; $j < $rowCount - $i; $j++)
                        if ($allRows[$i]['id'] != $allRows[$i + $j]['id'])
                            break;
                    $table .= <<<TABLEROW
<tr>
<td rowspan="$j"><b>{$allRows[$i]['time']}</b> at <b>{$allRows[$i]['location']}</b> hosted by <b>{$allRows[$i]['host']}</b></td>
<td>{$allRows[$i]['name']}</td>
<td>{$allRows[$i]['age']}</td>
<td>{$allRows[$i]['gender']}</td>
<td>{$allRows[$i]['email']}</td>
</tr>
TABLEROW
                    ;
                    for ($k = 1; $k < $j; $k++)
                        $table .= <<<TABLEROW
<tr>
<td>{$allRows[$i + $k]['name']}</td>
<td>{$allRows[$i + $k]['age']}</td>
<td>{$allRows[$i + $k]['gender']}</td>
<td>{$allRows[$i + $k]['email']}</td>
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