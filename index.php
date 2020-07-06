<?php 
# accept json format and convert to hierarchical JSON

# we can change conditions depending on requests
# we we submit data by ajax then we need to set Ajax checkpoint here
# here I just put check point for submitted data by post [json string ]

#$flattened_format data can be dynamic as mentioned in above comment we can share data via Ajax 

if(isset($_POST['format'])){
	$flattened_format=$_POST['format'];
}
else{
	$flattened_format='[
		  {
		    "id": 8,
		    "parent": 4,
		    "name": "Food & Lifestyle"
		  },
		  {
		    "id": 2,
		    "parent": 1,
		    "name": "Mobile Phones"
		  },
		  {
		    "id": 1,
		    "parent": 0,
		    "name": "Electronics"
		  },
		  {
		    "id": 3,
		    "parent": 1,
		    "name": "Laptops"
		  },
		  {
		    "id": 5,
		    "parent": 4,
		    "name": "Fiction"
		  },
		  {
		    "id": 4,
		    "parent": 0,
		    "name": "Books"
		  },
		  {
		    "id": 6,
		    "parent": 4,
		    "name": "Non-fiction"
		  },
		  {
		    "id": 7,
		    "parent": 1,
		    "name": "Storage"
		  }
		]';
}

$dataInArray=array_sort(json_decode($flattened_format,true),'parent');
 
foreach($dataInArray as $parent){
	if($parent['parent']=='0'){
		$newArray[]=$parent;
	}
	else{
		$chil_array[$parent['parent']][]=$parent;			
	}
}

foreach($newArray as $parent){
	 $parent['children']=array_sort($chil_array[$parent['id']],'id');
	 $FinalArray[]=$parent;
}
echo "<pre>"; 
echo json_encode(array_sort($FinalArray,'id'),JSON_PRETTY_PRINT);

// function for sorting array default ascending order 
function array_sort($array, $on, $order=SORT_ASC){
    $new_array = array();
    $sortable_array = array();
    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }
        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }
        foreach ($sortable_array as $k => $v) {
            $new_array[] = $array[$k];
        }
    }
    return $new_array;
}

?>