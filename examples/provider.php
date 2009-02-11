<?php

//Example: provider application code for posting a Contact list to the Consumer

require '../OpenFriends.class.php';

header('Content-Type: text/html');

if(isset($_REQUEST['consumer']))
  $consumer = new OpenFriends_Peer_Consumer($_REQUEST['consumer']);
else
  die("Must pass consumer descriptor");

$user = new stdClass;
$user->email = 'e@osterman.com';
$user->friends = Array(
                   Array('id' => 1,
                         'displayName' =>  'Chris Messina',
                         'urls' => Array(Array('value' => "http://factoryjoe.com/blog", "type" => "blog"))
                        ),
                    Array('id' => 2,
                          'displayName' => 'Joseph Smarr',
                          'emails' => Array(
                                        Array('value' => 'joseph@plaxo.com', 'type' => 'work', 'primary' => 'true'),
                                        Array('value' => 'jsmarr@gmail.com', 'type' => 'home'), 
                                        ),
                         ),
                       );

$provider = new OpenFriends_Peer_Provider('OpenFriends Provider', 'http://laptop.dev.osterman.com/~e/openfriends/provider.php', $consumer->token);  

?>
<style>
  input, textarea { display: block; }
</style>
<form method="POST" action="<?php echo $consumer->url; ?>" /> 
  <label for"provider">Provider:</label>
  <textarea rows="10" cols="80" name="provider"><?php echo $provider; ?></textarea>
  <label for="consumer">Consumer:</label>
  <textarea rows="10" cols="80" name="consumer"><?php echo $consumer; ?></textarea>
  <label for="friends">Friends:</label>
  <textarea rows="10" cols="80" name="friends"><?php echo OpenFriends::encode($user->friends); ?></textarea>
  <input type="submit">
</form>


