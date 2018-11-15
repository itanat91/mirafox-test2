<?php

require_once('default.php');

$intelligenceLevel = testInputs($_POST['intelligence-level']);
$complexityLowerLimit = testInputs($_POST['complexity-lower-limit']);
$complexityUpperLimit = testInputs($_POST['complexity-upper-limit']);
$attributes = [$intelligenceLevel, $complexityLowerLimit, $complexityUpperLimit];
foreach ($attributes as $attribute) {
    if (!validateInputs($attribute)) {
        echo json_encode(['errors' => 'Входные данные должны быть целыми числами от 0 до 100']);
        die;
    }
}
validateInputs($intelligenceLevel);

$testId = saveTestData();
$selectedQuestions = getRandomQuestions();
incrementQuestionsUsage($selectedQuestions);
$data['statistic'] = saveResults($testId, $selectedQuestions);
$data['successful'] = getSuccessfulAnswers($data['statistic']);
echo json_encode($data);

/**
 * @param $data
 * @return string
 */
function testInputs($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * @param $data
 * @return bool
 */
function validateInputs($data)
{
    if (!is_numeric($data) || strlen($data) > 3 || mb_strpos($data, '-') !== false) {
        return false;
    }

    return true;
}

/**
 * @param array $data
 * @return int
 */
function getSuccessfulAnswers(array $data): int
{
    $successful = 0;
    foreach ($data as $datum) {
        if ($datum['is_correct'] == 'да') {
            $successful++;
        }
    }

    return $successful;
}

/**
 * @param int $testId
 * @param array $questions
 * @return array
 */
function saveResults(int $testId, array $questions): array
{
    global $conn, $intelligenceLevel, $complexityLowerLimit, $complexityUpperLimit;
    $stmt = $conn->prepare('insert into results (test_id, question_id, complexity_level, is_correct) values (:test_id, :question_id, :complexity_level, :is_correct)');
    $result = $questions;
    $successful = 0;
    foreach ($questions as $key => $question) {
        $complexityLevel = rand($complexityLowerLimit, $complexityUpperLimit);
        $isCorrect = simulateAnswer($complexityLevel, $intelligenceLevel);
        $stmt->execute([
            ':test_id' => $testId,
            ':question_id' => $question['question_id'],
            ':complexity_level' => $complexityLevel,
            ':is_correct' => $isCorrect,
        ]);
        $result[$key]['complexity_level'] = $complexityLevel;
        $result[$key]['is_correct'] = $isCorrect;
        if ($isCorrect) {
            $successful++;
            $result[$key]['is_correct'] = 'да';
        } else {
            $result[$key]['is_correct'] = 'нет';
        }
    }

    $stmt = $conn->prepare('update tests set successful_answers = :successful where test_id = :test_id');
    $stmt->execute([
        ':successful' => $successful,
        ':test_id' => $testId,
    ]);

    return $result;
}

/**
 * @param int $complexityLevel
 * @param int $intelligenceLevel
 * @return int
 */
function simulateAnswer(int $complexityLevel, int $intelligenceLevel): int
{
    if ($intelligenceLevel == 100) {
        if ($complexityLevel == 100) {
            return rand(0, 1);
        }

        return 1;
    }

    if ($intelligenceLevel == 0) {
        return 0;
    }

    $goodTester = [0, 1, 0, 1, 0, 1, 1, 1, 1, 1];
    $badTester = [0, 1, 0, 1, 0, 1, 0, 0, 0, 0];
    return $intelligenceLevel < $complexityLevel ? $badTester[array_rand($badTester)] : $goodTester[array_rand($goodTester)];
}

/**
 * @param array $questions
 */
function incrementQuestionsUsage(array $questions)
{
    global $conn;
    $stmtUpdate = $conn->prepare('update questions set amount_of_usage = amount_of_usage + 1 where question_id = :question_id');
    foreach ($questions as $question) {
        $stmtUpdate->execute([':question_id' => $question['question_id']]);
    }
}

/**
 * @return string
 */
function saveTestData(): string
{
    global $conn, $intelligenceLevel, $complexityLowerLimit, $complexityUpperLimit;
    $complexityRange = $complexityLowerLimit . '-' . $complexityUpperLimit;
    $stmt = $conn->prepare('insert into tests (intelligence_level, complexity_range) values (:intelligence_level, :complexity_range)');
    $stmt->execute([
        ':intelligence_level' => $intelligenceLevel,
        ':complexity_range' => $complexityRange,
    ]);

    return $conn->lastInsertId();
}

/**
 * @return array|mixed
 */
function getRandomQuestions()
{
    global $conn;
    return $conn->query('select * from questions order by amount_of_usage limit 40')->fetchAll();
}