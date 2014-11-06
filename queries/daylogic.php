<?php

//function to check times
function check_times($t1, $t2, $t3,$t4){
	//t1 = new class start time
	//t2 = old class start time
	//t3 = new class end time
	//t4 = old class end time
	//returns true if no conflict
	//check time logic
	//if start time 1 == start time 2 => same time
	//if end time 1 == end time 2 => same time
	//if start time 1 > start time 2 && end time 1 < end time 2 => same time -- ex geo lab, 1-3:50 this would apply to 2-2:50 classes
	if($t1 == $t2)
		return false;
	else if($t3 == $t4)
		return false;
	else if(($t1 > $t2) && ($t1 < $t4))
		return false;
	else
		return true;

}

function check_days($ndays,$cdays, $nstime,$cstime,$netime,$cetime){
//days logic
//Potential Conflicts
//all but F check MTWRF and MTWR

// MWF -- MWF, MW, WF, MF, M, W, F
if($ndays == 'MWF'){
	if($cdays == 'MTWRF' || $cdays == 'MTWR' || $cdays == 'MWF' || $cdays == 'MF' || $cdays == 'WF' || $cdays == 'MW' || $cdays == 'M' || $cdays == 'W' || $cdays == 'F'){
		return check_times($nstime,$cstime,$netime,$cetime);
	}
}
// MW -- MWF, MF, WF, M, W, MW
else if($ndays == 'MW'){
	if($cdays == 'MTWRF' || $cdays == 'MTWR' || $cdays == 'MWF' || $cdays == 'MF' || $cdays == 'WF' || $cdays == 'MW' || $cdays == 'W' || $cdays == 'F'){
		return check_times($nstime,$cstime,$netime,$cetime);
	}
}
// WF -- MWF, WF, MW, F, W, MF
else if($ndays == 'WF'){
	if($cdays == 'MWF' || $cdays == 'MTWRF' || $cdays == 'MTWR' || $cdays == 'WF' || $cdays == 'MW' || $cdays == 'M' || $cdays == 'MF' || $cdays == 'F'){
		return check_times($nstime,$cstime,$netime,$cetime);
	}
}
// MF -- MWF, MF, MW,WF, M, F
else if($ndays == 'MF'){
	if($cdays == 'MTWRF' || $cdays == 'MTWR' || $cdays == 'MWF' || $cdays == 'MF' || $cdays == 'WF' || $cdays == 'MW' || $cdays == 'M' || $cdays == 'F'){
		return check_times($nstime,$cstime,$netime,$cetime);
	}
}
// M -- MWF, MF, MW, M
else if($ndays == 'M'){
	if($cdays == 'MTWRF' || $cdays == 'MTWR' || $cdays == 'MWF' || $cdays == 'MF' || $cdays == 'MW' || $cdays == 'M' ){
		return check_times($nstime,$cstime,$netime,$cetime);
	}
}
// W -- MWF, WF, MW, W
else if($ndays == 'W'){
	if($cdays == 'MTWRF' || $cdays == 'MTWR' || $cdays == 'MWF' || $cdays == 'WF' || $cdays == 'MW' ||  $cdays == 'W' ){
		return check_times($nstime,$cstime,$netime,$cetime);
	}
}
// F -- MWF, WF, MF, F
else if($ndays == 'F'){
	if($cdays == 'MTWRF' || $cdays == 'MWF' || $cdays == 'MF' || $cdays == 'WF' || $cdays == 'F'){
		return check_times($nstime,$cstime,$netime,$cetime);
	}
}

// MTWRF -- MWF, MW, WF, MF, M, W, F, TR, T, R
else if($ndays == 'MTWRF'){
	if($cdays == 'MTWRF' || $cdays == 'MTWR' || $cdays == 'MWF' || $cdays == 'MF' || $cdays == 'WF' || $cdays == 'MW' || $cdays == 'M' || $cdays == 'W' || $cdays == 'F' || $cdays == 'TR' || $cdays == 'T' || $cdays == 'R'){
		return check_times($nstime,$cstime,$netime,$cetime);
	}
}
//MTWF -- all but friday
else if($ndays == 'MTWR'){
	if($cdays == 'MTWRF' || $cdays == 'MTWR' || $cdays == 'MWF' || $cdays == 'MF' || $cdays == 'WF' || $cdays == 'MW' || $cdays == 'M' || $cdays == 'W' || $cdays == 'TR' || $cdays == 'T' || $cdays == 'R'){
		return check_times($nstime,$cstime,$netime,$cetime);
	}
}
// TR -- MTWRF, T, R, TR
else if($ndays == 'TR'){
	if($cdays == 'MTWRF' || $cdays == 'MTWR' || $cdays == 'TR' || $cdays == 'T' || $cdays == 'R' ){
		return check_times($nstime,$cstime,$netime,$cetime);
	}
}
// T -- TR, MTWRF, T
else if($ndays == 'T'){
	if($cdays == 'MTWRF' || $cdays == 'MTWR' || $cdays == 'TR' || $cdays == 'T' ){
				return check_times($nstime,$cstime,$netime,$cetime);
	}
}
// R -- TR, MTWRF, R
else if($ndays == 'R'){
	if($cdays == 'MTWRF' || $cdays == 'MTWR' || $cdays == 'TR' || $cdays == 'R' ){
				return check_times($nstime,$cstime,$netime,$cetime);
	}
}
else{
	//this will only trigger if the data does not fit one of the formats above.
	echo 'ERROR IN DATA\n';
	return false
}
}
?>
