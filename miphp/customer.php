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

    
    }elseif ($_GET["customer_store"]){
        // $userdata = compact( 'user_email', 'user_pass' );
        $user_email = $_GET["user_email"];
        $user_login = $_GET["user_login"];
        $user_id = wc_create_new_customer( $user_email, $user_login, 'password');
        update_user_meta( $user_id, "billing_first_name", $_GET["first_name"] );
        update_user_meta( $user_id, "billing_last_name", $_GET["last_name"] );
        update_user_meta( $user_id, "billing_phone", $_GET["billing_phone"] );
        update_user_meta( $user_id, "billing_postcode", $_GET["billing_postcode"] );
        
        echo json_encode(array('message' => 'Cliente Create Correctamente..'.$user_login, 'customer_id' => $user_id));
    }
?>