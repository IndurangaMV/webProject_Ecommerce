<?php
include "session.php";
require_once "connection.php";

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image'])) {
    $file = $_FILES['profile_image'];

    $fileName    = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize    = $file['size'];
    $fileError   = $file['error'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png', 'webp');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 5000000) { // 5MB Limit
                
                $targetDir = "../assests/images/users/";
                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }

                // Append a timestamp to make each file unique on upload
                $newFileName = "profile_" . preg_replace("/[^a-zA-Z0-9]/", "", $username) . "_" . time() . "." . $fileActualExt;
                $fileDestination = $targetDir . $newFileName;

                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    
                    // 1. Insert the brand new row into your user_image table
                    $insertImgQuery = "INSERT INTO user_image (path) VALUES (?)";
                    $imgStmt = $conn->prepare($insertImgQuery);
                    $imgStmt->bind_param("s", $fileDestination);
                    
                    if ($imgStmt->execute()) {
                        // Capture the auto-generated primary key ID
                        $newImageId = $conn->insert_id;
                        $imgStmt->close();

                        // 2. Map this new image ID straight back to the user record
                        $updateUserQuery = "UPDATE user SET image_id = ? WHERE username = ?";
                        $userStmt = $conn->prepare($updateUserQuery);
                        $userStmt->bind_param("is", $newImageId, $username);
                        
                        if ($userStmt->execute()) {
                            $userStmt->close();
                            header("Location: " . $_SERVER['HTTP_REFERER']);
                            exit();
                        } else {
                            echo "Failed to link the image to your profile.";
                        }
                    } else {
                        echo "Failed to save the image to the asset index.";
                    }
                } else {
                    echo "There was an error moving the image payload to storage.";
                }
            } else {
                echo "Your uploaded file size is too massive.";
            }
        } else {
            echo "An unknown system reading error occurred during transfer.";
        }
    } else {
        echo "Invalid file extension format type selection.";
    }
} else {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}