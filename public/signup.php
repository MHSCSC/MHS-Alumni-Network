<?php
    if(isset($_POST['studentButton'])){
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/studentSignupForm.php';
    }
    else if(isset($_POST['alumniButton'])){
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/alumniSignupForm.php';
    }
    else if(isset($_POST['submitStudentSignupForm'])){
		global $table_prefix, $wpdb;

		$studentTable = $table_prefix . 'studentInfo';

        $wp_id = null;

        //insert wp user
        $wp_id = wp_insert_user(array(
            'user_login' => $_POST['email'],
            'user_pass' => NULL,
            'user_email' => $_POST['email'],
            'display_name' => $_POST['displayName'],
            'role' => 'subscriber'
        ));
        
        wp_new_user_notification( $wp_id, null, 'both' );

        echo "Account created. Please check your school email to set your password.";

        //student info table
        $data = array(
            'wp_id' => $wp_id, 
            'displayName' => $_POST['displayName'], 
            'graduationYear' => $_POST['graduationYear'],
            'areaOfExpertise' => $_POST['areaOfExpertise'],
            'email' => $_POST['email'],
            'status' => "New"
        );

        $format = array('%d', '%s', '%s', '%s', '%s', '%s');
        $wpdb->insert($studentTable,$data,$format);
    }
    else if(isset($_POST['submitAlumniSignupForm'])){
		global $table_prefix, $wpdb;

		$alumniTable = $table_prefix . 'alumniInfo';

        //alumni info table
        $data = array(
            'wp_id' => null, 
            'displayName' => $_POST['displayName'], 
            'graduationYear' => $_POST['graduationYear'],
            'areaOfExpertise' => $_POST['areaOfExpertise'],
            'college' => $_POST['college'],
            'job' => $_POST['job'],
            'email' => $_POST['email'],
            'status' => "New"
        );

        $format = array('%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s');
        $wpdb->insert($alumniTable,$data,$format);

        echo "Account created. Please wait for an email to set your password.";
    }
    else{
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/chooseSignupAccount.php';
    }
?>