
<?php
error_log("Called with: " . $_SERVER["REQUEST_METHOD"] );
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $target_dir = "../../data/images/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);



    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ". ";
            $uploadOk = 1;
        } else {
            echo "File is not an image. ";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists. ";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["file"]["size"] > 1000000) {
        echo "Sorry, your file is too large. ";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if(!in_array($imageFileType, ["jpg", "JPG", "png", "PNG", "jpeg", "JPEG", "gif", "GIF"]) ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Your file was not uploaded. ";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "success";
        } else {
            echo "Sorry, there was an error uploading your file: " . basename( $_FILES["file"]["name"]) ;
        }
    }
}

if($_SERVER["REQUEST_METHOD"] == "DELETE"){
    
    parse_str(file_get_contents("php://input"));
    if( unlink($path) ){
        echo "success";
    }else{
        echo "Sorry, there was an error.  Your file [".$path."] has not been deleted.";
    }
}

if($_SERVER["REQUEST_METHOD"] == "GET"){

  $path = "../../data/";
$dir = "../../data/images";


// This function scans the files folder recursively, and builds a large array

function scan($dir){

	$files = array();

	// Is there actually such a folder/file?

	if(file_exists($dir)){
	
		foreach(scandir($dir) as $f) {
		
			if(!$f || $f[0] == '.') {
				continue; // Ignore hidden files
			}

			if(is_dir($dir . '/' . $f)) {

				// The path is a folder

				$files[] = array(
					"name" => $f,
					"type" => "folder",
					"path" => $dir . '/' . $f,
					"items" => scan($dir . '/' . $f) // Recursively get the contents of the folder
				);
			}
			
			else {

				// It is a file

				$files[] = array(
					"name" => $f,
					"type" => "file",
					"path" => $dir . '/' . $f,
					"size" => filesize($dir . '/' . $f) // Gets the size of this file
				);
			}
		}
	
	}

	return $files;
}


// Run the recursive function 

$response = scan($dir);


// Output the directory listing as JSON

header('Content-type: application/json');

echo json_encode(array(
	"name" => "images",
	"type" => "folder",
	"path" => $dir,
	"items" => $response
));
}
?>


