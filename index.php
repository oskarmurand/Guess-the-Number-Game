<?php
session_start();
 

if($_POST["limit"])
{
	$limit = htmlspecialchars($_POST['limit']);
	$_SESSION['limit'] = $limit;
}
elseif(isset($_SESSION['limit']))
{
	$limit = $_SESSION['limit'];
}
else
{
	$limit = 100;
}
 
if(isset($_SESSION['number']))
{
   $number = $_SESSION['number'];
}
else
{
   $_SESSION['number'] = rand(1,$limit);
}
$placeholder = "Make a guess!";
$universe = NULL;
if($_POST["guess"]){
    $guess  = htmlspecialchars($_POST['guess']); 
    $_SESSION['guess'] [] = $guess;
	if	(!is_numeric($guess))
	{
		$placeholder = "Please enter a number."; 
		$status = 'wrong';
	}
    elseif ($guess < $number AND $guess >= 1)
	{ 
        $placeholder = "The number is higher.";
        $status = 'wrong';
    }
    elseif ($guess > $number AND $guess <= $limit)
	{ 
        $placeholder = "The number is lower.";
        $status = 'wrong';
    }
    elseif($guess > 100)
    {
	    $placeholder = "Please enter a number that is ".$limit." or lower.";
	    $status = 'wrong';
    }
    elseif($guess < 1)
    {
	    $placeholder = "Please enter a number that is 1 or higher.";
	    $status = 'wrong';
    }
	elseif($guess == $number)
	{
        $placeholder = "You got the correct number! Try again!";
        $status = 'correct';
        $_SESSION['number'] = rand(1,$limit);
        unset ($_SESSION['guess']);
    }
 
}
if($_POST["guess"]){
    $guess  = htmlspecialchars($_POST['guess']);
	if ($guess == 42)
	{
		$universe = "<div class='answer'><p>42: Answer to the Ultimate Question of Life, The Universe, and Everything</p></div>";
	}
}

if($_POST["reset"]){
	 $_SESSION['number'] = rand(1,$limit);
	 $placeholder = "Guess The Number!";
	 unset ($_SESSION['guess']);
}

function history(){
	if(isset($_SESSION['guess'])){
			foreach ($_SESSION['guess'] as &$value)
			{
				echo "$value<br />";
			}
	}
}

// Next comes the HTML / CSS
?>

<!DOCTYPE html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Guess The Number</title>
		<style>
@import url(http://fonts.googleapis.com/css?family=Open+Sans:300,400,700);

*{margin:0;padding:0;}

body{
  background:#31547d;
  font-family:'Open Sans',sans-serif;
}

/*.button{
  width:100px;
  background:#3399cc;
  display:block;
  margin:0 auto;
  margin-top:1%;
  padding:10px;
  text-align:center;
  text-decoration:none;
  color:#fff;
  cursor:pointer;
  transition:background .3s;
  -webkit-transition:background .3s;
}

.button:hover{
  background:#2288bb;
}*/

.game{
  width:400px;
  margin:0 auto;
  margin-top:8px;
  margin-bottom:2%;
  transition:opacity 1s;
  -webkit-transition:opacity 1s;
}

.game h1{
  background:#3399cc;
  padding:15px 0;
  font-size:140%;
  font-weight:300;
  text-align:center;
  color:#fff;
  border-radius: 10px 10px 0px 0px
}

form{
  background:#f0f0f0;
  padding:6% 4%;
}

input[type="number"]{
  width:92%;
  background:#fff;
  margin-bottom:4%;
  border:1px solid #ccc;
  padding:4%;
  font-family:'Open Sans',sans-serif;
  font-size:95%;
  color:#555;
}

input[type="submit"]{
  position:relative;
  float:left;
  width:50%;
  background:#3399cc;
  border:0;
  padding:4%;
  font-family:'Open Sans',sans-serif;
  font-size:100%;
  color:#fff;
  cursor:pointer;
  transition:background .3s;
  -webkit-transition:background .3s;
}
input[name="reset"]{
	float:none;
}

input[type="submit"]:hover{
  background:#2288bb;
}

.answer {
  width:400px;
  margin: 0 auto;
  transition:opacity 1s;
  -webkit-transition:opacity 1s;
  color:black;
  margin-bottom: 10px;
}

.correct h1 {background-color: #5cb85c;}
.wrong h1 {background-color: #d9534f;}
a {text-decoration: none; color:#fff;}
a:hover{text-decoration: underline;}
p, h1 {text-align: center;font-weight: 300;color: #fff;}
		</style>
	</head>
 
	<body>
		<div id="game" class="game <?php echo $status; ?>">
			<h1>Guess The Number</h1>
				<form action="" method="post" name="guess-the-number">
					<span>Guess:</span>
					<input type="number" name="guess" placeholder="<?php echo $placeholder; ?>" />
				    <span>Difficulty:</span>
				    <input type="number" name="limit" value="Limit" placeholder="<?php echo $limit ?>" />
				    <input name="submit" type="submit" value="Guess" />
				    <input name="reset" type="submit" value="Reset" />
				    <?php echo history(); ?>
				</form>
		</div>
			<?php echo $universe?>
		<p><small><a target="_blank" href="http://codepen.io/miroot/pen/qwIgC">Theme based on pen by Miro Karilahti</a><small></p>
		
	
	</body>
</html>
<?php exit; ?>