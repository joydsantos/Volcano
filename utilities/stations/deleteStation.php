<?php
include '../../database/mydb.php';
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../../index.php");
}
if (isset($_POST['id'])) {
    $id = trim($_POST['id']);

    # Validate input
    if (!preg_match('/^[a-zA-Z0-9\s]+$/', $id)) {
        echo 'Invalid input';
        exit;
    }

    # Check if the station has transactions using prepared statement
    $checkQuery = "SELECT * FROM viewTransaction WHERE Station = ?";
    $checkStatement = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($checkStatement, "s", $id);
    mysqli_stmt_execute($checkStatement);
    $result = mysqli_stmt_get_result($checkStatement);

    if (mysqli_num_rows($result) > 0) {
        # Records with transactions exist, cannot delete
        echo 2;
        exit;
    } else {
        # Check if the station has old transactions using prepared statement
        $checkQuery1 = "SELECT * FROM viewoldtransaction WHERE Station = ?";
        $checkStatement1 = mysqli_prepare($conn, $checkQuery1);
        mysqli_stmt_bind_param($checkStatement1, "s", $id);
        mysqli_stmt_execute($checkStatement1);
        $result1 = mysqli_stmt_get_result($checkStatement1);

        if (mysqli_num_rows($result1) > 0) {
            # Records with transactions exist, cannot delete
            echo 3;
            exit;
        } else {

            # Check if the station used in remotetation
            $checkQuery2 = "
            SELECT
                e.id,
                l.location,
                (
                    SELECT
                        GROUP_CONCAT(ins.description ORDER BY ins.id SEPARATOR ',')
                    FROM
                        tbl_instruments ins
                    WHERE
                        ins.equipment_id = e.id
                ) AS instruments,
                s.Station AS station_name,
                sc.code AS station_code
            FROM
                tbl_deployed_equipment e
            LEFT JOIN tbl_station s ON s.id = e.station_id
            LEFT JOIN tbl_station_code sc ON sc.code_id = e.station_code_id
            LEFT JOIN tbl_locations l ON l.id = e.location_id
            WHERE s.Station = ?";
            $checkStatement2 = mysqli_prepare($conn, $checkQuery2);
            mysqli_stmt_bind_param($checkStatement2, "s", $id);
            mysqli_stmt_execute($checkStatement2);
            $result2 = mysqli_stmt_get_result($checkStatement2);

            if (mysqli_num_rows($result2) > 0) {
                # Records with transactions exist, cannot delete
                echo 4;
                exit;
            } else {

                #delete station code
                //$deleteStationCode = "DELETE FROM tbl_station_code where S "

                # Delete the station using prepared statement
                $deleteQuery = "DELETE FROM tbl_station WHERE Station = ?";
                $deleteStatement = mysqli_prepare($conn, $deleteQuery);
                mysqli_stmt_bind_param($deleteStatement, "s", $id);

                if (mysqli_stmt_execute($deleteStatement)) {
                    echo 1; // Successful deletion
                    exit;
                } else {
                    echo 5; // Deletion failed
                    exit;
                }
            }
        }
    }
} else {
    exit; // Invalid request
}
