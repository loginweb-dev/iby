<?php 
    require_once('../../../../wp-load.php');
    if ($_GET["customer_id"]) {
        $uid = array( $_GET["customer_id"] );
        $args = array(
            'include' => $uid,
        );
        $user_query = new WP_User_Query( $args );
        $users = (array) $user_query->results;
        $json = array();
        foreach ( $users as $user ) {
            $usermeta = get_user_meta($user->id);
            array_push($json, array(
                "id" => $user->id,
                "user_nicename" => $user->user_nicename,
                "user_email" => $user->user_email,
                "user_login" => $user->user_login,
                "first_name" => $usermeta['first_name'][0],
                "last_name" => $usermeta['last_name'][0]
            ));

        }
        // echo print_r($users);
        echo json_encode($json);

    
    }
?>