<?php

//Dati per accedere al database
define("DB_SERVERNAME", "localhost:3306");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "root");
define("DB_NAME", "db-university");

//Connessione al database
$conn = new mysqli (DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

//Check della connessione ed eventuali errori
if($conn && $conn->connect_error){
    echo "Connection failed: " . $conn->connect_error;
}
else{
    echo "Connection ok";
}

// $sql = "SELECT exam_student.exam_id AS `esame`, AVG(exam_student.vote) AS `media_esame`, courses.name AS `nome_corso`
//         FROM exam_student
//         INNER JOIN exams ON exam_student.exam_id = exams.id
//         INNER JOIN courses ON courses.id = exams.course_id
//         GROUP BY `esame`;";

?>

    <div>
        <h3>Risali ai dati dello studente selezionando l'ID</h3>
        <form action="./querySQL.php" method="get">
            <input type="number" name="id">
            <input type="submit" value="Cerca">
        </form>
        <a href="./querySQL.php">Back to full list</a>
    </div>

<?php

if(isset($_GET['id']) && $_GET['id'] > 0){
    $student_id = $_GET['id'];

    $sql = "SELECT `name`,`surname`,`fiscal_code`,`email` FROM `students` WHERE `id` = ?";
    $stmt = $conn-> prepare($sql);
    $stmt -> bind_param('i', $student_id);
    $stmt -> execute();

    

    $student_result = $stmt->get_result();
}else{
    $sql = "SELECT `name`,`surname`,`fiscal_code`,`email` FROM `students`";
    $student_result = $conn->query($sql);
    
}



?>

    <div style = "display: flex; flex-wrap: wrap;">
    
<?php
    if ($student_result && $student_result->num_rows > 0){
        while($row = $student_result->fetch_assoc()){
?>

        <div>
            <ul>
                <li>Nome: <?= $row['name']?></li>
                <li>Cognome: <?= $row['surname']?></li>
                <li>Codice fiscale: <?= $row['fiscal_code']?></li>
                <li>Email: <?= $row['email']?></li>
            </ul>
        </div>

<?php
    }
}

?>
</div>