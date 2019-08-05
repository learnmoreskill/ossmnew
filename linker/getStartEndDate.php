<?php

/* Start Getting Current Nepali Month Start And End Day */
/* Ensure to include Session Common */


        
		// echo $setEDate.'<br>';
		$cnd = eToN($setEDate);

		// echo 'Current Date:'.$cnd.'<br>';

		list($cnd_y, $cnd_m, $cnd_d) = explode('-', $cnd);
		$snd = $cnd_y.'-'.$cnd_m.'-01';

		$sed = nToE($snd);

  //       echo 'Starting Nepali Date:'.$snd.'<br>';
		// echo 'Starting English Date:'.$sed.'<br>';

		

		$tdate = $setEDate;

		$nnd_d = $cnd_d_temp = $cnd_d;

		while ( $cnd_d_temp <= $nnd_d) {

			$eed = $tdate;
			$end = eToN($tdate);

			$tdate = strtotime("+1 day", strtotime($tdate));
			$tdate = date("Y-m-d", $tdate);

			$nnd_temp = eToN($tdate);

			list($nnd_y, $nnd_m, $nnd_d) = explode('-', $nnd_temp);
			if ($cnd_d_temp < $nnd_d) {
				$cnd_d_temp = $nnd_d;
			}
			
		}
		// echo 'Ending Nepali Date:'.$end.'<br>';
		// echo 'Ending English Date:'.$eed.'<br>';


		/* End Getting Current Nepali Month Start And End Day */

?>