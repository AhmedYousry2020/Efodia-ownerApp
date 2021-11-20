<?php

  class Generators{

    public function generateToken(){
      $cstrong = true;
      return bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
    }

    public function generateConfirmationToken(){
      $cstrong = true;
      return bin2hex(openssl_random_pseudo_bytes(128, $cstrong));
    }

    /* TIMES ************************************************************************************* */
    public function generateTimeBetween($startTime, $endTime){
      $start = strtotime($startTime);
      $end =  strtotime($endTime);
      return date("Y-m-d H:i", rand($start, $end));
    }

    /* STRINGS ************************************************************************************* */
    public function generateFirstName(){
      $firstNames = ["Ahmad", "Osama", "Mohammed", "Alex", "Maya", "Dina", "Soha", "Yara", "Yasmine", "Sarah", "Somiah", "Khaled", "Saber", "Magdy", "Wael", "Mousa", "Mosatafa", "Hagar", "Mona", "Nahed"];
      return $firstNames[rand(0,19)];
    }

    public function generateLastName(){
      $last_names = ["Sami", "Al-Sayed", "Abd Alraouf", "Bahgat", "Ibrahim", "Abd Allah", "Marten", "White", "Foad", "Moaz", "Moamen", "Ramy", "Ayman", "Kamel", "Metwally", "Saaeed", "Hasan", "Gaber", "Seif", "Abdulhamed"];
      return $last_names[rand(0,19)];
    }

    public function generateFullName(){
      $firstNames = ["Ahmad", "Osama", "Mohammed", "Alex", "Maya", "Dina", "Soha", "Yara", "Yasmine", "Sarah", "Somiah", "Khaled", "Saber", "Magdy", "Wael", "Mousa", "Mosatafa", "Hagar", "Mona", "Nahed"];
      $last_names = ["Sami", "Al-Sayed", "Abd Alraouf", "Bahgat", "Ibrahim", "Abd Allah", "Marten", "White", "Foad", "Moaz", "Moamen", "Ramy", "Ayman", "Kamel", "Metwally", "Saaeed", "Hasan", "Gaber", "Seif", "Abdulhamed"];
      $fullName = $firstNames[rand(0,19)] . " " . $last_names[rand(0,19)];
      return $fullName;
    }

    public function generateEmail(){
      $firstNames = ["ahmad", "osama", "mohammed", "alex", "maya", "dina", "soha", "yara", "yasmine", "sarah", "somiah", "khaled", "saber", "magdy", "wael", "mousa", "mosatafa", "hagar", "mona", "nahed"];
      $last_names = ["sami", "alsayed", "abdalraouf", "bahgat", "ibrahim", "abdallah", "marten", "white", "foad", "moaz", "moamen", "ramy", "ayman", "kamel", "metwally", "saaeed", "hasan", "gaber", "seif", "abdulhamed"];
      $emails = ["@gmail.com", "@hotmail.com", "@yahoo.com"];
      $email = $firstNames[rand(0,19)] . $last_names[rand(0,19)] . $emails[rand(0,2)];
      return $email;
    }

    public function generatePhone(){
      $init = ["011", "012", "010"];
      $phone = $init[rand(0,2)] . rand(11111111,99999999);
      return $phone;
    }
    public function generateCardTimeID(){
		$id = rand(50,10050);
		return $id;
	}
	public function generateBusinessID(){
		$id = rand(248,10249);
		return $id;
	}
	public function generateLocationID(){
		$id = rand(42,10042);
		
		return $id;
	}
	public function generatePosition(){
		$position = rand(1,3);
		return $position;
	}
	public function generateCreatedAt(){
		$created_at = date("Y-m-d H:i:s");
		return $created_at;
	}
	public function generateUpdatedAt(){
		$updated_at = date("Y-m-d H:i:s");
		return $updated_at;
	}
	public function generateWorkTimeID(){
		$id = rand(200,10200);
		return $id;
	}
	public function generateStartHour(){
		$hours = ['9:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00'];
		return $hours[rand(0,8)];
	}
	public function generateEndHour(){
		$hours = ['22:00','23:00','21:00'];
		return $hours[rand(0,2)];
	}
	public function generateDayStatus(){
		return rand(0,1);
	}
	public function generateBsuinessWaitingQueue(){
		$waiting_queue = rand(0,1);
		return $waiting_queue;
	}
	public function generateBsuinessEmailNotifications(){
		$email_notification = rand(0,1);
		return $email_notification;
	}
	public function generateBsuinessCapacity(){
		$capacity = ['200','300','400','500','600','700','800','900','1000','1100','1200','1300','1400','1500','1600','1700','1800','1900','2000'];
		//$capacity = rand(200,5000);
		return $capacity[rand(0,18)];
	}
	public function generateBsuinessWorkCapacity(){
		$work_capacity = ['10','20','30','40','50','60','70','80','90','100'];
		return $work_capacity[rand(0,9)];
	}
	public function generateBsuinessServiceTime(){
		$service_time = array();
		for($i = 1;$i< 25 ; $i++){
			$service_time[$i] = $i * 5;
		}
		
		return $service_time[rand(1,24)];
	}
	public function generateRatingID(){
	    $id = rand(50,10050);
		return $id;
	}
	public function generateRating(){
	    return rand(0,5);
	}
	public function generateReservationID(){
	     $id = rand(400,10400);
		return $id;
	}
	

  }

?>