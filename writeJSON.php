<?php

//The linux server can have asetting enabled that adds slashes into POST variables.
//This is remove din later PHP versions.  Get around it here...
$json_string = $_POST['json'];
if (get_magic_quotes_gpc())  {
  $json_string = stripslashes($json_string);
}

//Perform the file writing and return details to the caller.
if( file_put_contents($_POST['file'], json_format($json_string)) ){
  echo "Success";
  echo $json_string;
}else{
  echo "There was an error saving data, if the error persists please contact the developer.\n";
  echo "String to be written: " . $_POST['json'];
}

//Reformat a json string with the correct whitespace so it is easily readblae.
function json_format($json)
{
    $tab = "  ";
    $new_json = "";
    $indent_level = 0;
    $in_string = false;

    //$json_obj = json_decode($json);

    //if($json_obj === false)
    //    return false;

    //$json = json_encode($json_obj);
    $len = strlen($json);

    for($c = 0; $c < $len; $c++)
    {
        $char = $json[$c];
        switch($char)
        {
            case '{':
            case '[':
                if(!$in_string)
                {
                    $new_json .= $char . "\n" . str_repeat($tab, $indent_level+1);
                    $indent_level++;
                }
                else
                {
                    $new_json .= $char;
                }
                break;
            case '}':
            case ']':
                if(!$in_string)
                {
                    $indent_level--;
                    $new_json .= "\n" . str_repeat($tab, $indent_level) . $char;
                }
                else
                {
                    $new_json .= $char;
                }
                break;
            case ',':
                if(!$in_string)
                {
                    $new_json .= ",\n" . str_repeat($tab, $indent_level);
                }
                else
                {
                    $new_json .= $char;
                }
                break;
            case ':':
                if(!$in_string)
                {
                    $new_json .= ": ";
                }
                else
                {
                    $new_json .= $char;
                }
                break;
            case '"':
                if($c > 0 && !( $json[$c-1] == '\\' && $json[$c-2] != '\\') )
                {
                    $in_string = !$in_string;
                }
            default:
                $new_json .= $char;
                break;                   
        }
    }

    return $new_json;
} 
?>
