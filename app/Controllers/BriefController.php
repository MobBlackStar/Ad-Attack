<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
// TEAM: Moataz here. I'm summoning the Warehouse Worker we just created.
use App\Models\Brief;

class BriefController extends Controller {

    // TEAM: This just shows the form we made above.
    public function create() {
        // Fedi: I'm using your Session check here to keep guests out!
        if (!Session::isLoggedIn()) {
            header('Location: /login');
            exit();
        }
        $this->view('briefs/create', ['title' => 'Ad-Attack | New Brief']);
    }

    // TEAM: This is the brain that handles the form submission.
    public function store() {
        $model = new Brief();

        // 1. Handle the Image Upload (Moving the file to our folder)
        $imageName = time() . '_' . $_FILES['brief_image']['name'];
        $destination = "assets/uploads/" . $imageName;
        
        // Moataz: We must move the file from 'temporary memory' to our physical folder.
        if (move_uploaded_file($_FILES['brief_image']['tmp_name'], $destination)) {
            
            // 2. Prepare the data for the Warehouse (Model)
            $data = [
                'agency_id'   => Session::get('user_id'), // Who is posting this?
                'title'       => $_POST['title'],
                'description' => $_POST['description'],
                'category'    => $_POST['category'],
                'image'       => $imageName,
                'deadline'    => $_POST['deadline']
            ];

            // 3. Save to Database
            if ($model->store($data)) {
                echo "<h1>Success! Brief is live.</h1>";
                // Eventually we will redirect to the homepage here.
            }
        } else {
            echo "Team, the photo upload failed. Check the 'uploads' folder permissions!";
        }
    }
}